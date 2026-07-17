<?php
session_start();

/* Not logged in */
if (
    !isset($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_logged_in'] !== true
) {
    header("Location: index.php");
    exit();
}

/* Session timeout after 30 minutes */
if (
    isset($_SESSION['last_activity']) &&
    (time() - $_SESSION['last_activity']) > 1800
) {
    session_unset();
    session_destroy();

    header("Location: index.php");
    exit();
}

/* Update activity time */
$_SESSION['last_activity'] = time();

$admin_name = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PWU QR Attendance Admin Dashboard</title>

<link rel="stylesheet" href="dashboard.css">
<link rel="stylesheet" href="../css/css/dashboard.css">


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <img class="logo-img" src="../pictures/PWU LOGO.png" width="70">
            <h2>PWU CDCEC</h2>
            <span>QR Attendance</span>
        </div>

        <ul class="menu">

            <li class="active">
                <a href="dashboard.php">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>

            <!-- STUDENT MANAGEMENT -->
            <li class="menu-title">
                Student Management
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

            <!-- PROFESSOR MANAGEMENT -->
            <li class="menu-title">
                Professor Management
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

            <!-- SYSTEM MODULES -->
            <li class="menu-title">
                System Modules
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

    <!-- MAIN -->
    <main class="main">

        <div class="header">

            <h1>
                QR-Based Student Course Attendance Monitoring System
            </h1>

            <p>
                with Cloud API Integration for PWU CDCEC Calamba
            </p>

        </div>

        <!-- CARDS -->

        <div class="cards">

            <div class="card">
                <h3>Total Students</h3>
                <h1>1,250</h1>
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <div class="card">
                <h3>Total Professors</h3>
                <h1>52</h1>
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>

            <div class="card">
                <h3>Today's Attendance</h3>
                <h1>945</h1>
                <i class="fa-solid fa-qrcode"></i>
            </div>

            <div class="card">
                <h3>ESP32 Devices Online</h3>
                <h1>8</h1>
                <i class="fa-solid fa-microchip"></i>
            </div>

        </div>

        <!-- SECOND ROW -->

      <div class="row">

    <!-- Courses with Students and Sections -->
    <div class="glass large">

        <h2>Courses, Students & Sections</h2>

        <table>

            <tr>
                <th>Course</th>
                <th>Total Students</th>
                <th>Total Sections</th>
            </tr>

            <tr>
                <td>BSIT</td>
                <td>320</td>
                <td>8</td>
            </tr>

            <tr>
                <td>BSBA</td>
                <td>280</td>
                <td>7</td>
            </tr>

            <tr>
                <td>BSHM</td>
                <td>210</td>
                <td>5</td>
            </tr>

            <tr>
                <td>BSTM</td>
                <td>180</td>
                <td>4</td>
            </tr>

            <tr>
                <td>BEED</td>
                <td>140</td>
                <td>3</td>
            </tr>

        </table>

    </div>

    <!-- Online Professors -->
    <div class="glass small">

        <h2>Online Professors</h2>

        <div class="professor-list">

            <div class="professor-item">
                <span>🟢 Prof. Maria Santos</span>
                <small>IT101 • BSIT-1A</small>
            </div>

            <div class="professor-item">
                <span>🟢 Prof. John Cruz</span>
                <small>IT102 • BSIT-1A</small>
            </div>

            <div class="professor-item">
                <span>🟢 Prof. Ana Reyes</span>
                <small>GEC1 • BSIT-1A</small>
            </div>

            <div class="professor-item">
                <span>🔴 Prof. Robert Garcia</span>
                <small>Offline</small>
            </div>

        </div>

    </div>

</div>

<!-- Analytics Section -->

<div class="row">

    <div class="glass large">

        <h2>Attendance Analytics</h2>

        <div class="analytics-container">

            <div class="analytics-card">
                <h3>Today's Attendance</h3>
                <h1>92%</h1>
            </div>

            <div class="analytics-card">
                <h3>Sit-In Attempts</h3>
                <h1 class="red">3</h1>
            </div>

            <div class="analytics-card">
                <h3>Active ESP32 Devices</h3>
                <h1 class="green">8</h1>
            </div>

            <div class="analytics-card">
                <h3>QR Scans Today</h3>
                <h1>1,245</h1>
            </div>

        </div>

        <canvas id="attendanceChart"></canvas>

    </div>

</div>

    </main>

</div>

</body>
</html>