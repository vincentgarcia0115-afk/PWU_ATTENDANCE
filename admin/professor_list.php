<?php
require_once 'auth.php';

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

$result = $conn->query("
    SELECT *
    FROM professors
    ORDER BY last_name ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Professor List</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet"
href="../css/css/list.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <img src="../../pictures/PWU LOGO.png" width="80">
            <h2>PWU CDCEC</h2>
            <span>QR Attendance</span>
        </div>

        <ul class="menu">

            <li>
                <a href="dashboard.php">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>

            <li class="menu-title">
                STUDENT MANAGEMENT
            </li>

            <li>
                <a href="student_registration.php">
                    <i class="fa-solid fa-user-plus"></i>
                    Student Registration
                </a>
            </li>

            <li>
                <a href="student_list.php">
                    <i class="fa-solid fa-users"></i>
                    Student List
                </a>
            </li>

            <li class="menu-title">
                PROFESSOR MANAGEMENT
            </li>

            <li>
                <a href="professor_registration.php">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Professor Registration
                </a>
            </li>

            <li class="active">
                <a href="professor_list.php">
                    <i class="fa-solid fa-user-tie"></i>
                    Professor List
                </a>
            </li>

            <li class="menu-title">
                SYSTEM MODULES
            </li>

            <li>
                <a href="cloud.php">
                    <i class="fa-solid fa-cloud"></i>
                    Cloud Integration
                </a>
            </li>

            <li>
                <a href="attendance.php">
                    <i class="fa-solid fa-qrcode"></i>
                    Attendance
                </a>
            </li>

            <li>
                <a href="courses.php">
                    <i class="fa-solid fa-book-open"></i>
                    Course Management
                </a>
            </li>

            <li>
                <a href="reports.php">
                    <i class="fa-solid fa-chart-pie"></i>
                    Reports
                </a>
            </li>

            <li>
                <a href="spreadsheet.php">
                    <i class="fa-solid fa-file-excel"></i>
                    Spreadsheet Import
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="glass-card">

            <h1 class="student_h1">Professor List</h1>

            <div class="table-container">

                <table>

                   <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subjects</th>
                            <th>Status</th>
                            <th>Device</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                  <tbody>

                        <?php if($result && $result->num_rows > 0): ?>

                        <?php while($row = $result->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($row['employee_id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['last_name']) ?>,
                                <?= htmlspecialchars($row['first_name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['email']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['subjects']) ?>
                            </td>

                            <td>

                                <?php if($row['status'] == 'Online'): ?>

                                    <span class="status-online">
                                        🟢 Online
                                    </span>

                                <?php else: ?>

                                    <span class="status-offline">
                                        🔴 Offline
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?= htmlspecialchars($row['device_name']) ?>
                            </td>

                            <td>

                                <a href="view_professor.php?id=<?= $row['id'] ?>" class="view">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="edit_professor.php?id=<?= $row['id'] ?>" class="edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <a href="delete_professor.php?id=<?= $row['id'] ?>"
                                class="delete"
                                onclick="return confirm('Delete this professor?')">

                                    <i class="fa-solid fa-trash"></i>

                                </a>

                            </td>

                        </tr>

                        <?php endwhile; ?>

                        <?php else: ?>

                        <tr>
                            <td colspan="7" style="text-align:center;">
                                No professors found.
                            </td>
                        </tr>

                        <?php endif; ?>

                        </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>