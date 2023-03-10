<?php

include("connection.php");

$response = [];

if(isset($_POST["patient"])) {
    if(isset(
        $_POST["email"])
        && $_POST["password"]
        && $_POST["name"]
        && $_POST["dob"]
        && $_POST["blood_type"]
        && $_POST["ehr"]
        )
        {$email = $_POST["email"];
        $password = $_POST["password"];
        $name = $_POST["name"];
        $dob = $_POST["dob"];
        $blood_type = $_POST["blood_type"];
        $ehr = $_POST["ehr"];}
}
else if (isset($_POST["employee"])){
    if(isset(
        $_POST["email"])
        && $_POST["password"]
        && $_POST["name"]
        && $_POST["dob"]
        && $_POST["ssn"]
        && $_POST["date_joined"]
        && $_POST["position"]
        )
        {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $name = $_POST["name"];
            $dob = $_POST["dob"];
            $date_joined = $_Post["date_joined"];
            $position = $_Post["position"];
            $ssn = $_Post["ssn"];

        }
}

    