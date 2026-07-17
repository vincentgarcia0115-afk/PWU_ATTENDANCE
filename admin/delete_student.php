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

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    $stmt = $conn->prepare("
        DELETE FROM students
        WHERE id = ?
    ");

    $stmt->bind_param(
        "i",
        $id
    );

    if($stmt->execute()){

        header(
            "Location: student_list.php?deleted=1"
        );

        exit();

    }else{

        echo "Delete Failed.";

    }

}else{

    header(
        "Location: student_list.php"
    );

}
?>