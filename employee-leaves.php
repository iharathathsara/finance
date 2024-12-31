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
        <title>Employee Leaves</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">

                <?php
                require "header.php";
                ?>

                <div class="col-12 my-5">
                    <div class="row">

                        <div class="offset-lg-2 col-12 col-lg-8 border rounded-3 shadow p-5">
                            <div class="row">

                                <?php
                                $leaves_rs = Database::search("SELECT * FROM `leaves`");
                                $leaves_num = $leaves_rs->num_rows;
                                for ($i = 0; $i < $leaves_num; $i++) {
                                    $leaves_data = $leaves_rs->fetch_assoc();

                                    $userLeavesNum_rs = Database::search("SELECT SUM(`user_has_leaves`.`days`) AS `leavedDays` FROM `user_has_leaves` WHERE `user_has_leaves`.`user_id`=? AND `user_has_leaves`.`leaves_id`=?", [$_SESSION["user"]["id"], $leaves_data["id"]], "ss");

                                    $userLeavesNum_data = $userLeavesNum_rs->fetch_assoc();

                                    $leavedDays = 0;
                                    if ($userLeavesNum_data) {
                                        $leavedDays = $userLeavesNum_data["leavedDays"];
                                    }

                                    $availableDays = $leaves_data["days"] - $leavedDays;
                                ?>
                                    <div class="col-12 col-lg-4 p-3">
                                        <div class="row p-2 border shadow rounded rounded-3 <?php echo $availableDays > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                            <label class="fw-bold text-white-50">Available <?php echo $leaves_data["name"]; ?></label>
                                            <h2 class="text-white text-end fs-1 pe-5"><?php echo $availableDays; ?></h2>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <h1 class="mt-3">Requesrt Leave</h1>

                                <div class="col-12 col-lg-4 p-3">
                                    <label for="leaveType">Leave Type</label>
                                    <select class="form-select" id="leaveType">
                                        <option value="0">SELECT</option>
                                        <?php
                                        $leaves_rs = Database::search("SELECT * FROM `leaves`");
                                        $leaves_num = $leaves_rs->num_rows;
                                        for ($i = 0; $i < $leaves_num; $i++) {
                                            $leaves_data = $leaves_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo $leaves_data['id']; ?>"><?php echo $leaves_data['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4 p-3">
                                    <label for="leaveDays">Leave Days</label>
                                    <input type="number" class="form-control" id="leaveDays" />
                                </div>
                                <div class="col-12 col-lg-4 p-3">
                                    <label for="leaveDate">Leave Date</label>
                                    <input type="date" class="form-control" id="leaveDate" />
                                </div>
                                <div class="col-12 p-3">
                                    <label for="leaveDetails">Other Details</label>
                                    <textarea class="form-control" rows="5" name="" id="leaveDetails"></textarea>
                                </div>
                                <div class="col-12 ">
                                    <button class="btn btn-primary" onclick="requestLeave();">Request Leave</button>
                                </div>


                            </div>
                        </div>

                        <hr class="my-4" />

                        <div class="col-12 p-3">
                            <div class="row">

                                <div class="col-12 col-lg-4 p-3">
                                    <label for="">Search User Name</label>
                                    <input type="text" class="form-control" id="" />
                                </div>
                                <div class="col-12 col-lg-4 p-3">
                                    <label for="">Search Leave Status</label>
                                    <select class="form-select" id="">
                                        <option>Select</option>
                                        <option value="0">Not Approved</option>
                                        <option value="1">Approved</option>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-4 p-3">
                                    <div class="row">
                                        <button class="btn btn-primary mt-4">Clear</button>

                                    </div>
                                </div>

                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>Leave Type</th>
                                                <th>Leave Date</th>
                                                <th>Leave Days</th>
                                                <th>Other Details</th>
                                                <th>Status</th>
                                                <th>Approved User</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $userHasLeaves_rs = Database::search("SELECT `user_has_leaves`.`id`,`user`.`full_name`,`leaves`.`name`, `user_has_leaves`.`leave_date`,`user_has_leaves`.`days`,`user_has_leaves`.`other_details`,`user_has_leaves`.`status`,`user_has_leaves`.`approved_user_id` FROM `user_has_leaves` INNER JOIN `user` ON `user_has_leaves`.`user_id`=`user`.`id` INNER JOIN `leaves` ON `user_has_leaves`.`leaves_id`=`leaves`.`id` ORDER BY `user_has_leaves`.`id` DESC");
                                            $userHasLeaves_num = $userHasLeaves_rs->num_rows;
                                            for ($i = 0; $i < $userHasLeaves_num; $i++) {
                                                $userHasLeaves_data = $userHasLeaves_rs->fetch_assoc();

                                                $approvedUser = "";
                                                if (isset($userHasLeaves_data["approved_user_id"])) {
                                                    $approvedUser_rs = Database::search("SELECT * FROM `user` WHERE `id`=?", [$userHasLeaves_data["approved_user_id"]], "s");

                                                    $approvedUser_data = $approvedUser_rs->fetch_assoc();
                                                    $approvedUser = $approvedUser_data["full_name"];
                                                }
                                            ?>
                                                <tr class="<?php echo $userHasLeaves_data["status"] == "0" ? 'table-warning' : ($userHasLeaves_data["status"] == "1"?'table-success':'table-danger'); ?>">
                                                    <td><?php echo $userHasLeaves_data["id"]; ?></td>
                                                    <td><?php echo $userHasLeaves_data["full_name"]; ?></td>
                                                    <td><?php echo $userHasLeaves_data["name"]; ?></td>
                                                    <td><?php echo $userHasLeaves_data["leave_date"]; ?></td>
                                                    <td><?php echo $userHasLeaves_data["days"]; ?></td>
                                                    <td><?php echo $userHasLeaves_data["other_details"]; ?></td>
                                                    <?php if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2") {
                                                        if ($userHasLeaves_data["status"] == "0") {
                                                    ?>
                                                            <td>
                                                                <button class="btn btn-success" onclick="approveEmpLeave('<?php echo $userHasLeaves_data['id']; ?>');">Approve</button>
                                                                <button class="btn btn-danger" onclick="rejectEmpLeave('<?php echo $userHasLeaves_data['id']; ?>');">Reject</button>
                                                            </td>
                                                        <?php
                                                        } else if ($userHasLeaves_data["status"] == "1") {
                                                        ?>
                                                            <td class="text-success fw-bold">Approved</td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td class="text-danger fw-bold">Reject</td>
                                                        <?php
                                                        }
                                                    } else {
                                                        if ($userHasLeaves_data["status"] == "0") {
                                                        ?>
                                                            <td class="text-danger fw-bold">Pending</td>
                                                        <?php
                                                        } else if ($userHasLeaves_data["status"] == "1") {
                                                        ?>
                                                            <td class="text-success fw-bold">Approved</td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td class="text-danger fw-bold">Reject</td>
                                                    <?php
                                                        }
                                                    } ?>

                                                    <td><?php echo $approvedUser; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
        <script src="script.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="bootstrap.js"></script>
    </body>

    </html><?php

        } else {
            header("Location: login.php");
        }
            ?>