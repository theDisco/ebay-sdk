<?php
require_once __DIR__ . '/../../../fixtures/TestService.php';

use DTS\eBaySDK\Services\BaseService;

class BaseServiceConfigTest extends \PHPUnit_Framework_TestCase
{
    private $obj;

    protected function setUp()
    {
        // BaseService is abstract so use class that is derived from it for testing.
        $this->obj = new TestService();
    }

    public function testConfig()
    {
        // Passing no parameters to the config method returns the configuration as an associative array.
        $config = $this->obj->config();
        $this->assertInternalType('array', $config);
        // Should be an empty array as no configuration was passed into the object ctor during construction.
        $this->assertEquals(0, count($config));

        // Passing the name of a configuration option and a value will set that option.
        $this->obj->config('foo', 1);
        // We can get the value of a configuration option just by passing its name.
        $this->assertEquals(1, $this->obj->config('foo'));

        // Returns the value assigned to the configuration option.
        $value = $this->obj->config('foo', 'foo');
        $this->assertEquals('foo', $value);

        // Can pass an associative array to set multiple configuration options.
        $options = [
            'bish' => 'bish',
            'bash' => 'bash',
            'bosh' => 'bosh'
        ];
        $config = $this->obj->config($options);
        $this->assertEquals($options, $config);
        $this->assertEquals($options, $this->obj->config());
    }
}
