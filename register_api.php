<?php

include("connection.php");

$response = [];
if(isset($_POST["type"])&& isset($_POST["email"])
    && isset($_POST["password"])
    && isset($_POST["name"])
    && isset($_POST["dob"])){

        $type =$_POST["type"];    
        $sql = "insert into user_types (type) values(?)";
        $query = $mysqli -> prepare($sql);
        $query->bind_param("s",$type);
        $query -> execute();
        $type_id = $mysqli->insert_id;

        $email = $_POST["email"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $dob = $_POST["dob"];
        
        $sql = "insert into users(name, email,password,dob,user_type) values (?,?,?,?,?) ";
        $query = $mysqli -> prepare($sql);
        $query->bind_param("ssssi",$name, $email, $password, $dob, $type_id);
        $result = $query -> execute();
        $user_id = $mysqli->insert_id;

        if($result) {
            $response["result"] = "added succes";
        }

}

else {
    $response["result"] = "error inputs data";

    echo json_encode($response);
    return;
}

if($_POST["type"] == "patient"
        && isset($_POST["blood_type"])
        && isset($_POST["ehr"])) {     
        $blood_type = $_POST["blood_type"];
        $ehr = $_POST["ehr"];
        
        $sql = "insert into patients_info(user_id, blood_type,ehr) values (?,?,?)";
        $query = $mysqli -> prepare($sql);
        $query->bind_param("iss" ,$user_id,$blood_type,$ehr);
        $result = $query -> execute();
        if($result) {
            $response["result"] = "added patient succes";
        }


}


else if(
         $_POST["type"] == "employee"
        && $_POST["ssn"]
        && $_POST["date_joined"]
        && $_POST["position"]
        ){
            $date_joined = $_POST["date_joined"];
            $position = $_POST["position"];
            $ssn = $_POST["ssn"];


        $sql = "insert into employees_infos(user_id,ssn, date_joined,position) values (?,?,?,?)";
        $query = $mysqli -> prepare($sql);
        $query->bind_param("iiss" ,$user_id,$ssn,$date_joined,$position);
        $result = $query -> execute();
        if($result) {
            $response["result"] = "added emplyee succes";
        }
        

}
else {
    $response["result"] = "error input data";

}

echo json_encode($response);