<?php
namespace SashaMart\FlagsBot;

use PHPUnit\Framework\TestCase;

class FlagsTest extends TestCase
{
    public function testFlagsGetUnicode()
    {
        $flag = new Flag('Russia');
        $this->assertEquals('🇷🇺', $flag->getUtf8());

        $flag = new Flag('Россия');
        $this->assertEquals('', $flag->getUtf8());

        $flag = new Flag('Ascension Island');
        $this->assertEquals('🇦🇨', $flag->getUtf8());
    }
}