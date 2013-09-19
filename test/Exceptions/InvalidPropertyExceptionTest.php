<?php

use DTS\eBaySDK\Exceptions\InvalidPropertyException;

class InvalidPropertyExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;

    protected function setUp()
    {
        $this->obj = new InvalidPropertyException('foo', 'Bar');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Exceptions\InvalidPropertyException', $this->obj);
    }

    public function testExtendsLogicException()
    {
        $this->assertInstanceOf('\LogicException', $this->obj);
    }

    public function testCorrectMessageIsGenerated()
    {
        $this->assertEquals('Unknown property: Bar::foo', $this->obj->getMessage());
    }
}
