<?php

class SimpleClass extends \DTS\eBaySDK\Types\BaseType
{
    public function __construct()
    {
        $properties = [
            'integer' => [
                'type' => 'integer',
                'unbound' => false
            ],
            'string' => [
                'type' => 'string',
                'unbound' => false
            ],
            'double' => [
                'type' => 'double',
                'unbound' => false
            ],
            'dateTime' => [
                'type' => 'DateTime',
                'unbound' => false
            ],
            'simpleClass' => [
                'type' => 'SimpleClass',
                'unbound' => false
            ],
            'strings' => [
                'type' => 'string',
                'unbound' => true
            ],
            'integers' => [
                'type' => 'integer',
                'unbound' => true
            ]
        ];

        parent::__construct();

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], $properties);
        }
    }
}
