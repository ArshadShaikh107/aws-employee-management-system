<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");

    exit();

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>

Welcome,

<?php

echo $_SESSION['fullname'];

?>

</h2>

<hr>

<div class="alert alert-success">

Login Successful

</div>

<a
href="logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</body>

</html>