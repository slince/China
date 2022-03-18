<?php

namespace China\Tests\Region\Location;

use China\Region\Location\District;
use China\Region\Location\City;
use China\Region\Location\Province;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testProvince()
    {
        $province = new Province('340000', '安徽省');
        $this->assertEquals(340000, $province->getCode());
        $this->assertEquals('安徽省', $province->getName());
        $this->assertEquals(null, $province->getParent());

        $city = new City('340300', '蚌埠市', $province);
        $this->assertEquals(340300, $city->getCode());
        $this->assertEquals('蚌埠市', $city->getName());
        $this->assertEquals($province, $city->getParent());

        $area = new District('340322', '五河县', $city);
        $this->assertEquals(340322, $area->getCode());
        $this->assertEquals('五河县', $area->getName());
        $this->assertEquals($city, $area->getParent());
    }
}