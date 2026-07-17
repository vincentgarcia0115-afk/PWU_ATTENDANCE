<?php
require_once 'auth.php';

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("
    SELECT *
    FROM students
    ORDER BY last_name ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student List</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet" href="../css/css/list.css">

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="../JS/student_list.js" defer></script>
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

            <li class="active">
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

            <li>
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
    <main class="main-content">

        <div class="glass-card">

            <h1 class="student_h1">Student List</h1>

         <table id="studentsTable" class="display">

                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Spreadsheet</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= htmlspecialchars($row['student_number']) ?></td>

                        <td>
                            <?= htmlspecialchars($row['last_name']) ?>,
                            <?= htmlspecialchars($row['first_name']) ?>
                        </td>

                        <td><?= htmlspecialchars($row['course']) ?></td>

                        <td><?= htmlspecialchars($row['year_level']) ?></td>

                        <td><?= htmlspecialchars($row['section']) ?></td>

                        <td><?= htmlspecialchars($row['spreadsheet_class']) ?></td>

                        <td>
                            <a href="edit_student.php?id=<?= $row['id'] ?>" class="edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <a href="delete_student.php?id=<?= $row['id'] ?>"
                            class="delete"
                            onclick="return confirm('Delete this student?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>
</html>