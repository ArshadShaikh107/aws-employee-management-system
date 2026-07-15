<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";
require_once "helpers/s3_upload.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_GET['id'];

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $department_id = $_POST['department_id'];
    $designation_id = $_POST['designation_id'];
    $salary = $_POST['salary'];
    $hire_date = $_POST['hire_date'];

    // Get current image
    $stmt = $conn->prepare("SELECT profile_image FROM employees WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $employee = $stmt->get_result()->fetch_assoc();

    $profile_image = $employee['profile_image'];

    // Upload new image to S3
if (!empty($_FILES['profile_image']['name'])) {

    try {

        // Delete previous image from S3
        if (!empty($profile_image)) {
            deleteFromS3($profile_image);
        }

        // Upload new image
        $profile_image = uploadToS3($_FILES['profile_image']);

    } catch (Exception $e) {

        die("S3 Upload Failed: " . $e->getMessage());

    }

}

    $sql = "UPDATE employees SET
            first_name=?,
            last_name=?,
            email=?,
            phone=?,
            department_id=?,
            designation_id=?,
            hire_date=?,
            salary=?,
            profile_image=?
            WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssiidssi",
        $first_name,
        $last_name,
        $email,
        $phone,
        $department_id,
        $designation_id,
        $hire_date,
        $salary,
        $profile_image,
        $id
    );

    if ($stmt->execute()) {

        header("Location: index.php?updated=1");
        exit();

    } else {

        die($stmt->error);

    }

}

$id = $_GET['id'];

// Fetch Employee
$stmt = $conn->prepare("SELECT * FROM employees WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Employee not found.");
}

$employee = $result->fetch_assoc();

// Fetch Departments
$departments = $conn->query("SELECT * FROM departments ORDER BY department_name");

// Fetch Designations
$designations = $conn->query("SELECT * FROM designations ORDER BY designation_name");

include "includes/header.php";

?>

<div class="card shadow">

<div class="card-header bg-warning">

<h3>

<i class="bi bi-pencil-square"></i>

Edit Employee

</h3>

</div>

<div class="card-body">

<form
action="edit_employee.php?id=<?= $employee['id']; ?>"
method="POST"
enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label>First Name</label>

<input
type="text"
name="first_name"
class="form-control"
value="<?= htmlspecialchars($employee['first_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Last Name</label>

<input
type="text"
name="last_name"
class="form-control"
value="<?= htmlspecialchars($employee['last_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($employee['email']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($employee['phone']); ?>">

</div>

<div class="col-md-6 mb-3">

<label>Department</label>

<select
name="department_id"
class="form-select"
required>

<?php while($row = $departments->fetch_assoc()){ ?>

<option
value="<?= $row['id']; ?>"
<?= ($employee['department_id']==$row['id']) ? "selected" : ""; ?>>

<?= htmlspecialchars($row['department_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Designation</label>

<select
name="designation_id"
class="form-select"
required>

<?php while($row = $designations->fetch_assoc()){ ?>

<option
value="<?= $row['id']; ?>"
<?= ($employee['designation_id']==$row['id']) ? "selected" : ""; ?>>

<?= htmlspecialchars($row['designation_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Salary</label>

<input
type="number"
step="0.01"
name="salary"
class="form-control"
value="<?= $employee['salary']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Hire Date</label>

<input
type="date"
name="hire_date"
class="form-control"
value="<?= $employee['hire_date']; ?>">

</div>

<div class="col-md-12 mb-3">

<label>Current Photo</label>

<br>

<?php if(!empty($employee['profile_image'])){ ?>

<img
src="<?= htmlspecialchars(getS3ImageUrl($employee['profile_image'])); ?>"
width="120"
class="img-thumbnail mb-2">

<?php }else{ ?>

<i class="bi bi-person-circle"
style="font-size:120px;color:gray;"></i>

<?php } ?>

</div>

<div class="col-md-12 mb-3">

<label>Upload New Photo</label>

<input
type="file"
name="profile_image"
class="form-control"
accept="image/*">

</div>

<div class="col-md-12">

<button
class="btn btn-warning">

<i class="bi bi-save"></i>

Update Employee

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

<?php include "includes/footer.php"; ?>