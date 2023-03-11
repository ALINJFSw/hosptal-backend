<?php

include("connection.php");

$response = [];
if (
    isset($_POST["type"]) && isset($_POST["email"])
    && isset($_POST["password"])
    && isset($_POST["name"])
    && isset($_POST["dob"])
) {




    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $name = $_POST["name"];
    $dob = $_POST["dob"];




    $check_username = $mysqli->prepare('select email from users where email=?');
    $check_username->bind_param('s', $email);
    $check_username->execute();
    $check_username->store_result();
    $username_exists = $check_username->num_rows();
    if ($username_exists > 0) {
        $response["result"] = "user exist ";
        echo json_encode($response);
        die();

    } else {
        $type = $_POST["type"];
        $sql = "insert into user_types (type) values(?)";
        $query = $mysqli->prepare($sql);
        $query->bind_param("s", $type);
        $query->execute();
        $type_id = $mysqli->insert_id;

        if ($type == "admin" && substr($password, 0, 5) != "admin") {
            $response["result"] = "your are not allowd to be admin";
            echo json_encode($response);
            exit();
        }
        $sql = "insert into users(name, email,password,dob,user_type) values (?,?,?,?,?) ";
        $query = $mysqli->prepare($sql);
        $query->bind_param("ssssi", $name, $email, $hashed_password, $dob, $type_id);
        $result = $query->execute();
        $user_id = $mysqli->insert_id;

    }


    if ($result) {
        $response["result"] = "added succes";
        if ($type == "admin") {
            echo json_encode($response);
            exit();
        }
    }

} else {
    $response["result"] = "error inputs data";

    echo json_encode($response);
    exit();
}

if (
    $_POST["type"] == "patient"
    && isset($_POST["blood_type"])
    && isset($_POST["ehr"])
) {
    $blood_type = $_POST["blood_type"];
    $ehr = $_POST["ehr"];

    $sql = "insert into patients_info(user_id, blood_type,ehr) values (?,?,?)";
    $query = $mysqli->prepare($sql);
    $query->bind_param("iss", $user_id, $blood_type, $ehr);
    $result = $query->execute();
    if ($result) {
        $response["result"] = "added patient succes";
    }


} else if (
    $_POST["type"] == "employee"
    && $_POST["ssn"]
    && $_POST["date_joined"]
    && $_POST["position"]
) {
    $date_joined = $_POST["date_joined"];
    $position = $_POST["position"];
    $ssn = $_POST["ssn"];


    $sql = "insert into employees_infos(user_id,ssn, date_joined,position) values (?,?,?,?)";
    $query = $mysqli->prepare($sql);
    $query->bind_param("iiss", $user_id, $ssn, $date_joined, $position);
    $result = $query->execute();
    if ($result) {
        $response["result"] = "added emplyee succes";
    }
  


} else {
    $response["result"] = "error input data";

}

echo json_encode($response);