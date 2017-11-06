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

interface AddressInterface extends \JsonSerializable
{
    /**
     * 获取Code
     * @return string
     */
    public function getCode();

    /**
     * 获取地址名称
     * @return string
     */
    public function getName();

    /**
     * 获取上一级地址
     * @return AddressInterface
     */
    public function getParent();
}