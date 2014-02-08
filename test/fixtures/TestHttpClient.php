<?php

class TestHttpClient implements \DTS\eBaySDK\Interfaces\HttpClientInterface
{
    public $url;
    public $headers;
    public $body;

    public function post($url, $headers, $body)
    { 
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }
}
