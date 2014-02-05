<?php
namespace DTS\eBaySDK\Services;

abstract class BaseService
{
    protected static $configProperties = array();

    private $config = array();

    public function __construct($config = array())
    {
        self::ensureValidConfigProperties($config);
        $this->config = $config;
    }

    /**
     * Method to get or set the service's configuration.
     *
     * @param mixed Pass an associative array to set multiple configuration options. Pass a string to get or set a single configuration option.
     * @param mixed Will be the value that is assigned when the name of a configuration option is passed in as the first parameter.
     * @throws InvalidArgumentException if an unknown configuration property is passed as an argument or via the associative array.
     * @return mixed Returns an associative array of configuration options if no parameters are passed, otherwise returns the value for the specified configuration option.
     */
    public function config($property = null, $value = null)
    {
        if ($property !== null) {
            self::ensureValidConfigProperties($property);

            if (!is_array($property)) {
                if ($value !== null) {
                    $this->config[$property] = $value;
                }
                return $this->config[$property];
            } 
            $this->config = $property;
        }
        return $this->config;
    }

    private static function ensureValidConfigProperties($property)
    {
        $class = get_called_class();

        if (!is_array($property)) {
            self::ensureValidConfigProperty($class, $property);
        } else {
            $properties = array_keys($property);
            foreach ($properties as $prop) {
                self::ensureValidConfigProperty($class, $prop);
            }
      }
    }

    private static function ensureValidConfigProperty($class, $property)
    {
        if (!array_key_exists($property, self::$configProperties[get_called_class()])) {
            throw new \InvalidArgumentException("Unknown configuration property: $property");
        }
    }
}
