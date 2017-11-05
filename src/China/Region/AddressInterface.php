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

interface AddressInterface extends \JsonSerializable
{
    /**
     * 获取地址名称
     * @return string
     */
    public function getName();
}