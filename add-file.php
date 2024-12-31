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
        <title>Add File</title>

        <link rel="stylesheet" href="bootstrap.css" />
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">

                <?php
                require "header.php";
                ?>

                <div class="col-12">
                    <div class="row d-flex justify-content-center align-items-center" style="height: 80vh;">

                        <div class="col-6 p-5 border bg-white">

                            <h1 class="text-center mb-3">File No</h1>
                            <h4 class="">Welcome to Insurance</h4>
                            <input class="form-control mb-3" placeholder="File No" type="text" id="newFileNo" />
                            <select class="form-select mb-3" id="newFileType">
                                <option value="0">SELECT</option>
                                <?php 
                                $file_type_rs = Database::search("SELECT * FROM `file_type`");
                                $file_type_num = $file_type_rs->num_rows;
                                for($i=0;$i<$file_type_num;$i++){
                                    $file_type_data=$file_type_rs->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $file_type_data["id"]; ?>"><?php echo $file_type_data["name"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <button onclick="createNewFile();" class="btn btn-success w-100 mb-3">Create New File</button>

                        </div>

                    </div>
                </div>

            </div>
        </div>
        <script src="script.js"></script>
        <script src="bootstrap.bundle.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location: login.php");
}
?>