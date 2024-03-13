<?php
include "../helpers/connection.php";

//isset() returns boolean value
if (isset(
    $_POST['full_name'],
    $_POST['email'],
    $_POST['password']
    
)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['full_name'];

    $sql = "select * from users where email = '$email'";

    $result = mysqli_query($CON, $sql); //execute query

    $count = mysqli_num_rows($result); //gets the number of rows in the result set

    if ($count > 0){
        echo json_encode(array(
            "success" => false,
            "message" => "email already exists"
        ));
        //die(); //terminates
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_sql = "insert into users (full_name, email, password) VALUES ('$fullname', '$email', '$hashed_password')";

    $insert_result = mysqli_query($CON, $insert_sql);

    if ($insert_result ){
        echo json_encode(array(
            "success" => true,
            "message" => "user registered successfully"
        ));
    }

}else{
    //send data in json format and in array format
    echo json_encode(array(
        "success" => false,
        "message" => "Email, Password and Fullname are required"
    ));
}