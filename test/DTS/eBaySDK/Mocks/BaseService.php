<?php
namespace DTS\eBaySDK\Mocks;

class BaseService extends \DTS\eBaySDK\Services\BaseService
{
    public function __construct(\DTS\eBaySDK\Interfaces\HttpClientInterface $httpClient, $config = array())
    {
        if (!array_key_exists(get_called_class(), self::$configOptions)) {
            self::$configOptions[get_called_class()] = array(
                'foo' => array('required' => false),
                'bish' => array('required' => false),
                'bash' => array('required' => false),
                'bosh' => array('required' => false)
            );
        }

        parent::__construct($httpClient, 'http://production.com', 'http://sandbox.com', $config);
    }

    protected function getEbayHeaders($operationName)
    {
        return array('fooHdr' => $operationName);
    }
}
