<?php
session_start();

if (isset($_SESSION["user"])) {

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2") {

        require "connection.php";

        if(isset($_GET["leaveId"])){
            $leaveId = $_GET["leaveId"];
            Database::iud("UPDATE `user_has_leaves` SET `status`=?,`approved_user_id`=? WHERE `id`=?",["1",$_SESSION["user"]["id"],$leaveId],"sss");
            echo "Success";
        }else{
            echo "Something wrong try again";
        }
    } else {
        echo "Only Directors can approve leaves";
    }
} else {
    header("Location: login.php");
}
