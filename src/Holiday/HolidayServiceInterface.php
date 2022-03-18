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

use Doctrine\Common\Collections\Collection;

interface HolidayServiceInterface
{
    /**
     * 获取所有的节假日.
     *
     * @return HolidayInterface[]|Collection
     */
    public function findAll(): iterable;

    /**
     * 获取所有的传统节日.
     *
     * @return HolidayInterface[]|Collection
     */
    public function findTraditionalHolidays(): iterable;

    /**
     * 获取所有的国际节日.
     *
     * @return HolidayInterface[]|Collection
     */
    public function findInternationalHolidays(): iterable;

    /**
     * 获取所有的节气.
     *
     * @return HolidayInterface[]|Collection
     */
    public function findSolarTermHolidays(): iterable;

    /**
     * 根据类型获取节假日.
     *
     * @param string $type
     *
     * @return HolidayInterface[]|Collection
     */
    public function findHolidaysByType(string $type): iterable;

    /**
     * 查找指定的民族.
     *
     * @param string $name
     *
     * @return HolidayInterface
     */
    public function find(string $name): ?HolidayInterface;
}