<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $sName = $_POST["sName"];
    $sEmail = $_POST["sEmail"];
    $sMobile = $_POST["sMobile"];
    $sType = $_POST["sType"];
    $sStatus = $_POST["sStatus"];

    $sNameLike = "%" . $sName . "%";
    $sEmailLike = "%" . $sEmail . "%";
    $sMobileLike = "%" . $sMobile . "%";

    $sParams = array();
    $sParamTypes = "";
    $sParams[] = $sNameLike;
    $sParams[] = $sNameLike;
    $sParams[] = $sEmailLike;
    $sParams[] = $sMobileLike;
    $sParamTypes .= "ssss";

    $squery = "SELECT `user`.`id`,`user`.`full_name`,`user`.`name_with_initial`,`user`.`email`,`user`.`mobile`,`user`.`nic`,`user`.`address`,`user_type`.`name` AS `userType`, `user_status`.`name` AS `userStatus` FROM `user` INNER JOIN `user_type` ON `user`.`user_type_id` = `user_type`.`id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id` WHERE (`user`.`full_name` LIKE ? OR `user`.`name_with_initial` LIKE ?) AND `user`.`email` LIKE ? AND `user`.`mobile` LIKE ? ";

    if (!empty($sType)) {
        $squery .= " AND `user`.`user_type_id`=? ";
        $sParams[] = $sType;
        $sParamTypes .= "s";
    }

    if (!empty($sStatus)) {
        $squery .= " AND `user`.`user_status_id`=? ";
        $sParams[] = $sStatus;
        $sParamTypes .= "s";
    }

    $users_rs = Database::search($squery, $sParams, $sParamTypes);
    $users_num = $users_rs->num_rows;
    for ($i = 0; $i < $users_num; $i++) {
        $users_data = $users_rs->fetch_assoc();
?>
        <tr>
            <td><?php echo $users_data["id"]; ?></td>
            <td><?php echo $users_data["full_name"]; ?></td>
            <td><?php echo $users_data["name_with_initial"]; ?></td>
            <td><?php echo $users_data["email"]; ?></td>
            <td><?php echo $users_data["mobile"]; ?></td>
            <td><?php echo $users_data["nic"]; ?></td>
            <td><?php echo $users_data["address"]; ?></td>
            <td><?php echo $users_data["userType"]; ?></td>
            <td>
                <?php
                if ($users_data["userStatus"] == "Active") {
                ?>
                    <button class="btn btn-success" onclick="updateUserStatus('<?php echo $users_data['id']; ?>');"><?php echo $users_data["userStatus"]; ?></button>
                <?php
                } else {
                ?>
                    <button class="btn btn-danger" onclick="updateUserStatus('<?php echo $users_data['id']; ?>');"><?php echo $users_data["userStatus"]; ?></button>
                <?php
                }
                ?>
            </td>
        </tr>
<?php
    }
} else {
    header("Location: login.php");
}
