<?php


function getHospitalInfoByName($name)
{
    include("connection.php");
    $data = [];
    $query = $mysqli->prepare('select * from hospitals where name=?');
    $query->bind_param('s', $name);
    $query->execute();

    $query->store_result();
    $num_rows = $query->num_rows();
    $query->bind_result($hospital_id, $name, $address, $phone_number, $email, $facbook_url);
    $query->fetch();
    if ($num_rows == 0) {
        return [];
    } else {

        $data["hospital_id"] = $hospital_id;
        $data["name"] = $name;
        $data["address"] = $address;
        $data["phone_number"] = $phone_number;
        $data["email"] = $email;
        $data["facbook_url"] = $facbook_url;
        return $data;

    }
}
function getUserInfoByName($email)
{
    $data = [];
    include('connection.php');
    $query = $mysqli->prepare('select u.user_id,u.name,u.email,u.password,u.dob,t.type from users u,user_types t where
    u.user_type = t.user_type and
    email=?');
    $query->bind_param('s', $email);
    $query->execute();

    $query->store_result();
    $num_rows = $query->num_rows();
    $query->bind_result($user_id, $name, $user_email, $hashed_password, $dob, $user_type);
    $query->fetch();
    if ($num_rows == 0) {
        $response['response'] = "user not found";
        return;
    } else {
        $data["user_id"] = $user_id;
        $data["user_email"] = $user_email;
        $data["name"] = $name;
        $data["dob"] = $dob;
        $data["user_type"] = $user_type;
        return $data;
    }
}