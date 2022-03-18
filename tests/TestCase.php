<?php

namespace China\Tests;

use China\China;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @return China
     */
    protected function getChina()
    {
        return new China();
    }
}