<?php
require_once 'auth.php';

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

$totalAttendance = 1245;
$totalPresent = 1180;
$totalLate = 48;
$totalSitIn = 17;
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Attendance Reports</title>

<link rel="stylesheet"
href="../css/css/reports.css">

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

    <!-- MAIN -->
    <div class="main-content">

        <h1>Attendance Reports & Analytics</h1>

        <!-- REPORT CARDS -->
        <div class="cards">

            <div class="card">
                <h3>Total Attendance</h3>
                <h2><?= $totalAttendance ?></h2>
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div class="card">
                <h3>Present</h3>
                <h2><?= $totalPresent ?></h2>
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="card">
                <h3>Late</h3>
                <h2><?= $totalLate ?></h2>
                <i class="fa-solid fa-clock"></i>
            </div>

            <div class="card">
                <h3>Sit-In Cases</h3>
                <h2><?= $totalSitIn ?></h2>
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

        </div>

        <!-- FILTER -->
        <div class="glass-card">

            <h2>Generate Report</h2>

            <div class="filters">

                <input type="date">

                <select>
                    <option>All Courses</option>
                    <option>BSIT</option>
                    <option>BSBA</option>
                    <option>BSTM</option>
                    <option>BSHRM</option>
                </select>

                <select>
                    <option>Daily</option>
                    <option>Weekly</option>
                    <option>Monthly</option>
                    <option>Semester</option>
                </select>

                <button class="generate-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Generate
                </button>

            </div>

        </div>

        <!-- REPORT TABLE -->
        <div class="glass-card">

            <h2>Latest Attendance Summary</h2>

            <table>

                <tr>
                    <th>Course</th>
                    <th>Total Students</th>
                    <th>Present</th>
                    <th>Late</th>
                    <th>Absent</th>
                    <th>Sit-In</th>
                    <th>Attendance Rate</th>
                </tr>

                <tr>
                    <td>BSIT</td>
                    <td>320</td>
                    <td>305</td>
                    <td>8</td>
                    <td>5</td>
                    <td>2</td>
                    <td class="green">95%</td>
                </tr>

                <tr>
                    <td>BSBA</td>
                    <td>280</td>
                    <td>262</td>
                    <td>9</td>
                    <td>7</td>
                    <td>2</td>
                    <td class="green">94%</td>
                </tr>

                <tr>
                    <td>BSTM</td>
                    <td>180</td>
                    <td>164</td>
                    <td>6</td>
                    <td>8</td>
                    <td>2</td>
                    <td class="yellow">91%</td>
                </tr>

            </table>

        </div>

        <!-- EXPORT -->
        <div class="glass-card">

            <h2>Export Reports</h2>

            <div class="export-buttons">

                <button class="pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    Export PDF
                </button>

                <button class="excel">
                    <i class="fa-solid fa-file-excel"></i>
                    Export Excel
                </button>

                <button class="print">
                    <i class="fa-solid fa-print"></i>
                    Print Report
                </button>

            </div>

        </div>

    </div>

</div>

</body>
</html>