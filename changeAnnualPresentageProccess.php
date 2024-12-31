<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"]["user_type_id"] == '1') {
        require "connection.php";
        
        $annualpresentage=$_POST["annualpresentage"];

        if(empty($annualpresentage)){
            echo "Please enter annual presentage";
        }else if($annualpresentage<0){
            echo "annual presentage should be greater than 0";
        }else{
            Database::iud("UPDATE `payment_anual_presentage` SET `value`=?",[$annualpresentage],"s");
            echo "Success";
        }

    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}
?>