<?php
session_start();
if (isset($_SESSION["user"])) {
    require "connection.php";

    $leaveType = $_POST["leaveType"];
    $leaveDays = $_POST["leaveDays"];
    $leaveDate = $_POST["leaveDate"];
    $leaveDetails = $_POST["leaveDetails"];

    if (empty($leaveType)) {
        echo "Please select Leave type";
    } else if (empty($leaveDays)) {
        echo "Please enter leave days";
    } else if (empty($leaveDate)) {
        echo "Please enter leave date";
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d");

        $d->modify("+7 days");
        $datePlus7 = $d->format("Y-m-d");

        $currentMonth = $d->format("m");
        $currentDay = $d->format("d");

        if( $leaveType==3){
            if ($currentMonth == "04" && $currentDay <= 14 ) {

                if ($leaveDate > $datePlus7) {

                    $leaves_rs = Database::search("SELECT * FROM `leaves` WHERE `id`=?",[$leaveType],"s");
                    $leaves_data = $leaves_rs->fetch_assoc();
                    $fullDays = $leaves_data["days"];
        
                    $userLeaves_rs = Database::search("SELECT SUM(`user_has_leaves`.`days`) AS `leavedDays` FROM `user_has_leaves` WHERE `user_has_leaves`.`user_id`=? AND `user_has_leaves`.`leaves_id`=?", [$_SESSION["user"]["id"], $leaveType], "ss");
        
                    $userLeaves_data = $userLeaves_rs->fetch_assoc();
        
                    $leavedDays = 0;
                    if ($userLeaves_data) {
                        $leavedDays = $userLeaves_data["leavedDays"];
                    }
        
                    if($fullDays >= $leaveDays+$leavedDays){
                        Database::iud("INSERT INTO `user_has_leaves` (`user_id`,`leaves_id`,`days`,`leave_date`,`status`,`other_details`) VALUES (?,?,?,?,?,?)", [$_SESSION["user"]["id"], $leaveType, $leaveDays, $leaveDate, "0", $leaveDetails], "ssssss");
                        echo "Success";
                    }else{
                        echo "Unavalable leave days";
                    }
        
                } else {
                    echo "Leave should be notified one week in advance";
                }

            } else {
                echo "Vacation leaves can only be requested within the first two weeks of April.";
            }
        }else{
            if ($leaveDate > $datePlus7) {

                $leaves_rs = Database::search("SELECT * FROM `leaves` WHERE `id`=?",[$leaveType],"s");
                $leaves_data = $leaves_rs->fetch_assoc();
                $fullDays = $leaves_data["days"];
    
                $userLeaves_rs = Database::search("SELECT SUM(`user_has_leaves`.`days`) AS `leavedDays` FROM `user_has_leaves` WHERE `user_has_leaves`.`user_id`=? AND `user_has_leaves`.`leaves_id`=?", [$_SESSION["user"]["id"], $leaveType], "ss");
    
                $userLeaves_data = $userLeaves_rs->fetch_assoc();
    
                $leavedDays = 0;
                if ($userLeaves_data) {
                    $leavedDays = $userLeaves_data["leavedDays"];
                }
    
                if($fullDays >= $leaveDays+$leavedDays){
                    Database::iud("INSERT INTO `user_has_leaves` (`user_id`,`leaves_id`,`days`,`leave_date`,`status`,`other_details`) VALUES (?,?,?,?,?,?)", [$_SESSION["user"]["id"], $leaveType, $leaveDays, $leaveDate, "0", $leaveDetails], "ssssss");
                    echo "Success";
                }else{
                    echo "Unavalable leave days";
                }
    
            } else {
                echo "Leave should be notified one week in advance";
            }
        }

        

        
       
    }
} else {
    header("Location: login.php");
}
