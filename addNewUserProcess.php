<?php
session_start();

if (isset($_SESSION["user"])) {



    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3") {
        require "connection.php";

        $fullName = $_POST["fullName"];
        $nameWithInitial = $_POST["nameWithInitial"];
        $email = $_POST["email"];
        $empNo = $_POST["empNo"];
        $mobile = $_POST["mobile"];
        $nic = $_POST["nic"];
        $address = $_POST["address"];
        $userType = $_POST["userType"];

        if (empty($fullName)) {
            echo "Please enter full name";
        } else if (empty($nameWithInitial)) {
            echo "Please enter name with initial";
        } else if (empty($empNo)) {
            echo "Please enter employee no";
        }else if (empty($email)) {
            echo "Please enter email";
        } else if (empty($mobile)) {
            echo "Please enter mobile number";
        } else if (strlen($mobile) < 10) {
            echo "Tel no must be 10 numbers";
        } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $mobile)) {
            echo "Please Enter Valid mobile No";
        }else if (empty($nic)) {
            echo "Please enter nic number";
        }else if (empty($address)) {
            echo "Please enter address";
        } else if (empty($userType)) {
            echo "Please select user type";
        } else {
            $users_rs = Database::search("SELECT * FROM `user` WHERE `email`=?", [$email], "s");
            $users_num = $users_rs->num_rows;
            if ($users_num > 0) {
                echo "User already exists";
            } else {

                $hashedPassword = password_hash($nic, PASSWORD_BCRYPT);

                Database::iud("INSERT INTO `user` (`emp_no`,`full_name`,`name_with_initial`,`email`,`mobile`,`nic`,`password`,`address`,`user_type_id`,`user_status_id`) VALUES (?,?,?,?,?,?,?,?,?,?)", [$empNo,$fullName, $nameWithInitial, $email, $mobile,$nic, $hashedPassword,$address, $userType, "1"], "ssssssssss");

                echo "Success";
            }
        }
    } else {
        echo "Only managers,Directors can register New User";
    }
} else {
    header("Location: login.php");
}
