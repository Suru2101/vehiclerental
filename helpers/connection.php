<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "vehiclerental";

try {
    $CON = mysqli_connect($host, $user, $password, $db);
} catch (mysqli_sql_exception){
    echo "Error connecting";
}


// if ($CON){
//     echo "Connection Successful";
// }