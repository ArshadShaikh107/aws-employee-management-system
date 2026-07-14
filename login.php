<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Employee Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header text-center">
<h3>Admin Login</h3>
</div>

<div class="card-body">

<?php
if(isset($_GET['error'])){
    echo "<div class='alert alert-danger'>Invalid Username or Password</div>";
}
?>

<form action="authenticate.php" method="POST">

<div class="mb-3">
<label>Username</label>
<input
type="text"
name="username"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Password</label>
<input
type="password"
name="password"
class="form-control"
required>
</div>

<button class="btn btn-primary w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>