<?php

class SimpleClassTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;

    protected function setUp()
    {
        $this->obj = new SimpleClass();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('SimpleClass', $this->obj);
    }

    public function testExtendsBaseType()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Types\BaseType', $this->obj);
    }

    public function testGettingNonExistentProperty()
    {
        $this->setExpectedException('\DTS\eBaySDK\Exceptions\UnknownPropertyException', 'Unknown property: SimpleClass::foo');

        $this->obj->foo;
    }

    public function testSettingNonExistentProperty()
    {
        $this->setExpectedException('\DTS\eBaySDK\Exceptions\UnknownPropertyException', 'Unknown property: SimpleClass::foo');

        $this->obj->foo = 'foo';
    }

    public function testSettingPropertyWithAnInvalidType()
    {
        $this->setExpectedException('\DTS\eBaySDK\Exceptions\InvalidPropertyTypeException', 'Invalid property type: SimpleClass::integer expected <integer>, got <string>');

        $this->obj->integer = 'foo';
    }

    public function testIntegerProperty()
    {
        $this->obj->integer = 123;
        $this->assertEquals(123, $this->obj->integer);
    } 

    public function testStringProperty()
    {
        $this->obj->string = 'foo';
        $this->assertEquals('foo', $this->obj->string);
    } 

    public function testDoubleProperty()
    {
        $this->obj->double = 123.45;
        $this->assertEquals(123.45, $this->obj->double);
    } 

    public function testDateTimeProperty()
    {
        $date = new \DateTime('2000-01-01');
        $this->obj->dateTime = $date;
        $this->assertEquals($date, $this->obj->dateTime);
    } 

    public function testSimpleClassProperty()
    {
        $simpleClass = new SimpleClass();
        $this->obj->simpleClass = $simpleClass;
        $this->assertEquals($simpleClass, $this->obj->simpleClass);
    } 
}
