<?php
namespace DTS\eBaySDK\Mocks;

class SimpleClass extends \DTS\eBaySDK\Types\BaseType
{
    public function __construct(array $values = [])
    {
        $properties = [
            'integer' => [
                'type' => 'integer',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'integer'
            ],
            'string' => [
                'type' => 'string',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'string'
            ],
            'double' => [
                'type' => 'double',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'double'
            ],
            'booleanTrue' => [
                'type' => 'boolean',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'booleanTrue'
            ],
            'booleanFalse' => [
                'type' => 'boolean',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'booleanFalse'
            ],
            'dateTime' => [
                'type' => 'DateTime',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'DateTime'
            ],
            'simpleClass' => [
                'type' => 'DTS\eBaySDK\Mocks\SimpleClass',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'SimpleClass'
            ],
            'strings' => [
                'type' => 'string',
                'unbound' => true,
                'attribute' => false,
                'elementName' => 'strings'
            ],
            'integers' => [
                'type' => 'integer',
                'unbound' => true,
                'attribute' => false,
                'elementName' => 'integers'
            ],
            'base64BinaryType' => [
                'type' => 'DTS\eBaySDK\Mocks\Base64BinaryType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'base64BinaryType'
            ],
            'booleanType' => [
                'type' => 'DTS\eBaySDK\Mocks\BooleanType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'booleanType'
            ],
            'decimalType' => [
                'type' => 'DTS\eBaySDK\Mocks\DecimalType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'decimalType'
            ],
            'doubleType' => [
                'type' => 'DTS\eBaySDK\Mocks\DoubleType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'doubleType'
            ],
            'integerType' => [
                'type' => 'DTS\eBaySDK\Mocks\IntegerType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'integerType'
            ],
            'stringType' => [
                'type' => 'DTS\eBaySDK\Mocks\StringType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'stringType'
            ],
            'tokenType' => [
                'type' => 'DTS\eBaySDK\Mocks\TokenType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'tokenType'
            ],
            'uriType' => [
                'type' => 'DTS\eBaySDK\Mocks\URIType',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'uriType'
            ]
        ];

        list($parentValues, $childValues) = self::getParentValues($properties, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], $properties);
        }

        if (!array_key_exists(__CLASS__, self::$xmlNamespaces)) {
            self::$xmlNamespaces[__CLASS__] = 'http://davidtsadler.com';
        }

        $this->setValues(__CLASS__, $childValues);
    }
}
