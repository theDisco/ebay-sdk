<?php
namespace DTS\eBaySDK\Mocks;

class ComplexClass extends \DTS\eBaySDK\Mocks\SimpleClass
{
    private static $propertyTypes = array(
        'foo' => array(
            'type' => 'string',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'foo'
        ),
        'amountClass' => array(
            'type' => 'DTS\eBaySDK\Mocks\AmountClass',
            'unbound' => false,
            'attribute' => false,
            'elementName' => 'AmountClass'
        ),
        'simpleClasses' => array(
            'type' => 'DTS\eBaySDK\Mocks\SimpleClass',
            'unbound' => true,
            'attribute' => false,
            'elementName' => 'simpleClasses'
        )
    );

    public function __construct(array $values = array())
    {
        list($parentValues, $childValues) = self::getParentValues(__CLASS__, self::$propertyTypes, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], self::$propertyTypes);
        }

        if (!array_key_exists(__CLASS__, self::$elementNames)) {
            self::$elementNames[__CLASS__] = array_merge(self::$elementNames[get_parent_class()], self::buildElementNamesMap(self::$propertyTypes));
        }

        if (!array_key_exists(__CLASS__, self::$xmlNamespaces)) {
            self::$xmlNamespaces[__CLASS__] = 'http://davidtsadler.com';
        }

        $this->setValues(__CLASS__, $childValues);
    }
}
