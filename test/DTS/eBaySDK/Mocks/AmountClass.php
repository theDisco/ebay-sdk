<?php
namespace DTS\eBaySDK\Mocks;

class AmountClass extends \DTS\eBaySDK\Types\DoubleType
{
    private static $propertyTypes = array(
        'attributeOne' => array(
            'type' => 'string',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'AttributeOne'
        ),
        'attributeTwo' => array(
            'type' => 'string',
            'unbound' => false,
            'attribute' => true,
            'attributeName' => 'AttributeTwo'
        )
    );

    public function __construct(array $values = array())
    {
        list($parentValues, $childValues) = self::getParentValues(self::$propertyTypes, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], self::$propertyTypes);
        }

        if (!array_key_exists(__CLASS__, self::$xmlNamespaces)) {
            self::$xmlNamespaces[__CLASS__] = 'http://davidtsadler.com';
        }

        $this->setValues(__CLASS__, $childValues);
    }
}
