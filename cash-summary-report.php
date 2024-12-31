<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $dateTime = $d->format("Y-m-d H:i:s");
    $date = $d->format("Y-m-d");

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cash Summary Report</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <script>
            function printReport() {
                var body = document.body.innerHTML;
                var page = document.getElementById("page").innerHTML;
                document.body.innerHTML = page;
                window.print();
                document.body.innerHTML = body;
            }

            function generatePDF() {
    const receiptContent = document.querySelector('.receipt-content');

    // Add the class to fix the layout for PDF generation
    receiptContent.classList.add('pdf-content');

    // Use html2canvas to capture the fixed layout
    html2canvas(receiptContent, {
        scale: 2
    }).then((canvas) => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4'); // A4 page size

        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 210; // A4 width in mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        // Add image to the PDF
        doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
        doc.save('Report.pdf'); // Save the PDF as 'receipt.pdf'

        // Remove the fixed layout class after generating the PDF
        receiptContent.classList.remove('pdf-content');
    });
}

        </script>

    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <!-- header -->
                <?php
                require "header.php";
                ?>
                <!-- header -->

                <div class="col-12">
                    <div class="row px-3 pt-4 pt-md-0">

                        <div class="col-12 col-md-4 p-md-4 mb-3">
                            <label class="form-label" for="selectedDate">Date</label>
                            <input class="form-control" value="<?php echo $date; ?>" type="date" id="selectedDate" />
                        </div>
                        <div class="col-12 col-md-4 p-md-4 mt-md-4 mb-3">
                            <div class="row">
                                <button class=" btn btn-primary mt-md-2" onclick="searchReport();">Search</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 p-md-4 mt-md-4 mb-3">
                            <div class="row">
                                <button class=" btn btn-secondary mt-md-2" onclick="window.location.reload();">Clear</button>
                            </div>
                        </div>
                        

                        <div class="col-12 mb-3">
                            <button class="btn btn-primary" onclick="printReport();"><i class="bi bi-printer-fill"></i>Print</button>
                            <button class="btn btn-danger" onclick="generatePDF();"><i class="bi bi-filetype-pdf"></i>Pdf</button>
                        </div>

                        <hr>

                        <div class="col-12 border-1 shadow rounded mt-3">
                            <div class="row p-5 receipt-content" id="page">

                                <h2 class="text-center m-0">Matara Investment Co.(PTE) Ltd.</h2>
                                <h3 class="text-center m-0">20, Wilfred Gunasekara Mawatha.</h3>
                                <h3 class="text-center m-0">FORT - MATARA</h3>
                                <hr />
                                <div class="d-flex justify-content-between">
                                    <h5 id="reportDate">Date: <?php echo $date; ?></h5>
                                    <h5>Tel - 041 22 22 033</h5>
                                </div>


                                <h6 class="text-end mb-5">Printed Date : <?php echo $dateTime; ?></h6>

                                <div class="responsive-table" id="tableDiv">
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
                                            $receipt_rs = Database::search("SELECT * FROM `file_installment_payment` WHERE `paid_date`=?", [$date], "s");
                                            $receipt_num = $receipt_rs->num_rows;


                                            $serviceCharge_rs = Database::search("SELECT * FROM `file_service_charge` WHERE `date`=?", [$date], "s");
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
                                </div>

                            </div>
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