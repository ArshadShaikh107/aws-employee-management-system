<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";
include "includes/header.php";

// Fetch Employees
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

    <div>
        <h2>
            <i class="bi bi-people-fill"></i>
            Employee Management
        </h2>
        <p class="text-muted mb-0">
            Manage all employees from one place.
        </p>
    </div>

    <a href="add_employee.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i>
        Add Employee
    </a>

</div>

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success alert-dismissible fade show">

    <strong>Success!</strong> Employee added successfully.

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php } ?>

<div class="card shadow">

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">

                <input
                    type="text"
                    id="searchEmployee"
                    class="form-control"
                    placeholder="Search employee...">

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle" id="employeeTable">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Photo</th>
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

                <?php

                if($result->num_rows > 0){

                    while($row = $result->fetch_assoc()){

                ?>

                    <tr>

                        <td>
                            <?= $row['id']; ?>
                        </td>

                        <td>

                        <?php

                        if(!empty($row['profile_image'])){

                        ?>

                        <img
                            src="<?= htmlspecialchars($row['profile_image']); ?>"
                            width="50"
                            height="50"
                            class="rounded-circle border"
                            style="object-fit:cover;">

                        <?php

                        }else{

                        ?>

                        <i class="bi bi-person-circle fs-1 text-secondary"></i>

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

                            <?= htmlspecialchars($row['phone']); ?>

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

                            ₹<?= number_format($row['salary'],2); ?>

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
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this employee?');">

                                <i class="bi bi-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php

                    }

                }else{

                ?>

                    <tr>

                        <td colspan="9" class="text-center text-muted">

                            No employees found.

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>