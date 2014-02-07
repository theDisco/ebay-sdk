<?php
namespace DTS\eBaySDK\HttpClient;

/**
 * Implements the sending of a request to eBay.
 * In practice users of the SDK should create their own classes
 * that implement the HttpClientInterface.
 */
class HttpClient implements \DTS\eBaySDK\Interfaces\HttpClientInterface
{
    public function post($url, $headers, $body)
    { 
    }
}
