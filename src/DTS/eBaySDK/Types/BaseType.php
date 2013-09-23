<?php
namespace DTS\eBaySDK\Types;

use \DTS\eBaySDK\Types;
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

    public function __isset($name)
    {
        return $this->isPropertySet($name);
    }

    public function __unset($name)
    {
        $this->unSetProperty($name);
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

    private function isPropertySet($name)
    {
        self::ensurePropertyExists($name);
        return array_key_exists($name, $this->values);
    }

    private function unSetProperty($name)
    {
        self::ensurePropertyExists($name);
        unset($this->values[$name]);
    }

    private function getValue($name)
    {
        $info = self::propertyInfo($name);

        if ($info['unbound'] && !array_key_exists($name, $this->values)) {
            $this->values[$name] = new Types\UnboundType(get_class($this), $name, $info['type']);
        }

        return array_key_exists($name, $this->values) ? $this->values[$name] : null;
    }

    private function setValue($name, $value)
    {
        $info = self::propertyInfo($name);

        if (!$info['unbound']) {
            $this->values[$name] = $value;
        } else {
            $actualType = self::getActualType($value);
            if ('array' !== $actualType) {
                throw new Exceptions\InvalidPropertyTypeException(\get_called_class(), $name, 'DTS\eBaySDK\Types\UnboundType', $actualType);
            } else {
                $this->values[$name] = new Types\UnboundType(get_class($this), $name, $info['type']);
                foreach($value as $item) {
                    $this->values[$name][] = $item;
                }
            }
        }
    }

    private static function ensurePropertyExists($name)
    {
        $class = \get_called_class();

        if (!array_key_exists($name, self::$properties[$class])) {
            throw new Exceptions\UnknownPropertyException($class, $name);
        }
    }

    private static function ensurePropertyType($name, $value)
    {
        $info = self::propertyInfo($name);

        $expectedType = $info['type'];
        $actualType = self::getActualType($value);

        if ($expectedType !== $actualType && $actualType !== 'array') {
            throw new Exceptions\InvalidPropertyTypeException(\get_called_class(), $name, $expectedType, $actualType);
        }
    }

    private static function getActualType($value) 
    {
        $actualType = gettype($value);
        if ('object' === $actualType) {
            $actualType = get_class($value);
        }
        return $actualType;
    }

    private static function propertyInfo($name)
    {
        return self::$properties[\get_called_class()][$name];
    }
}
