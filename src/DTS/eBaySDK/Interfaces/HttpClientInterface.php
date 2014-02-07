<?php
namespace DTS\eBaySDK\Interfaces;

/**
 * Client interface for sending HTTP POST requests to eBay.
 *
 * The idea is that client code should be free to implement how requests are sent to eBay.
 * This is done by the client code creating its own class that is derived from this interface.
 *
 * This reason for letting client code handle the implementation is that it gives users of the SDK
 * the freedom to chose how requests are to be sent. For example, some users may want to log every request.
 * 
 * Note that the SDK will provide an implementation of this interface in the HttpClient class. This class
 * is meant to help users of the SDK to quickly get up and running. In practice users should create their own
 * implementation for use in production. 
 */
interface HttpClientInterface
{
    /**
     * Create an API POST request and send it to eBay.
     *
     * @param string  $url      API endpoint.
     * @param array   $headers  Associative array of HTTP headers.
     * @param string  $body     The body of the POST request. Will be a XML string for the API operation call.
     *
     * @return string           The XML response from the API.
     */
    public function post($url, $headers, $body);
}
