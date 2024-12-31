<?php
session_start();

if (isset($_SESSION["user"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matara Investment</title>

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

                <div class="offset-lg-1 col-12 col-lg-10 mt-lg-5">
                    <div class="row d-flex justify-content-center">

                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='all-files.php';" class="btn shadow bg-green text-white fw-bolder home-cat-btn">Files</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='add-file.php';" class="btn shadow bg-blue  text-white fw-bolder home-cat-btn">Create New File</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='manage-users.php';" class="btn shadow bg-orange  text-white fw-bolder home-cat-btn">Manage Users</button>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='payment-calculate.php';" class="btn shadow bg-cyan  text-white fw-bolder home-cat-btn">Payment Calculate</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='payments.php';" class="btn shadow bg-gray  text-white fw-bolder home-cat-btn">Payments</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='employee-leaves.php';" class="btn shadow bg-darkblue  text-white fw-bolder home-cat-btn">Employee Leaves</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='cash-summary-report.php';" class="btn shadow bg-purple  text-white fw-bolder home-cat-btn">Cash Summery Report</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 p-3">
                            <div class="row">
                                <button onclick="window.location='inventory.php';" class="btn shadow bg-yellow  fw-bolder home-cat-btn">Inventory</button>
                            </div>
                        </div>
                        <?php
                        if ($_SESSION["user"]["user_type_id"] == "1") {
                        ?>
                            <div class="col-6 col-md-4 col-lg-3 p-3">
                                <div class="row">
                                <button onclick="window.location='super-admin-panel.php';" class="btn shadow bg-emeraldgreen  text-white fw-bolder home-cat-btn">Super Admin Settings</button>
                            
                                </div>
                            </div>
                        <?php
                        }
                        ?>



                        <div>
                            <!-- <canvas id="myChart"></canvas> -->
                        </div>


                    </div>
                </div>

            </div>
        </div>
        <script src="script.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: 'Monthly Profit',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 2,
                        borderColor: 'rgb(75, 192, 192)',
                    }]
                },
            });
        </script> -->

    </body>

    </html>

<?php

} else {
    header("Location: login.php");
}
?>