<?php

namespace China\Tests\Holiday;

use China\Holiday\Date;
use China\Holiday\Holiday;
use China\Holiday\HolidayInterface;
use PHPUnit\Framework\TestCase;

class HolidayTest extends TestCase
{
    public function testConstructor()
    {
        $holiday =  new Holiday('元旦节', HolidayInterface::TYPE_INTERNATIONAL, new Date(1, 1));
        $this->assertEquals('元旦节', $holiday->getName());
        $this->assertEquals(HolidayInterface::TYPE_INTERNATIONAL, $holiday->getType());
        $this->assertEquals('1月1日', $holiday->getDate()->toString());
    }
}