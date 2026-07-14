<?php

$host = "mysql -h employee-db1.ch8qyagi69r7.ap-south-1.rds.amazonaws.com -P 3306 -u admin -p --ssl-mode=VERIFY_IDENTITY --ssl-ca=./global-bundle.pem";
$username = "admin";
$password = "Arshad107";
$database = "employee_management";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>