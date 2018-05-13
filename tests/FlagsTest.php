<?php
namespace SashaMart\FlagsBot;

use PHPUnit\Framework\TestCase;

class FlagsTest extends TestCase
{
    public function testFlagsGetUnicode()
    {
        $flag = new Flag('Russia');
        $this->assertEquals('1F1F7 1F1FA', $flag->getUnicode());

        $flag = new Flag('Россия');
        $this->assertEquals('', $flag->getUnicode());

        $flag = new Flag('Ascension Island');
        $this->assertEquals('1F1E6 1F1E8', $flag->getUnicode());
    }
}