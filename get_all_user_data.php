<?php
include("connection.php");
require("auth.php");
$user = authorize();

$response = [];

if($user["user_type"] == "patient") {
    $query = $mysqli -> prepare("select * from patients_info where user_id = ?");
    $query -> bind_param("i",$user["user_id"]);
    $query -> execute();
    $query -> store_result();
    $query -> bind_result($patient_id, $user_id, $blood_type, $ehr);
    $query -> fetch();

    $num_rows = $query -> num_rows();

    if($num_rows > 0)
    {
        $response["blood_type"] = $blood_type;
        $response["ehr"] = $ehr;
        $response["main"] = $user;
        echo json_encode($response);
        die();
    }
    else {
        $response["result"] = "user not found";
    }
    
}

else if($data["user_type"] == "employee") {
    $query = $mysqli -> prepare("select * from employees_infos where user_id = ?");
    $query -> bind_param("i",$user["user_id"]);
    $query -> execute();
    $query -> store_result();
    $query -> bind_result($employee_id, $user_id, $hospital_id, $ssn, $date_joined, $position);
    $query -> fetch();

    $num_rows = $query -> num_rows();

    if($num_rows > 0)
    {
        $response["employee_id"] = $blood_type;
        $response["user_id"] = $user_id;
        $response["ssn"] = $ssn;
        $response["date_joined"] = $date_joined;
        $response["position"] = $position;
        $response["main"] = $user;

        echo json_encode($response);
        die();
    }
    else {
        $response["result"] = "user not found";
    }
}