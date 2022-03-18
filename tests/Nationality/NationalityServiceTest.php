<?php

namespace China\Tests\Nationality;

use China\Tests\TestCase;

class NationalityServiceTest extends TestCase
{
    public function testFind()
    {
        $nationalityService = $this->getChina()->getNationality();
        $han = $nationalityService->find('汉族');
        $this->assertGreaterThan(0, $han->getPopulation());
    }

    public function testFindAll()
    {
        $nationalityService = $this->getChina()->getNationality();
        $this->assertGreaterThan(0, count($nationalityService->findAll()));
    }
}