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


function getEmptyRoom($department_id){
    $data = [];
    include('connection.php');
    $query = $mysqli->prepare('select * from rooms where department_id = ?');
    $query->bind_param('i', $department_id);
    $query->execute();

    $query->store_result();
    $num_rows = $query->num_rows();
    $query->bind_result($room_id,$room_number, $number_beds, $floor_number, $phone_number, $cost_per_day, $is_vip, $department_id, $busy_bed);
    $query->fetch();
    if ($num_rows == 0) {
        return;
    } else {
        $data["room_id"] = $room_id;
        $data["room_number"] = $room_number;
        $data["number_beds"] = $number_beds;
        $data["floo_number"] = $floor_number;
        $data["phone_number"] = $phone_number;
        $data["cost_per_day"] = $cost_per_day;
        $data["is_vip"] = $is_vip;
        $data["department_id"] = $department_id;
        $data["busy_bed"] = $busy_bed;
        return $data;
    }
}

function getHospitalId($user_id){
    include('connection.php');
    $query = $mysqli->prepare('select hospital_id from hospital_users where user_id = ?');
    $query->bind_param('i', $user_id);
    $query->execute();

    $query->store_result();
    $num_rows = $query->num_rows();
    $query->bind_result($hospital_id);
    $query->fetch();
    if ($num_rows == 0) {
        return;
    } else {
        return $hospital_id;
    }
}