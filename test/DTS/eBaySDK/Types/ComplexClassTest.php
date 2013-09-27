<?php

class ComplexClassTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;

    protected function setUp()
    {
        $this->obj = new ComplexClass();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('ComplexClass', $this->obj);
    }

    public function testExtendsSimpleClass()
    {
        $this->assertInstanceOf('SimpleClass', $this->obj);
    }

    public function testGettingSettingProperties()
    {
        $this->obj->foo = 'foo';
        $this->assertEquals('foo', $this->obj->foo);
        $this->assertInternalType('string', $this->obj->foo);
    }

    public function testGettingSettingInheritedProperties()
    {
        $this->obj->integer = 123;
        $this->assertEquals(123, $this->obj->integer);
        $this->assertInternalType('integer', $this->obj->integer);

        $this->obj->string = 'foo';
        $this->assertEquals('foo', $this->obj->string);
        $this->assertInternalType('string', $this->obj->string);

        $this->obj->double = 123.45;
        $this->assertEquals(123.45, $this->obj->double);
        $this->assertInternalType('float', $this->obj->double);

        $date = new \DateTime('2000-01-01');
        $this->obj->dateTime = $date;
        $this->assertEquals($date, $this->obj->dateTime);
        $this->assertInstanceOf('\DateTime', $this->obj->dateTime);

        $simpleClass = new SimpleClass();
        $this->obj->simpleClass = $simpleClass;
        $this->assertEquals($simpleClass, $this->obj->simpleClass);
        $this->assertInstanceOf('SimpleClass', $this->obj->simpleClass);

        $this->assertEquals(0, count($this->obj->strings));
        $this->assertInstanceOf('\DTS\eBaySDK\Types\UnboundType', $this->obj->strings);

        $this->obj->strings[] = 'foo';
        $this->obj->strings[] = 'bar';
        $this->assertEquals(2, count($this->obj->strings));
        $this->assertEquals('foo', $this->obj->strings[0]);
        $this->assertEquals('bar', $this->obj->strings[1]);
        $this->assertInstanceOf('\DTS\eBaySDK\Types\UnboundType', $this->obj->strings);

        $this->obj->strings = ['foo', 'bar'];
        $this->assertEquals(2, count($this->obj->strings));
        $this->assertEquals('foo', $this->obj->strings[0]);
        $this->assertEquals('bar', $this->obj->strings[1]);
        $this->assertInstanceOf('\DTS\eBaySDK\Types\UnboundType', $this->obj->strings);

        $this->obj->strings = [];
        $this->assertEquals(0, count($this->obj->strings));
        $this->assertInstanceOf('\DTS\eBaySDK\Types\UnboundType', $this->obj->strings);
    }
}
