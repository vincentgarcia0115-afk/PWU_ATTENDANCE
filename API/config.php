<?php

header("Content-Type: application/json");


$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);


if($conn->connect_error){

    echo json_encode([
        "status"=>"error",
        "message"=>"Database connection failed"
    ]);

    exit();

}


echo json_encode([

    "status"=>"success",
    "message"=>"API connected successfully"

]);


?>