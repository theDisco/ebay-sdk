<?php
/**
 * Copyright 2014 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace DTS\eBaySDK\Services;

use DTS\eBaySDK\Parser\XmlParser;
use \DTS\eBaySDK\Exceptions;
use \DTS\eBaySDK\HttpClient\HttpClient;

/**
 * The base class for every eBay service class.
 */
abstract class BaseService
{
    /**
     * @var array A list of configuration options allowed for each service class.
     */
    protected static $configOptions = array();

    /**
     * @var mixed The object that will handle the actual sending of the API request.
     */
    private $httpClient;

    /**
     * @var array Associative array storing the current configuration option values.
     */
    private $config;

    /**
     * @var string The production URL for the service.
     */
    private $productionUrl;

    /**
     * @var string The sandbox URL for the service.
     */
    private $sandboxUrl;

    /**
     * @var \Psr\Log\LoggerInterface The logger for the service.
     */
    private $logger;

    /**
     * @param string $productionUrl The production URL.
     * @param string $sandboxUrl The sandbox URL.
     * @param array $config Optional configuration option values.
     * @param \DTS\eBaySDK\Interfaces\HttpClientInterface $httpClient The object that will handle sending requests to the API.
     */
    public function __construct(
        $productionUrl,
        $sandboxUrl,
        $config = array(),
        \DTS\eBaySDK\Interfaces\HttpClientInterface $httpClient = null
    ) {
        // Inject a 'sandbox' option for every derived class.
        if (!array_key_exists('sandbox', self::$configOptions[get_called_class()])) {
            self::$configOptions[get_called_class()]['sandbox'] = array('required' => false);
        }

        // Inject a 'debug' option for every derived class.
        if (!array_key_exists('debug', self::$configOptions[get_called_class()])) {
            self::$configOptions[get_called_class()]['debug'] = array('required' => false);
        }

        self::ensureValidConfigOptions($config);

        $this->productionUrl = $productionUrl;
        $this->sandboxUrl = $sandboxUrl;
        $this->config = $config;
        $this->httpClient = $httpClient ? $httpClient : new \DTS\eBaySDK\HttpClient\HttpClient();
        $this->logger = null;
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

    /**
     *
     * @param $logger \Psr\Log\LoggerInterface The logger instance the service will use.
     *
     * @return \Psr\Log\LoggerInterface The logger instance or null if one hasn't been assigned.
     */
    public function logger(\Psr\Log\LoggerInterface $logger = null)
    {
        if ($logger) {
            $this->logger = $logger;
        }

        return $this->logger;
    }

    /**
     * Sends an API request.
     *
     * @param string $name The name of the operation.
     * @param mixed PHP object containing the request information.
     * @param string The name of the PHP class that will be created from the XML response.
     *
     * @returns mixed A PHP object created from the XML respose.
     */
    protected function callOperation($name, $body, $responseClass)
    {
        $debug = $this->config('debug');

        $url = $this->getUrl();
        $headers = $this->getEbayHeaders($name);
        $headers['Content-Type'] = 'text/xml';
        $headers['Content-Length'] = strlen($body);

        if ($debug) {
            $this->logRequest($url, $name, $headers, $body);
        }

        $response = $this->httpClient->post($url, $headers, $body);

        if ($debug) {
            $this->logResponse($response);
        }

        $xmlParser = new XmlParser($responseClass);

        return $xmlParser->parse($response);
    }

    /**
     * Derived classes must implement this method that will build the needed eBay http headers.
     *
     * @param string $operationName The name of the operation been called.
     *
     * @return array An associative array of eBay http headers.
     */
    abstract protected function getEbayHeaders($operationName);

    /**
     * Helper function to return the URL as determined by the sandbox configuration option.
     *
     * @returns string Either the production or sandbox URL.
     */
    private function getUrl()
    {
        return $this->config('sandbox') ? $this->sandboxUrl : $this->productionUrl;
    }

    /**
     * Helper function to ensure that the passed configuration options exist.
     *
     * @param mixed $option Pass either the name of an option or an array of options.
     * @throws UnknownConfigurationOptionException If an option does not exist.
     */
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

    /**
     * Helper function to ensure that the passed configuration option exists.
     *
     * @param string $option The name of the option.
     * @throws UnknownConfigurationOptionException If the option does not exist.
     */
    private static function ensureValidConfigOption($class, $option)
    {
        if (!array_key_exists($option, self::$configOptions[$class])) {
            throw new Exceptions\UnknownConfigurationOptionException($class, $option);
        }
    }

    /**
     * Logs the request details.
     *
     * @param string $name The name of the operation.
     * @param string $url API endpoint.
     * @param array  $headers Associative array of HTTP headers.
     * @param string $body The XML body of the POST request.
      */
    private function logRequest($url, $name, $headers, $body)
    {
        if ($this->logger) {
            $this->logger->debug('Request', array(
                'url' => $url,
                'name' => $name,
                'headers' => $headers,
                'body' => $body
            ));
        }
    }

    /**
     * Logs the response details.
     *
     * @param string $body The XML body of the response.
      */
    private function logResponse($body)
    {
        if ($this->logger) {
            $this->logger->debug('Response', array(
                'body' => (string)$body
            ));
        }
    }
}
