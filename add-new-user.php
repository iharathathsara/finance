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
        <title>Add New User</title>
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

                    <h1>New User</h1>

                    <div class="col-12 col-lg-6">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="nameWithInitial">Name with initial</label>
                        <input type="text" class="form-control" id="nameWithInitial" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="empNo">Employee No</label>
                        <input type="text" class="form-control" id="empNo" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="mobile">Mobile</label>
                        <input type="text" class="form-control" id="mobile" onkeypress="mobileValidateKeyPress(event,'mobile');" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="nic">NIC</label>
                        <input type="text" class="form-control" id="nic" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="userType">User type</label>
                        <select name="" id="userType" class="form-select">
                        <option value="0">SELECT</option>
                                <?php
                                $userType_rs = Database::search("SELECT * FROM `user_type`");
                                $userType_num = $userType_rs->num_rows;
                                for ($i = 0; $i < $userType_num; $i++) {
                                    $userType_data = $userType_rs->fetch_assoc();
                                ?>
                                    <option class="<?php echo $_SESSION['user']['user_type_id']!='1'&&$userType_data['id']=='1'?'d-none':''; ?>" value="<?php echo $userType_data['id']; ?>"><?php echo $userType_data['name']; ?></option>
                                <?php
                                }
                                ?>
                        </select>
                    </div>

                    <div class="col-12 mt-4 px-4">
                        <div class="row">
                            <p class="text-danger fw-bold">*New User's password is his/her NIC number. he.she can change his/her password after login.</p>
                        </div>
                    </div>

                    <div class="col-12 mt-4 px-4">
                        <div class="row">
                            <button class="btn btn-success" onclick="addNewUser();">Save</button>

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