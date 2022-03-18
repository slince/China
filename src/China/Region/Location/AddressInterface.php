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
    const TYPE_DISTRICT = 'district';

    /**
     * 获取Code.
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * 获取地址名称.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * 获取上一级地址
     *
     * @return AddressInterface
     */
    public function getParent(): ?AddressInterface;

    /**
     * 设置子地区
     * @param array $children
     */
    public function setChildren(array $children);

    /**
     * 获取子地区.
     *
     * @return RegionCollectionInterface|AddressInterface[]
     */
    public function getChildren(): iterable;
}