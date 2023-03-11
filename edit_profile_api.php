<?php

require("auth.php");
include("connection.php");
$response = [];
$data = authorize();
if (
    isset($_POST["name"])
    && isset($_POST["email"])
    && isset($_POST["dob"])
) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $sql = "update users set name = ?, email = ?, dob = ? where user_id = ?";
    $query = $mysqli->prepare($sql);
    $query->bind_param("sssi", $name, $email, $dob, $data["user_id"]);
    $result = $query->execute();
    if ($result) {
        $response["result"] = "user update succeful";
    } else {
        $response["result"] = " can't update user ";

    }
}
else {
    $response["result"] = "error";
    die();
}

if ($data["user_type"] == "patient") {
    if (
        isset($_POST["blood_type"])
        && isset($_POST["ehr"])
    ) {
        $blood_type = $_POST["blood_type"];
        $ehr = $_POST["ehr"];
        $sql = "update patients_info set blood_type = ?, ehr = ? where user_id = ?";
        $query = $mysqli->prepare($sql);
        $query->bind_param("ssi", $blood_type, $ehr, $data["user_id"]);
        $result = $query->execute();
        if ($result) {
            $response["result"] = "patient update succeful";
        } else {
            $response["result"] = " can't update patient ";

        }

    }
    else {
        $response["result"] = "error";
        die();
    }
} else if ($data["user_type"] == "employee") {
    if (
        isset($_POST["ssn"])
        && isset($_POST["position"])
        && isset($_POST["date_joined"])
    ) {

        $ssn = $_POST["ssn"];
        $position = $_POST["position"];
        $date_joined = $_POST["date_joined"];

        $sql = "update employees_infos set ssn = ?, date_joined = ?,position = ? where user_id = ?";
        $query = $mysqli->prepare($sql);
        $query->bind_param("sssi", $ssn, $date_joined,$position, $data["user_id"]);
        $result = $query->execute();
        if ($result) {
            $response["result"] = "employee update succeful";
        } else {
            $response["result"] = " can't update employee ";

        }
    }
}

echo json_encode($response);