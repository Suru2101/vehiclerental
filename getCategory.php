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

$sql = "SELECT * FROM category";

$result = mysqli_query($CON, $sql);

$category = [];

while ($row = mysqli_fetch_assoc($result)){
    $category[] = $row;
}

echo json_encode(array(
    "success" => true,
    "message" => "Categories fetched successfully",
    "category" => $category
));