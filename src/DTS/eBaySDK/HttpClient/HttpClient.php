<?php
namespace DTS\eBaySDK\HttpClient;

use Guzzle\Http\Client;

/**
 * Implements the sending of a request to eBay.
 * In practice users of the SDK should create their own classes
 * that implement the HttpClientInterface.
 */
class HttpClient implements \DTS\eBaySDK\Interfaces\HttpClientInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function post($url, $headers, $body)
    {
        return $this->client->post($url, $headers, $body)->send()->getBody();
    }
}
