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

$id = $_GET['id'];

$result = $conn->query("
    SELECT *
    FROM students
    WHERE id = '$id'
");

$student = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];

    $stmt = $conn->prepare("
        UPDATE students
        SET
            first_name=?,
            middle_name=?,
            last_name=?,
            course=?,
            year_level=?,
            section=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssssssi",
        $first_name,
        $middle_name,
        $last_name,
        $course,
        $year_level,
        $section,
        $id
    );

    if($stmt->execute()){
        header("Location: student_list.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>

        body{
            font-family:Poppins,sans-serif;
            background:#f5f5f5;
            padding:50px;
        }

        .card{
            width:600px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 5px 20px rgba(0,0,0,.1);
        }

        h1{
            margin-bottom:20px;
            color:#800000;
        }

        input{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:10px;
        }

        button{
            background:#800000;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:10px;
            cursor:pointer;
        }

    </style>

</head>
<body>

<div class="card">

    <h1>Edit Student</h1>

    <form method="POST">

        <input
            type="text"
            name="first_name"
            value="<?= $student['first_name'] ?>"
            required
        >

        <input
            type="text"
            name="middle_name"
            value="<?= $student['middle_name'] ?>"
        >

        <input
            type="text"
            name="last_name"
            value="<?= $student['last_name'] ?>"
            required
        >

        <input
            type="text"
            name="course"
            value="<?= $student['course'] ?>"
            required
        >

        <input
            type="text"
            name="year_level"
            value="<?= $student['year_level'] ?>"
            required
        >

        <input
            type="text"
            name="section"
            value="<?= $student['section'] ?>"
            required
        >

        <button type="submit">
            <i class="fa-solid fa-floppy-disk"></i>
            Update Student
        </button>

    </form>

</div>

</body>
</html>