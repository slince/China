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

use Doctrine\Common\Collections\Collection;

interface HolidayServiceInterface
{
    /**
     * 获取所有的节假日
     * @return Collection
     */
    public function findAll();

    /**
     * 获取所有的传统节日
     * @return Collection
     */
    public function findTraditionalHolidays();

    /**
     * 获取所有的国际节日
     * @return Collection
     */
    public function findInternationalHolidays();

    /**
     * 获取所有的节气
     * @return Collection
     */
    public function findSolarTermHolidays();
}