<?php

use DTS\eBaySDK\Parser\XmlParser;

class XmlTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->xmlParser = new XmlParser('\DTS\eBaySDK\Mocks\ComplexClass');
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Parser\XmlParser', $this->xmlParser);
    }

    public function testCanParseXml()
    {
        $xml = file_get_contents(__DIR__.'/../Mocks/Response.xml');
        $xml = preg_replace('/[\n\r]/', '', $xml);
        $xml = preg_replace('/>\s+/', '>', $xml);
        $obj = $this->xmlParser->parse($xml);

        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\ComplexClass', $obj);

        // This is not in the XML and so should not be set.
        $this->assertEquals(false, isset($this->obj->foo));

        $this->assertEquals(123, $obj->integer);
        $this->assertEquals('a string', $obj->string);
        $this->assertEquals('foo', $obj->foo);
        $this->assertEquals(123.45, $obj->double);
        $this->assertEquals(true, $obj->booleanTrue);
        $this->assertEquals(false, $obj->booleanFalse);
        $this->assertEquals(new \DateTime('2000-01-01T16:15:30.123Z', new \DateTimeZone('UTC')), $obj->dateTime);
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\SimpleClass', $obj->simpleClass);
        $this->assertEquals(321, $obj->simpleClass->integer);
        $this->assertEquals('another string', $obj->simpleClass->string);
        $this->assertEquals(123, $obj->simpleClass->integerAttribute);
        $this->assertEquals(123.45, $obj->simpleClass->doubleAttribute);
        $this->assertEquals(true, $obj->simpleClass->booleanTrueAttribute);
        $this->assertEquals(false, $obj->simpleClass->booleanFalseAttribute);
        $this->assertEquals(new \DateTime('2000-01-01T16:15:30.123Z', new \DateTimeZone('UTC')), $obj->simpleClass->dateTimeAttribute);
        $this->assertEquals('foo', $obj->strings[0]);
        $this->assertEquals('bar', $obj->strings[1]);
        $this->assertEquals(1, $obj->integers[0]);
        $this->assertEquals(2, $obj->integers[1]);
        $this->assertEquals(3, $obj->integers[2]);
        $this->assertEquals(4, $obj->integers[3]);
        $this->assertEquals(5, $obj->integers[4]);
        $this->assertEquals('bar', $obj->strings[1]);
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\SimpleClass', $obj->simpleClasses[0]);
        $this->assertEquals(888, $obj->simpleClasses[0]->integer);
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\SimpleClass', $obj->simpleClasses[1]);
        $this->assertEquals(999, $obj->simpleClasses[1]->integer);
        $this->assertEquals(543.21, $obj->amountClass->value);
        $this->assertEquals('one', $obj->amountClass->attributeOne);
        $this->assertEquals('one', $obj->amountClass->AttributeOne);
        $this->assertEquals('two', $obj->amountClass->attributeBish);
        $this->assertEquals('two', $obj->amountClass->ATTRIBUTEBISH);
        $this->assertEquals('binary type', $obj->base64BinaryType->value);
        $this->assertEquals(true, $obj->booleanType->value);
        $this->assertEquals(123, $obj->decimalType->value);
        $this->assertEquals(123.45, $obj->doubleType->value);
        $this->assertEquals(123, $obj->integerType->value);
        $this->assertEquals('string type', $obj->stringType->value);
        $this->assertEquals('token type', $obj->tokenType->value);
        $this->assertEquals('uri type', $obj->uriType->value);
        $this->assertEquals('foo', $obj->bish);
        $this->assertEquals('foo', $obj->BISH);
        $this->assertEquals('foo', $obj->bishBash);
        $this->assertEquals('foo', $obj->BishBash);
    }
}
