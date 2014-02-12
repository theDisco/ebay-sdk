<?php
namespace DTS\eBaySDK\Services;

use DTS\eBaySDK\Parser\XmlParser;
use \DTS\eBaySDK\Exceptions;

abstract class BaseService
{
    protected static $configOptions = array();

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
        // Inject a 'sandbox' option for every derived class.
        if (!array_key_exists('sandbox', self::$configOptions[get_called_class()])) {
            self::$configOptions[get_called_class()]['sandbox'] = array('required' => false);
        }

        self::ensureValidConfigOptions($config);

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
     * @throws UnknownConfigurationOptionException if an unknown configuration option is passed as an argument or via the associative array.
     *
     * @return mixed Returns an associative array of configuration options if no parameters are passed, otherwise returns the value for the specified configuration option.
     */
    public function config($option = null, $value = null)
    {
        if ($option !== null) {
            self::ensureValidConfigOptions($option);

            if (!is_array($option)) {
                if ($value !== null) {
                    $this->config[$option] = $value;
                }
                return array_key_exists($option, $this->config) ? $this->config[$option] : null;
            }
            $this->config = $option;
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

    private static function ensureValidConfigOptions($option)
    {
        $class = get_called_class();

        if (!is_array($option)) {
            self::ensureValidConfigOption($class, $option);
        } else {
            $keys = array_keys($option);
            foreach ($keys as $key) {
                self::ensureValidConfigOption($class, $key);
            }
        }
    }

    private static function ensureValidConfigOption($class, $option)
    {
        if (!array_key_exists($option, self::$configOptions[$class])) {
            throw new Exceptions\UnknownConfigurationOptionException($class, $option);
        }
    }
}
