<?php

namespace China\Tests\Region;

use China\Region\AddressFactory;
use China\Region\Location\AddressInterface;
use China\Region\RegionCollection;
use PHPUnit\Framework\TestCase;

class RegionCollectionTest extends TestCase
{
    protected function createCollection()
    {
        $anhui = AddressFactory::createFromArray([
            'code' => 340000,
            'name' => '安徽省',
            'type'  => AddressInterface::TYPE_PROVINCE
        ]);
        $bengbu = AddressFactory::createFromArray([
            'code' => 340320,
            'name' => '蚌埠市',
            'type'  => AddressInterface::TYPE_CITY
        ], $anhui);

        return new RegionCollection([
            $anhui,
            $bengbu
        ]);
    }

    public function testFindByName()
    {
        $regions = $this->createCollection();
        $this->assertEquals('安徽省', $regions->findByName('安徽省')->getName());
        $this->assertEquals(340000, $regions->findByName('安徽省')->getCode());
    }

    public function testFindByCode()
    {
        $regions = $this->createCollection();
        $this->assertEquals('蚌埠市', $regions->findByCode(340320)->getName());
        $this->assertEquals(340320, $regions->findByCode(340320)->getCode());
    }

    public function testFilter()
    {
        $regions = $this->createCollection()->filter(function(AddressInterface $address){
            return strpos($address->getCode(), '340') === 0;
        });
        $this->assertCount(2, $regions);
    }
}