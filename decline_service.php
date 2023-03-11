<?php
require("auth.php");
include("connection.php");
$response = [];
$data = authorize();
if ($data["user_type"] == "admin") {
    $service_id = $_POST["service_id"];
    $result = $mysqli->query('delete from  services  where service_id =' . $service_id);

    if ($result) {
        $response["result"] = "delete succeful";
    }
    else {
        $response["result"] = " delete update ";

    }
}

echo json_encode($response);