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
        <title>My Profile</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php
                require "header.php";
                ?>

                <div class="col-12 mt-4 p-3">
                    <div class="row d-flex justify-content-center">

                        <div class="col-12 col-md-10 col-lg-8 rounded-3 shadow p-5">
                            <div class="row">

                                <?php
                                $user_rs = Database::search("SELECT * FROM `user` WHERE `id`=?", [$_SESSION["user"]["id"]], "s");
                                $user_data = $user_rs->fetch_assoc();

                                ?>

                                <h1>My Profile</h1>

                                <div class="col-12 col-lg-6">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" value="<?php echo $user_data["full_name"]; ?>" />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nameWithInitial">Name with initial</label>
                                    <input type="text" class="form-control" id="nameWithInitial" value="<?php echo $user_data["name_with_initial"]; ?>" />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" value="<?php echo $user_data["email"]; ?>" disabled />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="empNo">Employee No</label>
                                    <input type="text" class="form-control" id="empNo" value="<?php echo $user_data["emp_no"]; ?>" disabled />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="nic">NIC</label>
                                    <input type="text" class="form-control" id="nic" value="<?php echo $user_data["nic"]; ?>" disabled />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" value="<?php echo $user_data["mobile"]; ?>" />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" />
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="cPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="cPassword" />
                                </div>
                                <?php
                                $userTYpe_rs = Database::search("SELECT * FROM `user_type` WHERE `id`=?", [$user_data["user_type_id"]], "s");
                                $userTYpe_data = $userTYpe_rs->fetch_assoc();
                                ?>
                                <div class="col-12 col-lg-6">
                                    <label for="userType">User type</label>
                                    <input type="text" class="form-control" id="mobile" value="<?php echo $userTYpe_data["name"]; ?>" disabled />
                                </div>

                                <div class="col-12">
                                    <label for="address">Address</label>
                                    <Textarea class="form-control" id="address" rows="5"><?php echo $user_data["address"]; ?></Textarea>
                                </div>

                                <div class="col-12 mt-4 px-4">
                                    <div class="row">
                                        <button class="btn btn-success" onclick="updateMyProfile();">Save</button>

                                    </div>
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

    </html>
<?php

} else {
    header("Location: login.php");
}
?>