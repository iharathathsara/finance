<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $selectedDate = $_POST["selectedDate"];

    if (empty($selectedDate)) {
    } else {
?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Receit ID</th>
                    <th>File Name</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $receipt_rs = Database::search("SELECT * FROM `file_installment_payment` WHERE `paid_date`=?", [$selectedDate], "s");
                $receipt_num = $receipt_rs->num_rows;


                $serviceCharge_rs = Database::search("SELECT * FROM `file_service_charge` WHERE `date`=?", [$selectedDate], "s");
                $serviceCharge_num = $serviceCharge_rs->num_rows;

                $totalAmount = 0;

                for ($j = 0; $j < $serviceCharge_num; $j++) {
                    $serviceCharge_data = $serviceCharge_rs->fetch_assoc();
                    $file_rs = Database::search("SELECT * FROM `insurance_file` WHERE `id`=?", [$serviceCharge_data['file_id']], "s");
                    $file_data = $file_rs->fetch_assoc();

                    $totalAmount = $totalAmount + $serviceCharge_data["amount"];
                ?>
                    <tr>
                        <td>SC_<?php echo $serviceCharge_data["id"]; ?></td>
                        <td><?php echo $file_data["file_no"]; ?></td>
                        <td>Service Charge</td>
                        <td>RS.<?php echo $serviceCharge_data["amount"]; ?></td>
                    </tr>
                <?php
                }


                for ($i = 0; $i < $receipt_num; $i++) {
                    $receipt_data = $receipt_rs->fetch_assoc();

                    $file_rs = Database::search("SELECT * FROM `insurance_file` WHERE `id`=?", [$receipt_data['file_id']], "s");
                    $file_data = $file_rs->fetch_assoc();

                    $totalAmount = $totalAmount + $receipt_data["amount"];
                ?>
                    <tr>
                        <td>IP_<?php echo $receipt_data["id"]; ?></td>
                        <td><?php echo $file_data["file_no"]; ?></td>
                        <td>Installment Payment</td>
                        <td>Rs.<?php echo $receipt_data["amount"]; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>RS.<?php echo $totalAmount; ?></th>
                </tr>
            </tfoot>
        </table>
<?php
    }
} else {
    header("Location: login.php");
}
