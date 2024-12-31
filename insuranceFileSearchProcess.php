<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $sFileNo = $_POST["sFileNo"];
    $sFileCreateFrom = $_POST["sFileCreateFrom"];
    $sFileCreateTo = $_POST["sFileCreateTo"];
    $sFileVehicleNo = $_POST["sFileVehicleNo"];
    $sFileClientNic = $_POST["sFileClientNic"];
    $sFileGuarantorNic = $_POST["sFileGuarantorNic"];
    $sFileType = $_POST["sFileType"];
    $sSortBy = $_POST["sSortBy"];

    $sFileNoLike = "%" . $sFileNo . "%";
    $sFileVehicleNoLike = "%" . $sFileVehicleNo . "%";
    $sFileClientNicLike = "%" . $sFileClientNic . "%";
    $sFileGuarantorNicLike = "%" . $sFileGuarantorNic . "%";

    // Base query
    $squery = "SELECT `insurance_file`.`id`, `insurance_file`.`file_no`, `insurance_file`.`created_at`, `file_type`.`name` FROM `insurance_file` INNER JOIN `file_type` ON `insurance_file`.`file_type_id` = `file_type`.`id`";

    $sParams = array();
    $sParamTypes = "";
    $whereQuery = " WHERE `insurance_file`.`file_no` LIKE ? ";
    $sParams[] = $sFileNoLike;
    $sParamTypes .= "s";

    // Join additional tables based on search criteria
    if (!empty($sFileVehicleNo)) {
        $squery .= " INNER JOIN `vehicle` ON `insurance_file`.`id` = `vehicle`.`insurance_file_id` ";
        $whereQuery .= " AND `vehicle`.`reg_no` LIKE ? ";
        $sParams[] = $sFileVehicleNoLike;
        $sParamTypes .= "s";
    }

    if (!empty($sFileClientNic)) {
        $squery .= " INNER JOIN `client` ON `insurance_file`.`id` = `client`.`insurance_file_id` ";
        $whereQuery .= " AND `client`.`nic` LIKE ? ";
        $sParams[] = $sFileClientNicLike;
        $sParamTypes .= "s";
    }

    if (!empty($sFileGuarantorNic)) {
        $squery .= " INNER JOIN `guarantor` ON `insurance_file`.`id` = `guarantor`.`insurance_file_id` ";
        $whereQuery .= " AND `guarantor`.`nic` LIKE ? ";
        $sParams[] = $sFileGuarantorNicLike;
        $sParamTypes .= "s";
    }

    if (!empty($sFileCreateFrom)) {
        if (!empty($sFileCreateTo)) {
            $whereQuery .= " AND (`insurance_file`.`created_at` BETWEEN ? AND ?) ";
            $sParams[] = $sFileCreateFrom;
            $sParams[] = $sFileCreateTo;
            $sParamTypes .= "ss";
        } else {
            $whereQuery .= " AND `insurance_file`.`created_at` > ? ";
            $sParams[] = $sFileCreateFrom;
            $sParamTypes .= "s";
        }
    } else {
        if (!empty($sFileCreateTo)) {
            $whereQuery .= " AND `insurance_file`.`created_at` < ? ";
            $sParams[] = $sFileCreateTo;
            $sParamTypes .= "s";
        }
    }

    if (!empty($sFileType)) {
        $whereQuery .= " AND `insurance_file`.`file_type_id` = ? ";
        $sParams[] = $sFileType;
        $sParamTypes .= "s";
    }

    if ($sSortBy == "5") {
        // Sort by arrears
        $squery = "SELECT `insurance_file`.`id`, `insurance_file`.`file_no`, `insurance_file`.`created_at`, `file_type`.`name`, 
                          IFNULL(SUM(`file_installment_payment`.`balance`), 0) AS `arrears` 
                   FROM `insurance_file`
                   INNER JOIN `file_type` ON `insurance_file`.`file_type_id` = `file_type`.`id`
                   LEFT JOIN `file_installment_payment` ON `insurance_file`.`id` = `file_installment_payment`.`file_id`";
        $whereQuery .= " GROUP BY `insurance_file`.`id` ORDER BY `arrears` DESC";
    } else {
        // Existing sorting options
        if ($sSortBy == "1") {
            $whereQuery .= " ORDER BY `insurance_file`.`file_no` ASC ";
        } else if ($sSortBy == "2") {
            $whereQuery .= " ORDER BY `insurance_file`.`file_no` DESC ";
        } else if ($sSortBy == "3") {
            $whereQuery .= " ORDER BY `insurance_file`.`created_at` ASC ";
        } else if ($sSortBy == "4") {
            $whereQuery .= " ORDER BY `insurance_file`.`created_at` DESC ";
        }
    }

    $fullQuery = $squery . $whereQuery;

    try {
        $files_rs = Database::search($fullQuery, $sParams, $sParamTypes);
        $files_num = $files_rs->num_rows;
        for ($i = 0; $i < $files_num; $i++) {
            $file_data = $files_rs->fetch_assoc();
            $file_id = $file_data["id"];

            $client_rs = Database::search("SELECT * FROM `client` WHERE `insurance_file_id` = ?", [$file_id], "s");
            $client_data = $client_rs->fetch_assoc();

            $guarantor_rs = Database::search("SELECT * FROM `guarantor` WHERE `insurance_file_id` = ?", [$file_id], "s");
            $guarantor_data = $guarantor_rs->fetch_assoc();

            $vehicle_rs = Database::search("SELECT * FROM `vehicle` WHERE `insurance_file_id` = ?", [$file_id], "s");
            $vehicle_data = $vehicle_rs->fetch_assoc();

            $file_status_rs = Database::search("SELECT * FROM `insurance_file_status` INNER JOIN `user` ON `insurance_file_status`.`user_id`=`user`.`id` WHERE `insurance_file_status`.`insurance_file_id`=? AND `insurance_file_status`.`status_id`=?", [$file_id, "2"], "ss");
            $file_status_num = $file_status_rs->num_rows;

            $file_status = "Pending";
            if ($file_status_num > 0) {
                $file_status_data = $file_status_rs->fetch_assoc();

                if ($file_status_data['user_type_id'] == "1") {
                    $file_status = "Approved";
                } else if ($file_status_num == 1) {
                    $file_status = "Pending 50%";
                } else if ($file_status_num == 2) {
                    $file_status = "Approved";
                }
            }

            ?>
            <tr class="<?php
            if ($file_status == "Pending") {
                echo "table-danger";
            } else if ($file_status == "Approved") {
                echo "table-success";
            }
            ?>" onclick="window.location='update-file.php?fileNo=<?php echo $file_id; ?>';"
                style="cursor: pointer;">
                <td><?php echo $file_id; ?></td>
                <td><?php echo $file_data["file_no"]; ?></td>
                <td><?php echo $file_data["name"]; ?></td>
                <td><?php echo isset($vehicle_data['reg_no']) ? $vehicle_data['reg_no'] : '-'; ?></td>
                <td><?php echo isset($client_data['nic']) ? $client_data['nic'] : '-'; ?></td>
                <td><?php echo isset($guarantor_data['nic']) ? $guarantor_data['nic'] : '-'; ?></td>
                <td><?php echo $file_data["created_at"]; ?></td>
                <td><?php echo $file_status; ?></td>
            </tr>
            <?php
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: login.php");
}
?>