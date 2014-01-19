<?php
namespace DTS\eBaySDK\Services;

abstract class BaseService
{
    private $config = [];

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * Method to get or set the service's configuration.
     *
     * @param mixed Pass an associative array to set multiple configuration options. Pass a string to get or set a single configuration option.
     * @param mixed Will be the value that is assigned when the name of a configuration option is passed in as the first parameter.
     * @return mixed Returns an associative array of configuration options if no parameters are passed, otherwise returns the value for the specified configuration option.
     */
    public function config($key = null, $value = null)
    {
        if ($key !== null) {
            if (!is_array($key)) {
                if ($value !== null) {
                    $this->config[$key] = $value;
                }
                return $this->config[$key];
            } 
            $this->config = $key;
        }
        return $this->config;
    }
}
