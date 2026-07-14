<?php

$host = "employee-db1.ch8qyagi69r7.ap-south-1.rds.amazonaws.com";
$username = "admin";
$password = "Arshad107";
$database = "employee_management";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

echo "Database Connected Successfully!";

?>