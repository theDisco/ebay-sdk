<?php
namespace DTS\eBaySDK\Exceptions;

class InvalidPropertyTypeException extends \LogicException
{
    public function __construct($property, $class, $expectedType, $actualType, $code = 0, \Exception $previous = null) 
    {
        parent::__construct("Invalid property type: $class::$property expected <$expectedType>, got <$actualType>", $code, $previous);
    }
}
