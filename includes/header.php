<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet"
        href="assets/css/style.css">

</head>

<body>

<div class="sidebar">

    <h4>
        <i class="bi bi-building"></i>
        EMS
    </h4>

    <a href="dashboard.php">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="index.php">
        <i class="bi bi-people-fill"></i>
        Employees
    </a>

    <a href="#">
        <i class="bi bi-diagram-3-fill"></i>
        Departments
    </a>

    <a href="#">
        <i class="bi bi-briefcase-fill"></i>
        Designations
    </a>

    <a href="#">
        <i class="bi bi-graph-up-arrow"></i>
        Reports
    </a>

    <a href="#">
        <i class="bi bi-gear-fill"></i>
        Settings
    </a>

    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

</div>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Employee Management System
            </h2>

            <p class="text-muted">
                AWS Cloud Project
            </p>

        </div>

        <div>

            <span class="badge bg-primary fs-6">

                <i class="bi bi-person-circle"></i>

                <?php echo htmlspecialchars($_SESSION['fullname']); ?>

            </span>

        </div>

    </div>