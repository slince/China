<?php

namespace China\Tests\Nationality;

use China\Nationality\Nationality;
use PHPUnit\Framework\TestCase;

class NationalityTest extends TestCase
{
    public function testConstructor()
    {
        $nationality = new Nationality('阿昌族', 'ā chāng zú', 39555);
        $this->assertEquals('阿昌族', $nationality->getName());
        $this->assertEquals('ā chāng zú', $nationality->getPinyin());
        $this->assertEquals(39555, $nationality->getPopulation());
    }
}