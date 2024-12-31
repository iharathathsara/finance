<div class="col-12 d-flex justify-content-between align-items-center p-2 bg-dark">
    <h2 class="text-white" onclick="window.location='index.php';" style="cursor: pointer;">Matara Invesment</h2>
    <h5 class="d-none d-lg-block text-white"><?php echo $_SESSION["user"]["name_with_initial"]; ?></h5>
    <ul class="list-unstyled d-flex m-0 gap-3">
        <li><button class="btn btn-primary" onclick="window.location='my-profile.php'">My Profile</button></li>
        <li><button class="btn btn-danger" onclick="logOut();">Log Out</button></li>
    </ul>
</div>

<!-- Success Alert -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="successAlertBox">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-12 ">
                    <div class="row  justify-content-center">
                        <img class="col-6" src="resources/success_icon.png" alt="success icon">
                        <p class="text-center fs-3 fw-bold" id="successAlertText"></p>
                        <button type="button" class="col-3 btn btn-outline-success" id="successAlertOkButton" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Success Alert -->

<!-- warning Alert -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="warningAlertBox">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-12 ">
                    <div class="row  justify-content-center">
                        <img class="col-6" src="resources/warning_icon.png" alt="warning icon">
                        <p class="text-center fs-3 fw-bold" id="warningAlertText"></p>
                        <button type="button" class="col-3 btn btn-warning" id="warningAlertOkButton" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- warning Alert -->

<!-- loading Alert -->

<div class="col-12 position-fixed bg-dark bg-opacity-50 d-none" id="loading" style="height: 100vh; width: 100vw; z-index: 999;">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<!-- loading Alert -->