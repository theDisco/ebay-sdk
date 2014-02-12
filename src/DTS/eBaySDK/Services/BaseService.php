<?php
namespace DTS\eBaySDK\Services;

use DTS\eBaySDK\Parser\XmlParser;

abstract class BaseService
{
    protected static $configProperties = array();

    private $httpClient;

    private $config;

    private $productionUrl;

    private $sandboxUrl;

    public function __construct(
        \DTS\eBaySDK\Interfaces\HttpClientInterface $httpClient, 
        $productionUrl,
        $sandboxUrl,
        $config = array()
    ) {
        // Inject a 'sandbox' property for every derived class.
        if (!array_key_exists('sandbox', self::$configProperties[get_called_class()])) {
            self::$configProperties[get_called_class()]['sandbox'] = array('required' => false);
        }

        self::ensureValidConfigProperties($config);    

        $this->httpClient = $httpClient;
        $this->productionUrl = $productionUrl;
        $this->sandboxUrl = $sandboxUrl;
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
                return array_key_exists($property, $this->config) ? $this->config[$property] : null;
            } 
            $this->config = $property;
        }
        return $this->config;
    }

    protected function callOperation($name, $body, $responseClass)
    {
        $headers = $this->getEbayHeaders($name);
        $headers['Content-Type'] = 'text/xml';
        $headers['Content-Length'] = strlen($body);

        $response = $this->httpClient->post($this->getUrl(), $headers, $body);

        $xmlParser = new XmlParser($responseClass);

        return $xmlParser->parse($response); 
    }

    /*
     * Derived classes must implement this method that will build the needed eBay http headers.
     *
     * @param string $operationName The name of the operation been called.
     *
     * @return array An associative array of eBay http headers. 
     */
    abstract protected function getEbayHeaders($operationName);

    private function getUrl()
    {
        return $this->config('sandbox') ? $this->sandboxUrl : $this->productionUrl;
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
        if (!array_key_exists($property, self::$configProperties[$class])) {
            throw new \InvalidArgumentException("Unknown configuration property: $property");
        }
    }
}
