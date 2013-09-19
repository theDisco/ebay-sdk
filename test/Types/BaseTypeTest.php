<?php

use DTS\eBaySDK\Types\BaseType;

class BaseTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $baseType;

    protected function setUp()
    {
        $this->baseType = new BaseType();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Types\BaseType', $this->baseType);
    }
}
