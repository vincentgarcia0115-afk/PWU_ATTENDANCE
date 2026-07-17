<?php
require_once 'auth.php';

$cloud_status = "Connected";
$database_status = "Online";
$spreadsheet_status = "Connected";

$last_sync = date("F d, Y h:i:s A");
$api_response = "";

$devices = [
    [
        "name" => "ESP32-Room301",
        "location" => "Room 301",
        "status" => "Online"
    ],
    [
        "name" => "ESP32-IT-LAB",
        "location" => "IT Laboratory",
        "status" => "Online"
    ],
    [
        "name" => "ESP32-Room305",
        "location" => "Room 305",
        "status" => "Offline"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Cloud Integration</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet"
href="../css/css/cloud.css">

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

        <h1>Cloud Integration Dashboard</h1>

        <div class="cards">

            <div class="card">
                <i class="fa-solid fa-cloud"></i>
                <h3>Cloud API</h3>
                <h2><?= $cloud_status ?></h2>
            </div>

            <div class="card">
                <i class="fa-solid fa-database"></i>
                <h3>Database</h3>
                <h2><?= $database_status ?></h2>
            </div>

            <div class="card">
                <i class="fa-solid fa-file-excel"></i>
                <h3>Spreadsheet API</h3>
                <h2><?= $spreadsheet_status ?></h2>
            </div>

            <div class="card">
                <i class="fa-solid fa-microchip"></i>
                <h3>ESP32 Devices</h3>
                <h2><?= count($devices) ?></h2>
            </div>

        </div>

        <div class="glass-card">

            <h2>Synchronization Information</h2>

            <table>

                <tr>
                    <td>Last Synchronization</td>
                    <td><?= $last_sync ?></td>
                </tr>

                <tr>
                    <td>API Response Time</td>
                    <td><?= $api_response ?></td>
                </tr>

                <tr>
                    <td>Total Devices</td>
                    <td><?= count($devices) ?></td>
                </tr>

            </table>

            <br>

            <button class="sync-btn">
                <i class="fa-solid fa-rotate"></i>
                Sync Cloud Data
            </button>

        </div>

        <br>

        <div class="glass-card">

            <h2>Connected ESP32 Devices</h2>

            <table>

                <tr>
                    <th>Device Name</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>

                <?php foreach($devices as $device): ?>

                <tr>

                    <td><?= $device['name'] ?></td>

                    <td><?= $device['location'] ?></td>

                    <td>
                        <?php if($device['status'] == "Online"): ?>
                            🟢 Online
                        <?php else: ?>
                            🔴 Offline
                        <?php endif; ?>
                    </td>

                </tr>

                <?php endforeach; ?>

            </table>

        </div>

        <br>

        <div class="glass-card">

            <h2>Cloud Logs</h2>

            <table>

                <tr>
                    <th>Time</th>
                    <th>Event</th>
                </tr>

                <tr>
                    <td>08:10 AM</td>
                    <td>ESP32-Room401 uploaded attendance records.</td>
                </tr>

                <tr>
                    <td>08:15 AM</td>
                    <td>Google Spreadsheet synchronization completed.</td>
                </tr>

                <tr>
                    <td>08:20 AM</td>
                    <td>Cloud API heartbeat received.</td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>