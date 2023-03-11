<?php
require("auth.php");
include("connection.php");
$data = authorize();
$hospital_id = getHospitalId($data["user_id"]);
$query = $mysqli->prepare('select * from departments where hospital_id = ?');
$query->bind_param('i', $hos);
$query->execute();

$query->store_result();
$num_rows = $query->num_rows();

echo json_encode($hospital_id);

