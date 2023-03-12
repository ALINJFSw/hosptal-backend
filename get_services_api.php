<?php
require("auth.php");
include("connection.php");
$response = [];
$data = authorize();
if ($data["user_type"] == "admin") {
    $result = $mysqli->query('select * from services where accepted = 0');

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        $emp_data = getUserInfoById($row[1]);
        $patient_data = getUserInfoById($row["0"]);
        $arr = [];
        $arr["patient_email"] = $patient_data["user_email"];
        $arr["employe_email"] = $emp_data["user_email"];
        $arr["description"] = $row["2"];
        $arr["cost"] = $row["3"];
        $arr["department_id"] = $row["4"];
        $arr["service_id"] = $row["6"];
        array_push($response, $arr);
    }
}

echo json_encode($response);