<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";

include "includes/header.php";

$sql = "
SELECT

e.id,
e.first_name,
e.last_name,
e.email,
e.phone,
e.salary,
e.profile_image,

d.department_name,

g.designation_name

FROM employees e

JOIN departments d
ON e.department_id = d.id

JOIN designations g
ON e.designation_id = g.id

ORDER BY e.id DESC
";

$result = $conn->query($sql);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        <i class="bi bi-people-fill"></i>
        Employees
    </h2>

    <a href="add_employee.php" class="btn btn-success">

        <i class="bi bi-plus-circle"></i>

        Add Employee

    </a>

</div>

<div class="card shadow">

<div class="card-body">

<div class="mb-3">

<input
type="text"
id="searchEmployee"
class="form-control"
placeholder="Search employee...">

</div>

<div class="table-responsive">

<table class="table table-hover align-middle" id="employeeTable">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Photo</th>

<th>Name</th>

<th>Email</th>

<th>Department</th>

<th>Designation</th>

<th>Salary</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td>

<?php

if(!empty($row['profile_image'])){

?>

<img
src="<?= $row['profile_image']; ?>"
width="45"
height="45"
class="rounded-circle">

<?php

}else{

?>

<i class="bi bi-person-circle fs-2 text-secondary"></i>

<?php

}

?>

</td>

<td>

<?= htmlspecialchars($row['first_name']." ".$row['last_name']); ?>

</td>

<td>

<?= htmlspecialchars($row['email']); ?>

</td>

<td>

<span class="badge bg-primary">

<?= htmlspecialchars($row['department_name']); ?>

</span>

</td>

<td>

<?= htmlspecialchars($row['designation_name']); ?>

</td>

<td>

₹<?= number_format($row['salary']); ?>

</td>

<td>

<a
href="view_employee.php?id=<?= $row['id']; ?>"
class="btn btn-info btn-sm">

<i class="bi bi-eye"></i>

</a>

<a
href="edit_employee.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete_employee.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>