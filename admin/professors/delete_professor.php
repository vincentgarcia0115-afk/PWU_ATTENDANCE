<?php

require_once '../../auth/auth.php';


$conn = new mysqli(
    "localhost",
    "root",
    "",
    "qr_attendance"
);


if($conn->connect_error){

    die("Connection Failed");

}



$id=intval($_GET['id']);



/*
=========================
DELETE SUBJECT ASSIGNMENT
=========================
*/

$conn->query("

DELETE FROM professor_subjects

WHERE professor_id=$id

");



/*
=========================
DELETE PROFESSOR
=========================
*/


$stmt=$conn->prepare("

DELETE FROM professors

WHERE id=?

");



$stmt->bind_param(
    "i",
    $id
);



$stmt->execute();



header("Location: professor_list.php");


exit;


?>