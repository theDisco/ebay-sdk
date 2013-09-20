<?php
namespace DTS\eBaySDK\Exceptions;

class UnknownPropertyException extends \LogicException
{
    public function __construct($property, $class, $code = 0, \Exception $previous = null) 
    {
        parent::__construct("Unknown property: $class::$property", $code, $previous);
    }
}
