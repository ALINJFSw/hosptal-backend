<?php
require("auth.php");
include("connection.php");
$response = [];
if(
      isset($_POST["description"])
    &&  isset($_POST["employee_email"])
   
     
     ){
    $description = $_POST["description"];
    $emplyee_email = $_POST["employee_email"];
    $data = authorize();
    $department_id = 1; 
    $cost = 20;
    $accepted = 0;
    $emplyee_id = getUserInfoByName($emplyee_email)["user_id"];
    $sql = "insert into services (patients_id ,employee_id,description,cost,department_id ,accepted) values (?,?,?,?,?,?)";
    $query = $mysqli->prepare($sql);
    $query->bind_param("iisiii", $data["user_id"], $emplyee_id,$description, $cost, $department_id, $accepted);
    $result = $query->execute();
    if ($result) {
        $response["result"] = "added succefuly";
    } else {
        $response["result"] = "can't add ";
    }
}

else {
    $response["result"] = "error";
}
echo json_encode($response);
