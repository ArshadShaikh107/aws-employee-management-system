<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get employee image
$stmt = $conn->prepare("SELECT profile_image FROM employees WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$employee = $result->fetch_assoc();

// Delete image if exists
if (!empty($employee['profile_image']) && file_exists($employee['profile_image'])) {
    unlink($employee['profile_image']);
}

// Delete employee
$stmt = $conn->prepare("DELETE FROM employees WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: index.php?deleted=1");
    exit();

} else {

    die($stmt->error);

}
?>