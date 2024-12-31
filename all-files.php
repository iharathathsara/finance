<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insurance File</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <!-- header -->
                <?php
                require "header.php";
                ?>
                <!-- header -->

                <div class="col-12 p-3">
                    <div class="row">

                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileNo">File No</label>
                            <input class="form-control" type="text" id="sFileNo" onkeyup="searchInsuranceFiles();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileCreateFrom">Created Date From</label>
                            <input class="form-control" type="date" id="sFileCreateFrom"
                                onchange="searchInsuranceFiles();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileCreateTo">Created Date To</label>
                            <input class="form-control" type="date" id="sFileCreateTo" onchange="searchInsuranceFiles();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileVehicleNo">Vehicle NO</label>
                            <input class="form-control" type="text" id="sFileVehicleNo" onkeyup="searchInsuranceFiles();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileClientNic">Client NIC</label>
                            <input class="form-control" type="text" id="sFileClientNic" onkeyup="searchInsuranceFiles();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileGuarantorNic">Guarantor NIC</label>
                            <input class="form-control" type="text" id="sFileGuarantorNic"
                                onkeyup="searchInsuranceFiles();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sFileType">File Type</label>
                            <select class="form-select" id="sFileType" onchange="searchInsuranceFiles();">
                                <option value="0">SELECT</option>
                                <?php
                                $fileType_rs = Database::search("SELECT * FROM `file_type`");
                                $fileType_num = $fileType_rs->num_rows;
                                for ($i = 0; $i < $fileType_num; $i++) {
                                    $fileType_data = $fileType_rs->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $fileType_data["id"]; ?>"><?php echo $fileType_data["name"]; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sSortBy">Sort By</label>
                            <select class="form-select" id="sSortBy" onchange="searchInsuranceFiles();">
                                <option value="0">SELECT</option>
                                <option value="1">File No ASC</option>
                                <option value="2">File No DESC</option>
                                <option value="3">Created Date ASC</option>
                                <option value="4">Created Date DESC</option>
                                <option value="5">Arrears</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-3 mb-3 pt-2">
                            <div class="row">
                                <button class="btn btn-primary mt-4" onclick="window.location.reload();">Clear</button>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-12 table-responsive p-3">
                    <table class="table table-hover table-striped border">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>ID</th>
                                <th>File NO</th>
                                <th>File Type</th>
                                <th>Vehicle No</th>
                                <th>Client NIC</th>
                                <th>Guarantor NIC</th>
                                <th>Created Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="filesTableBody">
                            <?php
                            $files_rs = Database::search("SELECT `insurance_file`.`id`,`insurance_file`.`file_no`,`insurance_file`.`created_at`,`file_type`.`name` FROM `insurance_file` INNER JOIN `file_type` ON `insurance_file`.`file_type_id`=`file_type`.`id` ORDER BY `insurance_file`.`file_no` ASC");
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

                                // $file_status_rs = Database::search("SELECT * FROM `insurance_file_status` WHERE `insurance_file_id`=? AND `status_id`=?", [$file_id, "2"], "ss");
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
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

    <?php

} else {
    header("Location: login.php");
}
?>