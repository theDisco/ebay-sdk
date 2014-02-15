<?php
namespace DTS\eBaySDK\Mocks;

class Service extends \DTS\eBaySDK\Mocks\BaseService
{
    public function __construct(\DTS\eBaySDK\Interfaces\HttpClientInterface $httpClient, $config = array())
    {
        parent::__construct($httpClient, $config);
    }

    public function foo(\DTS\eBaySDK\Mocks\ComplexClass $request)
    {
        return $this->callOperation(
            'foo',
            $request->toXml('FooRequest', true),
            '\DTS\eBaySDK\Mocks\ComplexClass'
        );
    }
}
