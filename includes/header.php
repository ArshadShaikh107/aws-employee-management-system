<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand" href="../dashboard.php">

Employee Management

</a>

<button class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav me-auto">

<li class="nav-item">

<a class="nav-link"
href="/employee-management/dashboard.php">

Dashboard

</a>

</li>

<li class="nav-item">

<a class="nav-link"
href="/employee-management/employees/index.php">

Employees

</a>

</li>

</ul>

<span class="text-white me-3">

Welcome,
<?php echo $_SESSION['fullname']; ?>

</span>

<a
href="/employee-management/logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</div>

</nav>

<div class="container mt-4">