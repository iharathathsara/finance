<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"]["user_type_id"] == '1') {
        require "connection.php";
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Super Admin Panel</title>

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

                    <div class=" col-12 mt-lg-4">
                        <div class="row d-flex justify-content-center">

                            <div class="col-6 col-md-4 col-lg-3 p-3">
                                <div class="row">
                                    <form method="post" action="backup.php">
                                        <button type="submit" name="backup"
                                            class="btn col-12 shadow bg-emeraldgreen  text-white fw-bolder home-cat-btn">Save
                                            Database Backup</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <h2 class="text-decoration-underline">Annual Payment Presentage</h2>

                    <div class="col-12 mt-lg-4">
                        <div class="row d-flex justify-content-center">

                            <div class="col-6 col-md-4 p-3 d-flex gap-3">

                            <?php 
                            $presentage_rs = Database::search("SELECT * FROM `payment_anual_presentage`");
                            $presentage_data = $presentage_rs->fetch_assoc();
                            ?>

                                <div class="input-group">
                                    <input type="text" value="<?php echo $presentage_data["value"]; ?>" class="form-control" placeholder="Annual presentage"
                                        aria-label="Annual presentage" aria-describedby="basic-addon2" id="annualpresentage">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                                <button class="btn btn-primary" onclick="changeAnnualPresentage();">Change</button>

                            </div>

                        </div>
                    </div>

                    <hr />

                    <h2 class="text-decoration-underline">Reset User's Password</h2>

                    <div class="col-12 table-responsive p-3">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-dark text-white">
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Name with Initial</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>NIC</th>
                                    <!-- <th>Address</th> -->
                                    <th>User Type</th>
                                    <th>Status</th>
                                    <th>Reset password</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <?php
                                $users_rs = Database::search("SELECT `user`.`id`,`user`.`full_name`,`user`.`name_with_initial`,`user`.`email`,`user`.`mobile`,`user`.`nic`,`user`.`address`,`user_type`.`name` AS `userType`, `user_status`.`name` AS `userStatus` FROM `user` INNER JOIN `user_type` ON `user`.`user_type_id` = `user_type`.`id` INNER JOIN `user_status` ON `user`.`user_status_id`=`user_status`.`id`");
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

                                        <td><?php echo $users_data["userType"]; ?></td>
                                        <td>
                                            <?php
                                            if ($users_data["userType"] == "Super Admin") {
                                                ?>
                                                <div class="btn btn-success"><?php echo $users_data["userStatus"]; ?></div>
                                                <?php
                                            } else {
                                                if ($users_data["userStatus"] == "Active") {
                                                    ?>
                                                    <button class="btn btn-success"
                                                        onclick="updateUserStatus('<?php echo $users_data['id']; ?>');"><?php echo $users_data["userStatus"]; ?></button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button class="btn btn-danger"
                                                        onclick="updateUserStatus('<?php echo $users_data['id']; ?>');"><?php echo $users_data["userStatus"]; ?></button>
                                                    <?php
                                                }
                                            }

                                            ?>
                                        </td>
                                        <td><button class="btn btn-danger"
                                                onclick="resetPassword('<?php echo $users_data['id']; ?>');">Reset Password</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <script src="script.js"></script>
            <script src="bootstrap.bundle.js"></script>
        </body>

        </html>
        <?php

    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}
?>