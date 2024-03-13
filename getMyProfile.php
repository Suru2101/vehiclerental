<?php

include "helpers/connection.php";
include "helpers/authHelper.php";

if (!isset($_POST['token'])){
    echo json_encode(array(
        "success" => false,
        "message" => "Token is required"
    ));
    die();
}

$token = $_POST['token'];

$user_id = getUserId($token);

if (!$user_id){
    echo json_encode(array(
        "success" => false,
        "message" => "Invalid token"
    ));
    die();
}

$sql = "SELECT full_name, email, contact, address, created_at FROM users where user_id = $user_id";

$result = mysqli_query($CON, $sql);

if (!$result){
    echo json_encode(array(
        "success" => false,
        "message" => "Failed to fetch user data"
    ));
    die();
}

$user = mysqli_fetch_assoc($result);

echo json_encode(array(
    "success" => true,
    "message" => "User fetched successfully",
    "user" => $user
));