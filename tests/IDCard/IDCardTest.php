<?php

namespace China\Tests\IDCard;

use China\IDCard\IDCard;
use PHPUnit\Framework\TestCase;

class IDCardTest extends TestCase
{
    public function testCreate()
    {
        $idCard = new IDCard('340321199212026972');
        $this->assertEquals('340321199212026972', $idCard);
        $this->assertEquals('340321199212026972', $idCard->getLongNumber());
        $this->assertFalse($idCard->isShortLength());
    }

    public function testCreateError()
    {
        try {
            $idCard = new IDCard('340321199212026973');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertStringContainsString('invalid', $exception->getMessage());
        }

        try {
            $idCard = new IDCard('qwe340321199212026973');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertStringContainsString('length should be 15 numbers or 18 numbers', $exception->getMessage());
        }

        try {
            $idCard = new IDCard('34032119921202697');
            $this->fail();
        } catch (\Exception $exception) {
            $this->assertStringContainsString('card length should be 15 numbers or 18 numbers', $exception->getMessage());
        }
    }
}