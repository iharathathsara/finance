<?php
session_start();

if (isset($_SESSION["user"])) {

    // $userTypeId = $_SESSION["user"]["user_type_id"];


        require "connection.php";

        $fullName = $_POST["fullName"];
        $nameWithInitial = $_POST["nameWithInitial"];
        $mobile = $_POST["mobile"];
        $password = $_POST["password"];
        $cPassword = $_POST["cPassword"];
        $address = $_POST["address"];

        if (empty($fullName)) {
            echo "Please enter full name";
        } else if (empty($nameWithInitial)) {
            echo "Please enter name with initial";
        } else if (empty($mobile)) {
            echo "Please enter mobile Number";
        } else if (strlen($mobile) < 10) {
            echo "Tel no must be 10 numbers";
        } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $mobile)) {
            echo "Please Enter Valid mobile No";
        }else if (empty($address)) {
            echo "Please enter address";
        } else {

            $squery = "UPDATE `user` SET `full_name`=?,`name_with_initial`=?,`mobile`=?,`address`=? ";

            $sParams = array();
            $sParamTypes = "";
            $sParams[] = $fullName;
            $sParams[] = $nameWithInitial;
            $sParams[] = $mobile;
            $sParams[] = $address;
            $sParamTypes .= "ssss";

            // Database::iud("UPDATE `user` SET `full_name`=?,`name_with_initial`=?,`mobile`=? WHERE `id`=?", [$fullName, $nameWithInitial, $mobile, $_SESSION["user"]["id"]], "ssss");

            if (!empty($password)) {
                if (strlen($password) < 6) {
                    echo "Password must be greater than 6 charactors";
                    return;
                } else if (empty($cPassword)) {
                    echo "Please enter confirm password";
                    return;
                } else if ($password != $cPassword) {
                    echo "Confirm password incorrect";
                    return;
                } else {
                    $squery .= " ,`password`=? ";
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $sParams[] = $hashedPassword;
                    $sParamTypes .= "s";
                }
            }
            $squery .= " WHERE `id`=? ";
            $sParams[] = $_SESSION["user"]["id"];
            $sParamTypes .= "s";

            Database::iud($squery, $sParams, $sParamTypes);
            echo "Success";
        }
    
} else {
    header("Location: login.php");
}
