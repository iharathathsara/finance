<?php
session_start();

if (isset($_SESSION["user"])) {

    require "connection.php";

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventory</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <!-- header -->
                <?php
                require "header.php";
                ?>
                <!-- header -->

                <div class="col-12 p-3">
                    <div class="row">

                        <div class="col-12 mb-3">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#inventryItem">
                                Add new item to inventory
                            </button>

                        </div>

                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th class="text-center">Images</th>
                                        <?php
                                        if ($_SESSION["user"]["user_type_id"] == "1") {
                                            ?>
                                            <th>Action</th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $inventry_rs = Database::search("SELECT * FROM `inventory`");
                                    $inventry_num = $inventry_rs->num_rows;
                                    for ($i = 0; $i < $inventry_num; $i++) {
                                        $inventry_data = $inventry_rs->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td><?php echo $inventry_data["title"]; ?></td>
                                            <td><?php echo $inventry_data["desc"]; ?></td>
                                            <td class="text-center">
                                                <img src="<?php echo $inventry_data["img1"]; ?>" width="100px" alt="">
                                                <img src="<?php echo $inventry_data["img2"]; ?>" width="100px" alt="">
                                            </td>
                                            <?php
                                        if ($_SESSION["user"]["user_type_id"] == "1") {
                                            ?>
                                            <td><button class="btn btn-danger" onclick="removeInventoryItem(<?php echo $inventry_data['id'] ?>);"><i class="bi bi-trash-fill"></i> Remove</button></td>
                                            <?php
                                        }
                                        ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- MODEL -->
                <div class="modal fade" id="inventryItem" tabindex="-1" aria-labelledby="inventryItemLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="inventryItemLabel">New Inventory</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12">
                                    <div class="row">

                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label" for="itemTitle">Item Title</label>
                                            <input class="form-control" type="text" id="itemTitle" />
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label" for="itemDescription">Item Description</label>
                                            <input class="form-control" type="text" id="itemDescription" />
                                        </div>

                                        <div class="col-12 col-md-6 p-3">
                                            <label for="itemImg1">Item Image 1</label>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label class="btn btn-primary w-100" for="itemImg1"
                                                        onclick="selectPhoto('itemImg1','itemImg1Img');">Choose
                                                        a Photo</label>
                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                        id="itemImg1" />
                                                </div>

                                            </div>
                                            <div class="row">
                                                <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png"
                                                    id="itemImg1Img" alt="Item Image 1" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 p-3">
                                            <label for="itemImg2">Item Image 2</label>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label class="btn btn-primary w-100" for="itemImg2"
                                                        onclick="selectPhoto('itemImg2','itemImg2Img');">Choose
                                                        a Photo</label>
                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                        id="itemImg2" />
                                                </div>

                                            </div>
                                            <div class="row">
                                                <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png"
                                                    id="itemImg2Img" alt="Item Image 2" />
                                            </div>
                                        </div>
                                        <!-- <div class="col-12 col-md-6 p-3">
                                            <label for="itemImg3">Item Image 3</label>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label class="btn btn-primary w-100" for="itemImg3"
                                                        onclick="selectPhoto('itemImg3','itemImg3Img');">Choose
                                                        a Photo</label>
                                                    <input class="form-control d-none" type="file" accept="img/*"
                                                        id="itemImg3" />
                                                </div>

                                            </div>
                                            <div class="row">
                                                <img class="col-12 offset-md-1 col-md-10" src="resources/add-image.png"
                                                    id="itemImg3Img" alt="Item Image 3" />
                                            </div>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="saveItemInventory();">Save
                                    Item</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODEL -->

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