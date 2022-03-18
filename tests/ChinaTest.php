<?php

namespace China\Tests;

class ChinaTest extends TestCase
{
    public function testBaseInfo()
    {
        $china = $this->getChina();
        $this->assertEquals('中国', $china->getName());
        $this->assertEquals('中华人民共和国', $china->getOfficialName());
        $this->assertEquals('CN', $china->getIsoCode());
        $this->assertEquals(['zh_CN', 'zh_TW'], $china->getLanguages());
    }
}