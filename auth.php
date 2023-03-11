<?php

include("connection.php");
require './php-jwt/src/JWT.php';
require './php-jwt/src/Key.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secret_key = 'alinjsecretkey';
$headers = apache_request_headers();
if (! preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Token not found in request';
    exit;
}
$token = $matches[1];
$jwt = JWT::decode($token, new Key($secret_key, 'HS512'));


echo $jwt -> userName;
