<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient;

try {

    $client = new SecretsManagerClient([
        'version' => 'latest',
        'region'  => 'ap-south-1'
    ]);

    $result = $client->getSecretValue([
        'SecretId' => 'employee-management-db'
    ]);

    $secret = json_decode($result['SecretString'], true);

    $host = $secret['host'];
    $username = $secret['username'];
    $password = $secret['password'];
    $database = $secret['dbname'];

    $conn = new mysqli(
        $host,
        $username,
        $password,
        $database
    );

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

} catch (Exception $e) {

    die("Secrets Manager Error: " . $e->getMessage());

}