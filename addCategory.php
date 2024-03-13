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

$isAdmin = isAdmin($token);

if (!$isAdmin){
    echo json_encode(array(
        "success" => false,
        "message" => "You are not authorized to perform this action"
    ));
}

if (isset(
    $_POST['category']
)){
    $title = $_POST['category'];

    $sql = "INSERT INTO category (category_title) VALUES ('$title')";

    $result = mysqli_query($CON, $sql);

    if (mysqli_num_rows($result) > 0){
        echo json_encode(array(
            "success" => false,
            "message" => "Category already exists"
        ));
        die();
    }

    if (!$result){
        echo json_encode(array(
            "success" => false,
            "message" => "Failed to add category"
        ));
        die();
    }

    echo json_encode(array(
        "success" => true,
        "message" => "Category added successfully"
    ));

}else{
    echo json_encode(array(
        "success" => false,
        "message" => "category title required"
    ));
}