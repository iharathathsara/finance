<?php
session_start();

if (isset($_SESSION["user"])) {

    if (isset($_GET["fileNo"])) {

        $fileID = $_GET["fileNo"];

        require "connection.php";

        $file_rs = Database::search("SELECT `insurance_file`.`id`, `insurance_file`.`file_no` , `insurance_file`.`created_at`,`insurance_file`.`updated_at`,`file_type`.`name`,`user`.`full_name` FROM `insurance_file` INNER JOIN `user` ON `insurance_file`.`user_id`=`user`.`id` INNER JOIN `file_type` ON `insurance_file`.`file_type_id`=`file_type`.`id` WHERE `insurance_file`.`id` = ?", [$fileID], "s");
        $file_num = $file_rs->num_rows;
        if ($file_num > 0) {


            $file_data = $file_rs->fetch_assoc();
            $fileNo = $file_data["file_no"];

            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Update File</title>
                <link rel="stylesheet" href="bootstrap.css" />
                <link rel="stylesheet" href="style.css" />

                <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
                    rel="stylesheet">
            </head>

            <body>
                <div class="container-fluid">
                    <div class="row">

                        <!-- header -->
                        <?php
                        require "header.php";

                        $client_rs = Database::search("SELECT * FROM `client` WHERE `insurance_file_id`=?", [$fileID], "s");
                        $client_num = $client_rs->num_rows;
                        $client_data = $client_rs->fetch_assoc();

                        ?>
                        <!-- header -->

                        <div class="offset-lg-1 col-12 col-lg-10 mt-5">
                            <div class="row">

                                <h1 class="text-center mb-4 fw-bold text-decoration-underline">
                                    <?php echo $fileNo . " (" . $file_data["name"] . ")"; ?></h1>

                                <div class=" col-12 ">
                                    <div class="row d-flex justify-content-center">

                                        <div class="col-6 col-md-4 col-lg-3 p-3">
                                            <div class="row">
                                                <div
                                                    class="shadow border border-2  home-cat-btn d-flex flex-column justify-content-center align-items-center">
                                                    <span class="fs-5"><?php echo $file_data["created_at"]; ?></span>
                                                    <span>Created Date</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-4 col-lg-6 p-3">
                                            <div class="row">
                                                <div
                                                    class="shadow border border-2 home-cat-btn d-flex flex-column justify-content-center align-items-center">
                                                    <span class="fs-5"><?php echo $file_data["full_name"]; ?></span>
                                                    <span>Created User</span>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $currentStatus_rs = Database::search("SELECT * FROM `insurance_file_status` INNER JOIN `user` ON `insurance_file_status`.`user_id`=`user`.`id` WHERE `insurance_file_status`.`insurance_file_id`=? AND `insurance_file_status`.`status_id`=?", [$fileID, "2"], "ss");
                                        $currentStatus_num = $currentStatus_rs->num_rows;

                                        $currentStatus = "Pending";
                                        if ($currentStatus_num > 0) {
                                            $currentStatus_data = $currentStatus_rs->fetch_assoc();

                                            if ($currentStatus_data['user_type_id'] == "1") {
                                                $currentStatus = "Approved";
                                            } else if ($currentStatus_num == 1) {
                                                $currentStatus = "Pending 50%";
                                            } else if ($currentStatus_num == 2) {
                                                $currentStatus = "Approved";
                                            }
                                        }

                                        ?>

                                        <div class="col-6 col-md-4 col-lg-3 p-3">
                                            <div class="row">
                                                <div
                                                    class="shadow <?php echo $currentStatus == "Approved" ? 'bg-green' : 'bg-yellow'; ?> home-cat-btn d-flex flex-column justify-content-center align-items-center">
                                                    <span class="fs-4 fw-bold"><?php echo $currentStatus; ?></span>
                                                    <span>Current Status</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr />

                                <div class="col-12 mt-4">
                                    <div class="row table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>Status</th>
                                                    <th>Special Message</th>
                                                    <th>Updated Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fileStatus_rs = Database::search("SELECT `insurance_file_status`.`id`, `insurance_file_status`.`message`,`insurance_file_status`.`updated_at`,`status`.`name`,`status`.`id` AS `statusId`,`user`.`full_name`,`user`.`id` AS `userId` FROM `insurance_file_status` INNER JOIN `user` ON `insurance_file_status`.`user_id`=`user`.`id` INNER JOIN `status` ON `insurance_file_status`.`status_id`=`status`.`id` WHERE `insurance_file_status`.`insurance_file_id` = ?", [$fileID], "s");
                                                $fileStatus_num = $fileStatus_rs->num_rows;

                                                $approvedFilePayment_rs = Database::search("SELECT * FROM `file_approved_payment` WHERE `file_id`=?", [$fileID], "s");
                                                $approvedFilePayment_data = $approvedFilePayment_rs->fetch_assoc();

                                                if (isset($approvedFilePayment_data)) {
                                                    for ($i = 0; $i < $fileStatus_num; $i++) {
                                                        $fileStatus_data = $fileStatus_rs->fetch_assoc();

                                                        ?>
                                                        <tr
                                                            class="<?php echo $fileStatus_data["name"] == "Approved" ? "table-success" : "table-warning"; ?>">
                                                            <td><?php echo $fileStatus_data["full_name"]; ?></td>
                                                            <td> <?php echo $fileStatus_data["name"]; ?></td>
                                                            <td><?php echo $fileStatus_data["message"]; ?></td>
                                                            <td><?php echo $fileStatus_data["updated_at"]; ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php

                                                    }
                                                } else {
                                                    if ($fileStatus_num == 0) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $_SESSION["user"]["full_name"]; ?></td>
                                                            <td>
                                                                <select class="form-select" name="" id="selectedFileStatus">
                                                                    <option value="0">SELECT</option>
                                                                    <?php
                                                                    $status_rs = Database::search("SELECT * FROM `status`");
                                                                    $status_num = $status_rs->num_rows;
                                                                    for ($j = 0; $j < $status_num; $j++) {
                                                                        $status_data = $status_rs->fetch_assoc();
                                                                        ?>
                                                                        <option value="<?php echo $status_data['id']; ?>">
                                                                            <?php echo $status_data['name']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td><textarea class="form-control" name="" id="stausMessage"
                                                                    placeholder="Special Message (optional)"></textarea></td>
                                                            <td></td>
                                                            <td><button class="btn btn-primary"
                                                                    onclick="changeFileStatus('<?php echo $fileID; ?>');">Change
                                                                    Status</button></td>
                                                        </tr>
                                                        <?php
                                                    } else if ($fileStatus_num == 1) {

                                                        $fileStatus_data = $fileStatus_rs->fetch_assoc();

                                                        if ($fileStatus_data['userId'] == $_SESSION["user"]["id"]) {
                                                            ?>
                                                                <tr
                                                                    class="<?php echo $fileStatus_data["name"] == "Approved" ? "table-success" : "table-warning"; ?>">
                                                                    <td><?php echo $fileStatus_data["full_name"]; ?></td>
                                                                    <td>
                                                                        <select class="form-select" name="" id="selectedFileStatus">
                                                                            <option value="0">SELECT</option>
                                                                            <?php
                                                                            $status_rs = Database::search("SELECT * FROM `status`");
                                                                            $status_num = $status_rs->num_rows;
                                                                            for ($j = 0; $j < $status_num; $j++) {
                                                                                $status_data = $status_rs->fetch_assoc();
                                                                                ?>
                                                                                <option value="<?php echo $status_data['id']; ?>" <?php echo $fileStatus_data["statusId"] == $status_data['id'] ? 'selected' : ''; ?>><?php echo $status_data['name']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>

                                                                        <textarea class="form-control" name="" id="stausMessage"
                                                                            placeholder="Special Message (optional)"><?php echo $fileStatus_data["message"]; ?></textarea>
                                                                    </td>
                                                                    <td><?php echo $fileStatus_data["updated_at"]; ?></td>
                                                                    <td><button class="btn btn-primary"
                                                                            onclick="changeFileStatus('<?php echo $fileID; ?>');">Change
                                                                            Status</button></td>
                                                                </tr>
                                                            <?php
                                                        } else {
                                                            ?>
                                                                <tr
                                                                    class="<?php echo $fileStatus_data["name"] == "Approved" ? "table-success" : "table-warning"; ?>">
                                                                    <td><?php echo $fileStatus_data["full_name"]; ?></td>
                                                                    <td> <?php echo $fileStatus_data["name"]; ?></td>
                                                                    <td><?php echo $fileStatus_data["message"]; ?></td>
                                                                    <td><?php echo $fileStatus_data["updated_at"]; ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo $_SESSION["user"]["full_name"]; ?></td>
                                                                    <td>
                                                                        <select class="form-select" name="" id="selectedFileStatus">
                                                                            <option value="0">SELECT</option>
                                                                            <?php
                                                                            $status_rs = Database::search("SELECT * FROM `status`");
                                                                            $status_num = $status_rs->num_rows;
                                                                            for ($j = 0; $j < $status_num; $j++) {
                                                                                $status_data = $status_rs->fetch_assoc();
                                                                                ?>
                                                                                <option value="<?php echo $status_data['id']; ?>">
                                                                                <?php echo $status_data['name']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                    <td><textarea class="form-control" name="" id="stausMessage"
                                                                            placeholder="Special Message (optional)"></textarea></td>
                                                                    <td></td>
                                                                    <td><button class="btn btn-primary"
                                                                            onclick="changeFileStatus('<?php echo $fileID; ?>');">Change
                                                                            Status</button></td>
                                                                </tr>
                                                            <?php
                                                        }
                                                        ?>

                                                        <?php
                                                    } else {
                                                        for ($i = 0; $i < $fileStatus_num; $i++) {
                                                            $fileStatus_data = $fileStatus_rs->fetch_assoc();

                                                            if ($fileStatus_data['userId'] == $_SESSION["user"]["id"]) {
                                                                ?>
                                                                    <tr
                                                                        class="<?php echo $fileStatus_data["name"] == "Approved" ? "table-success" : "table-warning"; ?>">
                                                                        <td><?php echo $fileStatus_data["full_name"]; ?></td>
                                                                        <td>
                                                                            <select class="form-select" name="" id="selectedFileStatus">
                                                                                <option value="0">SELECT</option>
                                                                                <?php
                                                                                $status_rs = Database::search("SELECT * FROM `status`");
                                                                                $status_num = $status_rs->num_rows;
                                                                                for ($j = 0; $j < $status_num; $j++) {
                                                                                    $status_data = $status_rs->fetch_assoc();
                                                                                    ?>
                                                                                    <option value="<?php echo $status_data['id']; ?>" <?php echo $fileStatus_data["statusId"] == $status_data['id'] ? 'selected' : ''; ?>><?php echo $status_data['name']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>

                                                                            <textarea class="form-control" name="" id="stausMessage"
                                                                                placeholder="Special Message (optional)"><?php echo $fileStatus_data["message"]; ?></textarea>
                                                                        </td>
                                                                        <td><?php echo $fileStatus_data["updated_at"]; ?></td>
                                                                        <td><button class="btn btn-primary"
                                                                                onclick="changeFileStatus('<?php echo $fileID; ?>');">Change
                                                                                Status</button></td>
                                                                    </tr>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                    <tr
                                                                        class="<?php echo $fileStatus_data["name"] == "Approved" ? "table-success" : "table-warning"; ?>">
                                                                        <td><?php echo $fileStatus_data["full_name"]; ?></td>
                                                                        <td> <?php echo $fileStatus_data["name"]; ?></td>
                                                                        <td><?php echo $fileStatus_data["message"]; ?></td>
                                                                        <td><?php echo $fileStatus_data["updated_at"]; ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">

                                        <h2>Approved Payment Details</h2>
                                        <div class="col-12 col-md-6 p-3">
                                            <label for="paymentBankName">Bank Name</label>
                                            <input class="form-control" type="text" id="paymentBankName"
                                                value="<?php echo isset($approvedFilePayment_data["bank_name"]) ? $approvedFilePayment_data["bank_name"] : ''; ?>" />
                                        </div>
                                        <div class="col-12 col-md-6 p-3">
                                            <label for="paymentDate">Payment Date</label>
                                            <input class="form-control" type="Date" id="paymentDate"
                                                value="<?php echo isset($approvedFilePayment_data["payment_date"]) ? $approvedFilePayment_data["payment_date"] : ''; ?>" />
                                        </div>
                                        <div class="col-12 col-md-6 p-3">
                                            <label for="paymentCheckNo">Check No</label>
                                            <input class="form-control" type="text" id="paymentCheckNo"
                                                value="<?php echo isset($approvedFilePayment_data["check_no"]) ? $approvedFilePayment_data["check_no"] : ''; ?>" />
                                        </div>
                                        <div class="col-12 col-md-6 p-3">
                                            <label for="paymentAmount">Amount</label>
                                            <input class="form-control" type="text" id="paymentAmount"
                                                onkeypress="priceValidateKeyPress(event,this);"
                                                value="<?php echo isset($approvedFilePayment_data["amount"]) ? $approvedFilePayment_data["amount"] : ''; ?>" />
                                        </div>
                                        <div class="col-12 col-md-6 p-3">
                                            <label for=""> </label>
                                            <button class="btn btn-primary px-5"
                                                onclick="approvedPaymentDetails('<?php echo $fileID; ?>');">Save</button>
                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="offset-lg-1 col-12 col-lg-10 border shadow rounded-3 p-md-5 my-5">
                            <div class="row">

                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed fw-bold text-white <?php echo isset($client_data) ? 'bg-success' : 'bg-danger'; ?>"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#client-form"
                                                aria-expanded="false" aria-controls="client-form">
                                                Client Application
                                            </button>
                                        </h2>
                                        <div id="client-form" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="col-12 pb-5">
                                                    <div class="row">

                                                        <h1 class="text-center my-3">Client Application</h1>

                                                        <h3 class="bg-blue">Particulars of Appliciant</h3>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientFullName">Full Name of Applicant</label>
                                                            <input class="form-control" type="text" id="clientFullName"
                                                                value="<?php echo isset($client_data["full_name"]) ? $client_data["full_name"] : ''; ?>" />

                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientNameWithInitial">Name with Initials</label>
                                                            <input class="form-control" type="text" id="clientNameWithInitial"
                                                                value="<?php echo isset($client_data["name_with_initial"]) ? $client_data["name_with_initial"] : ''; ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientAddress">Permanent Address</label>
                                                            <input class="form-control" type="text" id="clientAddress"
                                                                value="<?php echo isset($client_data["address"]) ? htmlspecialchars($client_data["address"]) : ''; ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientDOB">Date of Birth</label>
                                                            <input class="form-control" type="text" id="clientDOB"
                                                                value="<?php echo isset($client_data["dob"]) ? $client_data["dob"] : ''; ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientNIC">NIC No</label>
                                                            <input class="form-control" type="text" id="clientNIC"
                                                                value="<?php echo isset($client_data["nic"]) ? $client_data["nic"] : ''; ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientTel">Tel No</label>
                                                            <input class="form-control" type="tel" id="clientTel"
                                                                onkeypress="mobileValidateKeyPress(event,'clientTel');"
                                                                maxlength="10"
                                                                value="<?php echo isset($client_data["tel"]) ? $client_data["tel"] : ''; ?>" />
                                                            <span id="message"></span>
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientMobile">Mobile No</label>
                                                            <input class="form-control" type="tel" id="clientMobile"
                                                                onkeypress="mobileValidateKeyPress(event,'clientMobile');"
                                                                maxlength="10"
                                                                value="<?php echo isset($client_data["mobile"]) ? $client_data["mobile"] : ''; ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientTitle">Title</label>
                                                            <select class="form-select" name="" id="clientTitle"
                                                                value="<?php echo isset($client_data["user_title_id"]) ? $client_data["user_title_id"] : ''; ?>">
                                                                <option value="0">SELECT</option>
                                                                <?php
                                                                $user_title_rs = Database::search("SELECT * FROM `user_title`");
                                                                $user_title_num = $user_title_rs->num_rows;
                                                                for ($i = 0; $i < $user_title_num; $i++) {
                                                                    $user_title_data = $user_title_rs->fetch_assoc();
                                                                    ?>
                                                                    <option value="<?php echo $user_title_data["id"]; ?>" <?php echo (isset($client_data["user_title_id"]) && $user_title_data["id"] == $client_data["user_title_id"]) ? "selected" : ""; ?>><?php echo $user_title_data["name"]; ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientNicFrontPhoto">NIC Photo front</label>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <label class="btn btn-primary w-100" for="clientNicFrontPhoto"
                                                                        onclick="selectPhoto('clientNicFrontPhoto','clientNicFrontPhotoImg');">Choose
                                                                        a Photo</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="clientNicFrontPhoto" />
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="<?php echo isset($client_data["nic_font_img_path"]) ? $client_data["nic_font_img_path"] : '#'; ?>"
                                                                        class="col-6 btn btn-outline-primary w-100"
                                                                        id="downloadNicFrontPhotoBtn"
                                                                        download="client_nic_front_photo.jpg"><i
                                                                            class="bi bi-download"></i> Download</a>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-1 col-md-10"
                                                                    src="<?php echo isset($client_data["nic_font_img_path"]) ? $client_data["nic_font_img_path"] : 'resources/add-image.png'; ?>"
                                                                    id="clientNicFrontPhotoImg" alt="NIC Front Photo" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientNicBackPhoto">NIC Photo back</label>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <label class="btn btn-primary w-100" for="clientNicBackPhoto"
                                                                        onclick="selectPhoto('clientNicBackPhoto','clientNicBackPhotoImg');">Choose
                                                                        a Photo</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="clientNicBackPhoto" />
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="<?php echo isset($client_data["nic_back_img_path"]) ? $client_data["nic_back_img_path"] : '#'; ?>"
                                                                        class="col-6 btn btn-outline-primary w-100"
                                                                        id="downloadNicFrontPhotoBtn"
                                                                        download="client_nic_back_img.jpg"><i
                                                                            class="bi bi-download"></i> Download</a>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-1 col-md-10"
                                                                    src="<?php echo isset($client_data["nic_back_img_path"]) ? $client_data["nic_back_img_path"] : 'resources/add-image.png'; ?>"
                                                                    id="clientNicBackPhotoImg" alt="NIC Back Photo">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="clientMarrageStatusCheckBox">Marage Status</label>
                                                                <input class="form-check-input" type="checkbox" role="switch"
                                                                    id="clientMarrageStatusCheckBox"
                                                                    onchange="clientMarrageStatusChange();" <?php echo isset($client_data["spouse_full_name"]) && !empty($client_data["spouse_full_name"]) ? 'checked' : ''; ?> />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3 mb-3 border shadow rounded-3 <?php echo isset($client_data["spouse_full_name"]) && !empty($client_data["spouse_full_name"]) ? '' : 'd-none'; ?>"
                                                            id="clientMarrageDetailsBox">
                                                            <div class="row">

                                                                <h3 class="bg-blue">Details of Spouse</h3>

                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="clientSpouseFullName">Name in Full</label>
                                                                    <input class="form-control" type="text"
                                                                        id="clientSpouseFullName"
                                                                        value="<?php echo htmlspecialchars(isset($client_data["spouse_full_name"]) ? $client_data["spouse_full_name"] : ''); ?>" />
                                                                </div>
                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="clientSpouseNIC">NIC No</label>
                                                                    <input class="form-control" type="text" id="clientSpouseNIC"
                                                                        value="<?php echo htmlspecialchars(isset($client_data["spouse_nic"]) ? $client_data["spouse_nic"] : ''); ?>" />
                                                                </div>
                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="clientSpouseTel">Tel No</label>
                                                                    <input class="form-control" type="tel" id="clientSpouseTel"
                                                                        onkeypress="mobileValidateKeyPress(event,'clientSpouseTel');"
                                                                        maxlength="10"
                                                                        value="<?php echo htmlspecialchars(isset($client_data["spouse_tel"]) ? $client_data["spouse_tel"] : ''); ?>" />
                                                                </div>
                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="clientSpouseProfession">Profession</label>
                                                                    <input class="form-control" type="text"
                                                                        id="clientSpouseProfession"
                                                                        value="<?php echo htmlspecialchars(isset($client_data["spouse_profession"]) ? $client_data["spouse_profession"] : ''); ?>" />
                                                                </div>

                                                            </div>
                                                        </div>


                                                        <h3 class="bg-blue">Details of Employment</h3>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientEmpName">Name of Employer/Business</label>
                                                            <input class="form-control" type="text" id="clientEmpName"
                                                                value="<?php echo htmlspecialchars(isset($client_data["business_name"]) ? $client_data["business_name"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientEmpAddress">Address of Employer/Business</label>
                                                            <input class="form-control" type="text" id="clientEmpAddress"
                                                                value="<?php echo htmlspecialchars(isset($client_data["business_address"]) ? $client_data["business_address"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientBusinessRegNo">Business Registration No</label>
                                                            <input class="form-control" type="tel" id="clientBusinessRegNo"
                                                                value="<?php echo htmlspecialchars(isset($client_data["business_reg_no"]) ? $client_data["business_reg_no"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientBusinessNature">Nature of Business</label>
                                                            <input class="form-control" type="text" id="clientBusinessNature"
                                                                value="<?php echo htmlspecialchars(isset($client_data["business_nature"]) ? $client_data["business_nature"] : ''); ?>" />
                                                        </div>

                                                        <h3 class="bg-blue">Details of Personal Income</h3>
                                                        <div class="col-12 p-3 table-responsive">
                                                            <table class="table">
                                                                <tr>
                                                                    <th colspan="2">Statement of Income (Monthly)</th>
                                                                    <th>Income (Net)(Rs.)</th>
                                                                </tr>
                                                                <tr>
                                                                    <th rowspan="3">Source of Income</th>
                                                                    <th>Employment/Business</th>
                                                                    <td><input class="form-control"
                                                                            value="<?php echo htmlspecialchars(isset($client_data["employment_income"]) ? $client_data["employment_income"] : ''); ?>"
                                                                            type="text" id="clentIncomeEmp" min="0"
                                                                            onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calClientTotalNetIncome();" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Other</th>
                                                                    <td><input class="form-control"
                                                                            value="<?php echo htmlspecialchars(isset($client_data["other_income"]) ? $client_data["other_income"] : ''); ?>"
                                                                            type="text" id="clentIncomeOther" min="0"
                                                                            onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calClientTotalNetIncome();" /></td>
                                                                </tr>
                                                                <?php
                                                                $clientTotalIncomeCal = 0;
                                                                $clientNetIncomeCal = 0;
                                                                if (isset($client_data["employment_income"])) {
                                                                    $clientTotalIncomeCal = $client_data["employment_income"] + $client_data["other_income"];
                                                                    $clientNetIncomeCal = $clientTotalIncomeCal - $client_data["living_cost"] - $client_data["loan_repayment"];
                                                                }

                                                                ?>
                                                                <tr>
                                                                    <th>Total Income</th>
                                                                    <th id="clientTotalIncome"><?php echo $clientTotalIncomeCal; ?>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th rowspan="3">Less</th>
                                                                    <th>Cost of Living</th>
                                                                    <td><input class="form-control"
                                                                            value="<?php echo htmlspecialchars(isset($client_data["living_cost"]) ? $client_data["living_cost"] : ''); ?>"
                                                                            type="text" id="clientCostLiving" min="0"
                                                                            onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calClientTotalNetIncome();" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Loan repayment</th>
                                                                    <td><input class="form-control"
                                                                            value="<?php echo htmlspecialchars(isset($client_data["loan_repayment"]) ? $client_data["loan_repayment"] : ''); ?>"
                                                                            type="text" id="clientLoanRepayment" min="0"
                                                                            onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calClientTotalNetIncome();" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Net Income</th>
                                                                    <th id="clientNetIncome"><?php echo $clientNetIncomeCal; ?></th>
                                                                </tr>
                                                            </table>

                                                        </div>

                                                        <h3 class="bg-blue">Credit Facilities Obtained</h3>
                                                        <?php
                                                        if (isset($client_data['id'])) {
                                                            $clientCreditObtained_rs = Database::search("SELECT * FROM `client_creadit_facility` WHERE `client_id`=?", [$client_data['id']], "s");
                                                            $clientCreditObtained_num = $clientCreditObtained_rs->num_rows;
                                                        }

                                                        ?>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="clientCreditObtainedCheckBox">Credit Facilities
                                                                    Obtained</label>
                                                                <input class="form-check-input" <?php echo isset($client_data['id']) && $clientCreditObtained_num > 0 ? 'checked' : ''; ?>
                                                                    type="checkbox" role="switch" id="clientCreditObtainedCheckBox"
                                                                    onchange="viewStatusChange(this,'clientCreditObtainedDetailsBox');" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 table-responsive <?php echo isset($client_data['id']) && $clientCreditObtained_num > 0 ? '' : 'd-none'; ?>"
                                                            id="clientCreditObtainedDetailsBox">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Institute</th>
                                                                        <th>Amount Obtained(Rs.)</th>
                                                                        <th>Present Outstanding(Rs.)</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="clientCreditObtainedBody">
                                                                    <?php
                                                                    if (isset($client_data['id']) && $clientCreditObtained_num > 0) {
                                                                        for ($i = 0; $i < $clientCreditObtained_num; $i++) {
                                                                            $clientCreditObtained_data = $clientCreditObtained_rs->fetch_assoc();
                                                                            ?>
                                                                            <tr id="clientCreditObtainedRow">
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientCreditObtained_data["institute"]); ?>"
                                                                                        type="text" name="clientCreditObtainedInstitute" />
                                                                                </td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientCreditObtained_data["amount"]); ?>"
                                                                                        type="text" name="clientCreditObtainedAmount"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientCreditObtained_data["present_outstanding"]); ?>"
                                                                                        type="text"
                                                                                        name="clientCreditObtainedPresentOutstanding"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="clientCreditObtainedRow">
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientCreditObtainedInstitute" /> </td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientCreditObtainedAmount"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientCreditObtainedPresentOutstanding"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('clientCreditObtainedBody','clientCreditObtainedRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                        <h3 class="bg-blue">Assets</h3>
                                                        <h3 class="">Details Of Bankers</h3>

                                                        <div class="col-12 table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name of Bank & Branch</th>
                                                                        <th>Account No</th>
                                                                        <th>Type of Account</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="clientBankDeatilsBody">

                                                                    <?php
                                                                    if (isset($client_data['id'])) {
                                                                        $clientBankDeatils_rs = Database::search("SELECT * FROM `client_bank` WHERE `client_id`=?", [$client_data['id']], "s");
                                                                        $clientBankDeatils_num = $clientBankDeatils_rs->num_rows;
                                                                        for ($i = 0; $i < $clientBankDeatils_num; $i++) {
                                                                            $clientBankDeatils_data = $clientBankDeatils_rs->fetch_assoc();
                                                                            ?>
                                                                            <tr id="clientBankDeatilsRow">
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientBankDeatils_data["name"]); ?>"
                                                                                        type="text" name="clientNameOfBankBranch" /> </td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientBankDeatils_data["account_no"]); ?>"
                                                                                        type="text" name="clientBankAccountNo" /></td>
                                                                                <td> <input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientBankDeatils_data["type"]); ?>"
                                                                                        type="text" name="clientBankType" /></td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="clientBankDeatilsRow">
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientNameOfBankBranch" /> </td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientBankAccountNo" /></td>
                                                                            <td> <input class="form-control" type="text"
                                                                                    name="clientBankType" /></td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('clientBankDeatilsBody','clientBankDeatilsRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                        <h3 class="bg-blue">Details of Property</h3>

                                                        <?php
                                                        if (isset($client_data['id'])) {
                                                            $clientPropertyTable_rs = Database::search("SELECT * FROM `client_property` WHERE `client_id`=?", [$client_data['id']], "s");
                                                            $clientPropertyTable_num = $clientPropertyTable_rs->num_rows;
                                                        }
                                                        ?>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="clientPropertyCheckBox">Immovable Property</label>
                                                                <input class="form-check-input" type="checkbox" <?php echo isset($client_data['id']) && $clientPropertyTable_num > 0 ? 'checked' : ''; ?> role="switch" id="clientPropertyCheckBox"
                                                                    onchange="viewStatusChange(this,'clientPropertyDetailsBox');" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3 table-responsive <?php echo isset($client_data['id']) && $clientPropertyTable_num > 0 ? '' : 'd-none'; ?>"
                                                            id="clientPropertyDetailsBox">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Location</th>
                                                                        <th>Extent</th>
                                                                        <th>Approximate Value</th>
                                                                        <th>Mortgaged</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="clientPropertyTableBody">
                                                                    <?php
                                                                    if (isset($client_data['id']) && $clientPropertyTable_num > 0) {
                                                                        for ($i = 0; $i < $clientPropertyTable_num; $i++) {
                                                                            $clientPropertyTable_data = $clientPropertyTable_rs->fetch_assoc();
                                                                            ?>
                                                                            <tr id="clientPropertyTableRow">
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientPropertyTable_data["location"]); ?>"
                                                                                        type="text" name="clientPropertyLocation" /></td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientPropertyTable_data["extent"]); ?>"
                                                                                        type="text" name="clientPropertyExtent" /></td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($clientPropertyTable_data["approximate_value"]); ?>"
                                                                                        type="text" name="clientPropertyValue"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td class="text-center"><input class="form-check-input"
                                                                                        type="checkbox" name="clientPropertyMortgaged" <?php echo htmlspecialchars($clientPropertyTable_data["mortgaged"] == 'true' ? 'checked' : ''); ?> /></td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="clientPropertyTableRow">
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientPropertyLocation" /></td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientPropertyExtent" /></td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientPropertyValue"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td class="text-center"><input class="form-check-input"
                                                                                    type="checkbox" name="clientPropertyMortgaged" />
                                                                            </td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }

                                                                    ?>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('clientPropertyTableBody','clientPropertyTableRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>

                                                            </table>

                                                        </div>

                                                        <h3 class="bg-blue">Morter Vehicles</h3>

                                                        <?php
                                                        if (isset($client_data['id'])) {
                                                            $clientMotorVehicleTable_rs = Database::search("SELECT * FROM `client_vehicle` WHERE `client_id`=?", [$client_data['id']], "s");
                                                            $clientMotorVehicleTable_num = $clientMotorVehicleTable_rs->num_rows;
                                                        }
                                                        ?>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="clientMotorVehicleCheckBox">Moter Vehicles</label>
                                                                <input class="form-check-input" <?php echo isset($client_data['id']) && $clientMotorVehicleTable_num > 0 ? 'checked' : ''; ?>
                                                                    type="checkbox" role="switch" id="clientMotorVehicleCheckBox"
                                                                    onchange="viewStatusChange(this,'clientMotorVehicleDetailsBox');" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3 table-responsive <?php echo isset($client_data['id']) && $clientMotorVehicleTable_num > 0 ? '' : 'd-none'; ?>"
                                                            id="clientMotorVehicleDetailsBox">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Reg.No</th>
                                                                        <th>Make</th>
                                                                        <th>Markert Value</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="clientMotorVehicleTableBody">

                                                                    <?php
                                                                    if (isset($client_data['id']) && $clientMotorVehicleTable_num > 0) {
                                                                        for ($i = 0; $i < $clientMotorVehicleTable_num; $i++) {
                                                                            $clientMotorVehicleTable_data = $clientMotorVehicleTable_rs->fetch_assoc();
                                                                            ?>
                                                                            <tr id="clientMotorVehicleTableRow">
                                                                                <th><input class="form-control" type="text"
                                                                                        name="clientVehicleRegNo"
                                                                                        value="<?php echo htmlspecialchars($clientMotorVehicleTable_data["reg_no"]); ?>" />
                                                                                </th>
                                                                                <th>
                                                                                    <select class="form-select" name="clientVehicleType"
                                                                                        id="">
                                                                                        <option value="">SELECT</option>
                                                                                        <?php
                                                                                        $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                                        $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                                        for ($j = 0; $j < $vehicle_type_num; $j++) {
                                                                                            $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                                            ?>
                                                                                            <option
                                                                                                value="<?php echo $vehicle_type_data["id"]; ?>"
                                                                                                <?php echo htmlspecialchars($vehicle_type_data["id"] == $clientMotorVehicleTable_data["vehicle_type_id"] ? 'selected' : ''); ?>>
                                                                                                <?php echo $vehicle_type_data["name"]; ?>
                                                                                            </option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </select>
                                                                                </th>
                                                                                <td><input class="form-control" type="text"
                                                                                        name="clientVehicleMarketValue"
                                                                                        onkeypress="priceValidateKeyPress(event,this);"
                                                                                        value="<?php echo htmlspecialchars($clientMotorVehicleTable_data["market_value"]); ?>" />
                                                                                </td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="clientMotorVehicleTableRow">
                                                                            <th><input class="form-control" type="text"
                                                                                    name="clientVehicleRegNo" /></th>
                                                                            <th>
                                                                                <select class="form-select" name="clientVehicleType"
                                                                                    id="">
                                                                                    <option value="">SELECT</option>
                                                                                    <?php
                                                                                    $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                                    $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                                    for ($i = 0; $i < $vehicle_type_num; $i++) {
                                                                                        $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                                        ?>
                                                                                        <option
                                                                                            value="<?php echo $vehicle_type_data["id"]; ?>">
                                                                                            <?php echo $vehicle_type_data["name"]; ?>
                                                                                        </option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </th>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="clientVehicleMarketValue"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>


                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('clientMotorVehicleTableBody','clientMotorVehicleTableRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>

                                                            </table>

                                                        </div>

                                                        <h3 class="bg-blue">Item Required</h3>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredtype">Type of Equipment</label>
                                                            <select class="form-select" name="clientItemRequiredtype"
                                                                id="clientItemRequiredtype">
                                                                <option value="">SELECT</option>
                                                                <?php
                                                                $file_type_rs = Database::search("SELECT * FROM `file_type`");
                                                                $file_type_num = $file_type_rs->num_rows;
                                                                for ($i = 0; $i < $file_type_num; $i++) {
                                                                    $file_type_data = $file_type_rs->fetch_assoc();
                                                                    ?>
                                                                    <option value="<?php echo $file_type_data["id"]; ?>" <?php echo htmlspecialchars(isset($client_data["equipment_type_id"]) && $file_type_data["id"] == $client_data["equipment_type_id"] ? 'selected' : ''); ?>><?php echo $file_type_data["name"]; ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredSupplier">Supplier</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($client_data["supplier"]) ? $client_data["supplier"] : ''); ?>"
                                                                type="text" id="clientItemRequiredSupplier" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredModel">Type(Make & Model)</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($client_data["required_item_type"]) ? $client_data["required_item_type"] : ''); ?>"
                                                                type="text" id="clientItemRequiredModel" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredFaclityAmount">Faclity Amount</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($client_data["required_item_facility_amount"]) ? $client_data["required_item_facility_amount"] : ''); ?>"
                                                                type="text" id="clientItemRequiredFaclityAmount"
                                                                onkeypress="priceValidateKeyPress(event,this);" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredColour">Colour</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($client_data["requied_item_color"]) ? $client_data["requied_item_color"] : ''); ?>"
                                                                type="text" id="clientItemRequiredColour" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredLeasePeriod">Lease Period</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($client_data["required_item_lease_period"]) ? $client_data["required_item_lease_period"] : ''); ?>"
                                                                type="text" id="clientItemRequiredLeasePeriod" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="clientItemRequiredPurposeOfUse">Purpose of Use</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($client_data["purpose_of_use"]) ? $client_data["purpose_of_use"] : ''); ?>"
                                                                type="text" id="clientItemRequiredPurposeOfUse" />
                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <label for="clientOtherDetails">Other Details</label>
                                                            <textarea rows="5" class="form-control" name=""
                                                                id="clientOtherDetails"><?php echo htmlspecialchars(isset($client_data["other_details"]) ? $client_data["other_details"] : ''); ?></textarea>
                                                        </div>

                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button class="btn btn-primary"
                                                                onclick="updateClientForm('<?php echo $fileNo; ?>');">Update
                                                                Client</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $guarantor_rs = Database::search("SELECT * FROM `guarantor` WHERE `insurance_file_id`=?", [$fileID], "s");
                                    $guarantor_num = $guarantor_rs->num_rows;
                                    $guarantor_data = $guarantor_rs->fetch_assoc();
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed fw-bold text-white <?php echo isset($guarantor_data) ? 'bg-success' : 'bg-danger'; ?>"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#guarantor-form"
                                                aria-expanded="false" aria-controls="guarantor-form">
                                                Guarantors Application
                                            </button>
                                        </h2>
                                        <div id="guarantor-form" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="col-12 pb-5">
                                                    <div class="row">



                                                        <h1 class="text-center my-3">Guarantors Application</h1>

                                                        <h3 class="bg-blue">Guarantors Statement</h3>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorFullName">Full Name of Guarantor</label>
                                                            <input class="form-control" type="text" id="guarantorFullName"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['full_name']) ? $guarantor_data['full_name'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorNameWithInitial">Name with Initials</label>
                                                            <input class="form-control" type="text" id="guarantorNameWithInitial"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['name_with_initial']) ? $guarantor_data['name_with_initial'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorAddress">Permanent Address</label>
                                                            <input class="form-control" type="text" id="guarantorAddress"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['address']) ? $guarantor_data['address'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorDOB">Date of Birth</label>
                                                            <input class="form-control" type="text" id="guarantorDOB"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['dob']) ? $guarantor_data['dob'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorNIC">NIC No</label>
                                                            <input class="form-control" type="text" id="guarantorNIC"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['nic']) ? $guarantor_data['nic'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorTelNo">Tel No</label>
                                                            <input class="form-control" type="tel" id="guarantorTelNo"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['tel']) ? $guarantor_data['tel'] : ''); ?>"
                                                                onkeypress="mobileValidateKeyPress(event,'guarantorTelNo');"
                                                                maxlength="10" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorMobile">Mobile No</label>
                                                            <input class="form-control" type="tel" id="guarantorMobile"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['mobile']) ? $guarantor_data['mobile'] : ''); ?>"
                                                                onkeypress="mobileValidateKeyPress(event,'guarantorMobile');"
                                                                maxlength="10" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorTitle">Title</label>
                                                            <select class="form-select" name="" id="guarantorTitle">
                                                                <option value="0">SELECT</option>
                                                                <?php
                                                                $user_title_rs = Database::search("SELECT * FROM `user_title`");
                                                                $user_title_num = $user_title_rs->num_rows;
                                                                for ($i = 0; $i < $user_title_num; $i++) {
                                                                    $user_title_data = $user_title_rs->fetch_assoc();
                                                                    ?>
                                                                    <option value="<?php echo $user_title_data["id"]; ?>" <?php echo htmlspecialchars(isset($guarantor_data['user_title_id']) && $guarantor_data['user_title_id'] == $user_title_data["id"]) ? 'selected' : '' ?>><?php echo $user_title_data["name"]; ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorNicFrontPhoto">NIC Photo front</label>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <label class="btn btn-primary w-100"
                                                                        for="guarantorNicFrontPhoto"
                                                                        onclick="selectPhoto('guarantorNicFrontPhoto','guarantorNicFrontPhotoImg');">Choose
                                                                        a Photo</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="guarantorNicFrontPhoto" />
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="<?php echo isset($guarantor_data["nic_font_img_path"]) ? $guarantor_data["nic_font_img_path"] : '#'; ?>"
                                                                        class="col-6 btn btn-outline-primary w-100"
                                                                        id="downloadNicFrontPhotoBtn"
                                                                        download="guarantor_nic_front_photo.jpg"><i
                                                                            class="bi bi-download"></i> Download</a>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-1 col-md-10"
                                                                    src="<?php echo htmlspecialchars(isset($guarantor_data['nic_font_img_path']) ? $guarantor_data['nic_font_img_path'] : 'resources/add-image.png'); ?>"
                                                                    id="guarantorNicFrontPhotoImg" alt="NIC Front Photo" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorNicBackPhoto">NIC Photo back</label>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <label class="btn btn-primary w-100" for="guarantorNicBackPhoto"
                                                                        onclick="selectPhoto('guarantorNicBackPhoto','guarantorNicBackPhotoImg');">Choose
                                                                        a Photo</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="guarantorNicBackPhoto" />
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="<?php echo isset($guarantor_data["nic_back_img_path"]) ? $guarantor_data["nic_back_img_path"] : '#'; ?>"
                                                                        class="col-6 btn btn-outline-primary w-100"
                                                                        id="downloadNicFrontPhotoBtn"
                                                                        download="guarantor_nic_back_photo.jpg"><i
                                                                            class="bi bi-download"></i> Download</a>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-1 col-md-10"
                                                                    src="<?php echo htmlspecialchars(isset($guarantor_data['nic_back_img_path']) ? $guarantor_data['nic_back_img_path'] : 'resources/add-image.png'); ?>"
                                                                    id="guarantorNicBackPhotoImg" alt="NIC Back Photo">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="guarantorMarrageStatusCheckBox">Marage Status</label>
                                                                <input class="form-check-input" type="checkbox" role="switch"
                                                                    id="guarantorMarrageStatusCheckBox"
                                                                    onchange="marrageStatusChange(this,'guarantorMarrageDetailsBox');"
                                                                    <?php echo htmlspecialchars(isset($guarantor_data['spouse_full_name']) && !empty($guarantor_data['spouse_full_name']) ? 'checked' : ''); ?> />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3 border rounded-3 shadow mb-3 <?php echo htmlspecialchars(isset($guarantor_data['spouse_full_name']) && !empty($guarantor_data['spouse_full_name']) ? '' : 'd-none'); ?>"
                                                            id="guarantorMarrageDetailsBox">
                                                            <div class="row">

                                                                <h3 class="bg-blue">Details of Spouse</h3>

                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="guarantorSpouseFullName">Name in Full</label>
                                                                    <input class="form-control" type="text"
                                                                        id="guarantorSpouseFullName"
                                                                        value="<?php echo htmlspecialchars(isset($guarantor_data['spouse_full_name']) ? $guarantor_data['spouse_full_name'] : ''); ?>" />
                                                                </div>
                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="guarantorSpouseNIC">NIC No</label>
                                                                    <input class="form-control" type="text" id="guarantorSpouseNIC"
                                                                        value="<?php echo htmlspecialchars(isset($guarantor_data['spouse_nic']) ? $guarantor_data['spouse_nic'] : ''); ?>" />
                                                                </div>
                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="guarantorSpouseTel">Tel No</label>
                                                                    <input class="form-control" type="tel" id="guarantorSpouseTel"
                                                                        value="<?php echo htmlspecialchars(isset($guarantor_data['spouse_tel']) ? $guarantor_data['spouse_tel'] : ''); ?>"
                                                                        onkeypress="mobileValidateKeyPress(event,'guarantorSpouseTel');"
                                                                        maxlength="10" />
                                                                </div>
                                                                <div class="col-12 col-md-6 p-3">
                                                                    <label for="guarantorSpouseProfession">Profession</label>
                                                                    <input class="form-control" type="text"
                                                                        id="guarantorSpouseProfession"
                                                                        value="<?php echo htmlspecialchars(isset($guarantor_data['spouse_profession']) ? $guarantor_data['spouse_profession'] : ''); ?>" />
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <h3 class="bg-blue">Details of Employment</h3>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorEmpName">Name of Employer/Business</label>
                                                            <input class="form-control" type="text" id="guarantorEmpName"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['business_name']) ? $guarantor_data['business_name'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorEmpAddress">Address of Employer/Business</label>
                                                            <input class="form-control" type="text" id="guarantorEmpAddress"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['business_address']) ? $guarantor_data['business_address'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorBusinessRegNo">Business Registration No</label>
                                                            <input class="form-control" type="tel" id="guarantorBusinessRegNo"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['business_reg_no']) ? $guarantor_data['business_reg_no'] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="guarantorBusinessNature">Nature of Business</label>
                                                            <input class="form-control" type="text" id="guarantorBusinessNature"
                                                                value="<?php echo htmlspecialchars(isset($guarantor_data['business_nature']) ? $guarantor_data['business_nature'] : ''); ?>" />
                                                        </div>

                                                        <h3 class="bg-blue">Details of Personal Income</h3>
                                                        <div class="col-12 p-3 table-responsive">
                                                            <!-- <div class="row"> -->
                                                            <table class="table">
                                                                <tr>
                                                                    <th colspan="2">Statement of Income (Monthly)</th>
                                                                    <th>Income (Net)(Rs.)</th>
                                                                </tr>
                                                                <tr>
                                                                    <th rowspan="3">Source of Income</th>
                                                                    <th>Employment</th>
                                                                    <td><input class="form-control" type="text"
                                                                            id="guarantorIncomeEmp"
                                                                            value="<?php echo htmlspecialchars(isset($guarantor_data['employment_income']) ? $guarantor_data['employment_income'] : ''); ?>"
                                                                            min="0" onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <th>Business</th>
                                                                    <td><input class="form-control" type="text" id="guarantorIncomeBusiness" value="<?php echo htmlspecialchars(isset($guarantor_data['business_income']) ? $guarantor_data['business_income'] : ''); ?>" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                                </tr> -->
                                                                <tr>
                                                                    <th>Other</th>
                                                                    <td><input class="form-control" type="text"
                                                                            id="guarantorIncomeOther"
                                                                            value="<?php echo htmlspecialchars(isset($guarantor_data['other_income']) ? $guarantor_data['other_income'] : ''); ?>"
                                                                            min="0" onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                                </tr>
                                                                <?php
                                                                $guarantorTotalIncomeCal = 0.00;
                                                                $guarantorNetIncomeCal = 0.00;
                                                                if (isset($guarantor_data['employment_income'])) {
                                                                    $guarantorTotalIncomeCal = $guarantor_data['employment_income'] + $guarantor_data['other_income'];
                                                                    $guarantorNetIncomeCal = $guarantorTotalIncomeCal - $guarantor_data['living_cost'] - $guarantor_data['loan_repayment'];
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <th>Total Income</th>
                                                                    <th id="guarantorTotalIncome">
                                                                        <?php echo $guarantorTotalIncomeCal; ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th rowspan="3">Less</th>
                                                                    <th>Cost of Living</th>
                                                                    <td><input class="form-control" type="text"
                                                                            id="guarantorCostLiving"
                                                                            value="<?php echo htmlspecialchars(isset($guarantor_data['living_cost']) ? $guarantor_data['living_cost'] : ''); ?>"
                                                                            min="0" onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Loan repayment</th>
                                                                    <td><input class="form-control" type="text"
                                                                            id="guarantorLoanRepayment"
                                                                            value="<?php echo htmlspecialchars(isset($guarantor_data['loan_repayment']) ? $guarantor_data['loan_repayment'] : ''); ?>"
                                                                            min="0" onkeypress="priceValidateKeyPress(event,this);"
                                                                            onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Net Income</th>
                                                                    <th id="guarantorNetIncome">
                                                                        <?php echo $guarantorNetIncomeCal; ?></th>
                                                                </tr>
                                                            </table>

                                                        </div>

                                                        <h3 class="bg-blue">Credit Facilities Obtained</h3>

                                                        <?php
                                                        if (isset($guarantor_data['id'])) {
                                                            $guarantorCreditObtained_rs = Database::search("SELECT * FROM `guarantor_creadit_facility` WHERE `guarantor_id`=?", [$guarantor_data['id']], "s");
                                                            $guarantorCreditObtained_num = $guarantorCreditObtained_rs->num_rows;
                                                        }
                                                        ?>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="guarantorCreditObtainedCheckBox">Credit Facilities
                                                                    Obtained</label>
                                                                <input class="form-check-input" <?php echo isset($guarantor_data['id']) && $guarantorCreditObtained_num > 0 ? 'checked' : ''; ?> type="checkbox" role="switch"
                                                                    id="guarantorCreditObtainedCheckBox"
                                                                    onchange="viewStatusChange(this,'guarantorCreditObtainedDetailsBox');" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 table-responsive <?php echo isset($guarantor_data['id']) && $guarantorCreditObtained_num > 0 ? '' : 'd-none'; ?>"
                                                            id="guarantorCreditObtainedDetailsBox">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Institute</th>
                                                                        <th>Amount Obtained(Rs.)</th>
                                                                        <th>Present Outstanding(Rs.)</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="guarantorCreditObtainedBody">
                                                                    <?php
                                                                    if (isset($guarantor_data['id']) && $guarantorCreditObtained_num > 0) {
                                                                        for ($i = 0; $i < $guarantorCreditObtained_num; $i++) {
                                                                            if (isset($guarantor_data['id'])) {
                                                                                $guarantorCreditObtained_data = $guarantorCreditObtained_rs->fetch_assoc();
                                                                            }
                                                                            ?>
                                                                            <tr id="guarantorCreditObtainedRow">
                                                                                <td><input class="form-control" type="text"
                                                                                        value="<?php echo htmlspecialchars(isset($guarantorCreditObtained_data['institute']) ? $guarantorCreditObtained_data['institute'] : ''); ?>"
                                                                                        name="guarantorCreditObtainedInstitute" /> </td>
                                                                                <td><input class="form-control" type="text"
                                                                                        value="<?php echo htmlspecialchars(isset($guarantorCreditObtained_data['amount']) ? $guarantorCreditObtained_data['amount'] : ''); ?>"
                                                                                        name="guarantorCreditObtainedAmount"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td><input class="form-control" type="text"
                                                                                        value="<?php echo htmlspecialchars(isset($guarantorCreditObtained_data['present_outstanding']) ? $guarantorCreditObtained_data['present_outstanding'] : ''); ?>"
                                                                                        name="guarantorCreditObtainedPresentOutstanding"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="guarantorCreditObtainedRow">
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorCreditObtainedInstitute" /> </td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorCreditObtainedAmount"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorCreditObtainedPresentOutstanding"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('guarantorCreditObtainedBody','guarantorCreditObtainedRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                        <h3 class="bg-blue">Assets</h3>
                                                        <h3 class="">Details Of Bankers</h3>

                                                        <div class="col-12 table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name of Bank & Branch</th>
                                                                        <th>Account No</th>
                                                                        <th>Type of Account</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="guarantorBankDeatilsBody">
                                                                    <?php
                                                                    $guarantorBankDeatils_num = 1;
                                                                    if (isset($guarantor_data['id'])) {
                                                                        $guarantorBankDeatils_rs = Database::search("SELECT * FROM `guarantor_bank` WHERE `guarantor_id`=?", [$guarantor_data['id']], "s");
                                                                        $guarantorBankDeatils_num = $guarantorBankDeatils_rs->num_rows;

                                                                        for ($i = 0; $i < $guarantorBankDeatils_num; $i++) {
                                                                            $guarantorBankDeatils_data = $guarantorBankDeatils_rs->fetch_assoc();
                                                                            ?>

                                                                            <tr id="guarantorBankDeatilsRow">
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($guarantorBankDeatils_data["name"]); ?>"
                                                                                        type="text" name="guarantorNameOfBankBranch" />
                                                                                </td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($guarantorBankDeatils_data["account_no"]); ?>"
                                                                                        type="text" name="guarantorBankAccountNo" /></td>
                                                                                <td> <input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($guarantorBankDeatils_data["type"]); ?>"
                                                                                        type="text" name="guarantorBankType" /></td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>

                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="guarantorBankDeatilsRow">
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorNameOfBankBranch" /> </td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorBankAccountNo" /></td>
                                                                            <td> <input class="form-control" type="text"
                                                                                    name="guarantorBankType" /></td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }

                                                                    ?>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('guarantorBankDeatilsBody','guarantorBankDeatilsRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>

                                                        <h3 class="bg-blue">Details of Property</h3>

                                                        <?php
                                                        if (isset($guarantor_data['id'])) {
                                                            $guarantorPropertyTable_rs = Database::search("SELECT * FROM `guarantor_property` WHERE `guarantor_id`=?", [$guarantor_data['id']], "s");
                                                            $guarantorPropertyTable_num = $guarantorPropertyTable_rs->num_rows;
                                                        }

                                                        ?>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="guarantorPropertyCheckBox">Details of Property</label>
                                                                <input class="form-check-input" <?php echo isset($guarantor_data['id']) && $guarantorPropertyTable_num > 0 ? 'checked' : ''; ?> type="checkbox" role="switch"
                                                                    id="guarantorPropertyCheckBox"
                                                                    onchange="viewStatusChange(this,'guarantorPropertyDetailsBox');" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3 table-responsive <?php echo isset($guarantor_data['id']) && $guarantorPropertyTable_num > 0 ? '' : 'd-none'; ?>"
                                                            id="guarantorPropertyDetailsBox">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="5">Immovable</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Location</th>
                                                                        <th>Extent</th>
                                                                        <th>Approximate Value</th>
                                                                        <th>Mortgaged</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="guarantorPropertyTableBody">
                                                                    <?php
                                                                    if (isset($guarantor_data['id']) && $guarantorPropertyTable_num > 0) {
                                                                        for ($i = 0; $i < $guarantorPropertyTable_num; $i++) {
                                                                            $guarantorPropertyTable_data = $guarantorPropertyTable_rs->fetch_assoc();
                                                                            ?>
                                                                            <tr id="guarantorPropertyTableRow">
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($guarantorPropertyTable_data["location"]); ?>"
                                                                                        type="text" name="guarantorPropertyLocation" /></td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($guarantorPropertyTable_data["extent"]); ?>"
                                                                                        type="text" name="guarantorPropertyExtent" /></td>
                                                                                <td><input class="form-control"
                                                                                        value="<?php echo htmlspecialchars($guarantorPropertyTable_data["approximate_value"]); ?>"
                                                                                        type="text" name="guarantorPropertyValue"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td class="text-center"><input class="form-check-input"
                                                                                        type="checkbox" name="guarantorPropertyMortgaged"
                                                                                        <?php echo htmlspecialchars($guarantorPropertyTable_data["mortgaged"] == "true" ? 'checked' : '') ?> /></td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="guarantorPropertyTableRow">
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorPropertyLocation" /></td>
                                                                            <td><input class="form-control" type="number"
                                                                                    name="guarantorPropertyExtent" /></td>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorPropertyValue"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td class="text-center"><input class="form-check-input"
                                                                                    type="checkbox" name="guarantorPropertyMortgaged" />
                                                                            </td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('guarantorPropertyTableBody','guarantorPropertyTableRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>

                                                            </table>

                                                        </div>


                                                        <h3 class="bg-blue">Morter Vehicles</h3>

                                                        <?php

                                                        if (isset($guarantor_data['id'])) {
                                                            $guarantorMotorVehicleTable_rs = Database::search("SELECT * FROM `guarantor_vehicle` WHERE `guarantor_id`=?", [$guarantor_data['id']], "s");
                                                            $guarantorMotorVehicleTable_num = $guarantorMotorVehicleTable_rs->num_rows;
                                                        }
                                                        ?>

                                                        <div class="col-12 p-3">
                                                            <div class="form-check form-switch">
                                                                <label class="form-check-label"
                                                                    for="guarantorMotorVehicleCheckBox">Morter Vehicles</label>
                                                                <input class="form-check-input" <?php echo isset($guarantor_data['id']) && $guarantorMotorVehicleTable_num > 0 ? 'checked' : ''; ?> type="checkbox" role="switch"
                                                                    id="guarantorMotorVehicleCheckBox"
                                                                    onchange="viewStatusChange(this,'guarantorMotorVehicleDetailsBox');" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3 table-responsive <?php echo isset($guarantor_data['id']) && $guarantorMotorVehicleTable_num > 0 ? '' : 'd-none'; ?>"
                                                            id="guarantorMotorVehicleDetailsBox">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Reg.No</th>
                                                                        <th>Make</th>
                                                                        <th>Markert Value</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="guarantorMotorVehicleTableBody">

                                                                    <?php
                                                                    if (isset($guarantor_data['id']) && $guarantorMotorVehicleTable_num > 0) {
                                                                        for ($i = 0; $i < $guarantorMotorVehicleTable_num; $i++) {
                                                                            $guarantorMotorVehicleTable_data = $guarantorMotorVehicleTable_rs->fetch_assoc();
                                                                            ?>
                                                                            <tr id="guarantorMotorVehicleTableRow">
                                                                                <th><input class="form-control" type="text"
                                                                                        value="<?php echo htmlspecialchars($guarantorMotorVehicleTable_data["reg_no"]); ?>"
                                                                                        name="guarantorVehicleRegNo" /></th>
                                                                                <th>
                                                                                    <select class="form-select" name="guarantorVehicleType"
                                                                                        id="">
                                                                                        <option value="">SELECT</option>
                                                                                        <?php
                                                                                        $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                                        $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                                        for ($j = 0; $j < $vehicle_type_num; $j++) {
                                                                                            $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                                            ?>
                                                                                            <option
                                                                                                value="<?php echo $vehicle_type_data["id"]; ?>"
                                                                                                <?php echo htmlspecialchars($guarantorMotorVehicleTable_data['vehicle_type_id'] == $vehicle_type_data["id"] ? 'selected' : ''); ?>>
                                                                                                <?php echo $vehicle_type_data["name"]; ?>
                                                                                            </option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </select>
                                                                                </th>
                                                                                <td><input class="form-control" type="text"
                                                                                        value="<?php echo htmlspecialchars($guarantorMotorVehicleTable_data["market_value"]); ?>"
                                                                                        name="guarantorVehicleMarketValue"
                                                                                        onkeypress="priceValidateKeyPress(event,this);" />
                                                                                </td>
                                                                                <td><button class="btn btn-danger d-none"
                                                                                        onclick="removeRow(this);"><i
                                                                                            class="bi bi-trash"></i></button></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr id="guarantorMotorVehicleTableRow">
                                                                            <th><input class="form-control" type="text"
                                                                                    name="guarantorVehicleRegNo" /></th>
                                                                            <th>
                                                                                <select class="form-select" name="guarantorVehicleType"
                                                                                    id="">
                                                                                    <option value="">SELECT</option>
                                                                                    <?php
                                                                                    $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                                    $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                                    for ($i = 0; $i < $vehicle_type_num; $i++) {
                                                                                        $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                                        ?>
                                                                                        <option
                                                                                            value="<?php echo $vehicle_type_data["id"]; ?>">
                                                                                            <?php echo $vehicle_type_data["name"]; ?>
                                                                                        </option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </th>
                                                                            <td><input class="form-control" type="text"
                                                                                    name="guarantorVehicleMarketValue"
                                                                                    onkeypress="priceValidateKeyPress(event,this);" />
                                                                            </td>
                                                                            <td><button class="btn btn-danger d-none"
                                                                                    onclick="removeRow(this);"><i
                                                                                        class="bi bi-trash"></i></button></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td>
                                                                            <button class="btn btn-primary"
                                                                                onclick="addMoreTrBtn('guarantorMotorVehicleTableBody','guarantorMotorVehicleTableRow');">Add
                                                                                more</button>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>

                                                            </table>

                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <label for="guarantorOtherDetails">Other Details</label>
                                                            <textarea rows="5" class="form-control" name=""
                                                                id="guarantorOtherDetails"><?php echo htmlspecialchars(isset($guarantor_data["other_details"]) ? $guarantor_data["other_details"] : ''); ?></textarea>
                                                        </div>

                                                        <div class="col-12 d-flex justify-content-end">

                                                            <button class="btn btn-primary"
                                                                onclick="updateGuarantorForm('<?php echo $fileNo; ?>');">Update
                                                                Guarantor</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $vehicle_rs = Database::search("SELECT * FROM `vehicle` WHERE `insurance_file_id`=?", [$fileID], "s");
                                    $vehicle_num = $vehicle_rs->num_rows;
                                    $vehicle_data = $vehicle_rs->fetch_assoc();
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed fw-bold text-white <?php echo isset($vehicle_data) ? 'bg-success' : 'bg-danger'; ?>"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#vehicle-form"
                                                aria-expanded="false" aria-controls="vehicle-form">
                                                Vehicle Form
                                            </button>
                                        </h2>
                                        <div id="vehicle-form" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="col-12 pb-5">
                                                    <div class="row">



                                                        <h1 class="text-center my-3">Vehicle Form</h1>
                                                        <h3 class="bg-blue">Mortor Vehicle Inspection Report</h3>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleType">Make</label>
                                                            <select class="form-select" name="" id="vehicleType"
                                                                onchange="showVehicleTypeTyres();">
                                                                <option value="0">SELECT</option>
                                                                <?php
                                                                $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                for ($i = 0; $i < $vehicle_type_num; $i++) {
                                                                    $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                    ?>
                                                                    <option value="<?php echo $vehicle_type_data["id"]; ?>" <?php echo (isset($vehicle_data["vehicle_type_id"]) && $vehicle_type_data["id"] == $vehicle_data["vehicle_type_id"]) ? "selected" : ""; ?>><?php echo $vehicle_type_data["name"]; ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleProposer">Proposer/Insured</label>
                                                            <input class="form-control" type="text"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["proposer"]) ? $vehicle_data["proposer"] : ''); ?>"
                                                                id="vehicleProposer" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleRegNo">Registration No</label>
                                                            <input class="form-control" type="text" id="vehicleRegNo"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["reg_no"]) ? $vehicle_data["reg_no"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleEngineNo">Engine No</label>
                                                            <input class="form-control" type="text" id="vehicleEngineNo"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["engine_no"]) ? $vehicle_data["engine_no"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleChassisNo">Chassis/Frame No</label>
                                                            <input class="form-control" type="text" id="vehicleChassisNo"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["chassis_no"]) ? $vehicle_data["chassis_no"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleDateOfInspection">Date of Inspection</label>
                                                            <input class="form-control" type="date" id="vehicleDateOfInspection"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["dateOfInspection"]) ? $vehicle_data["dateOfInspection"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleMeterReading">Meter Reading</label>
                                                            <input class="form-control" type="text" id="vehicleMeterReading"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["meter_reading"]) ? $vehicle_data["meter_reading"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleModel">Model</label>
                                                            <input class="form-control" type="text" id="vehicleModel"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["model"]) ? $vehicle_data["model"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vahicleValuerName">Valuer's Name</label>
                                                            <input class="form-control" type="text" id="vahicleValuerName"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["valuers_name"]) ? $vehicle_data["valuers_name"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleEstimateValue">Estimated Value</label>
                                                            <input class="form-control" type="text" id="vehicleEstimateValue"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["enstimate_value"]) ? $vehicle_data["enstimate_value"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleManufactureYear">Year of Manufacture</label>
                                                            <input class="form-control" type="number" id="vehicleManufactureYear"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["manufacture_year"]) ? $vehicle_data["manufacture_year"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleInspectedAt">Inspected at</label>
                                                            <input class="form-control" type="text" id="vehicleInspectedAt"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["inspect_at"]) ? $vehicle_data["inspect_at"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleInsuranceRenewDate">Insurance Renew Date</label>
                                                            <input class="form-control" type="date" id="vehicleInsuranceRenewDate"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["insurance_renew_date"]) ? $vehicle_data["insurance_renew_date"] : ''); ?>" />
                                                        </div>
                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicLelicenseRenewDate">License Renew Date</label>
                                                            <input class="form-control" type="date" id="vehicLelicenseRenewDate"
                                                                value="<?php echo htmlspecialchars(isset($vehicle_data["license_renew_date"]) ? $vehicle_data["license_renew_date"] : ''); ?>" />
                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <label for="vehicleRBook">Vehicle Book Image</label>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <label class="btn btn-primary w-100" for="vehicleRBook"
                                                                        onclick="selectPhoto('vehicleRBook','vehicleRBookImg');">Choose
                                                                        a Photo</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="vehicleRBook" />
                                                                </div>
                                                                <?php
                                                                if (isset($vehicle_data["vehicle_rb_img_path"])) {
                                                                    ?>
                                                                    <div class="col-6">
                                                                        <a href="<?php echo isset($vehicle_data["vehicle_rb_img_path"]) ? $vehicle_data["vehicle_rb_img_path"] : '#'; ?>"
                                                                            class="col-6 btn btn-outline-primary w-100"
                                                                            id="downloadNicFrontPhotoBtn" download="vehicle_book.jpg"><i
                                                                                class="bi bi-download"></i> Download</a>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>


                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-3 col-md-6"
                                                                    src="<?php echo htmlspecialchars(isset($vehicle_data["vehicle_rb_img_path"]) ? $vehicle_data["vehicle_rb_img_path"] : 'resources/add-image.png'); ?>"
                                                                    id="vehicleRBookImg" alt="NIC Front Photo" />
                                                            </div>
                                                        </div>

                                                        <h3 class="bg-blue">Vehicle Images</h3>

                                                        <div class="col-6 p-3">
                                                            <label for="vehicleFrontImg">Vehicle Front Image</label>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label class="btn btn-primary" for="vehicleFrontImg"
                                                                        onclick="selectPhoto('vehicleFrontImg','vehicleFrontImgImg');">Choose
                                                                        Front Image</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="vehicleFrontImg" />
                                                                    <?php
                                                                    if (isset($vehicle_data["vehicle_front_img_path"])) {
                                                                        ?>
                                                                        <a href="<?php echo isset($vehicle_data["vehicle_front_img_path"]) ? $vehicle_data["vehicle_front_img_path"] : '#'; ?>"
                                                                            class="btn btn-outline-primary"
                                                                            id="downloadNicFrontPhotoBtn"
                                                                            download="vehicle_front_img.jpg"><i
                                                                                class="bi bi-download"></i></a>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-3 col-md-6"
                                                                    src="<?php echo htmlspecialchars(isset($vehicle_data["vehicle_front_img_path"]) ? $vehicle_data["vehicle_front_img_path"] : 'resources/add-image.png'); ?>"
                                                                    id="vehicleFrontImgImg" alt="Front Photo" />
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-3">
                                                            <label for="vehicleBackImg">Vehicle Back Image</label>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label class="btn btn-primary" for="vehicleBackImg"
                                                                        onclick="selectPhoto('vehicleBackImg','vehicleBackImgImg');">Choose
                                                                        Back Image</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="vehicleBackImg" />
                                                                    <?php
                                                                    if (isset($vehicle_data["vehicle_back_img_path"])) {
                                                                        ?>
                                                                        <a href="<?php echo isset($vehicle_data["vehicle_back_img_path"]) ? $vehicle_data["vehicle_back_img_path"] : '#'; ?>"
                                                                            class="btn btn-outline-primary"
                                                                            id="downloadNicFrontPhotoBtn"
                                                                            download="vehicle_back_img.jpg"><i
                                                                                class="bi bi-download"></i></a>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-3 col-md-6"
                                                                    src="<?php echo htmlspecialchars(isset($vehicle_data["vehicle_back_img_path"]) ? $vehicle_data["vehicle_back_img_path"] : 'resources/add-image.png'); ?>"
                                                                    id="vehicleBackImgImg" alt="Back Photo" />
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-3">
                                                            <label for="vehicleEngineNoImg">Vehicle Engine No Image</label>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label class="btn btn-primary" for="vehicleEngineNoImg"
                                                                        onclick="selectPhoto('vehicleEngineNoImg','vehicleEngineNoImgImg');">Choose
                                                                        Engine No Image</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="vehicleEngineNoImg" />
                                                                    <?php
                                                                    if (isset($vehicle_data["vehicle_engine_img_path"])) {
                                                                        ?>
                                                                        <a href="<?php echo isset($vehicle_data["vehicle_engine_img_path"]) ? $vehicle_data["vehicle_engine_img_path"] : '#'; ?>"
                                                                            class="btn btn-outline-primary"
                                                                            id="downloadNicFrontPhotoBtn"
                                                                            download="vehicle_engine_img.jpg"><i
                                                                                class="bi bi-download"></i></a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-3 col-md-6"
                                                                    src="<?php echo htmlspecialchars(isset($vehicle_data["vehicle_engine_img_path"]) ? $vehicle_data["vehicle_engine_img_path"] : 'resources/add-image.png'); ?>"
                                                                    id="vehicleEngineNoImgImg" alt="Back Photo" />
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-3">
                                                            <label for="vehicleChassisNoImg">Vehicle Chassis No Image</label>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <label class="btn btn-primary" for="vehicleChassisNoImg"
                                                                        onclick="selectPhoto('vehicleChassisNoImg','vehicleChassisNoImgImg');">Choose
                                                                        Chassis No Image</label>
                                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                                        id="vehicleChassisNoImg" />
                                                                    <?php
                                                                    if (isset($vehicle_data["vehicle_chassis_img_path"])) {
                                                                        ?>
                                                                        <a href="<?php echo isset($vehicle_data["vehicle_chassis_img_path"]) ? $vehicle_data["vehicle_chassis_img_path"] : '#'; ?>"
                                                                            class="btn btn-outline-primary"
                                                                            id="downloadNicFrontPhotoBtn"
                                                                            download="vehicle_chassis_img.jpg"><i
                                                                                class="bi bi-download"></i></a>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <img class="col-12 offset-md-3 col-md-6"
                                                                    src="<?php echo htmlspecialchars(isset($vehicle_data["vehicle_chassis_img_path"]) ? $vehicle_data["vehicle_chassis_img_path"] : 'resources/add-image.png'); ?>"
                                                                    id="vehicleChassisNoImgImg" alt="Back Photo" />
                                                            </div>
                                                        </div>

                                                        <h3 class="bg-blue">Factory Fitted Accessories (Please check if they are
                                                            working)</h3>

                                                        <div class="col-12">

                                                            <?php
                                                            $factory_fitted_accessory_rs = Database::search("SELECT * FROM `factory_fitted_accessory`");
                                                            $factory_fitted_accessory_num = $factory_fitted_accessory_rs->num_rows;
                                                            for ($i = 0; $i < $factory_fitted_accessory_num; $i++) {
                                                                $factory_fitted_accessory_data = $factory_fitted_accessory_rs->fetch_assoc();

                                                                if (isset($vehicle_data["id"])) {
                                                                    $vahicleFactoryFittedAccessory_rs = Database::search("SELECT * FROM `vehicle_has_factory_fitted_accessory` WHERE `vehicle_id`=? AND `factory_fitted_accessory_id`=?", [$vehicle_data['id'], $factory_fitted_accessory_data["id"]], "ss");
                                                                    $vahicleFactoryFittedAccessory_data = $vahicleFactoryFittedAccessory_rs->fetch_assoc();
                                                                }

                                                                ?>
                                                                <div class="form-check me-5 mb-3 d-inline-flex">
                                                                    <input class="form-check-input me-2" type="checkbox" <?php echo htmlspecialchars(isset($vahicleFactoryFittedAccessory_data["id"]) ? 'checked' : ''); ?>
                                                                        value="<?php echo $factory_fitted_accessory_data["id"]; ?>"
                                                                        id="factoryFittedAccessory<?php echo $factory_fitted_accessory_data["id"]; ?>"
                                                                        name="factoryFittedAccessories" />
                                                                    <label class="form-check-label"
                                                                        for="factoryFittedAccessory<?php echo $factory_fitted_accessory_data["id"]; ?>">
                                                                        <?php echo $factory_fitted_accessory_data["name"]; ?>
                                                                    </label>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>

                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="vehicleOtherfactoryFittedAccessory">Other
                                                                    Accessories</label>
                                                                <input class="form-control" type="text"
                                                                    id="vehicleOtherfactoryFittedAccessory"
                                                                    value="<?php echo htmlspecialchars(isset($vehicle_data["other_accessories"]) ? $vehicle_data["other_accessories"] : ''); ?>" />
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="vehicleDuplicateKey">
                                                                    Duplicate Key
                                                                </label>
                                                                <input class="form-check-input me-2" type="checkbox" value="0"
                                                                    id="vehicleDuplicateKey" <?php echo htmlspecialchars(isset($vehicle_data["duplicate_key"]) && $vehicle_data["duplicate_key"] == 'true' ? 'checked' : ''); ?> />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="address">Type of Body</label>
                                                            <select class="form-select" name="" id="vehicleBodyType">
                                                                <option value="0">SELECT</option>
                                                                <?php
                                                                $vehicleBodyType_rs = Database::search("SELECT * FROM `vehicle_body_type`");
                                                                $vehicleBodyType_num = $vehicleBodyType_rs->num_rows;
                                                                for ($i = 0; $i < $vehicleBodyType_num; $i++) {
                                                                    $vehicleBodyType_data = $vehicleBodyType_rs->fetch_assoc();
                                                                    ?>
                                                                    <option value="<?php echo $vehicleBodyType_data['id']; ?>" <?php echo (isset($vehicle_data["vehicle_body_type_id"]) && $vehicleBodyType_data["id"] == $vehicle_data["vehicle_body_type_id"]) ? "selected" : ""; ?>>
                                                                        <?php echo $vehicleBodyType_data['name']; ?></option>

                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>


                                                        <div class="col-12 p-3 table-responsive">
                                                            <table class="table">
                                                                <tr>
                                                                    <th colspan="2">General Apperance of vehicle</th>
                                                                    <td>
                                                                        <div class="col-12 d-flex justify-content-between">
                                                                            <?php
                                                                            $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                            $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                            for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                                $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                                ?>
                                                                                <div class="form-check d-flex">
                                                                                    <input class="form-check-input me-2" <?php echo (isset($vehicle_data["generalApperanceStatus"]) && $vehicle_accessory_status_data["id"] == $vehicle_data["generalApperanceStatus"]) ? "checked" : ""; ?> type="radio"
                                                                                        name="vehicleGeneralApperanceStatus"
                                                                                        id="vehicleGeneralApperanceStatus<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="vehicleGeneralApperanceStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                        <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                    </label>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Pain Work </th>
                                                                    <td>
                                                                        <input class="form-control" placeholder="colour:"
                                                                            type="text" id="vehiclePainWorkColor"
                                                                            value="<?php echo htmlspecialchars(isset($vehicle_data["painWorkColor"]) ? $vehicle_data["painWorkColor"] : ''); ?>" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="col-12 d-flex justify-content-between">
                                                                            <?php
                                                                            $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                            $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                            for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                                $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                                ?>
                                                                                <div class="form-check d-flex">
                                                                                    <input class="form-check-input me-2" type="radio"
                                                                                        name="vehiclePainWorkStatus"
                                                                                        id="vehiclePainWorkStatus<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        value="<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        <?php echo (isset($vehicle_data["painWorkStatus"]) && $vehicle_accessory_status_data["id"] == $vehicle_data["painWorkStatus"]) ? "checked" : ""; ?>>
                                                                                    <label class="form-check-label"
                                                                                        for="vehiclePainWorkStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                        <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                    </label>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Upholstery</th>
                                                                    <td>
                                                                        <input class="form-control" placeholder="colour:"
                                                                            type="text" id="vehicleUpholsteryColor"
                                                                            value="<?php echo htmlspecialchars(isset($vehicle_data["upholsteryColor"]) ? $vehicle_data["upholsteryColor"] : ''); ?>" />
                                                                    </td>
                                                                    <td>
                                                                        <div class="col-12 d-flex justify-content-between">
                                                                            <?php
                                                                            $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                            $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                            for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                                $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                                ?>
                                                                                <div class="form-check d-flex">
                                                                                    <input class="form-check-input me-2" type="radio"
                                                                                        name="vehicleUpholsteryStatus"
                                                                                        id="vehicleUpholsteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        value="<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        <?php echo (isset($vehicle_data["upholsteryStatus"]) && $vehicle_accessory_status_data["id"] == $vehicle_data["upholsteryStatus"]) ? "checked" : ""; ?>>
                                                                                    <label class="form-check-label"
                                                                                        for="vehicleUpholsteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                        <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                    </label>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">Battery</th>
                                                                    <td>
                                                                        <div class="col-12 d-flex justify-content-between">
                                                                            <?php
                                                                            $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                            $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                            for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                                $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                                ?>
                                                                                <div class="form-check d-flex">
                                                                                    <input class="form-check-input me-2" type="radio"
                                                                                        name="vehicleBatteryStatus"
                                                                                        id="vehicleBatteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        value="<?php echo $vehicle_accessory_status_data["id"]; ?>"
                                                                                        <?php echo (isset($vehicle_data["batteryStatus"]) && $vehicle_accessory_status_data["id"] == $vehicle_data["batteryStatus"]) ? "checked" : ""; ?>>
                                                                                    <label class="form-check-label"
                                                                                        for="vehicleBatteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                        <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                    </label>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tfoot id="vehicleTypeTyresBox">

                                                                    <?php
                                                                    if (isset($vehicle_data['id'])) {
                                                                        $vehicleTyreStatus_rs = Database::search("SELECT * FROM `vehicle_tyre_status` INNER JOIN `vehicle_tyre` ON `vehicle_tyre_status`.`vehicle_tyre_id`=`vehicle_tyre`.`id` WHERE `vehicle_tyre_status`.`vehicle_id`=?", [$vehicle_data['id']], "s");
                                                                        $vehicleTyreStatus_num = $vehicleTyreStatus_rs->num_rows;
                                                                        for ($i = 0; $i < $vehicleTyreStatus_num; $i++) {
                                                                            $vehicleTyreStatus_data = $vehicleTyreStatus_rs->fetch_assoc();

                                                                            ?>
                                                                            <tr>
                                                                                <th colspan="2">
                                                                                    <?php echo $vehicleTyreStatus_data["name"]; ?> <input
                                                                                        class="d-none" name="vehicleTyreId" type="text"
                                                                                        value="<?php echo $vehicleTyreStatus_data["vehicle_tyre_id"] ?>" />
                                                                                </th>
                                                                                <td>
                                                                                    <div class="col-12 d-flex justify-content-between">
                                                                                        <?php
                                                                                        $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                                        $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                                        for ($j = 0; $j < $vehicle_accessory_status_num; $j++) {
                                                                                            $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                                            ?>
                                                                                            <div class="form-check d-flex">
                                                                                                <input class="form-check-input me-2" <?php echo (isset($vehicleTyreStatus_data["vehicle_accessory_status_id"]) && $vehicle_accessory_status_data["id"] == $vehicleTyreStatus_data["vehicle_accessory_status_id"]) ? "checked" : ""; ?> type="radio"
                                                                                                    name="<?php echo $vehicleTyreStatus_data["vehicle_tyre_id"] ?>"
                                                                                                    id="vehicleTyreStatus<?php echo $vehicleTyreStatus_data["vehicle_tyre_id"] . $vehicle_accessory_status_data["id"]; ?>"
                                                                                                    value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                                <label class="form-check-label"
                                                                                                    for="vehicleTyreStatus<?php echo $vehicleTyreStatus_data["vehicle_tyre_id"] . $vehicle_accessory_status_data["id"]; ?>">
                                                                                                    <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                                </label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php

                                                                        }
                                                                    }

                                                                    ?>

                                                                </tfoot>

                                                            </table>

                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <label for="vehicleOtherAccessiries">Other Details</label>
                                                            <textarea class="form-control" rows="5" name=""
                                                                id="vehicleOtherAccessiries"><?php echo htmlspecialchars(isset($vehicle_data['other_details']) ? $vehicle_data['other_details'] : ''); ?></textarea>
                                                        </div>

                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button class="btn btn-primary"
                                                                onclick="updateVehicleForm('<?php echo $fileNo; ?>');">Update
                                                                Vehicle</button>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $filePayments_rs = Database::search("SELECT * FROM `file_payments` WHERE `insurance_file_id`=?", [$fileID], "s");
                                    $filePayments_Data = $filePayments_rs->fetch_assoc();
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed fw-bold text-white <?php echo isset($filePayments_Data) ? 'bg-success' : 'bg-danger'; ?>"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#payment-form"
                                                aria-expanded="false" aria-controls="payment-form">
                                                payment Form
                                            </button>
                                        </h2>
                                        <div id="payment-form" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="col-12 pb-5">
                                                    <div class="row">



                                                        <h1 class="text-center">Calculate</h1>

                                                        <div class="col-12 col-md-6 mb-3">


                                                            <label class="form-label" for="amount">Amount</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($filePayments_Data['amount']) ? $filePayments_Data['amount'] : ''); ?>"
                                                                type="number" min="1" id="amount" onchange="installmentCalc();"
                                                                onkeypress="priceValidateKeyPress(event,this);"
                                                                onkeyup="installmentCalc();" />
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-3">


                                                            <label class="form-label" for="tenure">Loan Tenure(months)</label>
                                                            <input class="form-control"
                                                                value="<?php echo htmlspecialchars(isset($filePayments_Data['loan_tenure']) ? $filePayments_Data['loan_tenure'] : ''); ?>"
                                                                type="number" min="1" id="tenure" onchange="installmentCalc();"
                                                                onkeyup="installmentCalc();" />
                                                        </div>

                                                        <div class="col-6 col-md-6 mb-3">


                                                            <label class="form-label" for="percentage">Annual Percentage</label>
                                                            <div class="input-group mb-3">
                                                                <input type="number"
                                                                    value="<?php echo htmlspecialchars(isset($filePayments_Data['precentage']) ? $filePayments_Data['precentage'] : ''); ?>"
                                                                    class="form-control" aria-describedby="basic-addon2" min="28"
                                                                    id="percentage" onchange="installmentCalc();"
                                                                    onkeyup="installmentCalc();" />
                                                                <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="row" id="interestBody">

                                                                <?php
                                                                if (isset($filePayments_Data['amount'])) {
                                                                    $principal = $filePayments_Data['amount'];
                                                                    $tenureMonths = $filePayments_Data['loan_tenure'];
                                                                    $annualInterestRate = $filePayments_Data['precentage'];

                                                                    $monthlyInterestRate = $annualInterestRate / (12 * 100);
                                                                    $emi = $principal * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $tenureMonths) / (pow(1 + $monthlyInterestRate, $tenureMonths) - 1);

                                                                    $totalAmountPaid = $emi * $tenureMonths;
                                                                    $totalInterest = $totalAmountPaid - $principal;

                                                                    $balance = $principal;

                                                                    ?>

                                                                    <div class="col-12">
                                                                        <table>
                                                                            <tr>
                                                                                <th>
                                                                                    <h3>Total amount</h3>
                                                                                </th>
                                                                                <td class="px-4"> : </td>
                                                                                <td>
                                                                                    <h3>Rs.<?php echo round($totalAmountPaid, 2); ?>
                                                                                    </h3>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>
                                                                                    <h3>Total Interest</h3>
                                                                                </th>
                                                                                <td class="px-4"> : </td>
                                                                                <td>
                                                                                    <h3>Rs.<?php echo round($totalInterest, 2); ?></h3>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>
                                                                                    <h3>Installment amount</h3>
                                                                                </th>
                                                                                <td class="px-4"> : </td>
                                                                                <td>
                                                                                    <h3>Rs.<?php echo round($emi, 2); ?></h3>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="col-12 table-responsive mt-3">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Month</th>
                                                                                    <th>Principle (Rs)</th>
                                                                                    <th>Interest (Rs)</th>
                                                                                    <th>Balance (Rs)</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                for ($month = 1; $month <= $tenureMonths; $month++) {
                                                                                    $interest = $balance * $annualInterestRate / (12 * 100);
                                                                                    $principalRepayment = $emi - $interest;
                                                                                    $balance -= $principalRepayment;
                                                                                    ?>

                                                                                    <tr>
                                                                                        <td><?php echo $month; ?></td>
                                                                                        <td><?php echo round($principalRepayment, 2); ?>
                                                                                        </td>
                                                                                        <td><?php echo round($interest, 2); ?></td>
                                                                                        <td><?php echo round($balance, 2); ?></td>
                                                                                    </tr>
                                                                                    <?php

                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <?php


                                                                } else {
                                                                    ?>
                                                                    <div class="col-12">
                                                                        <table>
                                                                            <tr>
                                                                                <th>Total amount </th>
                                                                                <td class="px-4"> : </td>
                                                                                <td>00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Total Interest </th>
                                                                                <td class="px-4"> : </td>
                                                                                <td>00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Installment amount </th>
                                                                                <td class="px-4"> : </td>
                                                                                <td>00</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="col-12 table-responsive">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>month</th>
                                                                                    <th>EMI</th>
                                                                                    <th>Principle</th>
                                                                                    <th>Interest</th>
                                                                                    <th>Balance</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>


                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-3">
                                                            <label for="paymentOtherDetails">Other Details</label>
                                                            <textarea class="form-control" rows="5" name=""
                                                                id="paymentOtherDetails"><?php echo htmlspecialchars(isset($filePayments_Data['other_details']) ? $filePayments_Data['other_details'] : ''); ?></textarea>
                                                        </div>

                                                        <div class="col-12 d-flex justify-content-end">
                                                            <button class="btn btn-primary"
                                                                onclick="UpdatePaymentForm('<?php echo $fileNo; ?>');">Update
                                                                Payment</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <script src="bootstrap.bundle.js"></script>
                <script src="script.js"></script>
            </body>

            </html>

            <?php
        } else {
            header("Location: all-files.php");
        }
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}
?>