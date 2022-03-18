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
use Doctrine\Common\Collections\Collection;

interface RegionCollectionInterface extends Collection
{
    /**
     * 根据Code查找地址
     *
     * @param string $code
     *
     * @return AddressInterface|null
     */
    public function findByCode(string $code): ?AddressInterface;

    /**
     * 根据Name查找地址
     *
     * @param string $name
     *
     * @return AddressInterface|null
     */
    public function findByName(string $name): ?AddressInterface;
}