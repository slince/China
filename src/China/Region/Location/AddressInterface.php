<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\Region\Location;

use China\Region\RegionCollectionInterface;

interface AddressInterface extends \JsonSerializable
{
    /**
     * 类型，省
     *
     * @return string
     */
    const TYPE_PROVINCE = 'province';

    /**
     * 类型，市
     *
     * @return string
     */
    const TYPE_CITY = 'city';

    /**
     * 类型，区县
     *
     * @return string
     */
    const TYPE_AREA = 'area';

    /**
     * 获取Code.
     *
     * @return string
     */
    public function getCode();

    /**
     * 获取地址名称.
     *
     * @return string
     */
    public function getName();

    /**
     * 设置父级地区.
     *
     * @param AddressInterface $parent
     */
    public function setParent(AddressInterface $parent);

    /**
     * 获取上一级地址
     *
     * @return AddressInterface
     */
    public function getParent();

    /**
     * 获取子地区.
     *
     * @return RegionCollectionInterface|AddressInterface[]
     */
    public function getChildren();

    /**
     * 设置子地区.
     *
     * @param $children
     */
    public function setChildren($children);
}