<?php

class SimpleClass extends \DTS\eBaySDK\Types\BaseType
{
    public function __construct()
    {
        $properties = [
            'integer' => [
                'type' => 'integer'
            ],
            'string' => [
                'type' => 'string'
            ],
            'double' => [
                'type' => 'double'
            ],
            'dateTime' => [
                'type' => 'DateTime'
            ],
            'simpleClass' => [
                'type' => 'SimpleClass'
            ]
        ];

        parent::__construct();

        if(!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], $properties);
        }
    }
}
