<?php

require_once "config.php";


header("Content-Type: application/json");


$employee_id = $_GET['employee_id'] ?? "";


if(empty($employee_id)){


echo json_encode([

    "status"=>"error",

    "message"=>"Employee ID required"

]);


exit();


}



$stmt=$conn->prepare("

SELECT

id,
employee_id,
first_name,
middle_name,
last_name,
email,
phone,
qr_code

FROM professors

WHERE employee_id=?

");


$stmt->bind_param(

"s",

$employee_id

);



$stmt->execute();


$result=$stmt->get_result();



if($result->num_rows > 0){


$data=$result->fetch_assoc();


echo json_encode([

"status"=>"success",

"professor"=>$data

]);


}else{


echo json_encode([

"status"=>"failed",

"message"=>"Professor not found"

]);


}



?>