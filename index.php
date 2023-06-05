<?php

function setEnv()
{
    $envPath = __DIR__ . '/.env';
    $env = file_get_contents($envPath);
    if (!$env) {
        $envExamplePath = __DIR__ . '/.envExample';
        $env = file_get_contents($envExamplePath);
    }

    $envData = explode("\n", $env);
    foreach ($envData as $envDatum) {
        putenv("$envDatum");
    }
}

function connectDB(): mysqli
{
    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $db = getenv('DB_DATABASE');

    $conn = new mysqli($host, $user, $password, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully\n";

    return $conn;
}

function makeQuery(string $sql): mysqli_result|array|bool
{
    $conn = connectDB();
    if ($res = $conn->query($sql)) {
        echo "Table created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error . "\n";
    }

    $conn->close();

    return !is_bool($res) ? $res->fetch_all() : $res;
}
