<?php

namespace China\Tests\Holiday;

use China\Common\ResourceFile;
use China\Holiday\HolidayInterface;
use China\Holiday\HolidayLoader;
use PHPUnit\Framework\TestCase;

class HolidayLoaderTest extends TestCase
{
    public function testCreate()
    {
        $resource = new ResourceFile(__DIR__.'/../../resources/holidays.json');
        $holidays = new HolidayLoader($resource);
        $this->assertNotEmpty($holidays->toArray());
        $this->assertInstanceOf(HolidayInterface::class, $holidays->first());
    }
}