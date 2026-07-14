<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $department_id = $_POST['department_id'];
    $designation_id = $_POST['designation_id'];
    $salary = $_POST['salary'];
    $hire_date = $_POST['hire_date'];

    $profile_image = "";

    // Upload Image
    if (!empty($_FILES['profile_image']['name'])) {

    try {

        $profile_image = uploadToS3($_FILES['profile_image']);

    } catch (Exception $e) {

        die("S3 Upload Failed: " . $e->getMessage());

    }

}

    $sql = "INSERT INTO employees
    (
        first_name,
        last_name,
        email,
        phone,
        department_id,
        designation_id,
        hire_date,
        salary,
        profile_image
    )
    VALUES
    (?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssiidss",
        $first_name,
        $last_name,
        $email,
        $phone,
        $department_id,
        $designation_id,
        $hire_date,
        $salary,
        $profile_image
    );

    if ($stmt->execute()) {

        header("Location: index.php?success=1");
        exit();

    } else {

        echo "<div class='alert alert-danger'>".$stmt->error."</div>";

    }

}

require_once "helpers/s3_upload.php";

$departments = $conn->query("SELECT * FROM departments ORDER BY department_name");

$designations = $conn->query("SELECT * FROM designations ORDER BY designation_name");

include "includes/header.php";

?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>

<i class="bi bi-person-plus-fill"></i>

Add Employee

</h3>

</div>

<div class="card-body">

<form
action="add_employee.php"
method="POST"
enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

First Name

</label>

<input
type="text"
name="first_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Last Name

</label>

<input
type="text"
name="last_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Phone

</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Department

</label>

<select
name="department_id"
class="form-select"
required>

<option value="">Select Department</option>

<?php while($row = $departments->fetch_assoc()){ ?>

<option value="<?= $row['id']; ?>">

<?= htmlspecialchars($row['department_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Designation

</label>

<select
name="designation_id"
class="form-select"
required>

<option value="">Select Designation</option>

<?php while($row = $designations->fetch_assoc()){ ?>

<option value="<?= $row['id']; ?>">

<?= htmlspecialchars($row['designation_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Salary

</label>

<input
type="number"
step="0.01"
name="salary"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Hire Date

</label>

<input
type="date"
name="hire_date"
class="form-control">

</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Profile Image

</label>

<input
type="file"
name="profile_image"
class="form-control"
accept="image/*">

</div>

<div class="col-12">

<button
class="btn btn-success">

<i class="bi bi-check-circle"></i>

Save Employee

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

</div>

<?php include "includes/footer.php"; ?>