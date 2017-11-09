<?php
/*
 * This file is part of the Slince/China package.
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
    public function handleRawData($data)
    {
        return array_map(function($holidayData){
            $date = explode('月', trim($holidayData['date'], '日'));

            return new Holiday($holidayData['name'], $holidayData['type'], new Date($date[0], $date[1]));
        }, $data);
    }
}