<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"]["user_type_id"] == '1') {
        require "connection.php";

        if (isset($_GET["userId"])) {
            $userId = $_GET["userId"];

            $user_rs = Database::search("SELECT * FROM `user` WHERE `id`=?", [$userId], "s");
            $user_data = $user_rs->fetch_assoc();

            if ($user_data) {

                $nic = $user_data["nic"];

                $hashedPassword = password_hash($nic, PASSWORD_BCRYPT);

                Database::iud("UPDATE `user` SET `password`=? WHERE `id`=?", [$hashedPassword, $userId], "ss");

                echo "Success";
            } else {
                echo "Something wrong. refresh and try again";
            }
        } else {
            echo "Something wrong. refresh and try again";
        }
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}
