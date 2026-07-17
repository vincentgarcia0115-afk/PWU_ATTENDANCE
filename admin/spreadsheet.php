<?php
require_once 'auth.php';

$message = "";

if(isset($_POST['import'])){
    $message = "Spreadsheet uploaded successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Spreadsheet Import</title>

<link rel="stylesheet"
href="../css/css/spreadsheet.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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

            <li class="menu-title">STUDENT MANAGEMENT</li>

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

            <li class="menu-title">PROFESSOR MANAGEMENT</li>

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

            <li class="menu-title">SYSTEM MODULES</li>

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

            <li class="active">
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

    <!-- MAIN -->
    <main class="main-content">

        <h1>Spreadsheet Import Center</h1>

        <!-- Statistics -->
        <div class="cards">

            <div class="card">
                <h3>Total Imports</h3>
                <h2>145</h2>
                <i class="fa-solid fa-file-import"></i>
            </div>

            <div class="card">
                <h3>Students Imported</h3>
                <h2>4,125</h2>
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <div class="card">
                <h3>Professors Imported</h3>
                <h2>87</h2>
                <i class="fa-solid fa-user-tie"></i>
            </div>

            <div class="card">
                <h3>Cloud Sync</h3>
                <h2>Online</h2>
                <i class="fa-solid fa-cloud"></i>
            </div>

        </div>

        <!-- Upload Card -->
        <div class="glass-card">

            <h2>Import Spreadsheet</h2>

            <?php if($message != ""): ?>
                <div class="success">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="upload-box">

                    <i class="fa-solid fa-file-excel"></i>

                    <h3>Drag and Drop Spreadsheet Here</h3>

                    <p>Supported formats: XLSX, XLS, CSV</p>

                    <input type="file"
                           name="spreadsheet"
                           accept=".xlsx,.xls,.csv"
                           required>

                </div>

                <button type="submit" name="import" class="import-btn">
                    <i class="fa-solid fa-upload"></i>
                    Import Spreadsheet
                </button>

            </form>

        </div>

        <!-- Recent Imports -->
        <div class="glass-card">

            <h2>Recent Imports</h2>

            <table>

                <tr>
                    <th>Filename</th>
                    <th>Imported By</th>
                    <th>Date</th>
                    <th>Rows Imported</th>
                    <th>Status</th>
                </tr>

                <tr>
                    <td>BSIT_Students.xlsx</td>
                    <td>Admin</td>
                    <td>2026-07-14</td>
                    <td>320</td>
                    <td class="success-text">Success</td>
                </tr>

                <tr>
                    <td>Professors.xlsx</td>
                    <td>Admin</td>
                    <td>2026-07-12</td>
                    <td>52</td>
                    <td class="success-text">Success</td>
                </tr>

            </table>

        </div>

    </main>

</div>

</body>
</html>