<?php

session_start();
require_once "config/db.php";

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM users WHERE username=?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // DEBUG
    echo "<pre>";
    var_dump(password_verify($password, $user['password']));
    echo "</pre>";

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];

        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";

        exit("Authentication Successful");

    } else {

        exit("Password Verify Failed");

    }

}

exit("User Not Found");