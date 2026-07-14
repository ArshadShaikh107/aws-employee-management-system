<?php

require_once "config/db.php";

echo "<h2>Database Information</h2>";

echo "Host: " . $host . "<br>";
echo "Database: " . $database . "<br><br>";

$result = $conn->query("SELECT username, password FROM users");

while ($row = $result->fetch_assoc()) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}