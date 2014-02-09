<?php
use DTS\eBaySDK\Mocks\Service;
use DTS\eBaySDK\Mocks\ComplexClass;
use DTS\eBaySDK\Mocks\HttpClient;

class ApiRequestTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        /**
         * Use a class that will fake sending requests and getting responses.
         * The idea is that all the information needed to make the request is
         * passed to the client by the service. What we want to test is that the
         * is actualy passed correctly. We are not testing the sending of the request
         * over the internet. 
         * The HttpClient contains properties that will be set when the service
         * makes the request. We can test these properties to check what the service is passing.
         */
        $this->httpClient = new HttpClient();
        // BaseService is abstract so use class that is derived from it for testing.
        $this->service = new Service($this->httpClient);
        $this->request= new ComplexClass();
    }

    public function testProductionUrlIsUsed()
    {
        // By default sandbox will be false.
        $this->service->foo($this->request);
        $this->assertEquals('http://production.com', $this->httpClient->url);
    }

    public function testSandboxUrlIsUsed()
    {
        $this->service->config('sandbox', true);
        $this->service->foo($this->request);
        $this->assertEquals('http://sandbox.com', $this->httpClient->url);
    }

    public function testHttpHeadersAreCreated()
    {
        $this->service->foo($this->request);
        $this->assertEquals(array(
            'fooHdr' => 'foo',
            'Content-Type' => 'text/xml',
            'Content-Length' => strlen($this->request->toXml('FooRequest', true))
        ), $this->httpClient->headers);
    }

    public function testXmlIsCreated()
    {
        $this->service->foo($this->request);
        $this->assertEquals($this->request->toXml('FooRequest', true), $this->httpClient->body);
    }
}
