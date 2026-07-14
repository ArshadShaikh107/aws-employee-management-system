<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once "../config/db.php";
include "../includes/header.php";

$sql = "

SELECT

e.id,

e.first_name,

e.last_name,

e.email,

e.phone,

d.department_name,

g.designation_name,

e.salary

FROM employees e

JOIN departments d
ON e.department_id=d.id

JOIN designations g
ON e.designation_id=g.id

ORDER BY e.id DESC

";

$result = $conn->query($sql);

?>

<div class="d-flex justify-content-between mb-3">

<h2>Employees</h2>

<a href="add.php"
class="btn btn-success">

Add Employee

</a>

</div>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Phone</th>

<th>Department</th>

<th>Designation</th>

<th>Salary</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['first_name']." ".$row['last_name']; ?></td>

<td><?= $row['email']; ?></td>

<td><?= $row['phone']; ?></td>

<td><?= $row['department_name']; ?></td>

<td><?= $row['designation_name']; ?></td>

<td>₹<?= number_format($row['salary']); ?></td>

<td>

<a
href="view.php?id=<?= $row['id']; ?>"
class="btn btn-primary btn-sm">

View

</a>

<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php include "../includes/footer.php"; ?>