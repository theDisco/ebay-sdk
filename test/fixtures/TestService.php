<?php

class TestService extends \DTS\eBaySDK\Services\BaseService
{
    public function __construct($config = array())
    {
        if (!array_key_exists(__CLASS__, self::$configProperties)) {
            self::$configProperties[__CLASS__] = array(
                'foo' => array('required' => false),
                'bish' => array('required' => false),
                'bash' => array('required' => false),
                'bosh' => array('required' => false)
            );
        }

        parent::__construct($config);
    }
}
