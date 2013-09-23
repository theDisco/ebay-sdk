<?php

class ComplexClass extends SimpleClass
{
    public function __construct()
    {
        $properties = [
            'foo' => [
                'type' => 'string',
                'unbound' => false
            ]
        ];

        parent::__construct();

        if (!array_key_exists(__CLASS__, self::$properties)) {
            self::$properties[__CLASS__] = array_merge(self::$properties[get_parent_class()], $properties);
        }
    }
}
