<?php
session_start();

if (isset($_SESSION["user"])) {

    $principal = $_POST["amount"];
    $tenureMonths = $_POST["tenure"];
    $annualInterestRate = $_POST["percentage"];

    if (empty($principal)) {
        ?>
        <p class="text-center text-danger">Please enter Pricipal</p>
        <?php
    }  else if (empty($tenureMonths)) {
        ?>
        <p class="text-center text-danger">Please enter Loan Tenure(months)</p>
        <?php
    }else if (empty($annualInterestRate)) {
        ?>
        <p class="text-center text-danger">Please enter Anual Percentage</p>
        <?php
    } else {

        $monthlyInterestRate = $annualInterestRate / (12 * 100);
        $emi = $principal * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $tenureMonths) / (pow(1 + $monthlyInterestRate, $tenureMonths) - 1);

        $totalAmountPaid = $emi * $tenureMonths;
        $totalInterest = $totalAmountPaid - $principal;

        $balance = $principal;

?>

        <div class="col-12">
            <table>
                <tr>
                    <th><h3>Total amount</h3> </th>
                    <td class="px-4"> : </td>
                    <td> <h3>Rs.<?php echo round($totalAmountPaid, 2); ?></h3></td>
                </tr>
                <tr>
                    <th><h3>Total Interest</h3> </th>
                    <td class="px-4"> : </td>
                    <td><h3>Rs.<?php echo round($totalInterest, 2); ?></h3></td>
                </tr>
                <tr>
                    <th><h3>Installment amount</h3> </th>
                    <td class="px-4"> : </td>
                    <td><h3>Rs.<?php echo round($emi, 2); ?></h3></td>
                </tr>
            </table>
        </div>

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


    }
} else {
    header("Location: login.php");
}
