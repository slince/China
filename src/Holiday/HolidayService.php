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

use China\Common\ResourceFile;
use Doctrine\Common\Collections\Collection;

class HolidayService implements HolidayServiceInterface
{
    /**
     * @var Collection
     */
    protected $holidays;

    public function __construct(ResourceFile $resourceFile)
    {
        $this->holidays = new HolidayLoader($resourceFile);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): iterable
    {
        return $this->holidays;
    }

    /**
     * {@inheritdoc}
     */
    public function findTraditionalHolidays(): iterable
    {
        return $this->findHolidaysByType(HolidayInterface::TYPE_TRADITIONAL);
    }

    /**
     * {@inheritdoc}
     */
    public function findInternationalHolidays(): iterable
    {
        return $this->findHolidaysByType(HolidayInterface::TYPE_INTERNATIONAL);
    }

    /**
     * {@inheritdoc}
     */
    public function findSolarTermHolidays(): iterable
    {
        return $this->findHolidaysByType(HolidayInterface::TYPE_SOLAR_TERM);
    }

    /**
     * {@inheritdoc}
     */
    public function findHolidaysByType(string $type): iterable
    {
        return $this->holidays->filter(function(HolidayInterface $holiday) use ($type){
            return $holiday->getType() === $type;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $name): ?HolidayInterface
    {
        $result = $this->holidays->filter(function(HolidayInterface $holiday) use ($name){
            return $holiday->getName() === $name;
        })->first();
        return $result ?: null;
    }
}