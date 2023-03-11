<?php
include("connection.php");
require './php-jwt/src/JWT.php';
use Firebase\JWT\JWT;

$response = [];

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

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
    } else {
        if (password_verify($password, $hashed_password)) {
            $response['result'] = "logged in";
            // $response['user_id'] = $user_id;
            // $response['name'] = $name;
            // $response['type'] = $user_type;

            $secret_key = 'alinjsecretkey';
            $date = new DateTimeImmutable();
            $expire_at = $date->modify('+60 minutes')->getTimestamp();
            // $domainName = "localhost";
            $user = $user_email;
            $request_data = [
                'exp' => $expire_at,
                'userName' => $user,
            ];
            $response["token"] = JWT::encode(
                $request_data,
                $secret_key,
                "HS512"
            );

        } else {
            $response["result"] = "Incorrect password";
        }
    }



} else {
    $response["result"] = "error";

}

echo json_encode($response);