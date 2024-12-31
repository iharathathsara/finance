<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $fileID = $_POST["fileId"];
    $serviceChargeAmount = $_POST["serviceChargeAmount"];
    $serviceChargePaymentDate = $_POST["serviceChargePaymentDate"];

    if(empty($serviceChargeAmount)){
        echo "Please enter service charge";
    }else if (empty($serviceChargePaymentDate)){
        echo "Please enter payment date";
    }else{
        $serviceCharge_rs = Database::search("SELECT * FROM `file_service_charge` WHERE `file_id`=?",[$fileID],"s");
        $serviceCharge_num = $serviceCharge_rs->num_rows;
        if($serviceCharge_num>0){
            echo "Already paid service charge";
        }else{
            Database::iud("INSERT INTO `file_service_charge` (`file_id`,`amount`,`date`) VALUES (?,?,?)",[$fileID,$serviceChargeAmount,$serviceChargePaymentDate],"sss");
            echo "Success";
        }
    }

} else {
    header("Location: login.php");
}