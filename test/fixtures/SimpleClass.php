<?php

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
                'type' => 'SimpleClass',
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
            ]
        ];

        list($parentValues, $childValues) = self::getParentValues($properties, $values);

        parent::__construct($parentValues);

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], $properties);
        }

        $this->setValues(__CLASS__, $childValues);
    }
}
