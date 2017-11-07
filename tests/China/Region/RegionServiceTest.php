<?php

namespace China\Tests\Region;

use China\Tests\TestCase;

class RegionServiceTest extends TestCase
{
    public function testGetProvinces()
    {
        $regionService = $this->getChina()->getRegion();
        $provinces = $regionService->getProvinces();
//        $this->assertCount(32, $provinces);
//        $this->assertEquals('北京市', $provinces->first()->getName());
        file_put_contents(__DIR__ . '/output.log', print_r(array_map(function($area){return $area->getName();}, $provinces), true));
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
}