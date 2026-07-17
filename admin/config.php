<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "qr_attendance";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}
?>