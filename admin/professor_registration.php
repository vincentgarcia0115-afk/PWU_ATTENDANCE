<?php
require_once 'auth.php';

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
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_id = trim($_POST['employee_id']);
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $subject_code = trim($_POST['subject_code']);
    $subject_name = trim($_POST['subject_name']);

    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);
    $section = trim($_POST['section']);
    $spreadsheet_class = trim($_POST['spreadsheet_class']);

    $check = $conn->prepare(
        "SELECT id FROM professors WHERE employee_id=?"
    );

    $check->bind_param("s", $employee_id);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {

        $message = "Professor already exists.";
        $type = "error";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO professors(
                employee_id,
                first_name,
                middle_name,
                last_name,
                email,
                phone,
                subject_code,
                subject_name,
                course,
                year_level,
                section,
                spreadsheet_class
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "ssssssssssss",
            $employee_id,
            $first_name,
            $middle_name,
            $last_name,
            $email,
            $phone,
            $subject_code,
            $subject_name,
            $course,
            $year_level,
            $section,
            $spreadsheet_class
        );

        if ($stmt->execute()) {
            $message = "Professor registered successfully.";
            $type = "success";
        } else {
            $message = "Registration failed.";
            $type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Professor Registration</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="../css/css/professor_regisration.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

<div class="container">

    <div class="sidebar">

        <div class="logo-section">
            <img class="logo-img" src="../../pictures/PWU LOGO.png">
            <h2>PWU CDCEC</h2>
            <span>QR Attendance System</span>
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

    <div class="main-content">

        <div class="glass-card">

            <h1>Professor Registration</h1>

            <p class="subtitle">
                Register professors and assign their master class.
            </p>

            <?php if($message != ""): ?>
                <div class="message <?= $type ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

               <h2 class="section-title">
    Professor Information
</h2>

<div class="grid">

                <div class="input-group">
                    <label>Employee ID</label>
                    <input type="text" name="employee_id" required>
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
                    <label>Email</label>
                    <input type="email" name="email">
                </div>

                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone">
                </div>

            </div>

            <br>

            <hr>

            <br>

            <h2 class="section-title">
                Subject Assignments
            </h2>

            <div id="subjectContainer">

            <div class="subject-card">

            <div class="grid">

            <div class="input-group">
            <label>Subject Code</label>
            <input type="text" name="subject_code[]" required>
            </div>

            <div class="input-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name[]" required>
            </div>

            <div class="input-group">
            <label>Course</label>
            <select name="course[]" required>
            <option value="">Select Course</option>
            <option>BSIT</option>
            <option>BSBA</option>
            <option>BSTM</option>
            <option>BSHRM</option>
            <option>BEED</option>
            <option>BSED</option>
            </select>
            </div>

            <div class="input-group">
            <label>Year Level</label>
            <select name="year_level[]" required>
            <option value="">Select Year</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            </select>
            </div>

            <div class="input-group">
            <label>Section</label>
            <input type="text" name="section[]" required>
            </div>

            <div class="input-group">
            <label>Day</label>
            <select name="day[]" required>
            <option>Monday</option>
            <option>Tuesday</option>
            <option>Wednesday</option>
            <option>Thursday</option>
            <option>Friday</option>
            <option>Saturday</option>
            </select>
            </div>

            <div class="input-group">
            <label>Start Time</label>
            <input type="time" name="start_time[]" required>
            </div>

            <div class="input-group">
            <label>End Time</label>
            <input type="time" name="end_time[]" required>
            </div>

            <div class="input-group">
            <label>Spreadsheet Class</label>
            <select name="spreadsheet_class[]" required>
            <option>IT1</option>
            <option>IT2</option>
            <option>IT3</option>
            <option>IT4</option>
            </select>
            </div>

            </div>

            </div>

            </div>

            <button type="button" id="addSubjectBtn">
                + Add Another Subject
            </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>