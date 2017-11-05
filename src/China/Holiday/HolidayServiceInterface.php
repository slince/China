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

interface HolidayServiceInterface
{
    /**
     * 获取所有的节假日
     */
    public function findAll();

    public function findTraditionalHolidays();

    public function findInternationalHolidays();

    public function findSolarTermHolidays();
}