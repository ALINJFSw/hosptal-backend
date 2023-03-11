<?php
require("auth.php");
include("connection.php");
$response = [];
if (isset($_POST["department_id"])){
    $department_id = $_POST["department_id"];
    $result = $mysqli->query('select * from rooms where department_id = '. $department_id);

while($row = $result -> fetch_array(MYSQLI_NUM)){
    $arr = [];
    $arr["room_id"] = $row["0"];
    $arr["number_beds"] = $row["2"];
    $arr["floor_number"] = $row["3"];
    $arr["cost_per_day"] = $row["5"];
    $arr["is_vip"] = $row["6"];
    $arr["department_id"] = $row["7"];
    $arr["busu_bed"] = $row["8"];
    array_push($response,$arr);
}
}
else {
    $response["result"] = "error";
}

echo json_encode($response);