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

trait AddressFinderTrait
{
    /**
     * 根据Code查找地址
     *
     * @param string $code
     *
     * @return AddressInterface|null
     */
    public function findByCode(string $code): ?AddressInterface
    {
        $result = $this->filter(function(AddressInterface $address) use ($code){
            return $address->getCode() == $code;
        })->first();
        return $result ?: null;
    }

    /**
     * 根据Name查找地址
     *
     * @param string $name
     *
     * @return AddressInterface|null
     */
    public function findByName(string $name): ?AddressInterface
    {
        $result = $this->filter(function(AddressInterface $address) use ($name){
            return $address->getName() == $name;
        })->first();
        return $result ?: null;
    }
}