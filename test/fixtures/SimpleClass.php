<?php

class SimpleClass extends \DTS\eBaySDK\Types\BaseType
{
    public function __construct(array $values = [])
    {
        $properties = [
            'integer' => [
                'type' => 'integer',
                'unbound' => false,
                'attribute' => false
            ],
            'string' => [
                'type' => 'string',
                'unbound' => false,
                'attribute' => false
            ],
            'double' => [
                'type' => 'double',
                'unbound' => false,
                'attribute' => false
            ],
            'dateTime' => [
                'type' => 'DateTime',
                'unbound' => false,
                'attribute' => false
            ],
            'simpleClass' => [
                'type' => 'SimpleClass',
                'unbound' => false,
                'attribute' => false
            ],
            'strings' => [
                'type' => 'string',
                'unbound' => true,
                'attribute' => false
            ],
            'integers' => [
                'type' => 'integer',
                'unbound' => true,
                'attribute' => false
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
