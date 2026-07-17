<?php
require_once 'auth.php';

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if($conn->connect_error){
    die("Connection Failed");
}

$result = $conn->query("
SELECT *
FROM attendance_logs
ORDER BY scan_time DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Attendance Monitoring</title>

<link rel="stylesheet"
href="../css/css/attendance.css">

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

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <h1>
            Attendance Monitoring
        </h1>

        <div class="cards">

            <div class="card">
                <h3>Today's Attendance</h3>
                <h2>1,245</h2>
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div class="card">
                <h3>Late Students</h3>
                <h2>14</h2>
                <i class="fa-solid fa-clock"></i>
            </div>

            <div class="card">
                <h3>Sit-In Attempts</h3>
                <h2>3</h2>
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="card">
                <h3>ESP32 Devices Online</h3>
                <h2>8</h2>
                <i class="fa-solid fa-microchip"></i>
            </div>

        </div>

        <!-- Filters -->
        <div class="glass-card">

            <div class="filters">

                <input type="date">

                <select>
                    <option>All Courses</option>
                    <option>BSIT</option>
                    <option>BSBA</option>
                    <option>BSTM</option>
                </select>

                <select>
                    <option>All Status</option>
                    <option>Present</option>
                    <option>Late</option>
                    <option>Sit-In</option>
                    <option>Absent</option>
                </select>

                <button>
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>

            </div>

        </div>

        <!-- Attendance Table -->
        <div class="glass-card">

            <table>

                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Subject</th>
                    <th>Professor</th>
                    <th>Device</th>
                    <th>Room</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Cloud</th>
                </tr>

                <?php if($result && $result->num_rows > 0): ?>

                    <?php while($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td><?= $row['student_number'] ?></td>
                        <td><?= $row['student_name'] ?></td>
                        <td><?= $row['course'] ?></td>
                        <td><?= $row['subject_code'] ?></td>
                        <td><?= $row['professor_name'] ?></td>
                        <td><?= $row['device_name'] ?></td>
                        <td><?= $row['room_name'] ?></td>
                        <td><?= $row['scan_time'] ?></td>

                        <td>
                            <span class="<?= strtolower($row['status']) ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>

                        <td class="online">
                            Synced
                        </td>

                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="10" style="text-align:center;">
                            No attendance records found.
                        </td>
                    </tr>

                <?php endif; ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>a