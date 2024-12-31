<?php
session_start();

if (isset($_SESSION["user"])) {

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

                            <h1 class="text-center" style="font-size: 5rem;">error</h1>

                        </div>

                    </div>
                </div>

            </div>
        </div>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location: login.php");
}
?>