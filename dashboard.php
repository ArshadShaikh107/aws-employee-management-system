<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once "config/db.php";

include "includes/header.php";

$employeeCount=$conn->query("SELECT COUNT(*) total FROM employees")->fetch_assoc()['total'];

$departmentCount=$conn->query("SELECT COUNT(*) total FROM departments")->fetch_assoc()['total'];

$designationCount=$conn->query("SELECT COUNT(*) total FROM designations")->fetch_assoc()['total'];

$recentEmployees=$conn->query("

SELECT

e.first_name,
e.last_name,

d.department_name,

g.designation_name,

e.salary,

e.hire_date

FROM employees e

JOIN departments d
ON e.department_id=d.id

JOIN designations g
ON e.designation_id=g.id

ORDER BY e.id DESC

LIMIT 5

");

?>

<div class="row">

<div class="col-md-4">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Employees</h5>

<h1>

<?php echo $employeeCount; ?>

</h1>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center shadow">

<div class="card-body">

<h5>Departments</h5>

<h1>

<?php echo $departmentCount; ?>

</h1>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center shadow">

<div class="card-body">

<h5>Designations</h5>

<h1>

<?php echo $designationCount; ?>

</h1>

</div>

</div>

</div>

</div>

<div class="card shadow mt-4">

<div class="card-header">

Recent Employees

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Name</th>

<th>Department</th>

<th>Designation</th>

<th>Salary</th>

<th>Hire Date</th>

</tr>

</thead>

<tbody>

<?php

while($row=$recentEmployees->fetch_assoc()){

?>

<tr>

<td>

<?php

echo $row['first_name']." ".$row['last_name'];

?>

</td>

<td>

<?php echo $row['department_name']; ?>

</td>

<td>

<?php echo $row['designation_name']; ?>

</td>

<td>

₹<?php echo number_format($row['salary']); ?>

</td>

<td>

<?php echo $row['hire_date']; ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

<?php

include "includes/footer.php";

?>