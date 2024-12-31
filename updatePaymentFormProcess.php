<?php
session_start();

if (isset($_SESSION["user"])) {

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3" || $_SESSION["user"]["user_type_id"] == "4") {


    require "connection.php";

    $fileNO = $_POST["fileNo"];
    $amount = $_POST["amount"];
    $tenure = $_POST["tenure"];
    $percentage = $_POST["percentage"];
    $paymentOtherDetails = $_POST["paymentOtherDetails"];

    if (empty($amount)) {
        echo "Please enter Amount";
    } else if (empty($tenure)) {
        echo "Please enter Tenure";
    } else if (empty($percentage)) {
        echo "Please enter Percentage";
    }  else {

        $presentage_rs = Database::search("SELECT * FROM `payment_anual_presentage`");
            $presentage_data = $presentage_rs->fetch_assoc();

            if ($_SESSION["user"]["user_type_id"] != "1") {
                if ($percentage < $presentage_data["value"]) {
                    echo "Percentage should be greater than ".$presentage_data["value"]." %";
                    return;
                }
            }

        // if($_SESSION["user"]["user_type_id"]!="1"){
        //     if ($percentage < 51.5) {
        //         echo "Percentage should be greater than 51.5";
        //         return;
        //     }
        // }

        $insurance_file_rs = Database::search("SELECT * FROM `insurance_file` WHERE `file_no`=?", [$fileNO], "s");
        $insurance_file_data = $insurance_file_rs->fetch_assoc();
        $insurance_file_id = $insurance_file_data["id"];

        $filePayments_rs = Database::search("SELECT * FROM `file_payments` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
        $filePayments_num = $filePayments_rs->num_rows;

        if ($filePayments_num == 0) {
            Database::iud("INSERT INTO `file_payments` (`insurance_file_id`,`amount`,`loan_tenure`,`precentage`,`other_details`) VALUES (?,?,?,?,?)", [$insurance_file_id, $amount, $tenure, $percentage, $paymentOtherDetails], "sssss");
        } else {
            Database::iud("UPDATE `file_payments` SET `amount`=?, `loan_tenure`=?, `precentage`=?, `other_details`=? WHERE `insurance_file_id`=?", [$amount, $tenure, $percentage, $paymentOtherDetails, $insurance_file_id], "sssss");
        }

        echo "Updated";
    }
}else{
    echo "You are not authorized to change the client's information.";
}
} else {
    header("Location: login.php");
}
