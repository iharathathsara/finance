<?php
session_start();
require "connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

if (empty($_POST["email"])) {
    echo "Please Enter Email";
} else if (empty($_POST["password"])) {
    echo "Please Enter Password";
} else {


    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`=? AND `user_status_id`=?", [$email, "1"], "ss");
    $user_rs_num = $user_rs->num_rows;
    if ($user_rs_num > 0) {
        $user_data = $user_rs->fetch_assoc();

        $hashedPasswordFromDb = $user_data["password"];

        if (password_verify($password, $hashedPasswordFromDb)) {
            $_SESSION["user"] = $user_data;
            echo "Success";
        } else {
            echo "Invalid Email or Password";
        }
    } else {
        echo "Invalid Email or Password";
    }
}
