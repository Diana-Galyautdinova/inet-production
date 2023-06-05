<?php

function getUniqueById(array $array): array
{
    $ids = array_column($array, 'id');
    $uniqueId = array_unique($ids);
    $uniqueKeys = array_keys($uniqueId);

    return array_map(function ($key) use ($array) {
        return $array[$key];
    }, $uniqueKeys);
}

function sortById(array $array): array
{
    usort($array, function ($a, $b) {
        return $a['id'] <=> $b['id'];
    });

    return $array;
}

function getFreshArray(array $array): array
{
    $res = [];
    $names = array_column($array, 'name');
    array_map(function ($key, $date) use (&$res) {
        if ($date >= "test2") {
            $res[] = $key;
        }
    }, array_keys($names), array_values($names));

    return array_intersect_key($array, array_flip($res));
}

function convertArray(array $array): array
{
    return array_map(function ($item) {
        return [
            $item['name'] => $item['id']
        ];
    }, $array);
}

function getArray(): array
{
    return [
        ["id" => 1, "date" => "12.01.2020", "name" => "test1"],
        ["id" => 2, "date" => "02.05.2020", "name" => "test2"],
        ["id" => 4, "date" => "08.03.2020", "name" => "test4"],
        ["id" => 1, "date" => "22.01.2020", "name" => "test1"],
        ["id" => 2, "date" => "11.11.2020", "name" => "test4"],
        ["id" => 3, "date" => "06.06.2020", "name" => "test3"],
    ];
}

$array = getArray();
$result1 = getUniqueById($array);
var_dump($result1);

$result2 = sortById($array);
var_dump($result2);

$result3 = getFreshArray($array);
var_dump($result3);

$result4 = convertArray($array);
var_dump($result4);
