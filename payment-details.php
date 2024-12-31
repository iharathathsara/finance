<?php
session_start();

if (isset($_SESSION["user"])) {

    $fileID = $_GET["fileID"];

    require "connection.php";

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Details</title>

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

                        <div class="col-12 col-md-10 col-lg-8 rounded-3 shadow p-md-5">
                            <div class="row">
                                <!-- <div class="row"> -->

                                <?php
                                $filePayments_rs = Database::search("SELECT * FROM `file_payments` WHERE `insurance_file_id`=?", [$fileID], "s");
                                $filePayments_Data = $filePayments_rs->fetch_assoc();


                                ?>

                                <h1 class="text-center">Payments</h1>

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

                                    $d = new DateTime();
                                    $tz = new DateTimeZone("Asia/Colombo");
                                    $d->setTimezone($tz);
                                    $date = $d->format("Y-m-d");

                                    $lastInstallmentPayment_rs = Database::search("SELECT * FROM `file_installment_payment` WHERE `file_id`=? ORDER BY `paid_date` DESC", [$fileID], "s");
                                    $lastInstallmentPayment_num = $lastInstallmentPayment_rs->num_rows;
                                    $lastInstallmentPayment_data = $lastInstallmentPayment_rs->fetch_assoc();

                                    $fileApprovedPayment_rs = Database::search("SELECT * FROM `file_approved_payment` WHERE `file_id`=?", [$fileID], "s");
                                    $fileApprovedPayment_data = $fileApprovedPayment_rs->fetch_assoc();

                                    $dueDates;
                                    $approvedDate;
                                    $nextPaymentDate;
                                    $availableInstallment;
                                    if ($fileApprovedPayment_data) {
                                        $approvedDate = $fileApprovedPayment_data["payment_date"];
                                        $approvedDateObj = new DateTime($fileApprovedPayment_data["payment_date"], $tz);

                                        // if ($lastInstallmentPayment_data) {
                                        //     $lastPaidDateObj = new DateTime($lastInstallmentPayment_data['paid_date'], $tz);
                                        //     $nextPaymentDateObj = $lastPaidDateObj->modify('+1 months');
                                        // }else{
                                        //     $nextPaymentDateObj = $approvedDateObj->modify('+' . ($lastInstallmentPayment_num + 1) . ' months');
                                        // }

                                        if ($lastInstallmentPayment_data) {
                                            $lastPaidDateObj = new DateTime($lastInstallmentPayment_data['paid_date'], $tz);

                                            // Clone the approvedDateObj to keep the day and change only the month
                                            $nextPaymentDateObj = clone $approvedDateObj;
                                            $nextPaymentDateObj->setDate(
                                                $lastPaidDateObj->format('Y'),  // Keep the year from the last payment date
                                                $lastPaidDateObj->format('m') + 1,  // Increment the month from the last payment date
                                                $approvedDateObj->format('d')  // Keep the day from the approved date
                                            );
                                        } else {
                                            $nextPaymentDateObj = $approvedDateObj->modify('+' . ($lastInstallmentPayment_num + 1) . ' months');
                                        }

                                        $nextPaymentDate = $nextPaymentDateObj->format('Y-m-d');
                                        $currentDate = new DateTime($date, $tz);

                                        $interval = $currentDate->diff($nextPaymentDateObj);
                                        $dueDates = $interval->days;

                                        if ($currentDate < $nextPaymentDateObj) {
                                            $dueDates = 0;
                                        } else {
                                            $dueDates = +$dueDates;
                                        }

                                        if ($lastInstallmentPayment_data) {
                                            $lastPaidDateObj = new DateTime($lastInstallmentPayment_data['paid_date'], $tz);
                                            $availableInstallmentInterval = $lastPaidDateObj->diff($currentDate);
                                            $availableInstallment = ($availableInstallmentInterval->y * 12) + $availableInstallmentInterval->m;
                                        } else {
                                            $lastPaidDateObj = new DateTime($approvedDate, $tz);
                                            $availableInstallmentInterval = $lastPaidDateObj->diff($currentDate);
                                            $availableInstallment = ($availableInstallmentInterval->y * 12) + $availableInstallmentInterval->m;
                                        }
                                    } else {
                                        $availableInstallment = 0;
                                        $approvedDate = "0";
                                        $nextPaymentDate = "0";
                                        $dueDates = "0";
                                    }



                                    $fineAmount = 0;
                                    if ($dueDates != 0) {
                                        $fineAmount = $emi * 6 / 100 * $dueDates / 30;
                                    }
                                    $lastInstallmentBalance = 0;
                                    if ($lastInstallmentPayment_data) {
                                        $lastInstallmentBalance = $lastInstallmentPayment_data['balance'];
                                    }

                                    $availableInstallmentPayment = $availableInstallment * $emi;
                                    $totalPayment = $emi + $fineAmount + $lastInstallmentBalance + $availableInstallmentPayment;

                                    $totalPaid_rs = Database::search("SELECT SUM(`amount`) AS `totalPaid` FROM `file_installment_payment` WHERE `file_id`=?", [$fileID], "s");
                                    $totalPaid_data = $totalPaid_rs->fetch_assoc();

                                    $totalPaid = 0;
                                    if ($totalPaid_data) {
                                        $totalPaid = $totalPaid_data['totalPaid'];
                                    }
                                    $totalDueAmount = $totalAmountPaid - $totalPaid;

                                    if ($totalDueAmount <= 0) {
                                ?>
                                        <div class="offset-lg-3 col-12 col-lg-6 mb-5">
                                            <div class="row bg-success p-3 shadow">
                                                <h3 class="text-center text-white">Payment Completed</h3>
                                            </div>
                                        </div>
                                    <?php
                                    }

                                    ?>



                                    <div class="col-6 col-md-4 p-2 bg-green">
                                        <label class="form-label" for="amount">Amount</label>
                                        <h5>Rs.<?php echo htmlspecialchars(isset($filePayments_Data['amount']) ? $filePayments_Data['amount'] : ''); ?></h5>
                                    </div>

                                    <div class="col-6 col-md-4 p-2 bg-blue">
                                        <label class="form-label" for="tenure">Loan Tenure(months)</label>
                                        <h5><?php echo htmlspecialchars(isset($filePayments_Data['loan_tenure']) ? $filePayments_Data['loan_tenure'] : ''); ?>(Months)</h5>
                                    </div>

                                    <div class="col-6 col-md-4 p-2 bg-yellow">
                                        <label class="form-label" for="percentage">Annual Percentage</label>
                                        <h5><?php echo htmlspecialchars(isset($filePayments_Data['precentage']) ? $filePayments_Data['precentage'] : ''); ?>%</h5>

                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-orange">
                                        <label class="form-label" for="">Total amount</label>
                                        <h5>Rs.<?php echo htmlspecialchars(isset($totalAmountPaid) ? round($totalAmountPaid, 2) : ''); ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-cyan">
                                        <label class="form-label" for="">Total Interest</label>
                                        <h5>Rs.<?php echo htmlspecialchars(isset($totalInterest) ? round($totalInterest, 2) : ''); ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-gray">
                                        <label class="form-label" for="">Installment amount</label>
                                        <h5>Rs.<?php echo htmlspecialchars(isset($emi) ? round($emi, 2) : ''); ?></h5>
                                    </div>

                                    <hr class="my-3">

                                    <div class="col-6 col-md-4 p-2 bg-green">
                                        <label class="form-label" for="">Approved Date</label>
                                        <h5><?php echo $approvedDate; ?></h5>
                                    </div>

                                    <!-- <div class="col-6 col-md-4 p-2 bg-emeraldgreen">
                                        <label class="form-label" for="">Today</label>
                                        <h5><?php echo $date; ?></h5>
                                    </div> -->

                                    <div class="col-6 col-md-4 p-2 bg-blue">
                                        <label class="form-label" for="">Last Payment Date</label>
                                        <h5><?php echo htmlspecialchars(isset($lastInstallmentPayment_data['paid_date']) ? $lastInstallmentPayment_data['paid_date'] : ''); ?></h5>
                                    </div>

                                    <div class="col-6 col-md-4 p-2 bg-yellow">
                                        <label class="form-label" for="">Next Payment Date</label>
                                        <h5><?php echo $nextPaymentDate; ?></h5>
                                    </div>

                                    <div class="col-6 col-md-4 p-2 bg-orange">
                                        <label class="form-label" for="">Paid Installment</label>
                                        <h5><?php echo $lastInstallmentPayment_num; ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-cyan">
                                        <label class="form-label" for="">Available Installment</label>
                                        <h5 class="<?php echo $availableInstallment != 0 ? 'text-danger' : ''; ?>"><?php echo $availableInstallment; ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-gray">
                                        <label class="form-label" for="">Dilay Days</label>
                                        <h5 class="<?php echo $dueDates != 0 ? 'text-danger' : ''; ?>"><?php echo $dueDates; ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-darkblue">
                                        <label class="form-label" for="">Total Paid Amount (Rs.)</label>
                                        <h5 class=""><?php echo round($totalPaid, 2); ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-emeraldgreen">
                                        <label class="form-label" for="">Total Due Amount (Rs.)</label>
                                        <h5 class=""><?php echo round($totalDueAmount, 2); ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-purple">
                                        <label class="form-label" for="">Fine Amount (Rs.)</label>
                                        <h5 class="<?php echo $fineAmount != 0 ? 'text-danger' : ''; ?>"><?php echo round($fineAmount, 2); ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-green">
                                        <label class="form-label" for="">Available Balance (Rs.)</label>
                                        <h5 class="<?php echo $lastInstallmentBalance != 0 ? 'text-danger' : ''; ?>"><?php echo round($lastInstallmentBalance, 2); ?></h5>
                                    </div>
                                    <div class="col-6 col-md-4 p-2 bg-blue">
                                        <label class="form-label" for="">Total Amount (Rs.)</label>
                                        <h5 class=""><?php echo round($totalPayment, 2); ?></h5>
                                    </div>

                                    <hr class="my-3" />

                                    <?php 
                                    $serviceCharge_rs = Database::search("SELECT * FROM `file_service_charge` WHERE `file_id`=?",[$fileID],"s");
                                    $serviceCharge_num = $serviceCharge_rs->num_rows;
                                    $serviceCharge_data = $serviceCharge_rs->fetch_assoc();

                                    ?>

                                    <div class="col-12 col-md-5 p-2">
                                        <label class="form-label" for="paymentAmount">Service Charge (Rs)</label>
                                        <input class="form-control" value="<?php echo isset($serviceCharge_data['amount'])?$serviceCharge_data['amount']:'' ?>" <?php echo isset($serviceCharge_data['amount'])?'disabled':'' ?> type="number" min="1" id="serviceChargeAmount" onkeypress="priceValidateKeyPress(event,this);" />
                                    </div>
                                    <div class="col-12 col-md-5 p-2">
                                        <label class="form-label" for="paymentDate">payment Date</label>
                                        <input class="form-control" value="<?php echo isset($serviceCharge_data['date'])?$serviceCharge_data['date']:$date ?>" <?php echo isset($serviceCharge_data['date'])?'disabled':'' ?> type="date" min="1" id="serviceChargePaymentDate"  />
                                    </div>

                                    <div class="col-12 col-md-2 mt-md-4">
                                        <button class="btn btn-primary px-5 fs-4 fw-bold" onclick="payServiceCharge('<?php echo $fileID; ?>');">Pay</button>
                                    </div>

                                    <hr class="my-3" />
                                    <div class="col-12 col-md-6 p-2">
                                        <label class="form-label" for="paymentAmount">payment Amount (Rs)</label>
                                        <input class="form-control" type="number" value="<?php echo round($totalPayment, 2); ?>" min="1" id="paymentAmount" onkeypress="priceValidateKeyPress(event,this);" />
                                    </div>
                                    <div class="col-12 col-md-6 p-2">
                                        <label class="form-label" for="paymentDate">payment Date</label>
                                        <input class="form-control" value="<?php echo $date; ?>" type="date" id="paymentDate" />
                                    </div>

                                    <div class="col-12 p-3">
                                        <label for="paymentOtherDetails">Other Details</label>
                                        <textarea class="form-control" rows="5" name="" id="paymentOtherDetails"></textarea>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-primary px-5 fs-4 fw-bold" onclick="payNow('<?php echo $fileID; ?>');">Pay</button>
                                    </div>

                                    <hr class="my-3" />

                                    <h2>Payment History</h2>

                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Installment Balance</th>
                                                    <th>User Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $paymentDetails_rs = Database::search("SELECT `file_installment_payment`.`id`,`file_installment_payment`.`amount`,`file_installment_payment`.`balance`,`file_installment_payment`.`paid_date`,`user`.`full_name` FROM `file_installment_payment` INNER JOIN `user` ON `file_installment_payment`.`user_id`=`user`.`id` WHERE `file_installment_payment`.`file_id`=? ORDER BY `file_installment_payment`.`paid_date` DESC", [$fileID], "s");
                                                $paymentDetails_num = $paymentDetails_rs->num_rows;

                                                for ($i = 0; $i < $paymentDetails_num; $i++) {
                                                    $paymentDetails_data = $paymentDetails_rs->fetch_assoc();
                                                ?>
                                                    <tr>
                                                        <td><?php echo $paymentDetails_data["id"]; ?></td>
                                                        <td><?php echo $paymentDetails_data["amount"]; ?></td>
                                                        <td><?php echo $paymentDetails_data["paid_date"]; ?></td>
                                                        <td><?php echo $paymentDetails_data["balance"]; ?></td>
                                                        <td><?php echo $paymentDetails_data["full_name"]; ?></td>
                                                        <td><a target="_blank" href="receipt.php?receiptId=<?php echo $paymentDetails_data["id"] ?>" class="btn btn-primary">Receipt</a></td>
                                                    </tr>

                                                <?php
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>

                                    <hr class="my-3" />

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
                                                        <td><?php echo round($principalRepayment, 2); ?></td>
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
                                    <div class="col-12 mt-5">
                                        <div class="row">
                                            <h2 class="text-center text-danger">PaymentvDetails Not  Not Completed</h2>
                                        </div>
                                    </div>


                                <?php
                                }
                                ?>


                                <!-- </div>
                                    </div> -->



                                <!-- </div> -->

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