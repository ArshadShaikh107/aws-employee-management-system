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

$sql = "
SELECT
e.*,
d.department_name,
g.designation_name
FROM employees e
JOIN departments d ON e.department_id=d.id
JOIN designations g ON e.designation_id=g.id
WHERE e.id=?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();

$result=$stmt->get_result();

if($result->num_rows==0){
    die("Employee not found.");
}

$employee=$result->fetch_assoc();

include "includes/header.php";

?>

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>

Employee Details

</h3>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-3 text-center">

<?php

if(!empty($employee['profile_image'])){

?>

<img
src="<?= htmlspecialchars($employee['profile_image']) ?>"
class="img-fluid rounded-circle border"
style="width:180px;height:180px;object-fit:cover;">

<?php

}else{

?>

<i class="bi bi-person-circle"
style="font-size:170px;color:gray;"></i>

<?php

}

?>

</div>

<div class="col-md-9">

<table class="table">

<tr>
<th>Name</th>
<td><?= htmlspecialchars($employee['first_name']." ".$employee['last_name']) ?></td>
</tr>

<tr>
<th>Email</th>
<td><?= htmlspecialchars($employee['email']) ?></td>
</tr>

<tr>
<th>Phone</th>
<td><?= htmlspecialchars($employee['phone']) ?></td>
</tr>

<tr>
<th>Department</th>
<td><?= htmlspecialchars($employee['department_name']) ?></td>
</tr>

<tr>
<th>Designation</th>
<td><?= htmlspecialchars($employee['designation_name']) ?></td>
</tr>

<tr>
<th>Salary</th>
<td>₹<?= number_format($employee['salary'],2) ?></td>
</tr>

<tr>
<th>Hire Date</th>
<td><?= date("d M Y",strtotime($employee['hire_date'])) ?></td>
</tr>

<tr>
<th>Created At</th>
<td><?= date("d M Y H:i",strtotime($employee['created_at'])) ?></td>
</tr>

</table>

<a
href="edit_employee.php?id=<?= $employee['id'] ?>"
class="btn btn-warning">

<i class="bi bi-pencil"></i>

Edit Employee

</a>

<a
href="index.php"
class="btn btn-secondary">

Back

</a>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>