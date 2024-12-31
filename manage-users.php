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
        <title>Manage Users</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php
                require "header.php";
                ?>

                <div class="col-12 p-3">
                    <div class="row">

                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sName">Name</label>
                            <input class="form-control" type="text" id="sName" onkeyup="searchUsers();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sEmail">Email</label>
                            <input class="form-control" type="text" id="sEmail" onkeyup="searchUsers();" />
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sMobile">Mobile</label>
                            <input class="form-control" type="text" id="sMobile" onkeyup="searchUsers();" />
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sType">User Type</label>
                            <select class="form-select" name="" id="sType" onchange="searchUsers();">
                                <option value="0">SELECT</option>
                                <?php
                                $userType_rs = Database::search("SELECT * FROM `user_type`");
                                $userType_num = $userType_rs->num_rows;
                                for ($i = 0; $i < $userType_num; $i++) {
                                    $userType_data = $userType_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $userType_data['id']; ?>"><?php echo $userType_data['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-6 col-md-3 mb-3">
                            <label class="form-label" for="sStatus">Active/Inactive</label>
                            <select class="form-select" name="" id="sStatus" onchange="searchUsers();">
                                <option value="0">SELECT</option>
                                <?php
                                $userType_rs = Database::search("SELECT * FROM `user_status`");
                                $userType_num = $userType_rs->num_rows;
                                for ($i = 0; $i < $userType_num; $i++) {
                                    $userType_data = $userType_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $userType_data['id']; ?>"><?php echo $userType_data['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-6 col-md-3 mb-3 pt-2 px-4">
                            <div class="row">
                                <button class="btn btn-primary mt-4" onclick="window.location.reload();">Clear</button>
                            </div>

                        </div>
                        <div class="col-6 col-md-3 mb-3 pt-2 px-4">
                            <div class="row">
                                <button class="btn btn-success mt-4" onclick="window.location='add-new-user.php';">Create New user account</button>
                            </div>

                        </div>
                    </div>
                </div>

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
                                <th>Address</th>
                                <th>User Type</th>
                                <th>Status</th>
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
                                    <td><?php echo $users_data["address"]; ?></td>
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
                                                <button class="btn btn-success" onclick="updateUserStatus('<?php echo $users_data['id']; ?>');"><?php echo $users_data["userStatus"]; ?></button>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-danger" onclick="updateUserStatus('<?php echo $users_data['id']; ?>');"><?php echo $users_data["userStatus"]; ?></button>
                                        <?php
                                            }
                                        }

                                        ?>
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
        <script src="bootstrap.js"></script>
    </body>

    </html>
<?php

} else {
    header("Location: login.php");
}
?>