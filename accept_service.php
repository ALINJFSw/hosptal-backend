<?php
require("auth.php");
include("connection.php");
$response = [];
$data = authorize();
if ($data["user_type"] == "admin") {
    $service_id = $_POST["service_id"];
    $result = $mysqli->query('update services set accepted = 1 where service_id =' . $service_id);

    if ($result) {
        $response["result"] = "update succeful";
    }
    else {
        $response["result"] = " can't update ";

    }
}

echo json_encode($response);