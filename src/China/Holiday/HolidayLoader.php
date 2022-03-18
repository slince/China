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

namespace China\Holiday;

use China\Common\ResourceLoader\LazyLoader;

class HolidayLoader extends LazyLoader
{
    /**
     * {@inheritdoc}
     */
    public function handleRawData(array $record)
    {
        $date = explode('月', trim($record['date'], '日'));
        return new Holiday($record['name'], $record['type'], new Date($date[0], $date[1]));
    }
}