<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "config/db.php";

// Dashboard Statistics
$employeeCount = $conn->query("SELECT COUNT(*) AS total FROM employees")->fetch_assoc()['total'];

$departmentCount = $conn->query("SELECT COUNT(*) AS total FROM departments")->fetch_assoc()['total'];

$designationCount = $conn->query("SELECT COUNT(*) AS total FROM designations")->fetch_assoc()['total'];

// Recent Employees
$recentEmployees = $conn->query("
SELECT
    e.first_name,
    e.last_name,
    d.department_name,
    g.designation_name,
    e.salary,
    e.hire_date

FROM employees e

JOIN departments d
ON e.department_id = d.id

JOIN designations g
ON e.designation_id = g.id

ORDER BY e.id DESC

LIMIT 5
");

include "includes/header.php";

?>

<!-- Statistics Cards -->

<div class="row">

    <!-- Employees -->

    <div class="col-lg-4 col-md-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="text-muted">Total Employees</h6>

                    <h2><?php echo $employeeCount; ?></h2>

                </div>

                <div>

                    <i class="bi bi-people-fill stat-icon"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Departments -->

    <div class="col-lg-4 col-md-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="text-muted">Departments</h6>

                    <h2><?php echo $departmentCount; ?></h2>

                </div>

                <div>

                    <i class="bi bi-diagram-3-fill stat-icon text-success"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Designations -->

    <div class="col-lg-4 col-md-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="text-muted">Designations</h6>

                    <h2><?php echo $designationCount; ?></h2>

                </div>

                <div>

                    <i class="bi bi-briefcase-fill stat-icon text-warning"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Recent Employees -->

<div class="card shadow">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            <i class="bi bi-clock-history"></i>

            Recent Employees

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

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

                if ($recentEmployees->num_rows > 0) {

                    while ($row = $recentEmployees->fetch_assoc()) {

                ?>

                    <tr>

                        <td>

                            <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?>

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                <?php echo htmlspecialchars($row['department_name']); ?>

                            </span>

                        </td>

                        <td>

                            <?php echo htmlspecialchars($row['designation_name']); ?>

                        </td>

                        <td>

                            ₹<?php echo number_format($row['salary'], 2); ?>

                        </td>

                        <td>

                            <?php echo date("d M Y", strtotime($row['hire_date'])); ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="5" class="text-center">

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

<?php

include "includes/footer.php";

?>