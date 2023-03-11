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
    $user_info = getUserInfoByName($email);
    print(json_encode($user_info));
    $is_active = "true";
    $dj = "today";

    if ($user_info["user_type"] == "patient") {
        $query = $mysqli->prepare('select * from hospital_users where user_id = ?');
        $query->bind_param('i', $user_info["user_id"]);
        $query->execute();

        $query->store_result();
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            $response["result"] = "user can be assigned to many hospital";
            echo json_encode($response);
            die();

        }
    }

    if ($data["user_type"] == "admin") {
        $sql = "insert into hospital_users (hospital_id, user_id, is_active, date_joined ) values (?,?,?,?)";
        $query = $mysqli->prepare($sql);
        $query->bind_param("iiss", $hos_info["hospital_id"], $user_info["user_id"], $is_active, $dj);
        $result = $query->execute();
        if ($result) {
            $response["result"] = "user assigned to hospital";

        } else {
            $response["result"] = "can't assign to hospital";

        }
    } else {
        $response["result"] = "can't add";

    }
} else {
    $response["result"] = "error";
}

echo json_encode($response);