<?php
require_once __DIR__ . '/../../../fixtures/AmountClass.php';

class AmountClassTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        $this->obj = new AmountClass();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('AmountClass', $this->obj);
    }

    public function testExtendsDoubleType()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Types\DoubleType', $this->obj);
    }

    public function testToXml()
    {
        $this->obj->value = 123.45;
        $this->obj->attributeOne = 'one';
        $this->obj->attributeTwo = 'two';

        $this->assertXmlStringEqualsXmlFile(__DIR__ . '/../../../fixtures/AmountClassXml.xml', $this->obj->toXml('Price', true));
    }
}
