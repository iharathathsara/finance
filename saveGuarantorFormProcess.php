<?php
session_start();

if (isset($_SESSION["user"])) {

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3" || $_SESSION["user"]["user_type_id"] == "4") {


        require "connection.php";

        $fileNO = $_POST["fileNo"];
        $guarantorFullName = $_POST["guarantorFullName"];
        $guarantorNameWithInitial = $_POST["guarantorNameWithInitial"];
        $guarantorAddress = $_POST["guarantorAddress"];
        $guarantorDOB = $_POST["guarantorDOB"];
        $guarantorNIC = $_POST["guarantorNIC"];
        $guarantorTelNo = $_POST["guarantorTelNo"];
        $guarantorMobile = $_POST["guarantorMobile"];
        $guarantorTitle = $_POST["guarantorTitle"];

        $guarantorMarrageStatusCheckBox = $_POST["guarantorMarrageStatusCheckBox"];
        $guarantorSpouseFullName = $_POST["guarantorSpouseFullName"];
        $guarantorSpouseNIC = $_POST["guarantorSpouseNIC"];
        $guarantorSpouseTel = $_POST["guarantorSpouseTel"];
        $guarantorSpouseProfession = $_POST["guarantorSpouseProfession"];

        $guarantorEmpName = $_POST["guarantorEmpName"];
        $guarantorEmpAddress = $_POST["guarantorEmpAddress"];
        $guarantorBusinessRegNo = $_POST["guarantorBusinessRegNo"];
        $guarantorBusinessNature = $_POST["guarantorBusinessNature"];

        $guarantorIncomeEmp = $_POST["guarantorIncomeEmp"];
        $guarantorIncomeOther = $_POST["guarantorIncomeOther"];
        $guarantorCostLiving = $_POST["guarantorCostLiving"];
        $guarantorLoanRepayment = $_POST["guarantorLoanRepayment"];

        $guarantorCreditObtainedInstitute = $_POST["guarantorCreditObtainedInstitute"];
        $guarantorCreditObtainedAmount = $_POST["guarantorCreditObtainedAmount"];
        $guarantorCreditObtainedPresentOutstanding = $_POST["guarantorCreditObtainedPresentOutstanding"];

        $guarantorNameOfBankBranch = $_POST["guarantorNameOfBankBranch"];
        $guarantorBankAccountNo = $_POST["guarantorBankAccountNo"];
        $guarantorBankType = $_POST["guarantorBankType"];

        $guarantorPropertyLocation = $_POST["guarantorPropertyLocation"];
        $guarantorPropertyExtent = $_POST["guarantorPropertyExtent"];
        $guarantorPropertyValue = $_POST["guarantorPropertyValue"];
        $guarantorPropertyMortgaged = $_POST["guarantorPropertyMortgaged"];

        $guarantorVehicleRegNo = $_POST["guarantorVehicleRegNo"];
        $guarantorVehicleType = $_POST["guarantorVehicleType"];
        $guarantorVehicleMarketValue = $_POST["guarantorVehicleMarketValue"];

        $guarantorCreditObtainedCheckBox = $_POST["guarantorCreditObtainedCheckBox"];
        $guarantorPropertyCheckBox = $_POST["guarantorPropertyCheckBox"];
        $guarantorMotorVehicleCheckBox = $_POST["guarantorMotorVehicleCheckBox"];

        $guarantorOtherDetails = $_POST["guarantorOtherDetails"];

        if (empty($fileNO)) {
            echo "Something Wrong Try Again";
            return;
        } else if (empty($guarantorFullName)) {
            echo "Please Enter Full Name";
            return;
        } else if (empty($guarantorNameWithInitial)) {
            echo "Please Enter Name with Initial";
            return;
        } else if (empty($guarantorAddress)) {
            echo "Please Enter Address";
            return;
        } else if (empty($guarantorDOB)) {
            echo "Please Enter Date of Birth";
            return;
        } else if (empty($guarantorNIC)) {
            echo "Please Enter NIC";
            return;
        } else if (empty($guarantorTelNo)) {
            echo "Please Enter Tel no";
            return;
        } else if (strlen($guarantorTelNo) < 10) {
            echo "Tel no must be 10 numbers";
            return;
        } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $guarantorTelNo)) {
            echo "Please Enter Valid Tel No";
            return;
        } else if (empty($guarantorMobile)) {
            echo "Please Enter Mobile No";
            return;
        } else if (strlen($guarantorMobile) < 10) {
            echo "Tel no must be 10 numbers";
            return;
        } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $guarantorMobile)) {
            echo "Please Enter Valid Tel No";
            return;
        } else if (empty($guarantorTitle)) {
            echo "Please Select Title";
            return;
        } else if (!isset($_FILES["guarantorNicFrontPhoto"])) {
            echo "Please Select NIC Front Photo";
            return;
        } else if (!isset($_FILES["guarantorNicBackPhoto"])) {
            echo "Please Select NIC Back Photo";
            return;
        } else if ($guarantorMarrageStatusCheckBox == "true") {
            if (empty($guarantorSpouseFullName)) {
                echo "Please Enter Spouse Full name";
                return;
            } else if (empty($guarantorSpouseNIC)) {
                echo "Please Enter Spouse NIC";
                return;
            } else if (empty($guarantorSpouseTel)) {
                echo "Please Enter Spouse Tel No";
                return;
            } else if (strlen($guarantorSpouseTel) < 10) {
                echo "Tel no must be 10 numbers";
                return;
            } else if (!preg_match('/^0?[1-9]?[0-9]{0,8}$/', $guarantorSpouseTel)) {
                echo "Please Enter Valid Tel No";
                return;
            } else if (empty($guarantorSpouseProfession)) {
                echo "Please Enter Spouse Profession";
                return;
            }
        }
        if (empty($guarantorEmpName)) {
            echo "Please Enter Employe/Business Name";
            return;
        } else if (empty($guarantorEmpAddress)) {
            echo "Please Enter Employement/Business Address";
            return;
        } else if (empty($guarantorBusinessRegNo)) {
            echo "Please Enter Business Reg.No";
            return;
        } else if (empty($guarantorBusinessNature)) {
            echo "Please Enter Business Nature";
            return;
        } else if (empty($guarantorIncomeEmp)) {
            echo "Please Enter Employee Income";
            return;
        } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorIncomeEmp)) {
            echo "Invalid Employee Income";
            return;
        } else if (!isset($guarantorIncomeOther) || $guarantorIncomeOther === '') {
            echo "Please Enter Other Income";
            return;
        } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorIncomeOther)) {
            echo "Invalid Other Income";
            return;
        } else if (empty($guarantorCostLiving)) {
            echo "Please Enter Living cost";
            return;
        } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorCostLiving)) {
            echo "Invalid Living Cost";
            return;
        } else if (!isset($guarantorLoanRepayment) || $guarantorLoanRepayment === '') {
            echo "Please Enter Loan repayment";
            return;
        } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorLoanRepayment)) {
            echo "Invalid Loan Repayment";
            return;
        } else {
            if ($guarantorCreditObtainedCheckBox == 'true') {
                for ($i = 0; $i < count($guarantorCreditObtainedInstitute); $i++) {
                    if (empty($guarantorCreditObtainedInstitute[$i])) {
                        echo "Please Enter Credit Facilities Obtained Institute";
                        return;
                    } else if (empty($guarantorCreditObtainedAmount[$i])) {
                        echo "Please Enter Credit Facilities Obtained Amount";
                        return;
                    } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorCreditObtainedAmount[$i])) {
                        echo "Invalid Credit Obtained Amount";
                        return;
                    } else if (empty($guarantorCreditObtainedPresentOutstanding[$i])) {
                        echo "Please Enter Credit Facilities Obtained Present Out Standing";
                        return;
                    } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorCreditObtainedPresentOutstanding[$i])) {
                        echo "Invalid Credit Obtained Present Outstanding";
                        return;
                    }
                }
            }


            for ($i = 0; $i < count($guarantorNameOfBankBranch); $i++) {
                if (empty($guarantorNameOfBankBranch[$i])) {
                    echo "Please Enter Name of Bank/Branch";
                    return;
                } else if (empty($guarantorBankAccountNo[$i])) {
                    echo "Please Enter Account No";
                    return;
                } else if (empty($guarantorBankType[$i])) {
                    echo "Please Enter Account Type";
                    return;
                }
            }

            if ($guarantorPropertyCheckBox == 'true') {
                for ($i = 0; $i < count($guarantorPropertyLocation); $i++) {
                    if (empty($guarantorPropertyLocation[$i])) {
                        echo "Please Enter Property Location";
                        return;
                    } else if (empty($guarantorPropertyExtent[$i])) {
                        echo "Please Enter Property Extent";
                        return;
                    } else if (filter_var($guarantorPropertyExtent[$i], FILTER_VALIDATE_INT) === false) {
                        echo "Invalid Property Extent";
                        return;
                    } else if (empty($guarantorPropertyValue[$i])) {
                        echo "Please Enter Property Value";
                        return;
                    } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorPropertyValue[$i])) {
                        echo "Invalid Property Value";
                        return;
                    }
                }
            }

            if ($guarantorMotorVehicleCheckBox == 'true') {
                for ($i = 0; $i < count($guarantorVehicleRegNo); $i++) {
                    if (empty($guarantorVehicleRegNo[$i])) {
                        echo "Please Enter Vehicle Reg.No";
                        return;
                    } else if (empty($guarantorVehicleType[$i])) {
                        echo "Please Select Vahicle Type";
                        return;
                    } else if (empty($guarantorVehicleMarketValue[$i])) {
                        echo "Please Enter Market Value";
                        return;
                    } else if (!preg_match('/^\$?(0|[1-9]\d*)(\.\d{1,2})?$/', $guarantorVehicleMarketValue[$i])) {
                        echo "Invalid Vehicle Market Value";
                        return;
                    }
                }
            }

            $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
            $guarantorNicFrontPhotoPath="resources/add-image.png";
            $guarantorNicBackPhotoPath="resources/add-image.png";
            if (isset($_FILES["guarantorNicFrontPhoto"])) {
                $guarantorNicFrontPhoto = $_FILES["guarantorNicFrontPhoto"];
                $guarantorNicFrontPhoto_ex = $guarantorNicFrontPhoto["type"];
                if (!in_array($guarantorNicFrontPhoto_ex, $allowed_image_extentions)) {
                    echo "Please select a valid NIC front Image.";
                    return;
                } else {
                    $new_guarantorNicFrontPhoto_ex;
                    if ($guarantorNicFrontPhoto_ex == "image/jpg") {
                        $new_guarantorNicFrontPhoto_ex = ".jpg";
                    } else if ($guarantorNicFrontPhoto_ex == "image/jpeg") {
                        $new_guarantorNicFrontPhoto_ex = ".jpeg";
                    } else if ($guarantorNicFrontPhoto_ex == "image/png") {
                        $new_guarantorNicFrontPhoto_ex = ".png";
                    } else if ($guarantorNicFrontPhoto_ex == "image/svg+xml") {
                        $new_guarantorNicFrontPhoto_ex = ".svg";
                    }
                    $guarantorNicFrontPhotoPath = "resources//images//" . uniqid() . $new_guarantorNicFrontPhoto_ex;
                    move_uploaded_file($guarantorNicFrontPhoto["tmp_name"], $guarantorNicFrontPhotoPath);
                }
            }

            if (isset($_FILES["guarantorNicBackPhoto"])) {
                $guarantorNicBackPhoto = $_FILES["guarantorNicBackPhoto"];
                $guarantorNicBackPhoto_ex = $guarantorNicBackPhoto["type"];

                if (!in_array($guarantorNicBackPhoto_ex, $allowed_image_extentions)) {
                    echo "Please select a valid NIC back Image.";
                    return;
                } else {

                    $new_guarantorNicBackPhoto_ex;

                    if ($guarantorNicBackPhoto_ex == "image/jpg") {
                        $new_guarantorNicBackPhoto_ex = ".jpg";
                    } else if ($guarantorNicBackPhoto_ex == "image/jpeg") {
                        $new_guarantorNicBackPhoto_ex = ".jpeg";
                    } else if ($guarantorNicBackPhoto_ex == "image/png") {
                        $new_guarantorNicBackPhoto_ex = ".png";
                    } else if ($guarantorNicBackPhoto_ex == "image/svg+xml") {
                        $new_guarantorNicBackPhoto_ex = ".svg";
                    }
                    $guarantorNicBackPhotoPath = "resources//images//" . uniqid() . $new_guarantorNicBackPhoto_ex;
                    move_uploaded_file($guarantorNicBackPhoto["tmp_name"], $guarantorNicBackPhotoPath);
                }
            }

            $insurance_file_rs = Database::search("SELECT * FROM `insurance_file` WHERE `file_no`=?", [$fileNO], "s");
            $insurance_file_data = $insurance_file_rs->fetch_assoc();
            $insurance_file_id = $insurance_file_data["id"];

            $guarantor_rs = Database::search("SELECT * FROM `guarantor` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
            $guarantor_num = $guarantor_rs->num_rows;

            if ($guarantor_num == 0) {
                Database::iud("INSERT INTO `guarantor` (`insurance_file_id`,`full_name`,`name_with_initial`,`address`,`dob`,`nic`,`tel`,`mobile`,`user_title_id`,`nic_font_img_path`,`nic_back_img_path`,`spouse_full_name`,`spouse_nic`,`spouse_tel`,`spouse_profession`,`business_name`,`business_address`,`business_reg_no`,`business_nature`,`employment_income`,`other_income`,`living_cost`,`loan_repayment`,`other_details`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", [$insurance_file_id, $guarantorFullName, $guarantorNameWithInitial, $guarantorAddress, $guarantorDOB, $guarantorNIC, $guarantorTelNo, $guarantorMobile, $guarantorTitle, $guarantorNicFrontPhotoPath, $guarantorNicBackPhotoPath, $guarantorSpouseFullName, $guarantorSpouseNIC, $guarantorSpouseTel, $guarantorSpouseProfession, $guarantorEmpName, $guarantorEmpAddress, $guarantorBusinessRegNo, $guarantorBusinessNature, $guarantorIncomeEmp, $guarantorIncomeOther, $guarantorCostLiving, $guarantorLoanRepayment, $guarantorOtherDetails], "ssssssssssssssssssssssss");
            } else {
                $guarantor_data = $guarantor_rs->fetch_assoc();
                $guarantor_id = $guarantor_data["id"];

                Database::iud("UPDATE `guarantor` SET `full_name`=?,`name_with_initial`=?,`address`=?,`dob`=?,`nic`=?,`tel`=?,`mobile`=?,`user_title_id`=?,`nic_font_img_path`=?,`nic_back_img_path`=?,`spouse_full_name`=?,`spouse_nic`=?,`spouse_tel`=?,`spouse_profession`=?,`business_name`=?,`business_address`=?,`business_reg_no`=?,`business_nature`=?,`employment_income`=?,`other_income`=?,`living_cost`=?,`loan_repayment`=?,`other_details`=? WHERE `insurance_file_id`=? ;", [$guarantorFullName, $guarantorNameWithInitial, $guarantorAddress, $guarantorDOB, $guarantorNIC, $guarantorTelNo, $guarantorMobile, $guarantorTitle, $guarantorNicFrontPhotoPath, $guarantorNicBackPhotoPath, $guarantorSpouseFullName, $guarantorSpouseNIC, $guarantorSpouseTel, $guarantorSpouseProfession, $guarantorEmpName, $guarantorEmpAddress, $guarantorBusinessRegNo, $guarantorBusinessNature, $guarantorIncomeEmp, $guarantorIncomeOther, $guarantorCostLiving, $guarantorLoanRepayment, $guarantorOtherDetails, $insurance_file_id], "ssssssssssssssssssssssss");

                Database::iud("DELETE FROM `guarantor_creadit_facility` WHERE `guarantor_id`=?;", [$guarantor_id], "s");
                Database::iud("DELETE FROM `guarantor_bank` WHERE `guarantor_id`=?;", [$guarantor_id], "s");
                Database::iud("DELETE FROM `guarantor_property` WHERE `guarantor_id`=?;", [$guarantor_id], "s");
                Database::iud("DELETE FROM `guarantor_vehicle` WHERE `guarantor_id`=?;", [$guarantor_id], "s");
            }

            $new_guarantor_rs = Database::search("SELECT * FROM `guarantor` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
            $new_guarantor_data = $new_guarantor_rs->fetch_assoc();
            $new_guarantor_id = $new_guarantor_data["id"];

            if ($guarantorCreditObtainedCheckBox == 'true') {
                for ($i = 0; $i < count($guarantorCreditObtainedInstitute); $i++) {
                    Database::iud("INSERT INTO `guarantor_creadit_facility` (`institute`,`amount`,`present_outstanding`,`guarantor_id`) VALUES (?,?,?,?)", [$guarantorCreditObtainedInstitute[$i], $guarantorCreditObtainedAmount[$i], $guarantorCreditObtainedPresentOutstanding[$i], $new_guarantor_id], "ssss");
                }
            }



            for ($i = 0; $i < count($guarantorNameOfBankBranch); $i++) {
                Database::iud("INSERT INTO `guarantor_bank` (`name`,`account_no`,`type`,`guarantor_id`) VALUES (?,?,?,?)", [$guarantorNameOfBankBranch[$i], $guarantorBankAccountNo[$i], $guarantorBankType[$i], $new_guarantor_id], "ssss");
            }

            if ($guarantorPropertyCheckBox == 'true') {
                for ($i = 0; $i < count($guarantorPropertyLocation); $i++) {
                    Database::iud("INSERT INTO `guarantor_property` (`location`,`extent`,`approximate_value`,`mortgaged`,`guarantor_id`) VALUES (?,?,?,?,?)", [$guarantorPropertyLocation[$i], $guarantorPropertyExtent[$i], $guarantorPropertyValue[$i], $guarantorPropertyMortgaged[$i], $new_guarantor_id], "sssss");
                }
            }

            if ($guarantorMotorVehicleCheckBox == 'true') {
                for ($i = 0; $i < count($guarantorVehicleRegNo); $i++) {
                    Database::iud("INSERT INTO `guarantor_vehicle` (`reg_no`,`vehicle_type_id`,`market_value`,`guarantor_id`) VALUES (?,?,?,?)", [$guarantorVehicleRegNo[$i], $guarantorVehicleType[$i], $guarantorVehicleMarketValue[$i], $new_guarantor_id], "ssss");
                }
            }

            echo "Success";
        }
    } else {
        echo "Only Directors And Manages can change guarantor form";
    }
} else {
    header("Location: login.php");
}
