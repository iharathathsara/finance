<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $itemTitle = $_POST["itemTitle"];
    $itemDescription = $_POST["itemDescription"];

    if (empty($itemTitle)) {
        echo "Please enter item title";
    } else {

        $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
        $itemImg1Path = "resources/add-image.png";
        $itemImg2Path = "resources/add-image.png";

        if (isset($_FILES["itemImg1"])) {
            $itemImg1 = $_FILES["itemImg1"];
            $itemImg1_ex = $itemImg1["type"];
            if (!in_array($itemImg1_ex, $allowed_image_extentions)) {
                echo "Please select a valid NIC front Image.";
                return;
            } else {
                $new_itemImg1_ex;
                if ($itemImg1_ex == "image/jpg") {
                    $new_itemImg1_ex = ".jpg";
                } else if ($itemImg1_ex == "image/jpeg") {
                    $new_itemImg1_ex = ".jpeg";
                } else if ($itemImg1_ex == "image/png") {
                    $new_itemImg1_ex = ".png";
                } else if ($itemImg1_ex == "image/svg+xml") {
                    $new_itemImg1_ex = ".svg";
                }
                $itemImg1Path = "resources//images//" . uniqid() . $new_itemImg1_ex;
                move_uploaded_file($itemImg1["tmp_name"], $itemImg1Path);
            }

        }

        if (isset($_FILES["itemImg2"])) {
            $itemImg2 = $_FILES["itemImg2"];
            $itemImg2_ex = $itemImg2["type"];
            if (!in_array($itemImg2_ex, $allowed_image_extentions)) {
                echo "Please select a valid NIC front Image.";
                return;
            } else {
                $new_itemImg2_ex;
                if ($itemImg2_ex == "image/jpg") {
                    $new_itemImg2_ex = ".jpg";
                } else if ($itemImg2_ex == "image/jpeg") {
                    $new_itemImg2_ex = ".jpeg";
                } else if ($itemImg2_ex == "image/png") {
                    $new_itemImg2_ex = ".png";
                } else if ($itemImg2_ex == "image/svg+xml") {
                    $new_itemImg2_ex = ".svg";
                }
                $itemImg2Path = "resources//images//" . uniqid() . $new_itemImg2_ex;
                move_uploaded_file($itemImg2["tmp_name"], $itemImg2Path);
            }
        }

        Database::iud("INSERT INTO `inventory` (`title`,`desc`,`img1`,`img2`) VALUES (?,?,?,?)",[$itemTitle,$itemDescription,$itemImg1Path,$itemImg2Path],"ssss");
        echo "Success";



    }

} else {
    header("Location: login.php");
}
?>