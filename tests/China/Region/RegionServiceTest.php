<?php

namespace China\Tests\Region;

use China\Tests\TestCase;

class RegionServiceTest extends TestCase
{
    public function testGetProvinces()
    {
        $regionService = $this->getChina()->getRegion();
        $provinces = $regionService->getProvinces();
        $this->assertCount(34, $provinces);
        $this->assertEquals('北京市', $provinces->first()->getName());
    }

    public function testFindByCode()
    {
        $regionService = $this->getChina()->getRegion();
        $beijing = $regionService->findByCode('110000');
        $this->assertEquals('北京市', $beijing->getName());
    }

    public function testFindByName()
    {
        $regionService = $this->getChina()->getRegion();
        $beijing = $regionService->findByName('江宁区');
        $this->assertEquals('320115', $beijing->getCode());
    }

    public function testFind()
    {
        $regionService = $this->getChina()->getRegion();
        $this->assertFalse($regionService->findByName('不存在的地区'));
        $bengbu = $regionService->findByName('蚌埠市');
        $this->assertEquals($regionService->findByName('安徽省'), $bengbu->getParent());
        $this->assertContains($regionService->findByName('怀远县'), $bengbu->getChildren());
    }

    public function testFindByIdCard()
    {
        $regionService = $this->getChina()->getRegion();
        $address = $regionService->findByIdCard('340321199106196978');
        $this->assertEquals($regionService->findByName('怀远县'), $address);
        $this->assertEquals($regionService->findByName('蚌埠市'), $address->getParent());
        $this->assertEquals($regionService->findByName('安徽省'), $address->getParent()->getParent());
    }
}