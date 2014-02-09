<?php
use DTS\eBaySDK\Mocks\Service;
use DTS\eBaySDK\Mocks\HttpClient;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        // BaseService is abstract so use class that is derived from it for testing.
        $this->obj = new Service(new HttpClient());
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\Service', $this->obj);
    }

    public function testExtendsMockBaseService()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\BaseService', $this->obj);
    }

    public function testExtendsBaseService()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Services\BaseService', $this->obj);
    }
}
