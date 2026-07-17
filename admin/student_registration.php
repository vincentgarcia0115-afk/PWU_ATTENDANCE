<?php
session_start();
require_once '../phpqrcode/qrlib.php';

if(!isset($_SESSION['admin_logged_in'])){
    header("Location: index.php");
    exit();
}

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$message_type = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);

    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);
    $spreadsheet_class = trim($_POST['spreadsheet_class']);

    /*
    ================================
    GENERATE STUDENT NUMBER
    2050-0001
    2050-0002
    2050-0003
    ================================
    */

    $query = $conn->query("
        SELECT student_number
        FROM students
        ORDER BY id DESC
        LIMIT 1
    ");

    if($query->num_rows > 0){

        $last_student = $query->fetch_assoc();

        $last_number = intval(
            substr(
                $last_student['student_number'],
                5
            )
        );

        $next_number = $last_number + 1;

    }else{

        $next_number = 1;
    }

    $student_number =
        "2050-" .
        str_pad(
            $next_number,
            4,
            "0",
            STR_PAD_LEFT
        );

    /*
    ================================
    QR VALUE
    ================================
    */

    $qr_code = "STUDENT-" . $student_number;
    /*
    ================================
    GENERATE QR IMAGE FILE
    ================================
    */

    $qr_folder = "../qr_codes/";

    if(!file_exists($qr_folder)){
        mkdir($qr_folder, 0777, true);
    }

    $qr_filename = $student_number . ".png";

    $qr_path = $qr_folder . $qr_filename;

    QRcode::png(
        $qr_code,
        $qr_path,
        QR_ECLEVEL_H,
        10,
        2
    );

    /*
    ================================
    INSERT STUDENT
    ================================
    */

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $message = "Invalid email address.";
            $message_type = "error";

        } elseif (!preg_match('/^09\d{9}$/', $phone)) {

            $message = "Phone number must start with 09 and contain exactly 11 digits.";
            $message_type = "error";

        } else {

            // INSERT CODE HERE

        }

    $stmt = $conn->prepare("
        INSERT INTO students(
            student_number,
            first_name,
            middle_name,
            last_name,
            email,
            phone,
            course,
            year_level,
            spreadsheet_class,
            qr_code
        )
        VALUES(
            ?,?,?,?,?,?,?,?,?,?
        )
    ");

       $stmt->bind_param(
            "ssssssssss",
            $student_number,
            $first_name,
            $middle_name,
            $last_name,
            $email,
            $phone,
            $course,
            $year_level,
            $spreadsheet_class,
            $qr_filename
        );

  if($stmt->execute()){

    $registered_student = [
        'student_number' => $student_number,
        'name' => $first_name . ' ' . $last_name,
        'course' => $course,
        'year_level' => $year_level,
        'qr_code' => $qr_filename
    ];

    $message_type = "success";
}   else{

        $message =
            "Registration Failed: " .
            $stmt->error;

        $message_type = "error";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Student Registration</title>

<link rel="stylesheet"
href="../css/css/student_registration.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">
<script src="../JS/student_registration.js" defer></script>
</head>

<body>

<div class="container">

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

    <div class="main">

        <div class="header">
            <h1>Student Registration</h1>
            <p>
                Register students for QR Attendance Validation
            </p>
        </div>

        <div class="glass-card">

            <?php if($message != ""): ?>

                <div class="<?= $message_type ?>">
                    <?= $message ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="grid">

                    <div class="input-group">
                        <label>Student Number</label>
                        <input
                            type="text"
                            value="Auto Generated (2050-0001)"
                            readonly
                        >
                    </div>

                    <div class="input-group">
                        <label>First Name</label>
                        <input
                            type="text"
                            name="first_name"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Middle Name</label>
                        <input
                            type="text"
                            name="middle_name"
                        >
                    </div>

                    <div class="input-group">
                        <label>Last Name</label>
                        <input
                            type="text"
                            name="last_name"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            placeholder="example@pwu.edu.ph"
                            pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                            title="Please enter a valid email address."
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Phone Number</label>

                        <input
                            type="tel"
                            name="phone"
                            placeholder="09XXXXXXXXX"
                            pattern="^09[0-9]{9}$"
                            maxlength="11"
                            title="Phone number must start with 09 and contain 11 digits."
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Course</label>

                        <select
                            name="course"
                            required
                        >
                            <option value="">
                                Select Course
                            </option>

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

                        <select
                            name="year_level"
                            required
                        >
                            <option value="">
                                Select Year
                            </option>

                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>

                        </select>

                    </div>


                    <div class="input-group">
                        <label>Spreadsheet Class</label>

                        <select
                            name="spreadsheet_class"
                            required
                        >
                            <option value="">
                                Select Spreadsheet
                            </option>

                            <option>IT1</option>
                            <option>IT2</option>
                            <option>IT3</option>
                            <option>IT4</option>

                        </select>

                    </div>

                </div>

                <button
                    class="register-btn"
                    type="submit">

                    <i class="fa-solid fa-user-plus"></i>

                    Register Student

                </button>

            </form>

                <?php if(isset($registered_student)): ?>

<div id="idPopup" class="popup">

    <div class="popup-card">

        <h2>PWU CDCEC</h2>
        <h3>Student ID Generated</h3>

        <p>
            <strong>Student Number:</strong>
            <?= $registered_student['student_number'] ?>
        </p>

        <p>
            <strong>Name:</strong>
            <?= $registered_student['name'] ?>
        </p>

        <p>
            <strong>Course:</strong>
            <?= $registered_student['course'] ?>
        </p>

        <p>
            <strong>Year:</strong>
            <?= $registered_student['year_level'] ?>
        </p>

       

       <div class="qr-box">
        <img src="../qr_codes/<?= $registered_student['qr_code'] ?>">
        </div>

        <button onclick="window.print()">
            Print ID
        </button>

        <button onclick="closePopup()">
            Close
        </button>

    </div>

</div>

<?php endif; ?>



        </div>

    </div>

</div>

</body>
</html>