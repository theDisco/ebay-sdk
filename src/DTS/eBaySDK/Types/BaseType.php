<?php
namespace DTS\eBaySDK\Types;

use \DTS\eBaySDK\Exceptions;

class BaseType
{
    protected static $properties = [];
    
    private $values = [];
 
    public function __construct()
    {
        self::$properties[__CLASS__] = [];
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    private function get($name)
    {
        self::ensurePropertyExists($name);
        return $this->getValue($name);
    }

    private function set($name, $value)
    {
        self::ensurePropertyExists($name);
        self::ensurePropertyType($name, $value);
        $this->setValue($name, $value);
    }

    private function getValue($name)
    {
        return array_key_exists($name, $this->values) ? $this->values[$name] : null;
    }

    private function setValue($name, $value)
    {
        $this->values[$name] = $value;
    }

    private static function ensurePropertyExists($name)
    {
        $class = \get_called_class();

        if(!array_key_exists($name, self::$properties[$class])) {
            throw new Exceptions\UnknownPropertyException($class, $name);
        }
    }

    private static function ensurePropertyType($name, $value)
    {
        $info = self::propertyInfo($name);

        $expectedType = $info['type'];
        $actualType = gettype($value);
        if('object' === $actualType) {
            $actualType = get_class($value);
        }

        if($expectedType !== $actualType) {
            throw new Exceptions\InvalidPropertyTypeException(\get_called_class(), $name, $expectedType, $actualType);
        }
    }

    private static function propertyInfo($name)
    {
        return self::$properties[\get_called_class()][$name];
    }
}
