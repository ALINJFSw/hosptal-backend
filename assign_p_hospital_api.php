<?php

require('auth.php');
include("connection.php");
$data = authorize();
$response = [];


if (
    isset($_POST["email"]) &&
    isset($_POST["hospital"])
) {
    $email = $_POST["email"];
    $hospital = $_POST["hospital"];
    $hos_info = getHospitalInfoByName($hospital);
    $patien_info = getUserInfoByName($email);
    $is_active = "true";
    $dj = "today";
    print($data["user_type"]);
    if ($data["user_type"] == "admin") {
        $sql = "insert into hospital_users (hospital_id, user_id, is_active, date_joined ) values (?,?,?,?)";
        $query = $mysqli->prepare($sql);
        $query->bind_param("iiss", $hos_info["hospital_id"],$patien_info["user_id"],$is_active,$dj);
        $result = $query -> execute();
        if($result){
            $response["result"] = "user assigned to hospital";

        }
        else {
            $response["result"] = "can't assign to hospital";

        }
    }
    else {
        $response["result"] = "can't add";

    }
}

else {
    $response["result"] = "error";
}

echo json_encode($response);