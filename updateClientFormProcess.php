<?php

session_start();

if (isset($_SESSION["user"])) {

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3" || $_SESSION["user"]["user_type_id"] == "4") {


        require "connection.php";

        $fileNO = $_POST["fileNo"];
        $clientFullName = $_POST["clientFullName"];
        $clientNameWithInitial = $_POST["clientNameWithInitial"];
        $clientAddress = $_POST["clientAddress"];
        $clientDOB = $_POST["clientDOB"];
        $clientNIC = $_POST["clientNIC"];
        $clientTel = $_POST["clientTel"];
        $clientMobile = $_POST["clientMobile"];
        $clientTitle = $_POST["clientTitle"];

        $clientMarrageStatusCheckBox = $_POST["clientMarrageStatusCheckBox"];
        $clientSpouseFullName = $_POST["clientSpouseFullName"];
        $clientSpouseNIC = $_POST["clientSpouseNIC"];
        $clientSpouseTel = $_POST["clientSpouseTel"];
        $clientSpouseProfession = $_POST["clientSpouseProfession"];

        $clientEmpName = $_POST["clientEmpName"];
        $clientEmpAddress = $_POST["clientEmpAddress"];
        $clientBusinessRegNo = $_POST["clientBusinessRegNo"];
        $clientBusinessNature = $_POST["clientBusinessNature"];

        $clentIncomeEmp = $_POST["clentIncomeEmp"];
        $clentIncomeOther = $_POST["clentIncomeOther"];
        $clientTotalIncome = $_POST["clientTotalIncome"];
        $clientCostLiving = $_POST["clientCostLiving"];
        $clientLoanRepayment = $_POST["clientLoanRepayment"];
        $clientNetIncome = $_POST["clientNetIncome"];

        $clientPropertyCheckBox = $_POST["clientPropertyCheckBox"];
        $clientCreditObtainedCheckBox = $_POST["clientCreditObtainedCheckBox"];
        $clientCreditObtainedInstitute = $_POST["clientCreditObtainedInstitute"];
        $clientCreditObtainedAmount = $_POST["clientCreditObtainedAmount"];
        $clientCreditObtainedPresentOutstanding = $_POST["clientCreditObtainedPresentOutstanding"];

        $clientNameOfBankBranch = $_POST["clientNameOfBankBranch"];
        $clientBankAccountNo = $_POST["clientBankAccountNo"];
        $clientBankType = $_POST["clientBankType"];

        $clientPropertyLocation = $_POST["clientPropertyLocation"];
        $clientPropertyExtent = $_POST["clientPropertyExtent"];
        $clientPropertyValue = $_POST["clientPropertyValue"];
        $clientPropertyMortgaged = $_POST["clientPropertyMortgaged"];

        $clientMotorVehicleCheckBox = $_POST["clientMotorVehicleCheckBox"];
        $clientVehicleRegNo = $_POST["clientVehicleRegNo"];
        $clientVehicleType = $_POST["clientVehicleType"];
        $clientVehicleMarketValue = $_POST["clientVehicleMarketValue"];

        $clientItemRequiredtype = $_POST["clientItemRequiredtype"];
        $clientItemRequiredSupplier = $_POST["clientItemRequiredSupplier"];
        $clientItemRequiredModel = $_POST["clientItemRequiredModel"];
        $clientItemRequiredFaclityAmount = $_POST["clientItemRequiredFaclityAmount"];
        $clientItemRequiredColour = $_POST["clientItemRequiredColour"];
        $clientItemRequiredLeasePeriod = $_POST["clientItemRequiredLeasePeriod"];
        $clientItemRequiredPurposeOfUse = $_POST["clientItemRequiredPurposeOfUse"];
        $clientOtherDetails = $_POST["clientOtherDetails"];

        if (empty($fileNO)) {
            echo "Something Wrong Try Again";
            return;
        } else if (empty($clientFullName)) {
            echo "Please Enter Full Name";
            return;
        } else if (empty($clientNameWithInitial)) {
            echo "Please Enter Name with Initial";
            return;
        } else if (empty($clientAddress)) {
            echo "Please Enter Address";
            return;
        } else if (empty($clientDOB)) {
            echo "Please Enter Date of Birth";
            return;
        } else if (empty($clientNIC)) {
            echo "Please Enter NIC";
            return;
        } else if (empty($clientTel)) {
            echo "Please Enter Tel no";
            return;
        } else if (strlen($clientTel) < 10) {
            echo "Tel no must be 10 numbers";
            return;
        } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $clientTel)) {
            echo "Please Enter Valid Tel No";
            return;
        } else if (empty($clientMobile)) {
            echo "Please Enter Mobile No";
            return;
        } else if (strlen($clientMobile) < 10) {
            echo "Tel no must be 10 numbers";
            return;
        } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $clientMobile)) {
            echo "Please Enter Valid Tel No";
            return;
        } else if (empty($clientTitle)) {
            echo "Please Select Title";
            return;
        }
 
        else if ($clientMarrageStatusCheckBox == "true") {
            if (empty($clientSpouseFullName)) {
                echo "Please Enter Spouse Full name";
                return;
            } else if (empty($clientSpouseNIC)) {
                echo "Please Enter Spouse NIC";
                return;
            } else if (empty($clientSpouseTel)) {
                echo "Please Enter Spouse Tel No";
                return;
            } else if (strlen($clientSpouseTel) < 10) {
                echo "Tel no must be 10 numbers";
                return;
            } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $clientSpouseTel)) {
                echo "Please Enter Valid Tel No";
                return;
            } else if (empty($clientSpouseProfession)) {
                echo "Please Enter Spouse Profession";
                return;
            }
        }
        if (empty($clientEmpName)) {
            echo "Please Enter Employe/Business Name";
            return;
        } else if (empty($clientEmpAddress)) {
            echo "Please Enter Employement/Business Address";
            return;
        } else if (empty($clientBusinessRegNo)) {
            echo "Please Enter Business Reg.No";
            return;
        } else if (empty($clientBusinessNature)) {
            echo "Please Enter Business Nature";
            return;
        } else if (empty($clentIncomeEmp)) {
            echo "Please Enter Employee Income";
            return;
        } else if (!isset($clentIncomeOther) || $clentIncomeOther === '') {
            echo "Please Enter Other Income";
            return;
        }

        else if (empty($clientCostLiving)) {
            echo "Please Enter Living cost";
            return;
        }
 
        else if (!isset($clientLoanRepayment) || $clientLoanRepayment === '') {
            echo "Please Enter Loan Repayment";
            return;
        }

        else {
            if ($clientCreditObtainedCheckBox == 'true') {
                for ($i = 0; $i < count($clientCreditObtainedInstitute); $i++) {
                    if (empty($clientCreditObtainedInstitute[$i])) {
                        echo "Please Enter Credit Facilities Obtained Institute";
                        return;
                    } else if (empty($clientCreditObtainedAmount[$i])) {
                        echo "Please Enter Credit Facilities Obtained Amount";
                        return;
                    } else if (!is_numeric($clientCreditObtainedAmount[$i])) {
                        echo "Invalid Credit Facilities Obtained Amount";
                        return;
                    } else if (empty($clientCreditObtainedPresentOutstanding[$i])) {
                        echo "Please Enter Credit Facilities Obtained Present Out Standing";
                        return;
                    } else if (!is_numeric($clientCreditObtainedPresentOutstanding[$i])) {
                        echo "Invalid Credit Facilities Obtained Present Out Standing";
                        return;
                    }
                }
            }


            for ($i = 0; $i < count($clientNameOfBankBranch); $i++) {
                if (empty($clientNameOfBankBranch[$i])) {
                    echo "Please Enter Name of Bank/Branch";
                    return;
                } else if (empty($clientBankAccountNo[$i])) {
                    echo "Please Enter Account No";
                    return;
                } else if (empty($clientBankType[$i])) {
                    echo "Please Enter Account Type";
                    return;
                }
            }

            if ($clientPropertyCheckBox == "true") {
                for ($i = 0; $i < count($clientPropertyLocation); $i++) {
                    if (empty($clientPropertyLocation[$i])) {
                        echo "Please Enter Property Location";
                        return;
                    } else if (empty($clientPropertyExtent[$i])) {
                        echo "Please Enter Property Extent";
                        return;
                    } else if (empty($clientPropertyValue[$i])) {
                        echo "Please Enter Property Value";
                        return;
                    }
                }
            }



            if ($clientMotorVehicleCheckBox == 'true') {
                for ($i = 0; $i < count($clientVehicleRegNo); $i++) {
                    if (empty($clientVehicleRegNo[$i])) {
                        echo "Please Enter Vehicle Reg.No";
                        return;
                    } else if (empty($clientVehicleType[$i])) {
                        echo "Please Select Vahicle Type";
                        return;
                    } else if (empty($clientVehicleMarketValue[$i])) {
                        echo "Please Enter Market Value";
                        return;
                    } else if (!is_numeric($clientVehicleMarketValue[$i])) {
                        echo "Invalid Market Value";
                        return;
                    }
                }
            }


            if (empty($clientItemRequiredtype)) {
                echo "Please Select Type of Equipment";
                return;
            } else if (empty($clientItemRequiredSupplier)) {
                echo "Please Enter Suppllier";
                return;
            } else if (empty($clientItemRequiredModel)) {
                echo "Please Enter Type(Make & Model)";
                return;
            } else if (empty($clientItemRequiredFaclityAmount)) {
                echo "Please Enter Faclity Amount";
                return;
            } else if (empty($clientItemRequiredColour)) {
                echo "Please Enter Colour";
                return;
            } else if (empty($clientItemRequiredLeasePeriod)) {
                echo "Please Enter Lease Period";
                return;
            } else if (empty($clientItemRequiredPurposeOfUse)) {
                echo "Please Enter Purpose of Use";
                return;
            } else {

                $insurance_file_rs = Database::search("SELECT * FROM `insurance_file` WHERE `file_no`=?", [$fileNO], "s");
                $insurance_file_data = $insurance_file_rs->fetch_assoc();
                $insurance_file_id = $insurance_file_data["id"];

                $client_rs = Database::search("SELECT * FROM `client` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
                $client_num = $client_rs->num_rows;

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

                $clientNicFrontPhotoPath;
                if (isset($_FILES["clientNicFrontPhoto"])) {
                    $clientNicFrontPhoto = $_FILES["clientNicFrontPhoto"];

                    $clientNicFrontPhoto_ex = $clientNicFrontPhoto["type"];
                    if (!in_array($clientNicFrontPhoto_ex, $allowed_image_extentions)) {
                        echo "Please select a valid NIC front Image.";
                        return;
                    } else {
                        $new_clientNicFrontPhoto_ex;
                        if ($clientNicFrontPhoto_ex == "image/jpg") {
                            $new_clientNicFrontPhoto_ex = ".jpg";
                        } else if ($clientNicFrontPhoto_ex == "image/jpeg") {
                            $new_clientNicFrontPhoto_ex = ".jpeg";
                        } else if ($clientNicFrontPhoto_ex == "image/png") {
                            $new_clientNicFrontPhoto_ex = ".png";
                        } else if ($clientNicFrontPhoto_ex == "image/svg+xml") {
                            $new_clientNicFrontPhoto_ex = ".svg";
                        }
                        $clientNicFrontPhotoPath = "resources//images//" . uniqid() . $new_clientNicFrontPhoto_ex;
                        move_uploaded_file($clientNicFrontPhoto["tmp_name"], $clientNicFrontPhotoPath);
                    }
                }
                $clientNicBackPhotoPath;
                if (isset($_FILES["clientNicBackPhoto"])) {
                    $clientNicBackPhoto = $_FILES["clientNicBackPhoto"];

                    $clientNicBackPhoto_ex = $clientNicBackPhoto["type"];
                    if (!in_array($clientNicBackPhoto_ex, $allowed_image_extentions)) {
                        echo "Please select a valid NIC back Image.";
                        return;
                    } else {

                        $new_clientNicBackPhoto_ex;


                        if ($clientNicBackPhoto_ex == "image/jpg") {
                            $new_clientNicBackPhoto_ex = ".jpg";
                        } else if ($clientNicBackPhoto_ex == "image/jpeg") {
                            $new_clientNicBackPhoto_ex = ".jpeg";
                        } else if ($clientNicBackPhoto_ex == "image/png") {
                            $new_clientNicBackPhoto_ex = ".png";
                        } else if ($clientNicBackPhoto_ex == "image/svg+xml") {
                            $new_clientNicBackPhoto_ex = ".svg";
                        }

                        $clientNicBackPhotoPath = "resources//images//" . uniqid() . $new_clientNicBackPhoto_ex;

                        move_uploaded_file($clientNicBackPhoto["tmp_name"], $clientNicBackPhotoPath);
                    }
                }

                if ($client_num == 0) {

                    if (!isset($_FILES["clientNicFrontPhoto"])) {
                        echo "Please Select NIC Front Photo";
                        return;
                    } else if (!isset($_FILES["clientNicBackPhoto"])) {
                        echo "Please Select NIC Back Photo";
                        return;
                    }else{
                        Database::iud("INSERT INTO `client` (`insurance_file_id`,`full_name`,`name_with_initial`,`address`,`dob`,`nic`,`tel`,`mobile`,`user_title_id`,`nic_font_img_path`,`nic_back_img_path`,`spouse_full_name`,`spouse_nic`,`spouse_tel`,`spouse_profession`,`business_name`,`business_address`,`business_reg_no`,`business_nature`,`employment_income`,`other_income`,`living_cost`,`loan_repayment`,`equipment_type_id`,`supplier`,`required_item_type`,`required_item_facility_amount`,`requied_item_color`,`required_item_lease_period`,`purpose_of_use`,`other_details`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", [$insurance_file_id, $clientFullName, $clientNameWithInitial, $clientAddress, $clientDOB, $clientNIC, $clientTel, $clientMobile, $clientTitle, $clientNicFrontPhotoPath, $clientNicBackPhotoPath, $clientSpouseFullName, $clientSpouseNIC, $clientSpouseTel, $clientSpouseProfession, $clientEmpName, $clientEmpAddress, $clientBusinessRegNo, $clientBusinessNature, $clentIncomeEmp,  $clentIncomeOther, $clientCostLiving, $clientLoanRepayment, $clientItemRequiredtype, $clientItemRequiredSupplier, $clientItemRequiredModel, $clientItemRequiredFaclityAmount, $clientItemRequiredColour, $clientItemRequiredLeasePeriod, $clientItemRequiredPurposeOfUse, $clientOtherDetails], "sssssssssssssssssssssssssssssss");
                    }

                } else {
                    $client_data = $client_rs->fetch_assoc();
                    $client_id = $client_data["id"];

                    if (isset($_FILES["clientNicFrontPhoto"])) {
                        Database::iud("UPDATE `client` SET `nic_font_img_path`=? WHERE `id`=?;", [$clientNicFrontPhotoPath, $client_id], "ss");
                    }
                    if (isset($_FILES["clientNicBackPhoto"])) {
                        Database::iud("UPDATE `client` SET `nic_back_img_path`=? WHERE `id`=?;", [$clientNicBackPhotoPath, $client_id], "ss");
                    }

                    Database::iud("UPDATE `client` SET `full_name`=?,`name_with_initial`=?,`address`=?,`dob`=?,`nic`=?,`tel`=?,`mobile`=?,`user_title_id`=?,`spouse_full_name`=?,`spouse_nic`=?,`spouse_tel`=?,`spouse_profession`=?,`business_name`=?,`business_address`=?,`business_reg_no`=?,`business_nature`=?,`employment_income`=?,`other_income`=?,`living_cost`=?,`loan_repayment`=?,`equipment_type_id`=?,`supplier`=?,`required_item_type`=?,`required_item_facility_amount`=?,`requied_item_color`=?,`required_item_lease_period`=?,`purpose_of_use`=?, `other_details`=? WHERE `insurance_file_id`=?;", [$clientFullName, $clientNameWithInitial, $clientAddress, $clientDOB, $clientNIC, $clientTel, $clientMobile, $clientTitle, $clientSpouseFullName, $clientSpouseNIC, $clientSpouseTel, $clientSpouseProfession, $clientEmpName, $clientEmpAddress, $clientBusinessRegNo, $clientBusinessNature, $clentIncomeEmp,  $clentIncomeOther, $clientCostLiving, $clientLoanRepayment, $clientItemRequiredtype, $clientItemRequiredSupplier, $clientItemRequiredModel, $clientItemRequiredFaclityAmount, $clientItemRequiredColour, $clientItemRequiredLeasePeriod, $clientItemRequiredPurposeOfUse, $clientOtherDetails, $insurance_file_id], "sssssssssssssssssssssssssssss");

                    Database::iud("DELETE FROM `client_creadit_facility` WHERE `client_id`=?;", [$client_id], "s");
                    Database::iud("DELETE FROM `client_bank` WHERE `client_id`=?;", [$client_id], "s");
                    Database::iud("DELETE FROM `client_property` WHERE `client_id`=?;", [$client_id], "s");
                    Database::iud("DELETE FROM `client_vehicle` WHERE `client_id`=?;", [$client_id], "s");
                }

                $new_client_rs = Database::search("SELECT * FROM `client` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
                $new_client_data = $new_client_rs->fetch_assoc();
                $new_client_id = $new_client_data["id"];

                if ($clientCreditObtainedCheckBox == 'true') {
                    for ($i = 0; $i < count($clientCreditObtainedInstitute); $i++) {
                        Database::iud("INSERT INTO `client_creadit_facility` (`institute`,`amount`,`present_outstanding`,`client_id`) VALUES (?,?,?,?)", [$clientCreditObtainedInstitute[$i], $clientCreditObtainedAmount[$i], $clientCreditObtainedPresentOutstanding[$i], $new_client_id], "ssss");
                    }
                }

                for ($i = 0; $i < count($clientNameOfBankBranch); $i++) {
                    Database::iud("INSERT INTO `client_bank` (`name`,`account_no`,`type`,`client_id`) VALUES (?,?,?,?)", [$clientNameOfBankBranch[$i], $clientBankAccountNo[$i], $clientBankType[$i], $new_client_id], "ssss");
                }

                if ($clientPropertyCheckBox == "true") {
                    for ($i = 0; $i < count($clientPropertyLocation); $i++) {
                        Database::iud("INSERT INTO `client_property` (`location`,`extent`,`approximate_value`,`mortgaged`,`client_id`) VALUES (?,?,?,?,?)", [$clientPropertyLocation[$i], $clientPropertyExtent[$i], $clientPropertyValue[$i], $clientPropertyMortgaged[$i], $new_client_id], "sssss");
                    }
                }


                if ($clientMotorVehicleCheckBox == 'true') {
                    for ($i = 0; $i < count($clientVehicleRegNo); $i++) {
                        Database::iud("INSERT INTO `client_vehicle` (`reg_no`,`vehicle_type_id`,`market_value`,`client_id`) VALUES (?,?,?,?)", [$clientVehicleRegNo[$i], $clientVehicleType[$i], $clientVehicleMarketValue[$i], $new_client_id], "ssss");
                    }
                }

                echo "Updated";
            }
        }
    } else {
        echo "Only Directors And Manages can save client form";
    }
} else {
    header("Location: login.php");
}
