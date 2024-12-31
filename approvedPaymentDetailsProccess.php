<?php
session_start();

if (isset($_SESSION["user"])) {

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3") {

        require "connection.php";

        $fileId = $_POST["fileId"];
        $paymentBankName = $_POST["paymentBankName"];
        $paymentDate = $_POST["paymentDate"];
        $paymentCheckNo = $_POST["paymentCheckNo"];
        $paymentAmount = $_POST["paymentAmount"];

        if (empty($paymentBankName)) {
            echo "Please enter bank name";
        } else if (empty($paymentDate)) {
            echo "Please enter payment date";
        } else if (empty($paymentCheckNo)) {
            echo "Please enter payment check no";
        } else if (empty($paymentAmount)) {
            echo "Please enter payment amount";
        } else {
            $approvedFilePayment_rs = Database::search("SELECT * FROM `file_approved_payment` WHERE `file_id`=?", [$fileId], "s");
            $approvedFilePayment_num = $approvedFilePayment_rs->num_rows;
            if ($approvedFilePayment_num > 0) {

                Database::iud("UPDATE `file_approved_payment` SET `bank_name`=?,`payment_date`=?,`check_no`=?,`amount`=? WHERE `file_id`=?", [$paymentBankName, $paymentDate, $paymentCheckNo, $paymentAmount, $fileId], "sssss");
                echo "Updated Payment Details";
            } else {
                Database::iud("INSERT INTO `file_approved_payment`(`file_id`,`bank_name`,`payment_date`,`check_no`,`amount`) VALUES (?,?,?,?,?)", [$fileId, $paymentBankName, $paymentDate, $paymentCheckNo, $paymentAmount], "sssss");
                echo "Saved Payment Details";
            }
        }
    } else {
        echo "Only Directors and managers can change payment details";
    }
} else {
    header("Location: login.php");
}
