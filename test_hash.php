<?php

require_once "config/db.php";

$result = $conn->query("SELECT password FROM users WHERE username='admin'");
$user = $result->fetch_assoc();

echo "Hash from DB: " . $user['password'] . "<br><br>";

if (password_verify("Admin@123", $user['password'])) {
    echo "PASSWORD MATCH";
} else {
    echo "PASSWORD DOES NOT MATCH";
}