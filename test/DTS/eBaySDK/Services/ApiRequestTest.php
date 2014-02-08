<?php
require_once __DIR__ . '/../../../fixtures/TestService.php';
require_once __DIR__ . '/../../../fixtures/SimpleClass.php';
require_once __DIR__ . '/../../../fixtures/ComplexClass.php';

use DTS\eBaySDK\HttpClient\TestHttpClient;

class ApiRequestTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        /**
         * Use a class that will fake sending requests and getting responses.
         * The idea is that all the information needed to make the request is
         * passed to the client by the service. What we want to test is that the
         * is actualy passed correctly. We are not testing the sending of the request
         * over the internet. 
         * The TestHttpClient contains properties that will be set when the service
         * makes the request. We can test these properties to check what the service is passing.
         */
        $this->httpClient = new TestHttpClient();
        // BaseService is abstract so use class that is derived from it for testing.
        $this->service = new TestService($this->httpClient);
        $this->requestOne = new ComplexClass();
    }

    public function testRequestCanBeSent()
    {
        $this->service->operationOne($this->requestOne);
    }

    public function testProductionUrlIsUsed()
    {
        // By default sandbox will be false.
        $this->service->operationOne($this->requestOne);
        $this->assertEquals('http://production.com', $this->httpClient->url);
    }

    public function testSandboxUrlIsUsed()
    {
        $this->service->config('sandbox', true);
        $this->service->operationOne($this->requestOne);
        $this->assertEquals('http://sandbox.com', $this->httpClient->url);
    }

    public function testHttpHeadersAreCreated()
    {
        $this->service->operationOne($this->requestOne);
        $this->assertEquals(array(
            'fooHdr' => 'testOperationOne',
            'Content-Type' => 'text/xml',
            'Content-Length' => strlen($this->requestOne->toXml('TestOperationOneRequest', true))
        ), $this->httpClient->headers);
    }

    public function testXmlIsCreated()
    {
        $this->service->operationOne($this->requestOne);
        $this->assertEquals($this->requestOne->toXml('TestOperationOneRequest', true), $this->httpClient->body);
    }
}
