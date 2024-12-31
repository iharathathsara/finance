<?php
session_start();

if (isset($_SESSION["user"])) {

    if (isset($_GET["receiptId"])) {

        require "connection.php";

        $receiptId = $_GET["receiptId"];

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $dateTime = $d->format("Y-m-d H:i:s");

        $installmentPayment_rs = Database::search("SELECT * FROM `file_installment_payment` WHERE `id`=?", [$receiptId], "s");
        $installmentPayment_data = $installmentPayment_rs->fetch_assoc();
        $fileId = $installmentPayment_data["file_id"];

        $client_rs = Database::search("SELECT * FROM `client` WHERE `insurance_file_id`=?", [$fileId], "s");
        $client_data = $client_rs->fetch_assoc();

        $vehicle_rs = Database::search("SELECT * FROM `vehicle` WHERE `insurance_file_id`=?", [$fileId], "s");
        $vehicle_data = $vehicle_rs->fetch_assoc();


?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Receipt</title>

            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


            <style>
                .receipt-content {
                    font-size: 1rem;
                }

                /* Fixed styles for PDF export */
                @media print,
                screen and (min-width: 1024px) {
                    .pdf-content {
                        font-size: 12px !important;
                        /* Fixed font size for the PDF */
                        max-width: 148mm !important;
                        /* Fixed width matching A5 size */
                        padding: 10px !important;
                    }
                }



                @media print {

                    /* Ensure the content fits on an A5 page */
                    @page {
                        size: A5;
                        margin: 0;
                    }

                    body {
                        margin: 0;
                        padding: 0;
                    }

                    .receipt-content {
                        width: 100%;
                        margin: auto;
                    }

                    /* Hide everything else when printing */
                    body * {
                        visibility: hidden;
                    }

                    .receipt-content,
                    .receipt-content * {
                        visibility: visible;
                    }

                    /* Remove unnecessary margins */
                    .receipt-content {
                        position: absolute;
                        left: 0;
                        top: 0;
                        padding: 20px;
                    }
                }
            </style>

            <script>
                function printReceipt() {
                    window.print();
                }

                // function generatePDF() {
                //     const receiptContent = document.querySelector('.receipt-content');

                //     html2canvas(receiptContent, {
                //         scale: 2
                //     }).then((canvas) => {
                //         const {
                //             jsPDF
                //         } = window.jspdf;
                //         const doc = new jsPDF('p', 'mm', 'a5'); // A5 page size

                //         const imgData = canvas.toDataURL('image/png');
                //         const imgWidth = 148; // A5 width in mm
                //         const pageHeight = 210; // A5 height in mm
                //         const imgHeight = (canvas.height * imgWidth) / canvas.width;

                //         doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                //         doc.save('receipt.pdf'); // Save the PDF as 'receipt.pdf'
                //     });
                // }

                function generatePDF() {
                    const receiptContent = document.querySelector('.receipt-content');

                    // Add the class to fix the layout for PDF generation
                    receiptContent.classList.add('pdf-content');

                    // Use html2canvas to capture the fixed layout
                    html2canvas(receiptContent, {
                        scale: 2
                    }).then((canvas) => {
                        const {
                            jsPDF
                        } = window.jspdf;
                        const doc = new jsPDF('p', 'mm', 'a5'); // A5 page size

                        const imgData = canvas.toDataURL('image/png');
                        const imgWidth = 148; // A5 width in mm
                        const imgHeight = (canvas.height * imgWidth) / canvas.width;

                        // Add image to the PDF
                        doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                        doc.save('receipt.pdf'); // Save the PDF as 'receipt.pdf'

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
                        <div class="row">

                            <div class="col-12 mt-5">
                                <button class="btn btn-primary" onclick="printReceipt();"><i class="bi bi-printer-fill"></i>Print</button>
                                <button class="btn btn-danger" onclick="generatePDF();"><i class="bi bi-filetype-pdf"></i>Pdf</button>
                            </div>



                            <div class="col-12 offset-md-2 col-md-8 p-5 border-1 shadow rounded ">
                                <div class="row receipt-content">

                                    <h2 class="text-center m-0">Matara Investment Co.(PTE) Ltd.</h2>
                                    <h3 class="text-center m-0">20, Wilfred Gunasekara Mawatha.</h3>
                                    <h3 class="text-center m-0">FORT - MATARA</h3>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <h5>No: 00<?php echo $receiptId; ?></h5>
                                        <h5>Tel - 041 22 22 033</h5>
                                    </div>


                                    <h6 class="text-end mb-5">Printed Date : <?php echo $dateTime; ?></h6>

                                    <p class="fw-bold">Name : <span class="fw-normal"><?php echo $client_data["name_with_initial"]; ?></span></p>
                                    <p class="fw-bold">Contact No : <span class="fw-normal"><?php echo $client_data["mobile"]; ?></span></p>
                                    <p class="fw-bold">Vehicle No : <span class="fw-normal"><?php echo $vehicle_data["reg_no"]; ?></span></p>
                                    <p class="fw-bold">Amount : <span class="fw-normal"> RS.<?php echo $installmentPayment_data["amount"]; ?></span></p>
                                    <p class="fw-bold mb-5">Payment Date : <span class="fw-normal"><?php echo $installmentPayment_data["paid_date"]; ?></span> </p>

                                    <p class="text-end mb-0 mt-5">............................................................</p>
                                    <p class="text-end m-0">Manager/Chashier Signature</p>

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
        header("Location: payments.php");
    }
} else {
    header("Location: login.php");
}
?>