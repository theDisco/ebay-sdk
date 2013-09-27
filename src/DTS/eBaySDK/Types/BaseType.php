<?php
namespace DTS\eBaySDK\Types;

use \DTS\eBaySDK\Types;
use \DTS\eBaySDK\Exceptions;

class BaseType
{
    protected static $properties = [];

    private $values = [];

    public function __construct(array $values = [])
    {
        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = [];
        }

        $this->setValues(__CLASS__, $values);
    }

    public function __get($name)
    {
        return $this->get(get_class($this), $name);
    }

    public function __set($name, $value)
    {
        $this->set(get_class($this), $name, $value);
    }

    public function __isset($name)
    {
        return $this->isPropertySet(get_class($this), $name);
    }

    public function __unset($name)
    {
        $this->unSetProperty(get_class($this), $name);
    }

    protected function setValues($class, array $values = [])
    {
        foreach ($values as $property => $value) {
            $this->set($class, $property, $value);
        }
    }

    private function get($class, $name)
    {
        self::ensurePropertyExists($class, $name);

        return $this->getValue($class, $name);
    }

    private function set($class, $name, $value)
    {
        self::ensurePropertyExists($class, $name);
        self::ensurePropertyType($class, $name, $value);

        $this->setValue($class, $name, $value);
    }

    private function isPropertySet($class, $name)
    {
        self::ensurePropertyExists($class, $name);

        return array_key_exists($name, $this->values);
    }

    private function unSetProperty($class, $name)
    {
        self::ensurePropertyExists($class, $name);

        unset($this->values[$name]);
    }

    private function getValue($class, $name)
    {
        $info = self::propertyInfo($class, $name);

        if ($info['unbound'] && !array_key_exists($name, $this->values)) {
            $this->values[$name] = new Types\UnboundType($class, $name, $info['type']);
        }

        return array_key_exists($name, $this->values) ? $this->values[$name] : null;
    }

    private function setValue($class, $name, $value)
    {
        $info = self::propertyInfo($class, $name);

        if (!$info['unbound']) {
            $this->values[$name] = $value;
        } else {
            $actualType = self::getActualType($value);
            if ('array' !== $actualType) {
                throw new Exceptions\InvalidPropertyTypeException(get_class($this), $name, 'DTS\eBaySDK\Types\UnboundType', $actualType);
            } else {
                $this->values[$name] = new Types\UnboundType(get_class($this), $name, $info['type']);
                foreach ($value as $item) {
                    $this->values[$name][] = $item;
                }
            }
        }
    }

    private static function ensurePropertyExists($class, $name)
    {
        if (!array_key_exists($name, self::$properties[$class])) {
            throw new Exceptions\UnknownPropertyException(get_called_class(), $name);
        }
    }

    private static function ensurePropertyType($class, $name, $value)
    {
        $info = self::propertyInfo($class, $name);

        $expectedType = $info['type'];
        $actualType = self::getActualType($value);

        if ($expectedType !== $actualType && 'array' !== $actualType) {
            throw new Exceptions\InvalidPropertyTypeException(get_called_class(), $name, $expectedType, $actualType);
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

    private static function propertyInfo($class, $name)
    {
        return self::$properties[$class][$name];
    }

    protected static function getParentValues(array $properties = [], array $values = [])
    {
      return [
          array_diff_key($values, $properties),
          array_intersect_key($values, $properties)
      ];
    }
}
