<?php
session_start();

if(!isset($_SESSION['admin_logged_in'])){
    header("Location: index.php");
    exit();
}

/* Database Connection */
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "pwu_attendance"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$message_type = "";

/* Save Student */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_number = trim($_POST['student_number']);
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);

    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);
    $section = trim($_POST['section']);

    $spreadsheet_class = trim($_POST['spreadsheet_class']);

    /* Generate QR Token */
    $qr_token = bin2hex(random_bytes(16));

    /* Check duplicate student number */
    $check = $conn->prepare(
        "SELECT id FROM students WHERE student_number=?"
    );

    $check->bind_param(
        "s",
        $student_number
    );

    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {

        $message = "Student number already exists.";
        $message_type = "error";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO students(
                student_number,
                first_name,
                middle_name,
                last_name,
                course,
                year_level,
                section,
                spreadsheet_class,
                qr_token
            )
            VALUES(?,?,?,?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "sssssssss",
            $student_number,
            $first_name,
            $middle_name,
            $last_name,
            $course,
            $year_level,
            $section,
            $spreadsheet_class,
            $qr_token
        );

        if ($stmt->execute()) {

            $message = "Student registered successfully.";
            $message_type = "success";

        } else {

            $message = "Registration failed.";
            $message_type = "error";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Registration</title>

<link rel="stylesheet" href="../css/css/student_registration.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="logo">
            <img class="logo-img" src="../../pictures/PWU LOGO.png" alt="">
            <h2>PWU CDCEC</h2>
            <span>Attendance System</span>
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

    </div>

    <!-- Main -->
    <div class="main">

        <div class="header">
            <h1>Student Registration</h1>
            <p>Register students for QR attendance validation.</p>
        </div>

        <div class="glass-card">


        <?php if(isset($_GET['success'])): ?>

        <div class="success-message">
            Student registered successfully.
        </div>

        <?php endif; ?>

            <form method="POST" action="save_student.php">

                <div class="grid">

                    <div class="input-group">
                        <label>Student Number</label>
                        <input type="text" name="student_number" required>
                    </div>

                    <div class="input-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" required>
                    </div>

                    <div class="input-group">
                        <label>Middle Name</label>
                        <input type="text" name="middle_name">
                    </div>

                    <div class="input-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" required>
                    </div>

                    <div class="input-group">
                        <label>Course</label>

                        <select name="course" required>
                            <option value="">Select Course</option>
                            <option>BSIT</option>
                            <option>BSBA</option>
                            <option>BSHM</option>
                            <option>BSTM</option>
                            <option>BEED</option>
                            <option>BSED</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Year Level</label>

                        <select name="year_level" required>
                            <option value="">Select Year</option>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Section</label>
                        <input type="text" name="section" placeholder="A" required>
                    </div>

                    <div class="input-group">
                        <label>Spreadsheet Class</label>

                        <select name="spreadsheet_class" required>

                            <option value="">Select Spreadsheet</option>

                            <option>IT1</option>
                            <option>IT2</option>
                            <option>IT3</option>
                            <option>IT4</option>

                        </select>

                    </div>

                </div>

                <button class="register-btn" type="submit">
                    <i class="fa-solid fa-user-plus"></i>
                    Register Student
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>