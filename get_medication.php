<?php
include("connection.php");
$response = [];

    $result = $mysqli->query('select * from medications ');

while($row = $result -> fetch_array(MYSQLI_NUM)){
    $arr = [];
    $arr["medication_id"] = $row["0"];
    $arr["name"] = $row["1"];
    $arr["price"] = $row["2"];
    array_push($response,$arr);
}


echo json_encode($response);