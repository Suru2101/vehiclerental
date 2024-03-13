<?php

include "./helpers/connection.php";
include "./helpers/authHelper.php";

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

if (isset(
    $_POST['category'],
    $_POST['title'],
    $_POST['description'],
    $_POST['price_per_day'],
    $_FILES['img_url'],
    $_POST['no_of_seats']
)){
    $category = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price_per_day = $_POST['price_per_day'];
    $no_of_seats = $_POST['no_of_seats'];

    $image = $_FILES['img_url'];
    $image_size = $image['size'];

    if ($image_size > 5*1024*1024){
        echo json_encode(array(
            "success" => true,
            "message" => "Image size should be less than 5 MB"
        ));
        die();
    }

    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

    $allowed = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($ext, $allowed)){
        echo json_encode(array(
            "success" => false,
            "message" => "Invalid image format"
        ));
        die();
    }

    $new_name = uniqid() . "." . $ext;
    $temp_location = $image['tmp_name'];
    $new_location = "./images/" . $new_name;
    $img_url = "images/". $new_name;

    if (!move_uploaded_file($temp_location, $new_location)){
        echo json_encode(array(
            "success" => true,
            "message" => "Failed to upload image"
        ));
    }

    $sql = "INSERT INTO vehicles (title, description, no_of_seats, img_url, category, added_by, price_per_day) 
    VALUES ('$title', '$description','$no_of_seats','$img_url','$category','$user_id', '$price_per_day')";

    $result = mysqli_query($CON, $sql);

    if ($result){
        echo json_encode(array(
            "success" => true,
            "message" => "Vehicle added successfully"
        ));
    }

}else{
    echo json_encode(array(
        "success" => false,
        "message" => "all fields required"
    ));
}