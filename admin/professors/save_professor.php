<?php
require_once '../../auth/auth.php';
require_once '../../config.php';

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: professor_registration.php");
    exit();
}

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
    "SELECT id
     FROM professors
     WHERE employee_id=?"
);

$check->bind_param(
    "s",
    $employee_id
);

$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){

    header(
        "Location: professor_registration.php?error=Professor already exists."
    );
    exit();
}

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

if($stmt->execute()){

    header(
        "Location: professor_registration.php?success=1"
    );

}else{

    header(
        "Location: professor_registration.php?error=Registration Failed."
    );

}
exit();
?>