<?php
/*
 * Даны 2 класса. Один реализует поведение объектов, второй - сам объект. Привести функцию handleObjects
 * в соответствие с принципом открытости-закрытости (O: Open-Closed Principle) SOLID.
 */

class Response {}

interface XMLHTTPInterface
{
    public function setToken(string $token);
    public function initRequest();
    public function request(string $url, string $method, ?array $options = []): Response;
}

class XMLHttpService implements XMLHTTPInterface
{
    public function setToken(string $token)
    {
        //
    }

    public function initRequest()
    {
        // init request with token
    }
    public function request(string $url, string $method, ?array $options = []): Response
    {
        //request
    }
}

//можно тут сделать не абстракт, а интерфейс, если нужно например реализовать несколько разных Http (с разной реализацией), но с одной точкой входа.
abstract class HttpRequestService extends XMLHttpService
{
    public function __construct(Config $config)
    {
        $this->setToken($config->getSecretKey());
    }

    abstract public function post(string $url, array $options): Response;

    abstract public function get(string $url): Response;
}

class Http extends HttpRequestService
{
    public function post(string $url, array $options): Response
    {
        return $this->request($url, 'GET', $options);
    }

    public function get(string $url): Response
    {
        return $this->request($url, 'GET');
    }
}
