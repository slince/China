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

use China\Common\ResourceLoader\LazyLoader;
use China\Region\Location\AddressInterface;

class RegionLoader extends LazyLoader
{
    /**
     * {@inheritdoc}
     */
    public function handleRawData($data)
    {
        $rootData = [
            'type' => AddressInterface::TYPE_PROVINCE,
            'name' => 'China',
            'code' => 0,
            'children' => $data,
        ];

        return [AddressFactory::createFromArray($rootData)];
    }
}