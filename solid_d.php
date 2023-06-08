<?php

class Response {}

abstract class XMLHTTPRequestService
{
    abstract public function request(string $url, string $method, ?array $options = []): Response;
}

class XMLHttpService extends XMLHTTPRequestService
{
    public function request(string $url, string $method, ?array $options = []): Response
    {
        //request
    }
}

abstract class HttpRequestService
{
    abstract public function post(string $url, array $options): Response;

    abstract public function get(string $url): Response;
}

class Http extends HttpRequestService
{
    public function __construct(private XMLHttpService $xmlHttpService) {}

    public function post(string $url, array $options): Response
    {
        return $this->xmlHttpService->request($url, 'GET', $options);
    }

    public function get(string $url): Response
    {
        return $this->xmlHttpService->request($url, 'GET');
    }
}