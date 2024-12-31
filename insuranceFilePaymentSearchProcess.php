<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $sFileNo = $_POST["sFileNo"];
    $sFileVehicleNo = $_POST["sFileVehicleNo"];
    $sFileClientNic = $_POST["sFileClientNic"];
    $sFileType = $_POST["sFileType"];

    $sFileNoLike = "%" . $sFileNo . "%";
    $sFileVehicleNoLike = "%" . $sFileVehicleNo . "%";
    $sFileClientNicLike = "%" . $sFileClientNic . "%";

    $squery = "SELECT `insurance_file`.`id`,`insurance_file`.`file_no`,`insurance_file`.`created_at`,`file_type`.`name` FROM `insurance_file` INNER JOIN `file_type` ON `insurance_file`.`file_type_id`=`file_type`.`id` ";

    $sParams = array();
    $sParamTypes = "";

    $whereQuaery = " WHERE `insurance_file`.`file_no` LIKE ? ";
    $sParams[] = $sFileNoLike;
    $sParamTypes = "s";

    if (!empty($sFileClientNic)) {
        $squery .= " INNER JOIN `client` ON `insurance_file`.`id`=`client`.`insurance_file_id` ";
        $whereQuaery .= " AND `client`.`nic` LIKE ? ";
        $sParams[] = $sFileClientNicLike;
        $sParamTypes .= "s";
    }

    if (!empty($sFileVehicleNo)) {
        $squery .= " INNER JOIN `vehicle` ON `insurance_file`.`id`=`vehicle`.`insurance_file_id` ";
        $whereQuaery .= " AND `vehicle`.`reg_no` LIKE ? ";
        $sParams[] = $sFileVehicleNoLike;
        $sParamTypes .= "s";
    }

    if (!empty($sFileType)) {
        $whereQuaery .= " AND `insurance_file`.`file_type_id`= ? ";
        $sParams[] = $sFileType;
        $sParamTypes .= "s";
    }

    
    $fullQuery = $squery . $whereQuaery;
    // echo $fullQuery;

    $files_rs = Database::search($fullQuery, $sParams, $sParamTypes);
    $files_num = $files_rs->num_rows;
    for ($i = 0; $i < $files_num; $i++) {
        $file_data = $files_rs->fetch_assoc();
        $file_id =  $file_data["id"];

        $client_rs = Database::search("SELECT * FROM `client` WHERE `insurance_file_id` = ?", [$file_id], "s");
        $client_data = $client_rs->fetch_assoc();

        $vehicle_rs = Database::search("SELECT * FROM `vehicle` WHERE `insurance_file_id` = ?", [$file_id], "s");
        $vehicle_data = $vehicle_rs->fetch_assoc();

        $file_status_rs = Database::search("SELECT * FROM `insurance_file_status` WHERE `insurance_file_id`=? AND `status_id`=?", [$file_id, "2"], "ss");
        $file_status_num = $file_status_rs->num_rows;

        $file_status = "Pending";
        if ($file_status_num == 1) {
            $file_status = "Pending 50%";
        } else if ($file_status_num == 2) {
            $file_status = "Approved";
        }

?>
        <tr class="<?php
                    if ($file_status == "Pending") {
                        echo "table-danger";
                    } else if ($file_status == "Approved") {
                        echo "table-success";
                    }
                    ?>" onclick="window.location='payment-details.php?fileID=<?php echo $file_id; ?>';" style="cursor: pointer;">
            <td><?php echo $file_id; ?></td>
            <td><?php echo $file_data["file_no"]; ?></td>
            <td><?php echo $file_data["name"]; ?></td>
            <td><?php echo isset($vehicle_data['reg_no']) ? $vehicle_data['reg_no'] : '-'; ?></td>
            <td><?php echo isset($client_data['nic']) ? $client_data['nic'] : '-'; ?></td>
            <td><?php echo $file_status; ?></td>
        </tr>
<?php
    }
} else {
    header("Location: login.php");
}
