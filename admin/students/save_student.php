<?php
require_once 'auth.php';
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $student_number = trim($_POST['student_number']);
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);

    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);
    $section = trim($_POST['section']);

    $spreadsheet_class = trim($_POST['spreadsheet_class']);

    /* Generate secure QR token */
    $qr_token = bin2hex(random_bytes(16));

    /* Check duplicate student number */
    $check = $conn->prepare(
        "SELECT id FROM students
         WHERE student_number=?"
    );

    $check->bind_param(
        "s",
        $student_number
    );

    $check->execute();

    $result = $check->get_result();

    if($result->num_rows > 0){

        die("Student number already exists.");

    }

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

    if($stmt->execute()){

        header(
            "Location: student_registration.php?success=1"
        );
        exit();

    }else{

        echo "Registration failed.";

    }
}
?>