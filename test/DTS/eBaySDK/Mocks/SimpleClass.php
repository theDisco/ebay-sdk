<?php
namespace DTS\eBaySDK\Mocks;

class SimpleClass extends \DTS\eBaySDK\Types\BaseType
{
    private static $propertyTypes = array(
        'integer' => array(
            'type' => 'integer',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'integer'
        ),
        'string' => array(
            'type' => 'string',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'string'
        ),
        'double' => array(
            'type' => 'double',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'double'
        ),
        'booleanTrue' => array(
            'type' => 'boolean',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'booleanTrue'
        ),
        'booleanFalse' => array(
            'type' => 'boolean',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'booleanFalse'
        ),
        'dateTime' => array(
            'type' => 'DateTime',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'DateTime'
        ),
        'simpleClass' => array(
            'type' => 'DTS\eBaySDK\Mocks\SimpleClass',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'SimpleClass'
        ),
        'strings' => array(
            'type' => 'string',
            'unbound' => true,
            'attribute' => false,
            'elementName' => 'strings'
        ),
        'integers' => array(
            'type' => 'integer',
            'unbound' => true,
            'attribute' => false,
            'elementName' => 'integers'
        ),
        'base64BinaryType' => array(
            'type' => 'DTS\eBaySDK\Mocks\Base64BinaryType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'base64BinaryType'
        ),
        'booleanType' => array(
            'type' => 'DTS\eBaySDK\Mocks\BooleanType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'booleanType'
        ),
        'decimalType' => array(
            'type' => 'DTS\eBaySDK\Mocks\DecimalType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'decimalType'
        ),
        'doubleType' => array(
            'type' => 'DTS\eBaySDK\Mocks\DoubleType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'doubleType'
        ),
        'integerType' => array(
            'type' => 'DTS\eBaySDK\Mocks\IntegerType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'integerType'
        ),
        'stringType' => array(
            'type' => 'DTS\eBaySDK\Mocks\StringType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'stringType'
        ),
        'tokenType' => array(
            'type' => 'DTS\eBaySDK\Mocks\TokenType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'tokenType'
        ),
        'uriType' => array(
            'type' => 'DTS\eBaySDK\Mocks\URIType',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'uriType'
        ),
        'integerAttribute' => array(
            'type' => 'integer',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'IntegerAttribute'
        ),
        'doubleAttribute' => array(
            'type' => 'double',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'doubleAttribute'
        ),
        'booleanTrueAttribute' => array(
            'type' => 'boolean',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'BooleanTrueAttribute'
        ),
        'booleanFalseAttribute' => array(
            'type' => 'boolean',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'booleanFalseAttribute'
        ),
        'dateTimeAttribute' => array(
            'type' => 'DateTime',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'DateTimeAttribute'
        ),
        'bish' => array(
            'type' => 'string',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'BISH'
        ),
        'bishBash' => array(
            'type' => 'string',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'BishBash'
        )
    );

    public function __construct(array $values = array())
    {
        $elementNamesMap = self::buildElementNamesMap(self::$propertyTypes);

        list($parentValues, $childValues) = self::getParentValues($elementNamesMap, self::$propertyTypes, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], self::$propertyTypes);
        }

        if (!array_key_exists(__CLASS__, self::$elementNames)) {
            self::$elementNames[__CLASS__] = array_merge(self::$elementNames[get_parent_class()], $elementNamesMap);
        }

        if (!array_key_exists(__CLASS__, self::$xmlNamespaces)) {
            self::$xmlNamespaces[__CLASS__] = 'http://davidtsadler.com';
        }

        $this->setValues(__CLASS__, $childValues);
    }
}
