<?php
require_once '../../auth/auth.php';
require_once '../../phpqrcode/qrlib.php';

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
=========================================
QR CODE DIRECTORY
=========================================
*/

$qrFolder = "../../qr_codes/";

if(!is_dir($qrFolder)){
    mkdir($qrFolder,0777,true);
}

$message = "";
$type = "";

/*
=========================================================
DEFAULT VARIABLES
=========================================================
*/

$professorRegistered = false;
$professor_id = 0;
$registered_professor = null;

/*
=========================================================
GENERATE NEXT EMPLOYEE ID
2030-0001
2030-0002
=========================================================
*/

$result = $conn->query("
    SELECT employee_id
    FROM professors
    ORDER BY id DESC
    LIMIT 1
");

if($result && $result->num_rows > 0){

    $row = $result->fetch_assoc();

    $lastNumber = intval(substr($row['employee_id'],5));

    $nextNumber = $lastNumber + 1;

}else{

    $nextNumber = 1;

}

$employee_id =
"2030-".
str_pad(
    $nextNumber,
    4,
    "0",
    STR_PAD_LEFT
);

/*
=========================================================
REGISTER PROFESSOR
=========================================================
*/

if(isset($_POST['register_professor'])){

    $employee_id = $_POST['employee_id'];

    $first_name  = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name   = trim($_POST['last_name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);

    /*
    -----------------------------
    VALIDATION
    -----------------------------
    */

    if(
        empty($first_name) ||
        empty($last_name) ||
        empty($email) ||
        empty($phone)
    ){

        $message = "Please complete all required fields.";
        $type = "error";

    }

    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){

        $message = "Invalid email address.";
        $type = "error";

    }

    elseif(!preg_match("/^09[0-9]{9}$/",$phone)){

        $message = "Invalid phone number.";
        $type = "error";

    }

    else{

        /*
        -----------------------------
        CHECK DUPLICATE EMAIL
        -----------------------------
        */

        $check = $conn->prepare("
            SELECT id
            FROM professors
            WHERE email=?
        ");

        $check->bind_param(
            "s",
            $email
        );

        $check->execute();

        if($check->get_result()->num_rows>0){

            $message = "Email already exists.";
            $type = "error";

        }

        else{

                    /*
            -----------------------------
            GENERATE QR CODE
            -----------------------------
            */

            $qr_value = $employee_id;

            $qr_filename = "professor_".$employee_id.".png";

            $qr_path = $qrFolder.$qr_filename;


            /*
            CREATE QR IMAGE
            */

            QRcode::png(
                $qr_value,
                $qr_path,
                QR_ECLEVEL_L,
                8,
                2
            );


            /*
            SAVE IMAGE PATH
            */

            $qr_code = $qr_path;
            /*
            -----------------------------
            INSERT PROFESSOR
            -----------------------------
            */

            $stmt = $conn->prepare("

                INSERT INTO professors(

                    employee_id,
                    first_name,
                    middle_name,
                    last_name,
                    email,
                    phone,
                    qr_code

                )

                VALUES(

                    ?,?,?,?,?,?,?

                )

            ");

            $stmt->bind_param(

                "sssssss",

                $employee_id,
                $first_name,
                $middle_name,
                $last_name,
                $email,
                $phone,
                $qr_code

            );

            if($stmt->execute()){

                $professorRegistered = true;

                $professor_id = $stmt->insert_id;

                $registered_professor = [

                    "employee_id"=>$employee_id,
                    "name"=>$first_name." ".$last_name,
                    "email"=>$email,
                    "phone"=>$phone,
                    "qr_code"=>$qr_code

                ];

                $message = "Professor registered successfully.";
                $type = "success";

            }else{

                $message = $stmt->error;
                $type = "error";

            }

            $stmt->close();

        }

        $check->close();

    }

}

/*
=========================================================
SAVE SUBJECTS
=========================================================
*/

if(isset($_POST['create_subject'])){

    $professor_id = intval($_POST['professor_id']);

    if($professor_id==0){

        $message = "Register the professor first.";
        $type = "error";

    }else{

        $subject_code = $_POST['subject_code'];
        $subject_name = $_POST['subject_name'];
        $course = $_POST['course'];
        $year_level = $_POST['year_level'];
        $section = $_POST['section'];
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        for($i=0;$i<count($subject_code);$i++){

            $stmt = $conn->prepare("

                INSERT INTO professor_subjects(

                    professor_id,
                    subject_code,
                    subject_name,
                    course,
                    year_level,
                    section,
                    day,
                    start_time,
                    end_time,

                )

                VALUES(

                    ?,?,?,?,?,?,?,?

                )

            ");

            $stmt->bind_param(

                "issssssss",

                $professor_id,

                $subject_code[$i],
                $subject_name[$i],
                $course[$i],
                $year_level[$i],
                $section[$i],
                $day[$i],
                $start_time[$i],
                $end_time[$i],

            );

            $stmt->execute();

            $stmt->close();

        }

        $message = "Subject(s) assigned successfully.";
        $type = "success";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Professor Registration</title>

<link rel="stylesheet" href="../../assets/css/professor_regisration.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<script src="../../JS/professor_registration.js" defer></script>
</head>

<body>

<div class="container">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo-section">

            <img
                src="../../pictures/PWU LOGO.png"
                class="logo-img"
            >

            <h2>PWU CDCEC</h2>

            <span>QR Attendance System</span>

        </div>

        <ul class="menu">

            <li>
                <a href="../dashboard.php">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>
            </li>

            <li class="menu-title">
                Student Management
            </li>

            <li>
                <a href="../students/student_registration.php">
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
                Professor Management
            </li>

            <li class="active">
                <a href="../professors/professor_registration.php">
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
                System Modules
            </li>

            <li>
                <a href="../attendance.php">
                    <i class="fa-solid fa-qrcode"></i>
                    Attendance
                </a>
            </li>

            <li>
                <a href="../courses.php">
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
                <a href="../auth/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- ================= MAIN ================= -->

    <main class="main-content">

        <div class="glass-card">

            <h1>Professor Registration</h1>

            <p class="subtitle">
                Register a professor and assign his/her master class.
            </p>

            <?php if($message!=""): ?>

                <div class="message <?= $type; ?>">

                    <?= htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>

            <div class="form-wrapper">

                <!-- ========================================= -->
                <!-- LEFT PANEL -->
                <!-- PROFESSOR REGISTRATION -->
                <!-- ========================================= -->

                <div class="panel">

                    <h2>

                        <i class="fa-solid fa-user-tie"></i>

                        Professor Registration

                    </h2>

                    <form method="POST">

                        <div class="grid">

                            <div class="input-group">

                                <label>Employee ID</label>

                                <input
                                    type="text"
                                    name="employee_id"
                                    value="<?= $employee_id; ?>"
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
                                    required
                                >

                            </div>

                            <div class="input-group">

                                <label>Phone Number</label>

                                <input
                                    type="text"
                                    name="phone"
                                    maxlength="11"
                                    placeholder="09XXXXXXXXX"
                                    required
                                >

                            </div>

                        </div>

                        <button
                            type="submit"
                            name="register_professor"
                            class="submit-btn"
                        >

                            <i class="fa-solid fa-user-plus"></i>

                            Register Professor

                        </button>
                        </form>

                    <?php if($professorRegistered): ?>

                    <div class="success-badge">

                        <i class="fa-solid fa-circle-check"></i>

                        Professor Registered Successfully

                    </div>

                    <div class="registered-info">

                        <div class="info-item">

                            <strong>Employee ID</strong>

                            <span><?= htmlspecialchars($registered_professor['employee_id']); ?></span>

                        </div>

                        <div class="info-item">

                            <strong>Professor</strong>

                            <span><?= htmlspecialchars($registered_professor['name']); ?></span>

                        </div>

                        <div class="info-item">

                            <strong>Email</strong>

                            <span><?= htmlspecialchars($registered_professor['email']); ?></span>

                        </div>

                        <div class="info-item">

                            <strong>Phone</strong>

                            <span><?= htmlspecialchars($registered_professor['phone']); ?></span>

                        </div>

                    </div>

                    <div class="qr-card">

                        <h3>

                            <i class="fa-solid fa-qrcode"></i>

                            Professor QR Code

                        </h3>

                        <img
                                src="<?= htmlspecialchars($registered_professor['qr_code']); ?>"
                                class="qr-image"
                                alt="Professor QR Code"
                                width="250"
                            >

                        <p>

                            Scan this QR code for attendance.

                        </p>

                    </div>

                    <?php endif; ?>

                </div>

                <!-- ========================================= -->
                <!-- RIGHT PANEL -->
                <!-- SUBJECT ASSIGNMENT -->
                <!-- ========================================= -->

                <div class="panel">

                    <h2>

                        <i class="fa-solid fa-book-open"></i>

                        Subject Assignment

                    </h2>

                    <p class="subtitle">

                        Assign subjects to the registered professor.

                    </p>

                    <?php if(!$professorRegistered): ?>

                    <div class="locked-card">

                        <i class="fa-solid fa-lock"></i>

                        <h3>Subject Assignment Locked</h3>

                        <p>

                            Register the professor first before assigning
                            master classes.

                        </p>

                    </div>

                    <?php else: ?>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="professor_id"
                            value="<?= $professor_id; ?>"
                        >

                        <div id="subjectContainer">

                            <div class="subject-card">

                                <div class="grid">
                                            <div class="input-group">

                                        <label>Subject Code</label>

                                        <input
                                            type="text"
                                            name="subject_code[]"
                                            required
                                        >

                                    </div>

                                    <div class="input-group">

                                        <label>Subject Name</label>

                                        <input
                                            type="text"
                                            name="subject_name[]"
                                            required
                                        >

                                    </div>

                                    <div class="input-group">

                                        <label>Course</label>

                                        <select
                                            name="course[]"
                                            required
                                        >

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

                                        <select
                                            name="year_level[]"
                                            required
                                        >

                                            <option value="">Select Year</option>
                                            <option>1st Year</option>
                                            <option>2nd Year</option>
                                            <option>3rd Year</option>
                                            <option>4th Year</option>

                                        </select>

                                    </div>

                                    <div class="input-group">

                                        <label>Section</label>

                                        <input
                                            type="text"
                                            name="section[]"
                                            required
                                        >

                                    </div>

                                    <div class="input-group">

                                        <label>Day</label>

                                        <select
                                            name="day[]"
                                            required
                                        >

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

                                        <input
                                            type="time"
                                            name="start_time[]"
                                            required
                                        >

                                    </div>

                                    <div class="input-group">

                                        <label>End Time</label>

                                        <input
                                            type="time"
                                            name="end_time[]"
                                            required
                                        >

                                    </div>


                                </div>

                            </div>

                        </div>

                        <button
                            type="button"
                            id="addSubjectBtn"
                            class="submit-btn"
                        >

                            <i class="fa-solid fa-plus"></i>

                            Add Another Subject

                        </button>

                        <button
                            type="submit"
                            name="create_subject"
                            class="submit-btn"
                        >

                            <i class="fa-solid fa-book"></i>

                            Save Subject Assignment

                        </button>

                    </form>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html> 