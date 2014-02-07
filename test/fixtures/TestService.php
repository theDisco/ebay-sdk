<?php
require_once __DIR__ . '/TestBaseService.php';

class TestService extends TestBaseService
{
    public function __construct(\DTS\eBaySDK\Interfaces\HttpClientInterface $httpClient, $config = array())
    {
        parent::__construct($httpClient, $config);
    }

    public function operationOne(ComplexClass $request)
    {
        return $this->callOperation('testOperationOne', $request->toXml('TestOperationOneRequest', true));    
    }
}
