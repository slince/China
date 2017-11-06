<?php

namespace China\Tests\Holiday;

use China\Tests\TestCase;

class HolidayServiceTest extends TestCase
{
    public function testFindAll()
    {
        $holidayService = $this->getChina()->getHolidays();
        $holidays = $holidayService->findAll();
        $this->assertGreaterThan(0, count($holidays));
        $this->assertNotEmpty($holidays->toArray());
        var_dump($holidays->toArray());
    }
}