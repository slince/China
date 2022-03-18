<?php

declare(strict_types=1);

/*
 * This file is part of the slince/china package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\Region\Location;

use China\Region\RegionCollection;
use Doctrine\Common\Collections\Collection;

abstract class Address implements AddressInterface
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var AddressInterface
     */
    protected $parent;

    /**
     * 子地区.
     *
     * @var AddressInterface[]|Collection
     */
    protected $children;

    public function __construct(string $code, string $name, AddressInterface $parent = null, array $children = [])
    {
        $this->code = $code;
        $this->name = $name;
        $this->parent = $parent;
        $this->children = $children;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?AddressInterface
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren(): iterable
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'type' => static::getType(),
            'children' => $this->getChildren(),
        ];
    }

    /**
     * 获取当前类类型.
     * @return string
     */
    public static function getType(): string
    {
        return '';
    }

    /**
     * 创建地区对象
     *
     * @param array            $data
     * @param AddressInterface|null $parent
     *
     * @return AddressInterface
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data, AddressInterface $parent = null)
    {
        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Missing parameter "type"');
        }
        $address = null;
        switch ($data['type']) {
            case AddressInterface::TYPE_PROVINCE:
                $address = new Province($data['code'], $data['name'], $parent);
                break;
            case AddressInterface::TYPE_CITY:
                $address = new City($data['code'], $data['name'], $parent);
                break;
            case AddressInterface::TYPE_DISTRICT:
                $address = new District($data['code'], $data['name'], $parent);
                break;
        }
        if (!$address) {
            throw new \InvalidArgumentException(sprintf('Bad parameter "type" with "%s"', $data['type']));
        }
        //子地区
        if (isset($data['children'])) {
            $children = array_map(function($regionData) use ($address){
                return static::createFromArray($regionData, $address);
            }, $data['children']);
            $address->setChildren(new RegionCollection($children));
        }

        return $address;
    }
}