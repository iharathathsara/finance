<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $userId = $_POST["userId"];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `id`=?", [$userId], "s");
    $user_data = $user_rs->fetch_assoc();

    if($user_data["user_type_id"]=="1"){
        echo "You can't change super admin status";
    }else{
        if ($user_data['user_status_id'] == "1") {
            Database::iud("UPDATE `user` SET `user_status_id`=? WHERE `id`=?", ["2",$userId], "ss");
            echo "Success";
        } else {
            Database::iud("UPDATE `user` SET `user_status_id`=? WHERE `id`=?", ["1",$userId], "ss");
            echo "Success";
        }
    }

    
} else {
    header("Location: login.php");
}
