<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $fileID = $_POST["fileId"];
    $paymentAmount = $_POST["paymentAmount"];
    $paymentDate = $_POST["paymentDate"];
    $paymentOtherDetails = $_POST["paymentOtherDetails"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d");

    $response = [];

    if (empty($paymentAmount)) {
        $response['success'] = false;
        $response['message'] = 'Please enter payment amount';
        // echo "Please enter payment amount";
    } else if (empty($paymentDate)) {
        $response['success'] = false;
        $response['message'] = 'Please enter payment date';
        // echo "Please enter payment date";
    } else if ($date < $paymentDate) {
        $response['success'] = false;
        $response['message'] = 'Invalid payment date';
        // echo "Invalid payment date";
    } else {

        $filePayments_rs = Database::search("SELECT * FROM `file_payments` WHERE `insurance_file_id`=?", [$fileID], "s");
        $filePayments_Data = $filePayments_rs->fetch_assoc();

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
    
            $installmentBalance = $totalPayment - $paymentAmount;
            if ($totalDueAmount <= 0) {
                $response['success'] = false;
                $response['message'] = 'Payment Completed. Already file closed';
                // echo "Payment Completed. Already file closed";
            } else {
                Database::iud("INSERT INTO `file_installment_payment` (`file_id`,`user_id`,`balance`,`amount`,`paid_date`) VALUES (?,?,?,?,?)", [$fileID, $_SESSION['user']['id'], round($installmentBalance, 2), $paymentAmount, $paymentDate], "sssss");
                // echo "Success";
                $lastReceiptId_rs = Database::search("SELECT LAST_INSERT_ID() AS `receiptId`;");
                $lastReceiptId_data = $lastReceiptId_rs->fetch_assoc();
                $receiptId = $lastReceiptId_data["receiptId"];

                $response['success'] = true;
                $response['message'] = 'Success';
                $response['receiptId'] = $receiptId;
            }


        } else {
            $response['success'] = false;
            $response['message'] = 'File Not Approved';
            // echo "File Not Approved";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    header("Location: login.php");
}
