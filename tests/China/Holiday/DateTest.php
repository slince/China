<?php

namespace China\Tests\Holiday;

use China\Holiday\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testConstructor()
    {
        $date = new Date(12, 8);

        $this->assertEquals(12, $date->getMonth());
        $this->assertEquals(8, $date->getDay());
        $this->assertEquals('12月8日', $date->toString());
        $this->assertEquals('12-8', $date->format('{month}-{day}'));

        $date->setMonth(8);
        $date->setDay(16);
        $this->assertEquals('8月16日', $date->toString());
    }
}