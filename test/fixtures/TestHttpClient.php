<?php

class TestHttpClient implements \DTS\eBaySDK\Interfaces\HttpClientInterface
{
    public $url;

    public function post($url, $headers, $body)
    { 
        $this->url = $url;
    }
}
