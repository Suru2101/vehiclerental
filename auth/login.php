<?php

include ('../helpers/connection.php');

if (isset(
    $_POST['email'],
    $_POST['password'],
)){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "select * from users where email = '$email'";
    $result = mysqli_query($CON, $sql); //execute query

    $count = mysqli_num_rows($result); //gets the number of rows in the result set

    //check if email exists in the database or not
    if ($count == 0){
        echo json_encode(array(
            "success" => false,
            "message" => "User not found"
        ));
        die(); //terminates

    }else{

        $user = mysqli_fetch_assoc($result);
        $user_id = $user['user_id']; //get user id
        $hashed_password = $user['password']; //get password of the user
        $is_correct = password_verify($password, $hashed_password); //verify password

        // check if the password is correct
        if (!$is_correct){
            echo json_encode(array(
                "success" => false,
                "message" => "Password does not match"
            ));
        } else {
            $token = bin2hex(random_bytes(16));//generate random token
            $role = $user['role']; 
            $insert_sql = "insert into access_tokens (token, user_id) values('$token','$user_id')";
            $insert_result = mysqli_query($CON, $insert_sql);
            echo json_encode(array(
                "success" => true,
                "message" => "Login Successful",
                "token" => $token,
                "role" => $role
            ));
        }
    }

}else {
    echo json_encode(array(
        "success" => false,
        "message" => "Fullname, email and password are required."
    ));
}