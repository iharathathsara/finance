<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $itemId = $_GET["itemId"];

    if (empty($itemId)) {
        echo "Something wrong try again";
    } else {

        Database::iud("DELETE FROM `inventory` WHERE `id`=? ",[$itemId],"s");
        echo "Success";

    }

} else {
    header("Location: login.php");
}
?>