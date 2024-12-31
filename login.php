<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <link rel="stylesheet" href="bootstrap.css" />
    
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">

                    <div class="col-12 col-md-6 p-5 border bg-white">

                        <h1 class="text-center mb-3">Log In</h1>
                        <h4 class="">Welcome to Matara Invesment</h4>
                        <input class="form-control mb-3" placeholder="Email" id="email" type="text" />
                        <input class="form-control mb-3" placeholder="Password" id="password" type="password" />
                        <button onclick="signIn();" class="btn btn-success w-100 mb-3">Log In</button>

                    </div>

                </div>
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
            <div class="col-12 position-absolute bg-dark bg-opacity-50 d-none" id="loading">
                <div class="row d-flex justify-content-center align-items-center" style="height: 100vh;">
                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <!-- loading Alert -->


        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="bootstrap.js"></script>
</body>

</html>