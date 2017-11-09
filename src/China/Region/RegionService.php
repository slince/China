<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\Region;

use China\Common\ResourceFile;
use China\IDCard\IDCard;
use China\Region\Location\AddressInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class RegionService implements RegionServiceInterface
{
    /**
     * @var AddressInterface
     */
    protected $regions;

    /**
     * 根据code做索引
     * @var AddressInterface[]|Collection
     */
    protected $flattenRegions;

    public function __construct(ResourceFile $resourceFile)
    {
        $this->regions = new RegionLoader($resourceFile);
        $this->flattenRegions = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getProvinces()
    {
        return new ArrayCollection($this->regions->first()->getChildren());
    }

    /**
     * {@inheritdoc}
     */
    public function findByCode($code)
    {
        return $this->filter(function(AddressInterface $address) use ($code){
            return $address->getCode() == $code;
        })->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return $this->filter(function(AddressInterface $address) use ($name){
            return $address->getName() == $name;
        })->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByIdCard($idCard)
    {
        if (is_string($idCard)) {
            $idCard = new IDCard($idCard);
        }
        $areaCode = substr($idCard, 0, 6);
        return $this->findByCode($areaCode);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(\Closure $callback)
    {
        if (!$this->flattenRegions->isEmpty()) {
            return $this->flattenRegions->filter($callback);
        }
        // 没有遍历过则自行遍历
        $addresses = [];
        $this->traverseTree($this->regions->first(), function(AddressInterface $address) use ($callback, &$addresses){
            if ($callback($address) === true) {
                $addresses[] = $address;
            }
        });
        return new ArrayCollection($addresses);
    }

    /**
     * 遍历地区树
     * @param AddressInterface $address
     * @param \Closure $callback
     */
    protected function traverseTree(AddressInterface $address, \Closure $callback)
    {
        $callback($address);
        //将树形结构扁平化
        $this->flattenRegions->add($address);
        if ($address->getChildren()) {
            foreach ($address->getChildren() as $child) {
                $this->traverseTree($child, $callback);
            }
        }
    }
}