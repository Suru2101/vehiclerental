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

$sql = "SELECT vehicles.* ,category.*, email,full_name FROM vehicles join category on category.category_id = vehicles.category join users on users.user_id = vehicles.added_by where vehicles.added_by = $user_id";

$result = mysqli_query($CON, $sql);

$vehicles = [];

while ($row = mysqli_fetch_assoc($result)){
    $vehicles[] = $row;
}

echo json_encode(array(
    "success" => true,
    "message" => "Vehicles fetched successfully",
    "vehicles" => $vehicles
));