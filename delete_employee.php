<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";
require_once "helpers/s3_upload.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

/*
|--------------------------------------------------------------------------
| Get Employee Details
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("SELECT profile_image FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$employee = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Delete Image From S3
|--------------------------------------------------------------------------
*/

if (!empty($employee['profile_image'])) {

    try {

        deleteFromS3($employee['profile_image']);

    } catch (Exception $e) {

        // Continue even if image deletion fails

    }

}

/*
|--------------------------------------------------------------------------
| Delete Employee Record
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: index.php?deleted=1");
    exit();

} else {

    die("Delete Failed: " . $stmt->error);

}

?>