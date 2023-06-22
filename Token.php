<?php

/*
 * Имеется метод getUserData, который получает данные из внешнего API, передавая в запрос необходимые параметры,
 * вместе с ключом (token) идентификации. Необходимо реализовать универсальное решение getSecretKey(),
 * с использованием какого-либо шаблона (pattern) проектирования для хранения этого ключа всевозможными способами
 */

class Config
{
    protected string $token;

    public function getSecretKey(): string
    {
        // токен берется откуда угодно
    }
}

class HttpRequestService extends Http
{
    public function getUser(): Response
    {
        return $this->get('getUser');
    }
}
