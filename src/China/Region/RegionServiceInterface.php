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

use China\IDCard\IDCardInterface;
use China\Region\Location\AddressInterface;
use China\Region\Location\Province;
use Doctrine\Common\Collections\Collection;

interface RegionServiceInterface
{
    /**
     * 获取所有省份
     * @return Province[]|Collection
     */
    public function getProvinces();

    /**
     * 筛选地区
     * @param \Closure $callback
     * @return AddressInterface[]|Collection
     */
    public function filter(\Closure $callback);

    /**
     * 根据Code查找地址
     * @param string $code
     * @return AddressInterface|false
     */
    public function findByCode($code);

    /**
     * 根据Name查找地址
     * @param string $name
     * @return AddressInterface|false
     */
    public function findByName($name);

    /**
     * 查找身份证号码归属地
     * @param string|IDCardInterface $idCard
     * @return AddressInterface|false
     */
    public function findByIdCard($idCard);
}