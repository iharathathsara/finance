<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    if (isset($_POST["vehicleType"])) {
        $vehicleType = $_POST["vehicleType"];
        if (!empty($vehicleType)) {

            $vehicleTypeHasTyre_rs = Database::search("SELECT * FROM `vehicle_type_has_tyre` INNER JOIN `vehicle_tyre` ON `vehicle_type_has_tyre`.`vehicle_tyre_id`=`vehicle_tyre`.`id` WHERE `vehicle_type_has_tyre`.`vehicle_type_id`=?", [$vehicleType], "s");

            $vehicleTypeHasTyre_num = $vehicleTypeHasTyre_rs->num_rows;
            for ($i = 0; $i < $vehicleTypeHasTyre_num; $i++) {
                $vehicleTypeHasTyre_data = $vehicleTypeHasTyre_rs->fetch_assoc();

?>
                <tr>
                    <th colspan="2"><?php echo $vehicleTypeHasTyre_data["name"]; ?> <input class="d-none" name="vehicleTyreId" type="text" value="<?php echo $vehicleTypeHasTyre_data["vehicle_tyre_id"] ?>" /> </th>
                    <td>
                        <div class="col-12 d-flex justify-content-between">
                            <?php
                            $vehicle_accessory_status_rs = Database::search("SELECT * FROM `vehicle_accessory_status`");
                            $vehicle_accessory_status_num = $vehicle_accessory_status_rs->num_rows;

                            for ($j = 0; $j < $vehicle_accessory_status_num; $j++) {
                                $vehicle_accessory_status_data = $vehicle_accessory_status_rs->fetch_assoc();
                            ?>
                                <div class="form-check d-flex">
                                    <input class="form-check-input me-2" type="radio" name="<?php echo $vehicleTypeHasTyre_data["vehicle_tyre_id"] ?>" id="vehicleTyreStatus<?php echo $vehicleTypeHasTyre_data["vehicle_tyre_id"].$vehicle_accessory_status_data["id"]; ?>" value="<?php echo $vehicle_accessory_status_data["id"]; ?>">
                                    <label class="form-check-label" for="vehicleTyreStatus<?php echo $vehicleTypeHasTyre_data["vehicle_tyre_id"].$vehicle_accessory_status_data["id"]; ?>">
                                        <?php echo $vehicle_accessory_status_data["name"]; ?>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
<?php

            }
        }
    }
} else {
    header("Location: login.php");
}
