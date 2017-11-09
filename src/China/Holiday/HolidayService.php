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
    public function findAll()
    {
        return $this->holidays;
    }

    /**
     * {@inheritdoc}
     */
    public function findTraditionalHolidays()
    {
        return $this->findHolidaysByType(HolidayInterface::TYPE_TRADITIONAL);
    }

    /**
     * {@inheritdoc}
     */
    public function findInternationalHolidays()
    {
        return $this->findHolidaysByType(HolidayInterface::TYPE_INTERNATIONAL);
    }
    
    /**
     * {@inheritdoc}
     */
    public function findSolarTermHolidays()
    {
        return $this->findHolidaysByType(HolidayInterface::TYPE_SOLAR_TERM);
    }

    /**
     * {@inheritdoc}
     */
    public function findHolidaysByType($type)
    {
        return $this->holidays->filter(function(HolidayInterface $holiday) use ($type){
            return $holiday->getType() === $type;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function find($name)
    {
        return $this->holidays->filter(function(HolidayInterface $holiday) use ($name){
            return $holiday->getName() === $name;
        })->first();
    }
}