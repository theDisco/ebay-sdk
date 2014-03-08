<?php
use DTS\eBaySDK\Mocks\Service;
use DTS\eBaySDK\Mocks\HttpClient;
use DTS\eBaySDK\Mocks\Logger;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        // BaseService is abstract so use class that is derived from it for testing.
        $this->service = new Service(new HttpClient());
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\Service', $this->service);
    }

    public function testExtendsMockBaseService()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\BaseService', $this->service);
    }

    public function testExtendsBaseService()
    {
        $this->assertInstanceOf('\DTS\eBaySDK\Services\BaseService', $this->service);
    }
  
    public function testCanAssignALogger()
    {
        // By default no logger should be assigned.
        $this->assertEquals(null, $this->service->logger());

        // Allows a logger to be assigned.
        $this->service->logger(new Logger());

        // Should return the assigned logger.
        $this->assertInstanceOf('\DTS\eBaySDK\Mocks\Logger', $this->service->logger());
    } 
}
