<?php

require_once "config.php";

header("Content-Type: application/json");


$qr_code = $_GET['qr_code'] ?? "";


if(empty($qr_code)){


    echo json_encode([

        "status"=>"error",

        "message"=>"QR Code required"

    ]);


    exit();

}



$stmt = $conn->prepare("

SELECT

id,
student_number,
first_name,
middle_name,
last_name,
course,
year_level,
section,
qr_code

FROM students

WHERE qr_code=?

");


$stmt->bind_param(

"s",

$qr_code

);



$stmt->execute();


$result = $stmt->get_result();



if($result->num_rows > 0){


    $student = $result->fetch_assoc();


    echo json_encode([


        "status"=>"success",


        "student"=>$student


    ]);



}else{


    echo json_encode([


        "status"=>"failed",


        "message"=>"Student not found"


    ]);



}



$stmt->close();

$conn->close();


?>