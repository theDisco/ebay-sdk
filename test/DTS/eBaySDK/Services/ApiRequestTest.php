<?php
require_once __DIR__ . '/../../../fixtures/TestService.php';
require_once __DIR__ . '/../../../fixtures/TestHttpClient.php';
require_once __DIR__ . '/../../../fixtures/SimpleClass.php';
require_once __DIR__ . '/../../../fixtures/ComplexClass.php';

class ApiRequestTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        // Use a class that will fake sending requests and getting responses.
        $this->httpClient = new TestHttpClient();
        // BaseService is abstract so use class that is derived from it for testing.
        $this->obj = new TestService($this->httpClient);
        $this->requestOne = new ComplexClass();
    }

    public function testRequestCanBeSent()
    {
        $this->obj->operationOne($this->requestOne);
    }
}
