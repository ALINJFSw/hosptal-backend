<?php

require("auth.php");
include("connection.php");
$data = authorize();
$response = [];
if (isset($_POST["room_id"]) && isset($_POST["bed_number"])) {
    $room_id = $_POST["room_id"];
    $bed_id = $_POST["bed_number"];
    $date_in = "mbere7";
    $date_out = 'bokra';
    $bed_number = 1;

    $sql = "insert into user_rooms (user_id,room_id,date_in,date_out, bed_number) values (?,?,?,?,?)";
    $query = $mysqli->prepare($sql);
    $query->bind_param("iissi", $data["user_id"], $room_id,$date_in,$date_out,$bed_number );
    $result = $query->execute();
    if ($result) {
        $response["result"] = "added succefuly";
    } else {
        $response["result"] = "can't add to room";
    }
} else {
    $response["result"] = "error";
}

echo json_encode($response);