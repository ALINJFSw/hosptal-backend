<?php
require("auth.php");
include("connection.php");
$response = [];
$data = authorize();
$hospital_id = getHospitalId($data["user_id"]);
$result = $mysqli->query('select * from departments where hospital_id = '. $hospital_id);

while($row = $result -> fetch_array(MYSQLI_NUM)){
    $arr = [];
    $arr["department_id"] = $row["0"];
    $arr["name"] = $row["1"];
    $arr["building"] = $row["2"];
    $arr["hospital_id"] = $row["4"];
    array_push($response,$arr);
}

echo json_encode($response);