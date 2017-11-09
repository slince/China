<?php

namespace China\Tests\Nationality;

use China\Nationality\NationalityInterface;
use China\Nationality\NationalityLoader;
use PHPUnit\Framework\TestCase;
use China\Common\ResourceFile;

class NationalityLoaderTest extends TestCase
{
    public function testConstructor()
    {
        $resource = new ResourceFile(__DIR__ . '/../../../resources/nationalities.json');
        $holidays = new NationalityLoader($resource);
        $this->assertNotEmpty($holidays->toArray());
        $this->assertInstanceOf(NationalityInterface::class, $holidays->first());
    }
}