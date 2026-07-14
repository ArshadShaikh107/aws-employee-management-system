<?php

session_start();
require_once "config/db.php";

$username = trim($_POST['username']);
$password = trim($_POST['password']);

echo "<h3>Debug Authentication</h3>";

echo "Username Entered: " . htmlspecialchars($username) . "<br>";
echo "Password Entered: " . htmlspecialchars($password) . "<br><br>";

$sql = "SELECT * FROM users WHERE username=?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

echo "Users Found: " . $result->num_rows . "<br><br>";

if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    echo "Database Username: " . $user['username'] . "<br>";
    echo "Database Hash: " . $user['password'] . "<br><br>";

    if (password_verify($password, $user['password'])) {
        echo "<h2 style='color:green'>PASSWORD VERIFIED ✅</h2>";
    } else {
        echo "<h2 style='color:red'>PASSWORD VERIFICATION FAILED ❌</h2>";
    }

} else {

    echo "<h2>User Not Found</h2>";

}
?>