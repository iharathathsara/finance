<?php
session_start();

if (isset($_SESSION["user"])) {

    $userTypeId = $_SESSION["user"]["user_type_id"];

    if ($userTypeId == "2" || $userTypeId == "1") {

        require "connection.php";

        $fileID = $_POST["fileID"];
        $selectedFileStatus = $_POST["selectedFileStatus"];
        $stausMessage = $_POST["stausMessage"];

        if (empty($fileID)) {
            echo "Spmething wrong try again";
        } else if (empty($selectedFileStatus)) {
            echo "Please Select status";
        } else {
            
            $fileUserStatus_rs = Database::search("SELECT * FROM `insurance_file_status` WHERE `insurance_file_id` = ? AND `user_id`=?", [$fileID,$_SESSION['user']['id']], "ss");
            $fileUserStatus_num = $fileUserStatus_rs->num_rows;
            
            if($fileUserStatus_num=="1"){
                $fileUserStatus_data = $fileUserStatus_rs->fetch_assoc();
                // update
                Database::iud("UPDATE `insurance_file_status` SET `message`=? ,`status_id`=? WHERE `id`=?",[$stausMessage,$selectedFileStatus,$fileUserStatus_data['id']],"sss");
                echo "Updated";
            }else{
                $fileStatusCout_rs = Database::search("SELECT COUNT(`id`) AS `status_count` FROM `insurance_file_status` WHERE insurance_file_id = ?",[$fileID],"s");
                $fileStatusCout_data = $fileStatusCout_rs->fetch_assoc();

                if($fileStatusCout_data['status_count']<2){
                    // insert
                    Database::iud("INSERT INTO `insurance_file_status` (`insurance_file_id`,`user_id`,`message`,`status_id`) VALUES (?,?,?,?)",[$fileID,$_SESSION['user']['id'],$stausMessage,$selectedFileStatus],"ssss");
                    echo "Success";
                }else{
                    echo "Already 2 directors are ckecking this file";
                }
            }
            
        }
    } else {
        echo "Status change can be only directors";
    }
} else {
    header("Location: login.php");
}
