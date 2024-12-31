<?php
session_start();

if (isset($_SESSION["user"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Calculate</title>

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
                                <h1>Calculate</h1>

                                <div class="col-12 col-md-6 mb-3">


                                    <label class="form-label" for="">Amount</label>
                                    <input class="form-control" type="number" min="1" id="amount" onchange="installmentCalc();" onkeyup="installmentCalc();" />
                                </div>

                                <div class="col-12 col-md-6 mb-3">


                                    <label class="form-label" for="">Loan Tenure(months)</label>
                                    <input class="form-control" type="number" min="1" id="tenure" onchange="installmentCalc();" onkeyup="installmentCalc();" />
                                </div>

                                <div class="col-6 col-md-6 mb-3">

                                    <label class="form-label" for="">Annual Percentage</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" aria-describedby="basic-addon2" min="51.5" id="percentage" onchange="installmentCalc();" onkeyup="installmentCalc();" />
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row" id="interestBody">

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