<?php
require("auth.php");
include("connection.php");
$response = [];
if(isset($_POST["medication_id"]) && isset($_POST["quantity"])){
    $medication_id = $_POST["medication_id"];
    $quantity = $_POST["quantity"];
    $data = authorize();
    $sql = "insert into users_has_medications (user_id,medication_id,quantity) values (?,?,?)";
    $query = $mysqli->prepare($sql);
    $query->bind_param("iii", $data["user_id"], $medication_id,$quantity);
    $result = $query->execute();
    if ($result) {
        $response["result"] = "added succefuly";
    } else {
        $response["result"] = "can't add to medication";
    }
}

else {
    print($_POST["quantity"]);
    $response["result"] = "error";

}
echo json_encode($response);
