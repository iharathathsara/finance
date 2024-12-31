<?php 
session_start();
if(isset($_SESSION["user"])){

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3" || $_SESSION["user"]["user_type_id"] == "4") {

    require "connection.php";
    $newFileNo = $_POST["newFileNo"];
    $newFileType = $_POST["newFileType"];

    if(empty($newFileNo)){
        echo "Please Enter File No";
    }else if(empty($newFileType)){
        echo "Please Select File type";
    }else{
        $userId = $_SESSION["user"]["id"];
        $fiels_rs = Database::search("SELECT * FROM `insurance_file` WHERE `file_no`=?",[$newFileNo],"s");
        $fiels_num= $fiels_rs->num_rows;
        if($fiels_num>0){
            echo "File already Exists";
        }else{
            Database::iud("INSERT INTO `insurance_file` (`file_no`,`user_id`,`file_type_id`) VALUES (?,?,?)",[$newFileNo,$userId,$newFileType],"sss");
            echo "Success";
        }
    }
}else{
    echo "Only Directors And Manages can add new File";
}
}else{
    header("Location: login.php");
}

?>