<?php

namespace China\Tests\Region;

use China\Region\AddressFactory;
use China\Region\Location\AddressInterface;
use PHPUnit\Framework\TestCase;

class AddressFactoryTest extends TestCase
{
    public function testCreate()
    {
        $anhui = AddressFactory::createFromArray([
            'code' => 340000,
            'name' => '安徽省',
            'type' => AddressInterface::TYPE_PROVINCE,
        ]);
        $bengbu = AddressFactory::createFromArray([
            'code' => 340320,
            'name' => '蚌埠市',
            'type' => AddressInterface::TYPE_CITY,
        ], $anhui);
        $this->assertEquals($anhui, $bengbu->getParent());
    }

    public function testCreateWithoutType()
    {
        $this->expectException(\InvalidArgumentException::class);
        AddressFactory::createFromArray([
            'code' => 340000,
            'name' => '安徽省',
        ]);
    }
}