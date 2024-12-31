<?php
session_start();

if (isset($_SESSION["user"])) {

    if ($_SESSION["user"]["user_type_id"] == "1" || $_SESSION["user"]["user_type_id"] == "2" || $_SESSION["user"]["user_type_id"] == "3" || $_SESSION["user"]["user_type_id"] == "4") {


        require "connection.php";

        $fileNO = $_POST["fileNo"];
        $vehicleType = $_POST["vehicleType"];
        $vehicleProposer = $_POST["vehicleProposer"];
        $vehicleRegNo = $_POST["vehicleRegNo"];
        $vehicleEngineNo = $_POST["vehicleEngineNo"];
        $vehicleChassisNo = $_POST["vehicleChassisNo"];
        $vehicleDateOfInspection = $_POST["vehicleDateOfInspection"];
        $vehicleMeterReading = $_POST["vehicleMeterReading"];
        $vehicleModel = $_POST["vehicleModel"];
        $vehicleValuerName = $_POST["vahicleValuerName"];
        $vehicleEstimateValue = $_POST["vehicleEstimateValue"];
        $vehicleManufactureYear = $_POST["vehicleManufactureYear"];
        $vehicleInspectedAt = $_POST["vehicleInspectedAt"];
        $vehicleInsuranceRenewDate = $_POST["vehicleInsuranceRenewDate"];
        $vehicLelicenseRenewDate = $_POST["vehicLelicenseRenewDate"];

        $selectedVehiclefactoryFittedAccessories = isset($_POST["selectedVehiclefactoryFittedAccessories"]) ? $_POST["selectedVehiclefactoryFittedAccessories"] : [];

        $vehicleOtherfactoryFittedAccessory = $_POST["vehicleOtherfactoryFittedAccessory"];
        $vehicleDuplicateKey = $_POST["vehicleDuplicateKey"];
        $vehicleBodyType = $_POST["vehicleBodyType"];
        $vehicleGeneralApperanceStatus = $_POST["vehicleGeneralApperanceStatus"];
        $vehiclePainWorkStatus = $_POST["vehiclePainWorkStatus"];
        $vehicleUpholsteryStatus = $_POST["vehicleUpholsteryStatus"];
        $vehicleBatteryStatus = $_POST["vehicleBatteryStatus"];
        $vehicleOtherAccessiries = $_POST["vehicleOtherAccessiries"];
        $vehiclePainWorkColor = $_POST["vehiclePainWorkColor"];
        $vehicleUpholsteryColor = $_POST["vehicleUpholsteryColor"];



        if (empty($fileNO)) {
            echo "Something Wrong Try Again";
            return;
        } else if (empty($vehicleType)) {
            echo "Please Select Vehicle Type";
            return;
        } else if (empty($vehicleProposer)) {
            echo "Please Enter Vehicle Proposer";
            return;
        } else if (empty($vehicleRegNo)) {
            echo "Please Enter Vehicle Registor Number";
            return;
        } else if (empty($vehicleEngineNo)) {
            echo "Please Enter Vehicle Engine Number";
            return;
        } else if (empty($vehicleChassisNo)) {
            echo "Please Enter Vehicle Chassis Number";
            return;
        } else if (empty($vehicleDateOfInspection)) {
            echo "Please Enter Vehicle Date Of Inspection";
            return;
        } else if (empty($vehicleMeterReading)) {
            echo "Please Enter Vehicle Meter Reading";
            return;
        } else if (empty($vehicleModel)) {
            echo "Please Enter Vehicle Model";
            return;
        } else if (empty($vehicleValuerName)) {
            echo "Please Enter Vehicle Valuer Name";
            return;
        } else if (empty($vehicleEstimateValue)) {
            echo "Please Enter Vehicle Estimate Value";
            return;
        } else if (empty($vehicleManufactureYear)) {
            echo "Please Enter Vehicle Manufacture Year";
            return;
        } else if (empty($vehicleInspectedAt)) {
            echo "Please Enter Vehicle Inspected At";
            return;
        } else if (empty($vehicleInsuranceRenewDate)) {
            echo "Please Enter Vehicle Insurance Renew Date";
            return;
        } else if (empty($vehicLelicenseRenewDate)) {
            echo "Please Enter Vehicle License Renew Date";
            return;
        }

        else if (empty($vehicleBodyType)) {
            echo "Please Select Vehicle Body Type";
            return;
        } else if ($vehicleGeneralApperanceStatus == "null") {
            echo "Please Select Vehicle General Apperance Status";
            return;
        } else if (empty($vehiclePainWorkColor)) {
            echo "Please Enter Vehicle Pain Work Color";
            return;
        } else if ($vehiclePainWorkStatus == "null") {
            echo "Please Select Vehicle Pain Work Status";
            return;
        } else if (empty($vehicleUpholsteryColor)) {
            echo "Please Enter Vehicle Upholstery Color";
            return;
        } else if ($vehicleUpholsteryStatus == "null") {
            echo "Please Select Vehicle Upholstery Status";
            return;
        } else if ($vehicleBatteryStatus == "null") {
            echo "Please Select Vehicle Battery Status";
            return;
        } else {

            $vehicleTyreId = $_POST["vehicleTyreId"];
            $vehicleTyreStatus = $_POST["vehicleTyreStatus"];
            for ($i = 0; $i < count($vehicleTyreId); $i++) {
                if ($vehicleTyreStatus[$i] == "null") {
                    echo "Vehicle tyre status";
                    return;
                }
            }

            $insurance_file_rs = Database::search("SELECT * FROM `insurance_file` WHERE `file_no`=?", [$fileNO], "s");
            $insurance_file_data = $insurance_file_rs->fetch_assoc();
            $insurance_file_id = $insurance_file_data["id"];

            $vehicle_rs = Database::search("SELECT * FROM `vehicle` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
            $vehicle_num = $vehicle_rs->num_rows;

            $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

            if (isset($_FILES["vehicleRBookImg"])) {
                $vehicleRBookImg = $_FILES["vehicleRBookImg"];
                $vehicleRBookImgPath;
                $vehicleRBookImg_ex = $vehicleRBookImg["type"];
                if (!in_array($vehicleRBookImg_ex, $allowed_image_extentions)) {
                    echo "Please select a valid Vehicle RBook Image.";
                    return;
                } else {
                    $newVehicleRBookImg_ex;
                    if ($vehicleRBookImg_ex == "image/jpg") {
                        $newVehicleRBookImg_ex = ".jpg";
                    } else if ($vehicleRBookImg_ex == "image/jpeg") {
                        $newVehicleRBookImg_ex = ".jpeg";
                    } else if ($vehicleRBookImg_ex == "image/png") {
                        $newVehicleRBookImg_ex = ".png";
                    } else if ($vehicleRBookImg_ex == "image/svg+xml") {
                        $newVehicleRBookImg_ex = ".svg";
                    }
                    $vehicleRBookImgPath = "resources//images//" . uniqid() . $newVehicleRBookImg_ex;
                    move_uploaded_file($vehicleRBookImg["tmp_name"], $vehicleRBookImgPath);
                }
            }

            if (isset($_FILES["vehicleFrontImg"])) {
                $vehicleFrontImg = $_FILES["vehicleFrontImg"];
                $vehicleFrontImgPath;
                $vehicleFrontImg_ex = $vehicleFrontImg["type"];
                if (!in_array($vehicleFrontImg_ex, $allowed_image_extentions)) {
                    echo "Please select a valid Vehicle RBook Image.";
                    return;
                } else {
                    $newvehicleFrontImg_ex;
                    if ($vehicleFrontImg_ex == "image/jpg") {
                        $newvehicleFrontImg_ex = ".jpg";
                    } else if ($vehicleFrontImg_ex == "image/jpeg") {
                        $newvehicleFrontImg_ex = ".jpeg";
                    } else if ($vehicleFrontImg_ex == "image/png") {
                        $newvehicleFrontImg_ex = ".png";
                    } else if ($vehicleFrontImg_ex == "image/svg+xml") {
                        $newvehicleFrontImg_ex = ".svg";
                    }
                    $vehicleFrontImgPath = "resources//images//" . uniqid() . $newvehicleFrontImg_ex;
                    move_uploaded_file($vehicleFrontImg["tmp_name"], $vehicleFrontImgPath);
                }
            }

            if (isset($_FILES["vehicleBackImg"])) {
                $vehicleBackImg = $_FILES["vehicleBackImg"];
                $vehicleBackImgPath;
                $vehicleBackImg_ex = $vehicleBackImg["type"];
                if (!in_array($vehicleBackImg_ex, $allowed_image_extentions)) {
                    echo "Please select a valid Vehicle RBook Image.";
                    return;
                } else {
                    $newvehicleBackImg_ex;
                    if ($vehicleBackImg_ex == "image/jpg") {
                        $newvehicleBackImg_ex = ".jpg";
                    } else if ($vehicleBackImg_ex == "image/jpeg") {
                        $newvehicleBackImg_ex = ".jpeg";
                    } else if ($vehicleBackImg_ex == "image/png") {
                        $newvehicleBackImg_ex = ".png";
                    } else if ($vehicleBackImg_ex == "image/svg+xml") {
                        $newvehicleBackImg_ex = ".svg";
                    }
                    $vehicleBackImgPath = "resources//images//" . uniqid() . $newvehicleBackImg_ex;
                    move_uploaded_file($vehicleBackImg["tmp_name"], $vehicleBackImgPath);
                }
            }

            if (isset($_FILES["vehicleEngineNoImg"])) {
                $vehicleEngineNoImg = $_FILES["vehicleEngineNoImg"];
                $vehicleEngineNoImgPath;
                $vehicleEngineNoImg_ex = $vehicleEngineNoImg["type"];
                if (!in_array($vehicleEngineNoImg_ex, $allowed_image_extentions)) {
                    echo "Please select a valid Vehicle RBook Image.";
                    return;
                } else {
                    $newvehicleEngineNoImg_ex;
                    if ($vehicleEngineNoImg_ex == "image/jpg") {
                        $newvehicleEngineNoImg_ex = ".jpg";
                    } else if ($vehicleEngineNoImg_ex == "image/jpeg") {
                        $newvehicleEngineNoImg_ex = ".jpeg";
                    } else if ($vehicleEngineNoImg_ex == "image/png") {
                        $newvehicleEngineNoImg_ex = ".png";
                    } else if ($vehicleEngineNoImg_ex == "image/svg+xml") {
                        $newvehicleEngineNoImg_ex = ".svg";
                    }
                    $vehicleEngineNoImgPath = "resources//images//" . uniqid() . $newvehicleEngineNoImg_ex;
                    move_uploaded_file($vehicleEngineNoImg["tmp_name"], $vehicleEngineNoImgPath);
                }
            }

            if (isset($_FILES["vehicleChassisNoImg"])) {
                $vehicleChassisNoImg = $_FILES["vehicleChassisNoImg"];
                $vehicleChassisNoImgPath;
                $vehicleChassisNoImg_ex = $vehicleChassisNoImg["type"];
                if (!in_array($vehicleChassisNoImg_ex, $allowed_image_extentions)) {
                    echo "Please select a valid Vehicle RBook Image.";
                    return;
                } else {
                    $newvehicleChassisNoImg_ex;
                    if ($vehicleChassisNoImg_ex == "image/jpg") {
                        $newvehicleChassisNoImg_ex = ".jpg";
                    } else if ($vehicleChassisNoImg_ex == "image/jpeg") {
                        $newvehicleChassisNoImg_ex = ".jpeg";
                    } else if ($vehicleChassisNoImg_ex == "image/png") {
                        $newvehicleChassisNoImg_ex = ".png";
                    } else if ($vehicleChassisNoImg_ex == "image/svg+xml") {
                        $newvehicleChassisNoImg_ex = ".svg";
                    }
                    $vehicleChassisNoImgPath = "resources//images//" . uniqid() . $newvehicleChassisNoImg_ex;
                    move_uploaded_file($vehicleChassisNoImg["tmp_name"], $vehicleChassisNoImgPath);
                }
            }

            if ($vehicle_num == 0) {
                Database::iud("INSERT INTO `vehicle` (`insurance_file_id`,`vehicle_type_id`,`proposer`,`reg_no`,`engine_no`,`chassis_no`,`dateOfInspection`,`meter_reading`,`model`,`valuers_name`,`enstimate_value`,`manufacture_year`,`inspect_at`,`insurance_renew_date`,`license_renew_date`,`vehicle_rb_img_path`,`vehicle_front_img_path`,`vehicle_back_img_path`,`vehicle_engine_img_path`,`vehicle_chassis_img_path`,`other_accessories`,`duplicate_key`,`vehicle_body_type_id`,`generalApperanceStatus`,`painWorkStatus`,`painWorkColor`,`upholsteryStatus`,`upholsteryColor`,`batteryStatus`,`other_details`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);", [$insurance_file_id, $vehicleType, $vehicleProposer, $vehicleRegNo, $vehicleEngineNo, $vehicleChassisNo, $vehicleDateOfInspection, $vehicleMeterReading, $vehicleModel, $vehicleValuerName, $vehicleEstimateValue, $vehicleManufactureYear, $vehicleInspectedAt, $vehicleInsuranceRenewDate, $vehicLelicenseRenewDate, $vehicleRBookImgPath, $vehicleFrontImgPath, $vehicleBackImgPath, $vehicleEngineNoImgPath, $vehicleChassisNoImgPath, $vehicleOtherfactoryFittedAccessory, $vehicleDuplicateKey, $vehicleBodyType, $vehicleGeneralApperanceStatus, $vehiclePainWorkStatus, $vehiclePainWorkColor, $vehicleUpholsteryStatus, $vehicleUpholsteryColor, $vehicleBatteryStatus, $vehicleOtherAccessiries], "ssssssssssssssssssssssssssssss");
            } else {
                $vehicle_data = $vehicle_rs->fetch_assoc();
                $vehicle_id = $vehicle_data['id'];

                if (isset($_FILES["vehicleRBookImg"])) {
                    Database::iud("UPDATE `vehicle` SET `vehicle_rb_img_path`=? WHERE `id`=?;", [$vehicleRBookImgPath, $vehicle_id], "ss");
                }
                if (isset($_FILES["vehicleFrontImg"])) {
                    Database::iud("UPDATE `vehicle` SET `vehicle_front_img_path`=? WHERE `id`=?;", [$vehicleFrontImgPath, $vehicle_id], "ss");
                }
                if (isset($_FILES["vehicleBackImg"])) {
                    Database::iud("UPDATE `vehicle` SET `vehicle_back_img_path`=? WHERE `id`=?;", [$vehicleBackImgPath, $vehicle_id], "ss");
                }
                if (isset($_FILES["vehicleEngineNoImg"])) {
                    Database::iud("UPDATE `vehicle` SET `vehicle_engine_img_path`=? WHERE `id`=?;", [$vehicleEngineNoImgPath, $vehicle_id], "ss");
                }
                if (isset($_FILES["vehicleChassisNoImg"])) {
                    Database::iud("UPDATE `vehicle` SET `vehicle_chassis_img_path`=? WHERE `id`=?;", [$vehicleChassisNoImgPath, $vehicle_id], "ss");
                }

                Database::iud("UPDATE `vehicle` SET `vehicle_type_id`=?,`proposer`=?,`reg_no`=?,`engine_no`=?,`chassis_no`=?,`dateOfInspection`=?,`meter_reading`=?,`model`=?,`valuers_name`=?,`enstimate_value`=?,`manufacture_year`=?,`inspect_at`=?,`insurance_renew_date`=?,`license_renew_date`=?,`other_accessories`=?,`duplicate_key`=?,`vehicle_body_type_id`=?,`generalApperanceStatus`=?,`painWorkStatus`=?,`painWorkColor`=?,`upholsteryStatus`=?,`upholsteryColor`=?,`batteryStatus`=?,`other_details`=? WHERE `insurance_file_id`=?;", [$vehicleType, $vehicleProposer, $vehicleRegNo, $vehicleEngineNo, $vehicleChassisNo, $vehicleDateOfInspection, $vehicleMeterReading, $vehicleModel, $vehicleValuerName, $vehicleEstimateValue, $vehicleManufactureYear, $vehicleInspectedAt, $vehicleInsuranceRenewDate, $vehicLelicenseRenewDate, $vehicleOtherfactoryFittedAccessory, $vehicleDuplicateKey, $vehicleBodyType, $vehicleGeneralApperanceStatus, $vehiclePainWorkStatus, $vehiclePainWorkColor, $vehicleUpholsteryStatus, $vehicleUpholsteryColor, $vehicleBatteryStatus, $vehicleOtherAccessiries, $insurance_file_id,], "sssssssssssssssssssssssss");

                Database::iud("DELETE FROM `vehicle_has_factory_fitted_accessory` WHERE `vehicle_id`=?;", [$vehicle_id], "s");
                Database::iud("DELETE FROM `vehicle_tyre_status` WHERE `vehicle_id`=?;", [$vehicle_id], "s");
            }

            $newVehicle_rs = Database::search("SELECT * FROM `vehicle` WHERE `insurance_file_id`=?", [$insurance_file_id], "s");
            $newVehicle_data = $newVehicle_rs->fetch_assoc();
            $newVehicle_id = $newVehicle_data["id"];


            for ($i = 0; $i < count($selectedVehiclefactoryFittedAccessories); $i++) {
                Database::iud("INSERT INTO `vehicle_has_factory_fitted_accessory` (`vehicle_id`,`factory_fitted_accessory_id`) VALUES (?,?)", [$vehicle_id, $selectedVehiclefactoryFittedAccessories[$i]], "ss");
            }

            for ($i = 0; $i < count($vehicleTyreId); $i++) {
                Database::iud("INSERT INTO `vehicle_tyre_status` (`vehicle_id`,`vehicle_tyre_id`,`vehicle_accessory_status_id`) VALUES (?,?,?)", [$vehicle_id, $vehicleTyreId[$i], $vehicleTyreStatus[$i]], "sss");
            }

            echo "Updated";
        }
    } else {
        echo "You are not authorized to change the client's information.";
    }
} else {
    header("Location: login.php");
}
