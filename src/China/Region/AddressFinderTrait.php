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

use China\Region\Location\AddressInterface;

trait AddressFinderTrait
{
    /**
     * 根据Code查找地址
     *
     * @param string $code
     *
     * @return AddressInterface|false
     */
    public function findByCode($code)
    {
        return $this->filter(function(AddressInterface $address) use ($code){
            return $address->getCode() == $code;
        })->first();
    }

    /**
     * 根据Name查找地址
     *
     * @param string $name
     *
     * @return AddressInterface|false
     */
    public function findByName($name)
    {
        return $this->filter(function(AddressInterface $address) use ($name){
            return $address->getName() == $name;
        })->first();
    }

    /**
     * 筛选.
     *
     * @param \Closure $callback
     *
     * @return mixed
     */
    abstract public function filter(\Closure $callback);
}