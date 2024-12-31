<?php
session_start();

if (isset($_SESSION["user"])) {
    if (isset($_GET["fileNo"])) {

        $fileNo = $_GET["fileNo"];

        require "connection.php";
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add File Details</title>
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        </head>

        <body>
            <div class="container-fluid">
                <div class="row">

                    <?php
                    require "header.php";
                    ?>

                    <div class="offset-lg-1 col-12 col-lg-10 border shadow rounded-3 p-md-5 my-5">
                        <div class="row">
                            <h1 class="text-center mb-4 fw-bold text-decoration-underline"><?php echo $fileNo; ?></h1>

                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item ">
                                    <h2 class="accordion-header ">
                                        <button class="accordion-button collapsed text-white fw-bold bg-danger" id="clientFormHeaderButton" type="button" data-bs-toggle="collapse" data-bs-target="#client-form" aria-expanded="false" aria-controls="client-form">
                                            Client Application
                                        </button>
                                    </h2>
                                    <div id="client-form" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="col-12 pb-5">
                                                <div class="row">

                                                    <h1 class="text-center my-3">Client Application</h1>

                                                    <h3 class="bg-blue">Particulars of Appliciant</h3>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientFullName">Full Name of Applicant</label>
                                                        <input class="form-control" type="text" id="clientFullName" />

                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientNameWithInitial">Name with Initials</label>
                                                        <input class="form-control" type="text" id="clientNameWithInitial" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientAddress">Permanent Address</label>
                                                        <input class="form-control" type="text" id="clientAddress" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientDOB">Date of Birth</label>
                                                        <input class="form-control" type="text" id="clientDOB" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientNIC">NIC No</label>
                                                        <input class="form-control" type="text" id="clientNIC" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientTel">Tel No</label>
                                                        <input class="form-control" type="tel" id="clientTel" onkeypress="mobileValidateKeyPress(event,'clientTel');" maxlength="10" />
                                                        <span id="message"></span>
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientMobile">Mobile No</label>
                                                        <input class="form-control" type="tel" id="clientMobile" onkeypress="mobileValidateKeyPress(event,'clientMobile');" maxlength="10" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientTitle">Title</label>
                                                        <select class="form-select" name="" id="clientTitle">
                                                            <option value="0">SELECT</option>
                                                            <?php
                                                            $user_title_rs = Database::search("SELECT * FROM `user_title`");
                                                            $user_title_num = $user_title_rs->num_rows;
                                                            for ($i = 0; $i < $user_title_num; $i++) {
                                                                $user_title_data = $user_title_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $user_title_data["id"]; ?>"><?php echo $user_title_data["name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientNicFrontPhoto">NIC Photo front</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="clientNicFrontPhoto" onclick="selectPhoto('clientNicFrontPhoto','clientNicFrontPhotoImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="clientNicFrontPhoto" />
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png" id="clientNicFrontPhotoImg" alt="NIC Front Photo" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientNicBackPhoto">NIC Photo back</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="clientNicBackPhoto" onclick="selectPhoto('clientNicBackPhoto','clientNicBackPhotoImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="clientNicBackPhoto" />
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png" id="clientNicBackPhotoImg" alt="NIC Back Photo">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="clientMarrageStatusCheckBox">Marage Status</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="clientMarrageStatusCheckBox" onchange="clientMarrageStatusChange();" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3 mb-3 border shadow rounded-3 d-none" id="clientMarrageDetailsBox">
                                                        <div class="row">

                                                            <h3 class="bg-blue">Details of Spouse</h3>

                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="clientSpouseFullName">Name in Full</label>
                                                                <input class="form-control" type="text" id="clientSpouseFullName" />
                                                            </div>
                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="clientSpouseNIC">NIC No</label>
                                                                <input class="form-control" type="text" id="clientSpouseNIC" />
                                                            </div>
                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="clientSpouseTel">Tel No</label>
                                                                <input class="form-control" type="tel" id="clientSpouseTel" onkeypress="mobileValidateKeyPress(event,'clientSpouseTel');" maxlength="10" />
                                                            </div>
                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="clientSpouseProfession">Profession</label>
                                                                <input class="form-control" type="text" id="clientSpouseProfession" />
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <h3 class="bg-blue">Details of Employment</h3>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientEmpName">Name of Employer/Business</label>
                                                        <input class="form-control" type="text" id="clientEmpName" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientEmpAddress">Address of Employer/Business</label>
                                                        <input class="form-control" type="text" id="clientEmpAddress" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientBusinessRegNo">Business Registration No</label>
                                                        <input class="form-control" type="tel" id="clientBusinessRegNo" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientBusinessNature">Nature of Business</label>
                                                        <input class="form-control" type="text" id="clientBusinessNature" />
                                                    </div>

                                                    <h3 class="bg-blue">Details of Personal Income</h3>
                                                    <div class="col-12 p-3 table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th colspan="2">Statement of Income (Monthly)</th>
                                                                <th>Income (Net)(Rs.)</th>
                                                            </tr>
                                                            <tr>
                                                                <th rowspan="3">Source of Income</th>
                                                                <th>Employment/Business</th>
                                                                <td><input class="form-control" type="text" id="clentIncomeEmp" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calClientTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Other</th>
                                                                <td><input class="form-control" type="text" id="clentIncomeOther" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calClientTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Income</th>
                                                                <th id="clientTotalIncome">0.00</th>
                                                            </tr>
                                                            <tr>
                                                                <th rowspan="3">Less</th>
                                                                <th>Cost of Living</th>
                                                                <td><input class="form-control" type="text" id="clientCostLiving" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calClientTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Loan repayment</th>
                                                                <td><input class="form-control" type="text" id="clientLoanRepayment" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calClientTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Net Income</th>
                                                                <th id="clientNetIncome">0.00</th>
                                                            </tr>
                                                        </table>

                                                    </div>

                                                    <h3 class="bg-blue">Credit Facilities Obtained</h3>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="clientCreditObtainedCheckBox">Credit Facilities Obtained</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="clientCreditObtainedCheckBox" onchange="viewStatusChange(this,'clientCreditObtainedDetailsBox');" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 table-responsive d-none" id="clientCreditObtainedDetailsBox">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Institute</th>
                                                                    <th>Amount Obtained(Rs.)</th>
                                                                    <th>Present Outstanding(Rs.)</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="clientCreditObtainedBody">
                                                                <tr id="clientCreditObtainedRow">
                                                                    <td><input class="form-control" type="text" name="clientCreditObtainedInstitute" /> </td>
                                                                    <td><input class="form-control" type="text" name="clientCreditObtainedAmount" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td><input class="form-control" type="text" name="clientCreditObtainedPresentOutstanding" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('clientCreditObtainedBody','clientCreditObtainedRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <h3 class="bg-blue">Assets</h3>
                                                    <h3 class="">Details Of Bankers</h3>

                                                    <div class="col-12 table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name of Bank & Branch</th>
                                                                    <th>Account No</th>
                                                                    <th>Type of Account</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="clientBankDeatilsBody">
                                                                <tr id="clientBankDeatilsRow">
                                                                    <td><input class="form-control" type="text" name="clientNameOfBankBranch" /> </td>
                                                                    <td><input class="form-control" type="text" name="clientBankAccountNo" /></td>
                                                                    <td> <input class="form-control" type="text" name="clientBankType" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('clientBankDeatilsBody','clientBankDeatilsRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <h3 class="bg-blue">Details of Property</h3>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="clientPropertyCheckBox">Immovable Property</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="clientPropertyCheckBox" onchange="viewStatusChange(this,'clientPropertyDetailsBox');" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3 table-responsive d-none" id="clientPropertyDetailsBox">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Location</th>
                                                                    <th>Extent</th>
                                                                    <th>Approximate Value</th>
                                                                    <th>Mortgaged</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="clientPropertyTableBody">
                                                                <tr id="clientPropertyTableRow">
                                                                    <td><input class="form-control" type="text" name="clientPropertyLocation" /></td>
                                                                    <td><input class="form-control" type="text" name="clientPropertyExtent" /></td>
                                                                    <td><input class="form-control" type="text" name="clientPropertyValue" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td class="text-center"><input class="form-check-input" type="checkbox" name="clientPropertyMortgaged" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('clientPropertyTableBody','clientPropertyTableRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                        </table>

                                                    </div>

                                                    <h3 class="bg-blue">Morter Vehicles</h3>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="clientMotorVehicleCheckBox">Moter Vehicles</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="clientMotorVehicleCheckBox" onchange="viewStatusChange(this,'clientMotorVehicleDetailsBox');" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3 table-responsive d-none" id="clientMotorVehicleDetailsBox">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Reg.No</th>
                                                                    <th>Make</th>
                                                                    <th>Markert Value</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="clientMotorVehicleTableBody">

                                                                <tr id="clientMotorVehicleTableRow">
                                                                    <th><input class="form-control" type="text" name="clientVehicleRegNo" /></th>
                                                                    <th>
                                                                        <select class="form-select" name="clientVehicleType" id="">
                                                                            <option value="">SELECT</option>
                                                                            <?php
                                                                            $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                            $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                            for ($i = 0; $i < $vehicle_type_num; $i++) {
                                                                                $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                            ?>
                                                                                <option value="<?php echo $vehicle_type_data["id"]; ?>"><?php echo $vehicle_type_data["name"]; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </th>
                                                                    <td><input class="form-control" type="text" name="clientVehicleMarketValue" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('clientMotorVehicleTableBody','clientMotorVehicleTableRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                        </table>

                                                    </div>

                                                    <h3 class="bg-blue">Item Required</h3>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredtype">Type of Equipment</label>
                                                        <select class="form-select" name="clientItemRequiredtype" id="clientItemRequiredtype">
                                                            <option value="">SELECT</option>
                                                            <?php
                                                            $file_type_rs = Database::search("SELECT * FROM `file_type`");
                                                            $file_type_num = $file_type_rs->num_rows;
                                                            for ($i = 0; $i < $file_type_num; $i++) {
                                                                $file_type_data = $file_type_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $file_type_data["id"]; ?>"><?php echo $file_type_data["name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredSupplier">Supplier</label>
                                                        <input class="form-control" type="text" id="clientItemRequiredSupplier" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredModel">Type(Make & Model)</label>
                                                        <input class="form-control" type="text" id="clientItemRequiredModel" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredFaclityAmount">Faclity Amount</label>
                                                        <input class="form-control" type="text" id="clientItemRequiredFaclityAmount" onkeypress="priceValidateKeyPress(event,this);" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredColour">Colour</label>
                                                        <input class="form-control" type="text" id="clientItemRequiredColour" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredLeasePeriod">Lease Period</label>
                                                        <input class="form-control" type="text" id="clientItemRequiredLeasePeriod" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="clientItemRequiredPurposeOfUse">Purpose of Use</label>
                                                        <input class="form-control" type="text" id="clientItemRequiredPurposeOfUse" />
                                                    </div>

                                                    <div class="col-12 p-3">
                                                        <label for="clientOtherDetails">Other Details</label>
                                                        <textarea rows="5" class="form-control" name="" id="clientOtherDetails"></textarea>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button class="btn btn-primary" onclick="saveClientForm('<?php echo $fileNo; ?>');">Save Client</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-white fw-bold bg-danger" id="guarantorFormHeaderButton" type="button" data-bs-toggle="collapse" data-bs-target="#guarantor-form" aria-expanded="false" aria-controls="guarantor-form">
                                            Guarantors Application
                                        </button>
                                    </h2>
                                    <div id="guarantor-form" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="col-12 pb-5">
                                                <div class="row">

                                                    <h1 class="text-center my-3">Guarantors Application</h1>

                                                    <h3 class="bg-blue">Guarantors Statement</h3>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorFullName">Full Name of Guarantor</label>
                                                        <input class="form-control" type="text" id="guarantorFullName" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorNameWithInitial">Name with Initials</label>
                                                        <input class="form-control" type="text" id="guarantorNameWithInitial" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorAddress">Permanent Address</label>
                                                        <input class="form-control" type="text" id="guarantorAddress" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorDOB">Date of Birth</label>
                                                        <input class="form-control" type="text" id="guarantorDOB" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorNIC">NIC No</label>
                                                        <input class="form-control" type="text" id="guarantorNIC" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorTelNo">Tel No</label>
                                                        <input class="form-control" type="tel" id="guarantorTelNo" onkeypress="mobileValidateKeyPress(event,'guarantorTelNo');" maxlength="10" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorMobile">Mobile No</label>
                                                        <input class="form-control" type="tel" id="guarantorMobile" onkeypress="mobileValidateKeyPress(event,'guarantorMobile');" maxlength="10" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorTitle">Title</label>
                                                        <select class="form-select" name="" id="guarantorTitle">
                                                            <option value="0">SELECT</option>
                                                            <?php
                                                            $user_title_rs = Database::search("SELECT * FROM `user_title`");
                                                            $user_title_num = $user_title_rs->num_rows;
                                                            for ($i = 0; $i < $user_title_num; $i++) {
                                                                $user_title_data = $user_title_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $user_title_data["id"]; ?>"><?php echo $user_title_data["name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorNicFrontPhoto">NIC Photo front</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="guarantorNicFrontPhoto" onclick="selectPhoto('guarantorNicFrontPhoto','guarantorNicFrontPhotoImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="guarantorNicFrontPhoto" />
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png" id="guarantorNicFrontPhotoImg" alt="NIC Front Photo" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorNicBackPhoto">NIC Photo back</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="guarantorNicBackPhoto" onclick="selectPhoto('guarantorNicBackPhoto','guarantorNicBackPhotoImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="guarantorNicBackPhoto" />
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png" id="guarantorNicBackPhotoImg" alt="NIC Back Photo">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="guarantorMarrageStatusCheckBox">Marage Status</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="guarantorMarrageStatusCheckBox" onchange="marrageStatusChange(this,'guarantorMarrageDetailsBox');">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3 border rounded-3 shadow mb-3 d-none" id="guarantorMarrageDetailsBox">
                                                        <div class="row">

                                                            <h3 class="bg-blue">Details of Spouse</h3>

                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="guarantorSpouseFullName">Name in Full</label>
                                                                <input class="form-control" type="text" id="guarantorSpouseFullName" />
                                                            </div>
                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="guarantorSpouseNIC">NIC No</label>
                                                                <input class="form-control" type="text" id="guarantorSpouseNIC" />
                                                            </div>
                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="guarantorSpouseTel">Tel No</label>
                                                                <input class="form-control" type="tel" id="guarantorSpouseTel" onkeypress="mobileValidateKeyPress(event,'guarantorSpouseTel');" maxlength="10" />
                                                            </div>
                                                            <div class="col-12 col-md-6 p-3">
                                                                <label for="guarantorSpouseProfession">Profession</label>
                                                                <input class="form-control" type="text" id="guarantorSpouseProfession" />
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <h3 class="bg-blue">Details of Employment</h3>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorEmpName">Name of Employer/Business</label>
                                                        <input class="form-control" type="text" id="guarantorEmpName" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorEmpAddress">Address of Employer/Business</label>
                                                        <input class="form-control" type="text" id="guarantorEmpAddress" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorBusinessRegNo">Business Registration No</label>
                                                        <input class="form-control" type="tel" id="guarantorBusinessRegNo" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="guarantorBusinessNature">Nature of Business</label>
                                                        <input class="form-control" type="text" id="guarantorBusinessNature" />
                                                    </div>

                                                    <h3 class="bg-blue">Details of Personal Income</h3>
                                                    <div class="col-12 p-3 table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th colspan="2">Statement of Income (Monthly)</th>
                                                                <th>Income (Net)(Rs.)</th>
                                                            </tr>
                                                            <tr>
                                                                <th rowspan="3">Source of Income</th>
                                                                <th>Employment/Business</th>
                                                                <td><input class="form-control" type="text" id="guarantorIncomeEmp" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Other</th>
                                                                <td><input class="form-control" type="text" id="guarantorIncomeOther" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Income</th>
                                                                <th id="guarantorTotalIncome">0.00</th>
                                                            </tr>
                                                            <tr>
                                                                <th rowspan="3">Less</th>
                                                                <th>Cost of Living</th>
                                                                <td><input class="form-control" type="text" id="guarantorCostLiving" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Loan repayment</th>
                                                                <td><input class="form-control" type="text" id="guarantorLoanRepayment" min="0" onkeypress="priceValidateKeyPress(event,this);" onkeyup="calGuarantorTotalNetIncome();" /></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Net Income</th>
                                                                <th id="guarantorNetIncome">0.00</th>
                                                            </tr>
                                                        </table>

                                                    </div>

                                                    <h3 class="bg-blue">Credit Facilities Obtained</h3>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="guarantorCreditObtainedCheckBox">Credit Facilities Obtained</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="guarantorCreditObtainedCheckBox" onchange="viewStatusChange(this,'guarantorCreditObtainedDetailsBox');" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 table-responsive d-none" id="guarantorCreditObtainedDetailsBox">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Institute</th>
                                                                    <th>Amount Obtained(Rs.)</th>
                                                                    <th>Present Outstanding(Rs.)</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="guarantorCreditObtainedBody">
                                                                <tr id="guarantorCreditObtainedRow">
                                                                    <td><input class="form-control" type="text" name="guarantorCreditObtainedInstitute" /> </td>
                                                                    <td><input class="form-control" type="text" name="guarantorCreditObtainedAmount" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td><input class="form-control" type="text" name="guarantorCreditObtainedPresentOutstanding" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('guarantorCreditObtainedBody','guarantorCreditObtainedRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <h3 class="bg-blue">Assets</h3>
                                                    <h3 class="">Details Of Bankers</h3>

                                                    <div class="col-12 table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name of Bank & Branch</th>
                                                                    <th>Account No</th>
                                                                    <th>Type of Account</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="guarantorBankDeatilsBody">
                                                                <tr id="guarantorBankDeatilsRow">
                                                                    <td><input class="form-control" type="text" name="guarantorNameOfBankBranch" /> </td>
                                                                    <td><input class="form-control" type="text" name="guarantorBankAccountNo" /></td>
                                                                    <td> <input class="form-control" type="text" name="guarantorBankType" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('guarantorBankDeatilsBody','guarantorBankDeatilsRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <h3 class="bg-blue">Details of Property</h3>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="guarantorPropertyCheckBox">Details of Property</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="guarantorPropertyCheckBox" onchange="viewStatusChange(this,'guarantorPropertyDetailsBox');" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3 table-responsive d-none" id="guarantorPropertyDetailsBox">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="5">Immovable</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Location</th>
                                                                    <th>Extent</th>
                                                                    <th>Approximate Value</th>
                                                                    <th>Mortgaged</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="guarantorPropertyTableBody">
                                                                <tr id="guarantorPropertyTableRow">
                                                                    <td><input class="form-control" type="text" name="guarantorPropertyLocation" /></td>
                                                                    <td><input class="form-control" type="number" name="guarantorPropertyExtent" /></td>
                                                                    <td><input class="form-control" type="text" name="guarantorPropertyValue" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td class="text-center"><input class="form-check-input" type="checkbox" name="guarantorPropertyMortgaged" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('guarantorPropertyTableBody','guarantorPropertyTableRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                        </table>

                                                    </div>

                                                    <h3 class="bg-blue">Morter Vehicles</h3>

                                                    <div class="col-12 p-3">
                                                        <div class="form-check form-switch">
                                                            <label class="form-check-label" for="guarantorMotorVehicleCheckBox">Morter Vehicles</label>
                                                            <input class="form-check-input" type="checkbox" role="switch" id="guarantorMotorVehicleCheckBox" onchange="viewStatusChange(this,'guarantorMotorVehicleDetailsBox');" />
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-3 table-responsive d-none" id="guarantorMotorVehicleDetailsBox">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Reg.No</th>
                                                                    <th>Make</th>
                                                                    <th>Markert Value</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="guarantorMotorVehicleTableBody">

                                                                <tr id="guarantorMotorVehicleTableRow">
                                                                    <th><input class="form-control" type="text" name="guarantorVehicleRegNo" /></th>
                                                                    <th>
                                                                        <select class="form-select" name="guarantorVehicleType" id="">
                                                                            <option value="">SELECT</option>
                                                                            <?php
                                                                            $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                                            $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                                            for ($i = 0; $i < $vehicle_type_num; $i++) {
                                                                                $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                                            ?>
                                                                                <option value="<?php echo $vehicle_type_data["id"]; ?>"><?php echo $vehicle_type_data["name"]; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>

                                                                        </select>
                                                                    </th>
                                                                    <td><input class="form-control" type="text" name="guarantorVehicleMarketValue" onkeypress="priceValidateKeyPress(event,this);" /></td>
                                                                    <td><button class="btn btn-danger d-none" onclick="removeRow(this);"><i class="bi bi-trash"></i></button></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary" onclick="addMoreTrBtn('guarantorMotorVehicleTableBody','guarantorMotorVehicleTableRow');">Add more</button>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                        </table>

                                                    </div>

                                                    <div class="col-12 p-3">
                                                        <label for="guarantorOtherDetails">Other Details</label>
                                                        <textarea rows="5" class="form-control" name="" id="guarantorOtherDetails"></textarea>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end">

                                                        <button class="btn btn-primary" onclick="saveGuarantorForm('<?php echo $fileNo; ?>');">Save Guarantor</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-white fw-bold bg-danger" id="vehicleFormHeaderButton" type="button" data-bs-toggle="collapse" data-bs-target="#vehicle-form" aria-expanded="false" aria-controls="vehicle-form">
                                            Vehicle Form
                                        </button>
                                    </h2>
                                    <div id="vehicle-form" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="col-12 pb-5">
                                                <div class="row">

                                                    <h1 class="text-center my-3">Vehicle Form</h1>
                                                    <h3 class="bg-blue">Mortor Vehicle Inspection Report</h3>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleType">Make</label>
                                                        <select class="form-select" name="" id="vehicleType" onchange="showVehicleTypeTyres();">
                                                            <option value="0">SELECT</option>
                                                            <?php
                                                            $vehicle_type_rs = Database::search("SELECT * FROM `vehicle_type`");
                                                            $vehicle_type_num = $vehicle_type_rs->num_rows;
                                                            for ($i = 0; $i < $vehicle_type_num; $i++) {
                                                                $vehicle_type_data = $vehicle_type_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $vehicle_type_data["id"]; ?>"><?php echo $vehicle_type_data["name"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleProposer">Proposer/Insured</label>
                                                        <input class="form-control" type="text" id="vehicleProposer" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleRegNo">Registration No</label>
                                                        <input class="form-control" type="text" id="vehicleRegNo" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleEngineNo">Engine No</label>
                                                        <input class="form-control" type="text" id="vehicleEngineNo" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleChassisNo">Chassis/Frame No</label>
                                                        <input class="form-control" type="text" id="vehicleChassisNo" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleDateOfInspection">Date of Inspection</label>
                                                        <input class="form-control" type="date" id="vehicleDateOfInspection" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleMeterReading">Meter Reading</label>
                                                        <input class="form-control" type="text" id="vehicleMeterReading" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleModel">Model</label>
                                                        <input class="form-control" type="text" id="vehicleModel" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vahicleValuerName">Valuer's Name</label>
                                                        <input class="form-control" type="text" id="vahicleValuerName" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleEstimateValue">Estimated Value</label>
                                                        <input class="form-control" type="text" id="vehicleEstimateValue" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleManufactureYear">Year of Manufacture</label>
                                                        <input class="form-control" type="number" id="vehicleManufactureYear" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleInspectedAt">Inspected at</label>
                                                        <input class="form-control" type="text" id="vehicleInspectedAt" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicleInsuranceRenewDate">Insurance Renew Date</label>
                                                        <input class="form-control" type="date" id="vehicleInsuranceRenewDate" />
                                                    </div>
                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="vehicLelicenseRenewDate">License Renew Date</label>
                                                        <input class="form-control" type="date" id="vehicLelicenseRenewDate" />
                                                    </div>

                                                    <div class="col-12 p-3">
                                                        <label for="vehicleRBook">Vehicle Book Image</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="vehicleRBook" onclick="selectPhoto('vehicleRBook','vehicleRBookImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="vehicleRBook" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-3 col-md-6" src="resources/add-image.png" id="vehicleRBookImg" alt="NIC Front Photo" />
                                                        </div>
                                                    </div>

                                                    <h3 class="bg-blue">Vehicle Images</h3>

                                                    <div class="col-6 p-3">
                                                        <label for="vehicleFrontImg">Vehicle Front Image</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="vehicleFrontImg" onclick="selectPhoto('vehicleFrontImg','vehicleFrontImgImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="vehicleFrontImg" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-3 col-md-6" src="resources/add-image.png" id="vehicleFrontImgImg" alt="Front Photo" />
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-3">
                                                        <label for="vehicleBackImg">Vehicle Back Image</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="vehicleBackImg" onclick="selectPhoto('vehicleBackImg','vehicleBackImgImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="vehicleBackImg" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-3 col-md-6" src="resources/add-image.png" id="vehicleBackImgImg" alt="Back Photo" />
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-3">
                                                        <label for="vehicleEngineNoImg">Vehicle Engine No Image</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="vehicleEngineNoImg" onclick="selectPhoto('vehicleEngineNoImg','vehicleEngineNoImgImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="vehicleEngineNoImg" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-3 col-md-6" src="resources/add-image.png" id="vehicleEngineNoImgImg" alt="Back Photo" />
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-3">
                                                        <label for="vehicleChassisNoImg">Vehicle Chassis No Image</label>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <label class="btn btn-primary w-100" for="vehicleChassisNoImg" onclick="selectPhoto('vehicleChassisNoImg','vehicleChassisNoImgImg');">Choose a Photo</label>
                                                                <input class="form-control d-none" type="file" accept="img/*" id="vehicleChassisNoImg" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <img class="col-12 offset-md-3 col-md-6" src="resources/add-image.png" id="vehicleChassisNoImgImg" alt="Back Photo" />
                                                        </div>
                                                    </div>

                                                    <h3 class="bg-blue">Factory Fitted Accessories (Please check if they are working)</h3>

                                                    <div class="col-12">

                                                        <?php
                                                        $factory_fitted_accessory_rs = Database::search("SELECT * FROM `factory_fitted_accessory`");
                                                        $factory_fitted_accessory_num = $factory_fitted_accessory_rs->num_rows;
                                                        for ($i = 0; $i < $factory_fitted_accessory_num; $i++) {
                                                            $factory_fitted_accessory_data = $factory_fitted_accessory_rs->fetch_assoc();
                                                        ?>
                                                            <div class="form-check me-5 mb-3 d-inline-flex">
                                                                <input class="form-check-input me-2" type="checkbox" value="<?php echo $factory_fitted_accessory_data["id"]; ?>" id="factoryFittedAccessory<?php echo $factory_fitted_accessory_data["id"]; ?>" name="factoryFittedAccessories" />
                                                                <label class="form-check-label" for="factoryFittedAccessory<?php echo $factory_fitted_accessory_data["id"]; ?>">
                                                                    <?php echo $factory_fitted_accessory_data["name"]; ?>
                                                                </label>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>

                                                        <div class="col-12 col-md-6 p-3">
                                                            <label for="vehicleOtherfactoryFittedAccessory">Other Accessories</label>
                                                            <input class="form-control" type="text" id="vehicleOtherfactoryFittedAccessory" />
                                                        </div>

                                                    </div>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="vehicleDuplicateKey">
                                                                Duplicate Key
                                                            </label>
                                                            <input class="form-check-input me-2" type="checkbox" value="0" id="vehicleDuplicateKey">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6 p-3">
                                                        <label for="address">Type of Body</label>
                                                        <select class="form-select" name="" id="vehicleBodyType">
                                                            <option value="0">SELECT</option>
                                                            <?php
                                                            $vehicleBodyType_rs = Database::search("SELECT * FROM `vehicle_body_type`");
                                                            $vehicleBodyType_num = $vehicleBodyType_rs->num_rows;
                                                            for ($i = 0; $i < $vehicleBodyType_num; $i++) {
                                                                $vehicleBodyType_data = $vehicleBodyType_rs->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $vehicleBodyType_data['id']; ?>"><?php echo $vehicleBodyType_data['name']; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>


                                                    <div class="col-12 p-3 table-responsive">
                                                        <table class="table">
                                                            <tr>
                                                                <th colspan="2">General Apperance of vehicle</th>
                                                                <td>
                                                                    <div class="col-12 d-flex justify-content-between">
                                                                        <?php
                                                                        $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                        $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                        for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                            $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                        ?>
                                                                            <div class="form-check d-flex">
                                                                                <input class="form-check-input me-2" type="radio" name="vehicleGeneralApperanceStatus" id="vehicleGeneralApperanceStatus<?php echo $vehicle_accessory_status_data["id"]; ?>" value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                <label class="form-check-label" for="vehicleGeneralApperanceStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                    <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                </label>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pain Work </th>
                                                                <td>
                                                                    <input class="form-control" placeholder="colour:" type="text" id="vehiclePainWorkColor" />
                                                                </td>
                                                                <td>
                                                                    <div class="col-12 d-flex justify-content-between">
                                                                        <?php
                                                                        $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                        $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                        for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                            $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                        ?>
                                                                            <div class="form-check d-flex">
                                                                                <input class="form-check-input me-2" type="radio" name="vehiclePainWorkStatus" id="vehiclePainWorkStatus<?php echo $vehicle_accessory_status_data["id"]; ?>" value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                <label class="form-check-label" for="vehiclePainWorkStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                    <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                </label>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Upholstery</th>
                                                                <td>
                                                                    <input class="form-control" placeholder="colour:" type="text" id="vehicleUpholsteryColor" />
                                                                </td>
                                                                <td>
                                                                    <div class="col-12 d-flex justify-content-between">
                                                                        <?php
                                                                        $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                        $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                        for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                            $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                        ?>
                                                                            <div class="form-check d-flex">
                                                                                <input class="form-check-input me-2" type="radio" name="vehicleUpholsteryStatus" id="vehicleUpholsteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>" value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                <label class="form-check-label" for="vehicleUpholsteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                    <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                </label>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2">Battery</th>
                                                                <td>
                                                                    <div class="col-12 d-flex justify-content-between">
                                                                        <?php
                                                                        $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                                                                        $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                                                                        for ($i = 0; $i < $vehicle_accessory_status_num; $i++) {
                                                                            $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                                                                        ?>
                                                                            <div class="form-check d-flex">
                                                                                <input class="form-check-input me-2" type="radio" name="vehicleBatteryStatus" id="vehicleBatteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>" value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                <label class="form-check-label" for="vehicleBatteryStatus<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                                                                    <?php echo $vehicle_accessory_status_data["name"]; ?>
                                                                                </label>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tfoot id="vehicleTypeTyresBox">

                                                            </tfoot>

                                                        </table>

                                                        <table class="table">
                                                            <tbody>

                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    <div class="col-12 p-3">
                                                        <label for="vehicleOtherAccessiries">Other Details</label>
                                                        <textarea class="form-control" rows="5" name="" id="vehicleOtherAccessiries"></textarea>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button class="btn btn-primary" onclick="saveVehicleForm('<?php echo $fileNo; ?>');">Save Vehicle</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed text-white fw-bold bg-danger" id="paymentFormHeaderButton" type="button" data-bs-toggle="collapse" data-bs-target="#payment-form" aria-expanded="false" aria-controls="payment-form">
                                            Payment Form
                                        </button>
                                    </h2>
                                    <div id="payment-form" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="col-12 pb-5">
                                                <div class="row">


                                                    <h1 class="text-center">Calculate</h1>

                                                    <div class="col-12 col-md-6 mb-3">


                                                        <label class="form-label" for="amount">Amount</label>
                                                        <input class="form-control" type="number" min="1" id="amount" onchange="installmentCalc();" onkeypress="priceValidateKeyPress(event,this);" onkeyup="installmentCalc();" />
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-3">


                                                        <label class="form-label" for="tenure">Loan Tenure(months)</label>
                                                        <input class="form-control" type="number" min="1" id="tenure" onchange="installmentCalc();" onkeyup="installmentCalc();" />
                                                    </div>

                                                    <div class="col-6 col-md-6 mb-3">

                                                    <?php 
                                                    $presentage_rs = Database::search("SELECT * FROM `payment_anual_presentage`");
                                                    $presentage_data = $presentage_rs->fetch_assoc();
                                                    ?>

                                                        <label class="form-label" for="percentage">Annual Percentage (<?php echo $presentage_data["value"]; ?>%)</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control" aria-describedby="basic-addon2" id="percentage" onchange="installmentCalc();" onkeyup="installmentCalc();" />
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

                                                    <div class="col-12 p-3">
                                                        <label for="paymentOtherDetails">Other Details</label>
                                                        <textarea class="form-control" rows="5" name="" id="paymentOtherDetails"></textarea>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button class="btn btn-primary" onclick="savePaymentForm('<?php echo $fileNo; ?>');">Save Payment</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
        </body>

        </html>

<?php
    } else {
        header("Location: error.php");
    }
} else {
    header("Location: login.php");
}
?>