<?php

class ComplexClass extends SimpleClass
{
    public function __construct(array $values = [])
    {
        $properties = [
            'foo' => [
                'type' => 'string',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'foo'
            ],
            'amountClass' => [
                'type' => 'AmountClass',
                'unbound' => false,
                'attribute' => false,
                'elementName' => 'AmountClass'
            ],
            'simpleClasses' => [
                'type' => 'SimpleClass',
                'unbound' => true,
                'attribute' => false,
                'elementName' => 'simpleClasses'
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
