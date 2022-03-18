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

namespace China\Region;

use China\Region\Location\AddressInterface;
use China\Region\Location\Area;
use China\Region\Location\City;
use China\Region\Location\Province;

final class AddressFactory
{
    /**
     * 创建地区对象
     *
     * @param array            $data
     * @param AddressInterface $parent
     *
     * @return AddressInterface
     *
     * @throws \InvalidArgumentException
     */
    public static function createFromArray($data, AddressInterface $parent = null)
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
            case AddressInterface::TYPE_AREA:
                $address = new Area($data['code'], $data['name'], $parent);
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