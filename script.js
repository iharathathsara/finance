function selectPhoto(fileId, imageId) {
  var file = document.getElementById(fileId);
  var view = document.getElementById(imageId);

  file.onchange = function () {
    var file1 = this.files[0];
    var url1 = window.URL.createObjectURL(file1);
    view.src = url1;
  };
}

function addMoreRowBtn(containerId, rowId) {
  var container = document.getElementById(containerId);
  var row = document.getElementById(rowId).innerHTML;

  var newRow = document.createElement("div");
  newRow.className = "row";

  newRow.innerHTML = row;
  container.appendChild(newRow);
}

function addMoreTrBtn(containerId, rowId) {
  var container = document.getElementById(containerId);
  var row = document.getElementById(rowId).innerHTML;

  var newRow = document.createElement("tr");

  newRow.innerHTML = row;
  newRow.querySelector(".btn-danger").classList.remove("d-none");
  container.appendChild(newRow);
}

function removeRow(button) {
  var row = button.closest("tr");
  row.remove();
}

function clientMarrageStatusChange() {
  var clientMarrageStatusCheckBox = document.getElementById(
    "clientMarrageStatusCheckBox"
  ).checked;
  var clientMarrageDetailsBox = document.getElementById(
    "clientMarrageDetailsBox"
  );
  if (clientMarrageStatusCheckBox) {
    clientMarrageDetailsBox.classList.remove("d-none");
  } else {
    clientMarrageDetailsBox.classList.add("d-none");
  }
}

function marrageStatusChange(marrageStatusCheckBox, MarrageDetailsBoxId) {
  var marrageStatus = marrageStatusCheckBox.checked;
  var marrageDetailsBox = document.getElementById(MarrageDetailsBoxId);

  if (marrageStatus) {
    marrageDetailsBox.classList.remove("d-none");
  } else {
    marrageDetailsBox.classList.add("d-none");
  }
}

function viewStatusChange(statusCheckBox, detailsBoxId) {
  var status = statusCheckBox.checked;
  var detailsBox = document.getElementById(detailsBoxId);

  if (status) {
    detailsBox.classList.remove("d-none");
  } else {
    detailsBox.classList.add("d-none");
  }
}

function signIn() {
  document.getElementById("loading").classList.remove("d-none");
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;

  const f = new FormData();
  f.append("email", email);
  f.append("password", password);

  fetch("signInProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location = "index.php";
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      loading.hide();
      alert(error);
    });
}

function logOut() {
  document.getElementById("loading").classList.remove("d-none");
  fetch("signOutProcess.php", {
    method: "GET",
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location = "login.php";
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function createNewFile() {
  document.getElementById("loading").classList.remove("d-none");

  var newFileNo = document.getElementById("newFileNo").value;
  var newFileType = document.getElementById("newFileType").value;

  const f = new FormData();
  f.append("newFileNo", newFileNo);
  f.append("newFileType", newFileType);

  fetch("addNewFileProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location = "add-file-details.php?fileNo=" + newFileNo;
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function mobileValidateKeyPress(event, id) {
  const keyChar = String.fromCharCode(event.which);
  const phoneInput = document.getElementById(id);
  const mobile = phoneInput.value;
  const text = mobile + keyChar;

  // Allow only digits
  if (!/^\d$/.test(keyChar)) {
    event.preventDefault();
  } else if (text.length === 1) {
    if (text !== "0") {
      event.preventDefault();
    }
  } else if (text.length === 2) {
    if (!/^0[1-9]$/.test(text)) {
      event.preventDefault();
    }
  } else if (text.length <= 10) {
    if (!/^0[1-9][0-9]+$/.test(text)) {
      event.preventDefault();
    }
  } else {
    event.preventDefault();
  }
}

function priceValidateKeyPress(event, priceInput) {
  const keyChar = String.fromCharCode(event.which);
  const price = priceInput.value;

  // Allow only digits and a single decimal point
  if (!/[\d.]/.test(keyChar)) {
    event.preventDefault();
    return;
  }

  // Prevent multiple decimal points
  if (keyChar === "." && price.includes(".")) {
    event.preventDefault();
    return;
  }

  // Validate based on the specified rules
  if (price.length === 0 && keyChar === ".") {
    // Prevent entering a decimal point as the first character
    event.preventDefault();
    return;
  }

  if (price.startsWith("0")) {
    // If the first character is '0', the second must be '.'
    if (price.length > 1 && price[1] !== ".") {
      event.preventDefault();
      return;
    }

    // Allow only two digits after the decimal point if it starts with '0.'
    if (/^0\.\d{3}$/.test(price + keyChar)) {
      event.preventDefault();
      return;
    }
  } else {
    // If it doesn't start with '0', allow any number of digits and up to two decimal places
    if (/\.\d{3}$/.test(price + keyChar)) {
      event.preventDefault();
      return;
    }
  }
}

function calClientTotalNetIncome() {
  var clentIncomeEmp =
    parseFloat(document.getElementById("clentIncomeEmp").value) || 0;
  var clentIncomeOther =
    parseFloat(document.getElementById("clentIncomeOther").value) || 0;
  var clientCostLiving =
    parseFloat(document.getElementById("clientCostLiving").value) || 0;
  var clientLoanRepayment =
    parseFloat(document.getElementById("clientLoanRepayment").value) || 0;

  // Calculate total income and net income
  var clientTotalIncome = clentIncomeEmp + clentIncomeOther;
  var clientNetIncome =
    clientTotalIncome - clientCostLiving - clientLoanRepayment;

  // Update the result input fields
  document.getElementById("clientTotalIncome").innerText = clientTotalIncome;
  document.getElementById("clientNetIncome").innerText = clientNetIncome;
}

function calGuarantorTotalNetIncome() {
  var guarantorIncomeEmp =
    parseFloat(document.getElementById("guarantorIncomeEmp").value) || 0;
  var guarantorIncomeOther =
    parseFloat(document.getElementById("guarantorIncomeOther").value) || 0;
  var guarantorCostLiving =
    parseFloat(document.getElementById("guarantorCostLiving").value) || 0;
  var guarantorLoanRepayment =
    parseFloat(document.getElementById("guarantorLoanRepayment").value) || 0;

  // Calculate total income and net income
  var guarantorTotalIncome = guarantorIncomeEmp + guarantorIncomeOther;
  var guarantorNetIncome =
    guarantorTotalIncome - guarantorCostLiving - guarantorLoanRepayment;

  // Update the result input fields
  document.getElementById("guarantorTotalIncome").innerText =
    guarantorTotalIncome;
  document.getElementById("guarantorNetIncome").innerText = guarantorNetIncome;
}

function saveClientForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var clientFullName = document.getElementById("clientFullName").value;
  var clientNameWithInitial = document.getElementById(
    "clientNameWithInitial"
  ).value;
  var clientAddress = document.getElementById("clientAddress").value;
  var clientDOB = document.getElementById("clientDOB").value;
  var clientNIC = document.getElementById("clientNIC").value;
  var clientTel = document.getElementById("clientTel").value;
  var clientMobile = document.getElementById("clientMobile").value;
  var clientTitle = document.getElementById("clientTitle").value;
  var clientNicFrontPhoto = document.getElementById("clientNicFrontPhoto")
    .files[0];
  var clientNicBackPhoto =
    document.getElementById("clientNicBackPhoto").files[0];

  var clientMarrageStatusCheckBox = document.getElementById(
    "clientMarrageStatusCheckBox"
  ).checked;
  var clientSpouseFullName = document.getElementById(
    "clientSpouseFullName"
  ).value;
  var clientSpouseNIC = document.getElementById("clientSpouseNIC").value;
  var clientSpouseTel = document.getElementById("clientSpouseTel").value;
  var clientSpouseProfession = document.getElementById(
    "clientSpouseProfession"
  ).value;

  var clientEmpName = document.getElementById("clientEmpName").value;
  var clientEmpAddress = document.getElementById("clientEmpAddress").value;
  var clientBusinessRegNo = document.getElementById(
    "clientBusinessRegNo"
  ).value;
  var clientBusinessNature = document.getElementById(
    "clientBusinessNature"
  ).value;

  var clentIncomeEmp = document.getElementById("clentIncomeEmp").value;

  var clentIncomeOther = document.getElementById("clentIncomeOther").value;
  var clientTotalIncome = document.getElementById("clientTotalIncome").value;
  var clientCostLiving = document.getElementById("clientCostLiving").value;
  var clientLoanRepayment = document.getElementById(
    "clientLoanRepayment"
  ).value;
  var clientNetIncome = document.getElementById("clientNetIncome").value;

  var clientCreditObtainedCheckBox = document.getElementById(
    "clientCreditObtainedCheckBox"
  ).checked;

  var clientMotorVehicleCheckBox = document.getElementById(
    "clientMotorVehicleCheckBox"
  ).checked;
  var clientPropertyCheckBox = document.getElementById(
    "clientPropertyCheckBox"
  ).checked;

  var form = new FormData();
  form.append("fileNo", fileNo);
  form.append("clientFullName", clientFullName);
  form.append("clientNameWithInitial", clientNameWithInitial);
  form.append("clientAddress", clientAddress);
  form.append("clientDOB", clientDOB);
  form.append("clientNIC", clientNIC);
  form.append("clientTel", clientTel);
  form.append("clientMobile", clientMobile);
  form.append("clientTitle", clientTitle);
  form.append("clientNicFrontPhoto", clientNicFrontPhoto);
  form.append("clientNicBackPhoto", clientNicBackPhoto);

  form.append("clientMarrageStatusCheckBox", clientMarrageStatusCheckBox);
  form.append("clientSpouseFullName", clientSpouseFullName);
  form.append("clientSpouseNIC", clientSpouseNIC);
  form.append("clientSpouseTel", clientSpouseTel);
  form.append("clientSpouseProfession", clientSpouseProfession);

  form.append("clientEmpName", clientEmpName);
  form.append("clientEmpAddress", clientEmpAddress);
  form.append("clientBusinessRegNo", clientBusinessRegNo);
  form.append("clientBusinessNature", clientBusinessNature);

  form.append("clentIncomeEmp", clentIncomeEmp);
  form.append("clentIncomeOther", clentIncomeOther);
  form.append("clientTotalIncome", clientTotalIncome);
  form.append("clientCostLiving", clientCostLiving);
  form.append("clientLoanRepayment", clientLoanRepayment);
  form.append("clientNetIncome", clientNetIncome);

  form.append("clientCreditObtainedCheckBox", clientCreditObtainedCheckBox);
  form.append("clientMotorVehicleCheckBox", clientMotorVehicleCheckBox);
  form.append("clientPropertyCheckBox", clientPropertyCheckBox);

  // clientCreditObtainedBody
  var clientCreditObtainedBody = document.getElementById(
    "clientCreditObtainedBody"
  );
  var clientCreditObtainedBodyRows = clientCreditObtainedBody.rows;

  for (var i = 0; i < clientCreditObtainedBodyRows.length; i++) {
    var clientCreditObtainedInstitute = clientCreditObtainedBodyRows[
      i
    ].querySelector('input[name="clientCreditObtainedInstitute"]').value;
    var clientCreditObtainedAmount = clientCreditObtainedBodyRows[
      i
    ].querySelector('input[name="clientCreditObtainedAmount"]').value;
    var clientCreditObtainedPresentOutstanding = clientCreditObtainedBodyRows[
      i
    ].querySelector(
      'input[name="clientCreditObtainedPresentOutstanding"]'
    ).value;

    form.append(
      "clientCreditObtainedInstitute[]",
      clientCreditObtainedInstitute
    );
    form.append("clientCreditObtainedAmount[]", clientCreditObtainedAmount);
    form.append(
      "clientCreditObtainedPresentOutstanding[]",
      clientCreditObtainedPresentOutstanding
    );
  }
  // clientCreditObtainedBody

  // clientBankDeatilsBody
  var clientBankDeatilsBody = document.getElementById("clientBankDeatilsBody");
  var clientBankDeatilsBodyRows = clientBankDeatilsBody.rows;

  for (var i = 0; i < clientBankDeatilsBodyRows.length; i++) {
    var clientNameOfBankBranch = clientBankDeatilsBodyRows[i].querySelector(
      'input[name="clientNameOfBankBranch"]'
    ).value;
    var clientBankAccountNo = clientBankDeatilsBodyRows[i].querySelector(
      'input[name="clientBankAccountNo"]'
    ).value;
    var clientBankType = clientBankDeatilsBodyRows[i].querySelector(
      'input[name="clientBankType"]'
    ).value;

    form.append("clientNameOfBankBranch[]", clientNameOfBankBranch);
    form.append("clientBankAccountNo[]", clientBankAccountNo);
    form.append("clientBankType[]", clientBankType);
  }

  // clientBankDeatilsBody

  // clientPropertyTableBody
  var clientPropertyTableBody = document.getElementById(
    "clientPropertyTableBody"
  );
  var clientPropertyTableBodyRow = clientPropertyTableBody.rows;
  for (var i = 0; i < clientPropertyTableBodyRow.length; i++) {
    var clientPropertyLocation = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyLocation"]'
    ).value;
    var clientPropertyExtent = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyExtent"]'
    ).value;
    var clientPropertyValue = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyValue"]'
    ).value;
    var clientPropertyMortgaged = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyMortgaged"]'
    ).checked;

    form.append("clientPropertyLocation[]", clientPropertyLocation);
    form.append("clientPropertyExtent[]", clientPropertyExtent);
    form.append("clientPropertyValue[]", clientPropertyValue);
    form.append("clientPropertyMortgaged[]", clientPropertyMortgaged);
  }

  // clientPropertyTableBody

  // clientMotorVehicleTableBody

  var clientMotorVehicleTableBody = document.getElementById(
    "clientMotorVehicleTableBody"
  );
  var clientMotorVehicleTableBodyRow = clientMotorVehicleTableBody.rows;

  for (var i = 0; i < clientMotorVehicleTableBodyRow.length; i++) {
    var clientVehicleRegNo = clientMotorVehicleTableBodyRow[i].querySelector(
      'input[name="clientVehicleRegNo"]'
    ).value;
    var clientVehicleType = clientMotorVehicleTableBodyRow[i].querySelector(
      'select[name="clientVehicleType"]'
    ).value;
    var clientVehicleMarketValue = clientMotorVehicleTableBodyRow[
      i
    ].querySelector('input[name="clientVehicleMarketValue"]').value;

    form.append("clientVehicleRegNo[]", clientVehicleRegNo);
    form.append("clientVehicleType[]", clientVehicleType);
    form.append("clientVehicleMarketValue[]", clientVehicleMarketValue);
  }

  // clientMotorVehicleTableBody

  var clientItemRequiredtype = document.getElementById(
    "clientItemRequiredtype"
  ).value;
  var clientItemRequiredSupplier = document.getElementById(
    "clientItemRequiredSupplier"
  ).value;
  var clientItemRequiredModel = document.getElementById(
    "clientItemRequiredModel"
  ).value;
  var clientItemRequiredFaclityAmount = document.getElementById(
    "clientItemRequiredFaclityAmount"
  ).value;
  var clientItemRequiredColour = document.getElementById(
    "clientItemRequiredColour"
  ).value;
  var clientItemRequiredLeasePeriod = document.getElementById(
    "clientItemRequiredLeasePeriod"
  ).value;
  var clientItemRequiredPurposeOfUse = document.getElementById(
    "clientItemRequiredPurposeOfUse"
  ).value;
  var clientOtherDetails = document.getElementById("clientOtherDetails").value;

  form.append("clientItemRequiredtype", clientItemRequiredtype);
  form.append("clientItemRequiredSupplier", clientItemRequiredSupplier);
  form.append("clientItemRequiredModel", clientItemRequiredModel);
  form.append(
    "clientItemRequiredFaclityAmount",
    clientItemRequiredFaclityAmount
  );
  form.append("clientItemRequiredColour", clientItemRequiredColour);
  form.append("clientItemRequiredLeasePeriod", clientItemRequiredLeasePeriod);
  form.append("clientItemRequiredPurposeOfUse", clientItemRequiredPurposeOfUse);
  form.append("clientOtherDetails", clientOtherDetails);

  fetch("saveClientFormProcess.php", {
    method: "POST",
    body: form,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Something Wrong Try Again") {
        window.location = "add-file.php";
      } else if (data == "Success") {
        document
          .getElementById("clientFormHeaderButton")
          .classList.remove("bg-danger");
        document
          .getElementById("clientFormHeaderButton")
          .classList.add("bg-success");

        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function saveGuarantorForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var guarantorFullName = document.getElementById("guarantorFullName").value;
  var guarantorNameWithInitial = document.getElementById(
    "guarantorNameWithInitial"
  ).value;
  var guarantorAddress = document.getElementById("guarantorAddress").value;
  var guarantorDOB = document.getElementById("guarantorDOB").value;
  var guarantorNIC = document.getElementById("guarantorNIC").value;
  var guarantorTelNo = document.getElementById("guarantorTelNo").value;
  var guarantorMobile = document.getElementById("guarantorMobile").value;
  var guarantorTitle = document.getElementById("guarantorTitle").value;
  var guarantorNicFrontPhoto = document.getElementById("guarantorNicFrontPhoto")
    .files[0];
  var guarantorNicBackPhoto = document.getElementById("guarantorNicBackPhoto")
    .files[0];

  var guarantorMarrageStatusCheckBox = document.getElementById(
    "guarantorMarrageStatusCheckBox"
  ).checked;
  var guarantorSpouseFullName = document.getElementById(
    "guarantorSpouseFullName"
  ).value;
  var guarantorSpouseNIC = document.getElementById("guarantorSpouseNIC").value;
  var guarantorSpouseTel = document.getElementById("guarantorSpouseTel").value;
  var guarantorSpouseProfession = document.getElementById(
    "guarantorSpouseProfession"
  ).value;

  var guarantorEmpName = document.getElementById("guarantorEmpName").value;
  var guarantorEmpAddress = document.getElementById(
    "guarantorEmpAddress"
  ).value;
  var guarantorBusinessRegNo = document.getElementById(
    "guarantorBusinessRegNo"
  ).value;
  var guarantorBusinessNature = document.getElementById(
    "guarantorBusinessNature"
  ).value;

  var guarantorIncomeEmp = document.getElementById("guarantorIncomeEmp").value;

  var guarantorIncomeOther = document.getElementById(
    "guarantorIncomeOther"
  ).value;
  var guarantorCostLiving = document.getElementById(
    "guarantorCostLiving"
  ).value;
  var guarantorLoanRepayment = document.getElementById(
    "guarantorLoanRepayment"
  ).value;

  var guarantorCreditObtainedCheckBox = document.getElementById(
    "guarantorCreditObtainedCheckBox"
  ).checked;
  var guarantorPropertyCheckBox = document.getElementById(
    "guarantorPropertyCheckBox"
  ).checked;
  var guarantorMotorVehicleCheckBox = document.getElementById(
    "guarantorMotorVehicleCheckBox"
  ).checked;

  var guarantorOtherDetails = document.getElementById(
    "guarantorOtherDetails"
  ).value;

  var form = new FormData();
  form.append("fileNo", fileNo);
  form.append("guarantorFullName", guarantorFullName);
  form.append("guarantorNameWithInitial", guarantorNameWithInitial);
  form.append("guarantorAddress", guarantorAddress);
  form.append("guarantorDOB", guarantorDOB);
  form.append("guarantorNIC", guarantorNIC);
  form.append("guarantorTelNo", guarantorTelNo);
  form.append("guarantorMobile", guarantorMobile);
  form.append("guarantorTitle", guarantorTitle);
  form.append("guarantorNicFrontPhoto", guarantorNicFrontPhoto);
  form.append("guarantorNicBackPhoto", guarantorNicBackPhoto);

  form.append("guarantorMarrageStatusCheckBox", guarantorMarrageStatusCheckBox);
  form.append("guarantorSpouseFullName", guarantorSpouseFullName);
  form.append("guarantorSpouseNIC", guarantorSpouseNIC);
  form.append("guarantorSpouseTel", guarantorSpouseTel);
  form.append("guarantorSpouseProfession", guarantorSpouseProfession);

  form.append("guarantorEmpName", guarantorEmpName);
  form.append("guarantorEmpAddress", guarantorEmpAddress);
  form.append("guarantorBusinessRegNo", guarantorBusinessRegNo);
  form.append("guarantorBusinessNature", guarantorBusinessNature);

  form.append("guarantorIncomeEmp", guarantorIncomeEmp);
  form.append("guarantorIncomeOther", guarantorIncomeOther);
  form.append("guarantorCostLiving", guarantorCostLiving);
  form.append("guarantorLoanRepayment", guarantorLoanRepayment);

  form.append(
    "guarantorCreditObtainedCheckBox",
    guarantorCreditObtainedCheckBox
  );
  form.append("guarantorPropertyCheckBox", guarantorPropertyCheckBox);
  form.append("guarantorMotorVehicleCheckBox", guarantorMotorVehicleCheckBox);

  form.append("guarantorOtherDetails", guarantorOtherDetails);

  // clientCreditObtainedBody
  var guarantorCreditObtainedBody = document.getElementById(
    "guarantorCreditObtainedBody"
  );
  var guarantorCreditObtainedBodyRows = guarantorCreditObtainedBody.rows;

  for (var i = 0; i < guarantorCreditObtainedBodyRows.length; i++) {
    var guarantorCreditObtainedInstitute = guarantorCreditObtainedBodyRows[
      i
    ].querySelector('input[name="guarantorCreditObtainedInstitute"]').value;
    var guarantorCreditObtainedAmount = guarantorCreditObtainedBodyRows[
      i
    ].querySelector('input[name="guarantorCreditObtainedAmount"]').value;
    var guarantorCreditObtainedPresentOutstanding =
      guarantorCreditObtainedBodyRows[i].querySelector(
        'input[name="guarantorCreditObtainedPresentOutstanding"]'
      ).value;

    form.append(
      "guarantorCreditObtainedInstitute[]",
      guarantorCreditObtainedInstitute
    );
    form.append(
      "guarantorCreditObtainedAmount[]",
      guarantorCreditObtainedAmount
    );
    form.append(
      "guarantorCreditObtainedPresentOutstanding[]",
      guarantorCreditObtainedPresentOutstanding
    );
  }
  // clientCreditObtainedBody

  // clientBankDeatilsBody
  var guarantorBankDeatilsBody = document.getElementById(
    "guarantorBankDeatilsBody"
  );
  var guarantorBankDeatilsBodyRows = guarantorBankDeatilsBody.rows;

  for (var i = 0; i < guarantorBankDeatilsBodyRows.length; i++) {
    var guarantorNameOfBankBranch = guarantorBankDeatilsBodyRows[
      i
    ].querySelector('input[name="guarantorNameOfBankBranch"]').value;
    var guarantorBankAccountNo = guarantorBankDeatilsBodyRows[i].querySelector(
      'input[name="guarantorBankAccountNo"]'
    ).value;
    var guarantorBankType = guarantorBankDeatilsBodyRows[i].querySelector(
      'input[name="guarantorBankType"]'
    ).value;

    form.append("guarantorNameOfBankBranch[]", guarantorNameOfBankBranch);
    form.append("guarantorBankAccountNo[]", guarantorBankAccountNo);
    form.append("guarantorBankType[]", guarantorBankType);
  }

  // clientBankDeatilsBody

  // clientPropertyTableBody
  var guarantorPropertyTableBody = document.getElementById(
    "guarantorPropertyTableBody"
  );
  var guarantorPropertyTableBodyRow = guarantorPropertyTableBody.rows;
  for (var i = 0; i < guarantorPropertyTableBodyRow.length; i++) {
    var guarantorPropertyLocation = guarantorPropertyTableBodyRow[
      i
    ].querySelector('input[name="guarantorPropertyLocation"]').value;
    var guarantorPropertyExtent = guarantorPropertyTableBodyRow[
      i
    ].querySelector('input[name="guarantorPropertyExtent"]').value;
    var guarantorPropertyValue = guarantorPropertyTableBodyRow[i].querySelector(
      'input[name="guarantorPropertyValue"]'
    ).value;
    var guarantorPropertyMortgaged = guarantorPropertyTableBodyRow[
      i
    ].querySelector('input[name="guarantorPropertyMortgaged"]').checked;

    form.append("guarantorPropertyLocation[]", guarantorPropertyLocation);
    form.append("guarantorPropertyExtent[]", guarantorPropertyExtent);
    form.append("guarantorPropertyValue[]", guarantorPropertyValue);
    form.append("guarantorPropertyMortgaged[]", guarantorPropertyMortgaged);
  }

  // clientPropertyTableBody

  // clientMotorVehicleTableBody

  var guarantorMotorVehicleTableBody = document.getElementById(
    "guarantorMotorVehicleTableBody"
  );
  var guarantorMotorVehicleTableBodyRow = guarantorMotorVehicleTableBody.rows;

  for (var i = 0; i < guarantorMotorVehicleTableBodyRow.length; i++) {
    var guarantorVehicleRegNo = guarantorMotorVehicleTableBodyRow[
      i
    ].querySelector('input[name="guarantorVehicleRegNo"]').value;
    var guarantorVehicleType = guarantorMotorVehicleTableBodyRow[
      i
    ].querySelector('select[name="guarantorVehicleType"]').value;
    var guarantorVehicleMarketValue = guarantorMotorVehicleTableBodyRow[
      i
    ].querySelector('input[name="guarantorVehicleMarketValue"]').value;

    form.append("guarantorVehicleRegNo[]", guarantorVehicleRegNo);
    form.append("guarantorVehicleType[]", guarantorVehicleType);
    form.append("guarantorVehicleMarketValue[]", guarantorVehicleMarketValue);
  }

  fetch("saveGuarantorFormProcess.php", {
    method: "POST",
    body: form,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Something Wrong Try Again") {
        window.location = "add-file.php";
      } else if (data == "Success") {
        document
          .getElementById("guarantorFormHeaderButton")
          .classList.remove("bg-danger");
        document
          .getElementById("guarantorFormHeaderButton")
          .classList.add("bg-success");

        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function showVehicleTypeTyres() {
  document.getElementById("loading").classList.remove("d-none");

  var vehicleType = document.getElementById("vehicleType").value;

  var form = new FormData();
  form.append("vehicleType", vehicleType);

  fetch("showVehicleTypeTyresProcess.php", {
    method: "POST",
    body: form,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");

      document.getElementById("vehicleTypeTyresBox").innerHTML = data;
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function saveVehicleForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var f = new FormData();

  var vehicleType = document.getElementById("vehicleType").value;
  var vehicleProposer = document.getElementById("vehicleProposer").value;
  var vehicleRegNo = document.getElementById("vehicleRegNo").value;
  var vehicleEngineNo = document.getElementById("vehicleEngineNo").value;
  var vehicleChassisNo = document.getElementById("vehicleChassisNo").value;
  var vehicleDateOfInspection = document.getElementById(
    "vehicleDateOfInspection"
  ).value;
  var vehicleMeterReading = document.getElementById(
    "vehicleMeterReading"
  ).value;
  var vehicleModel = document.getElementById("vehicleModel").value;
  var vahicleValuerName = document.getElementById("vahicleValuerName").value;
  var vehicleEstimateValue = document.getElementById(
    "vehicleEstimateValue"
  ).value;
  var vehicleManufactureYear = document.getElementById(
    "vehicleManufactureYear"
  ).value;
  var vehicleInspectedAt = document.getElementById("vehicleInspectedAt").value;
  var vehicleInsuranceRenewDate = document.getElementById(
    "vehicleInsuranceRenewDate"
  ).value;
  var vehicLelicenseRenewDate = document.getElementById(
    "vehicLelicenseRenewDate"
  ).value;

  var vehicleRBookImg = document.getElementById("vehicleRBook").files[0];

  var vehicleFrontImg = document.getElementById("vehicleFrontImg").files[0];
  var vehicleBackImg = document.getElementById("vehicleBackImg").files[0];
  var vehicleEngineNoImg =
    document.getElementById("vehicleEngineNoImg").files[0];
  var vehicleChassisNoImg = document.getElementById("vehicleChassisNoImg")
    .files[0];

  var vehiclefactoryFittedAccessories = document.querySelectorAll(
    'input[name="factoryFittedAccessories"]:checked'
  );
  const selectedVehiclefactoryFittedAccessories = [];

  vehiclefactoryFittedAccessories.forEach((vehiclefactoryFittedAccessory) => {
    selectedVehiclefactoryFittedAccessories.push(
      vehiclefactoryFittedAccessory.value
    );
  });

  var vehicleOtherfactoryFittedAccessory = document.getElementById(
    "vehicleOtherfactoryFittedAccessory"
  ).value;
  var vehicleDuplicateKey = document.getElementById(
    "vehicleDuplicateKey"
  ).checked;

  var vehicleBodyType = document.getElementById("vehicleBodyType").value;

  var vehicleGeneralApperance = document.getElementsByName(
    "vehicleGeneralApperanceStatus"
  );
  let vehicleGeneralApperanceStatus = null;

  for (let status of vehicleGeneralApperance) {
    if (status.checked) {
      vehicleGeneralApperanceStatus = status.value;
      break;
    }
  }

  var vehiclePainWorkColor = document.getElementById(
    "vehiclePainWorkColor"
  ).value;

  var vehiclePainWork = document.getElementsByName("vehiclePainWorkStatus");
  let vehiclePainWorkStatus = null;

  for (let status of vehiclePainWork) {
    if (status.checked) {
      vehiclePainWorkStatus = status.value;
      break;
    }
  }

  var vehicleUpholsteryColor = document.getElementById(
    "vehicleUpholsteryColor"
  ).value;

  var vehicleUpholstery = document.getElementsByName("vehicleUpholsteryStatus");
  let vehicleUpholsteryStatus = null;

  for (let status of vehicleUpholstery) {
    if (status.checked) {
      vehicleUpholsteryStatus = status.value;
      break;
    }
  }
  //
  var vehicleTypeTyresBox = document.getElementById("vehicleTypeTyresBox");
  var vehicleTypeTyresBoxRow = vehicleTypeTyresBox.rows;

  for (var i = 0; i < vehicleTypeTyresBoxRow.length; i++) {
    var vehicleTyreId = vehicleTypeTyresBoxRow[i].querySelector(
      'input[name="vehicleTyreId"]'
    ).value;

    var vehicleTyre = document.getElementsByName(vehicleTyreId);
    let vehicleTyreStatus = null;

    for (let status of vehicleTyre) {
      if (status.checked) {
        vehicleTyreStatus = status.value;
      }
    }

    f.append("vehicleTyreId[]", vehicleTyreId);
    f.append("vehicleTyreStatus[]", vehicleTyreStatus);
  }

  var vehicleBattery = document.getElementsByName("vehicleBatteryStatus");
  let vehicleBatteryStatus = null;

  for (let status of vehicleBattery) {
    if (status.checked) {
      vehicleBatteryStatus = status.value;
      break;
    }
  }

  var vehicleOtherAccessiries = document.getElementById(
    "vehicleOtherAccessiries"
  ).value;

  f.append("fileNo", fileNo);
  f.append("vehicleType", vehicleType);
  f.append("vehicleProposer", vehicleProposer);
  f.append("vehicleRegNo", vehicleRegNo);
  f.append("vehicleEngineNo", vehicleEngineNo);
  f.append("vehicleChassisNo", vehicleChassisNo);
  f.append("vehicleDateOfInspection", vehicleDateOfInspection);
  f.append("vehicleMeterReading", vehicleMeterReading);
  f.append("vehicleModel", vehicleModel);
  f.append("vahicleValuerName", vahicleValuerName);
  f.append("vehicleEstimateValue", vehicleEstimateValue);
  f.append("vehicleManufactureYear", vehicleManufactureYear);
  f.append("vehicleInspectedAt", vehicleInspectedAt);
  f.append("vehicleInsuranceRenewDate", vehicleInsuranceRenewDate);
  f.append("vehicLelicenseRenewDate", vehicLelicenseRenewDate);
  f.append("vehicleRBookImg", vehicleRBookImg);

  f.append("vehicleFrontImg", vehicleFrontImg);
  f.append("vehicleBackImg", vehicleBackImg);
  f.append("vehicleEngineNoImg", vehicleEngineNoImg);
  f.append("vehicleChassisNoImg", vehicleChassisNoImg);

  selectedVehiclefactoryFittedAccessories.forEach((status) =>
    f.append("selectedVehiclefactoryFittedAccessories[]", status)
  );

  f.append(
    "vehicleOtherfactoryFittedAccessory",
    vehicleOtherfactoryFittedAccessory
  );
  f.append("vehicleDuplicateKey", vehicleDuplicateKey);
  f.append("vehicleBodyType", vehicleBodyType);

  f.append("vehicleGeneralApperanceStatus", vehicleGeneralApperanceStatus);
  f.append("vehiclePainWorkStatus", vehiclePainWorkStatus);
  f.append("vehicleUpholsteryStatus", vehicleUpholsteryStatus);
  // f.append("vehicleRightFrontTyreStatus", vehicleRightFrontTyreStatus);
  // f.append("vehicleLeftFrontTyreStatus", vehicleLeftFrontTyreStatus);
  // f.append("vehicleRightRearTyreStatus", vehicleRightRearTyreStatus);
  // f.append("vehicleLeftRearTyreStatus", vehicleLeftRearTyreStatus);
  f.append("vehicleBatteryStatus", vehicleBatteryStatus);
  f.append("vehicleOtherAccessiries", vehicleOtherAccessiries);
  f.append("vehiclePainWorkColor", vehiclePainWorkColor);
  f.append("vehicleUpholsteryColor", vehicleUpholsteryColor);

  fetch("saveVehicleFormProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");

      if (data == "Something Wrong Try Again") {
        window.location = "add-file.php";
      } else if (data == "Success") {
        document
          .getElementById("vehicleFormHeaderButton")
          .classList.remove("bg-danger");
        document
          .getElementById("vehicleFormHeaderButton")
          .classList.add("bg-success");

        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function savePaymentForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var amount = document.getElementById("amount").value;
  var tenure = document.getElementById("tenure").value;
  var percentage = document.getElementById("percentage").value;
  var paymentOtherDetails = document.getElementById(
    "paymentOtherDetails"
  ).value;

  var f = new FormData();
  f.append("fileNo", fileNo);
  f.append("amount", amount);
  f.append("tenure", tenure);
  f.append("percentage", percentage);
  f.append("paymentOtherDetails", paymentOtherDetails);

  fetch("savePaymentFormProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document
          .getElementById("paymentFormHeaderButton")
          .classList.remove("bg-danger");
        document
          .getElementById("paymentFormHeaderButton")
          .classList.add("bg-success");

        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function UpdatePaymentForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var amount = document.getElementById("amount").value;
  var tenure = document.getElementById("tenure").value;
  var percentage = document.getElementById("percentage").value;
  var paymentOtherDetails = document.getElementById(
    "paymentOtherDetails"
  ).value;

  var f = new FormData();
  f.append("fileNo", fileNo);
  f.append("amount", amount);
  f.append("tenure", tenure);
  f.append("percentage", percentage);
  f.append("paymentOtherDetails", paymentOtherDetails);

  fetch("updatePaymentFormProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");

      if (data == "Updated") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function searchInsuranceFiles() {
  document.getElementById("loading").classList.remove("d-none");

  var sFileNo = document.getElementById("sFileNo").value;
  var sFileCreateFrom = document.getElementById("sFileCreateFrom").value;
  var sFileCreateTo = document.getElementById("sFileCreateTo").value;
  var sFileVehicleNo = document.getElementById("sFileVehicleNo").value;
  var sFileClientNic = document.getElementById("sFileClientNic").value;
  var sFileGuarantorNic = document.getElementById("sFileGuarantorNic").value;
  var sFileType = document.getElementById("sFileType").value;
  var sSortBy = document.getElementById("sSortBy").value;

  var f = new FormData();
  f.append("sFileNo", sFileNo);
  f.append("sFileCreateFrom", sFileCreateFrom);
  f.append("sFileCreateTo", sFileCreateTo);
  f.append("sFileVehicleNo", sFileVehicleNo);
  f.append("sFileClientNic", sFileClientNic);
  f.append("sFileGuarantorNic", sFileGuarantorNic);
  f.append("sFileType", sFileType);
  f.append("sSortBy", sSortBy);

  fetch("insuranceFileSearchProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      document.getElementById("filesTableBody").innerHTML = data;
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function updateClientForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var clientFullName = document.getElementById("clientFullName").value;
  var clientNameWithInitial = document.getElementById(
    "clientNameWithInitial"
  ).value;
  var clientAddress = document.getElementById("clientAddress").value;
  var clientDOB = document.getElementById("clientDOB").value;
  var clientNIC = document.getElementById("clientNIC").value;
  var clientTel = document.getElementById("clientTel").value;
  var clientMobile = document.getElementById("clientMobile").value;
  var clientTitle = document.getElementById("clientTitle").value;
  var clientNicFrontPhoto = document.getElementById("clientNicFrontPhoto")
    .files[0];
  var clientNicBackPhoto =
    document.getElementById("clientNicBackPhoto").files[0];

  var clientMarrageStatusCheckBox = document.getElementById(
    "clientMarrageStatusCheckBox"
  ).checked;
  var clientSpouseFullName = document.getElementById(
    "clientSpouseFullName"
  ).value;
  var clientSpouseNIC = document.getElementById("clientSpouseNIC").value;
  var clientSpouseTel = document.getElementById("clientSpouseTel").value;
  var clientSpouseProfession = document.getElementById(
    "clientSpouseProfession"
  ).value;

  var clientEmpName = document.getElementById("clientEmpName").value;
  var clientEmpAddress = document.getElementById("clientEmpAddress").value;
  var clientBusinessRegNo = document.getElementById(
    "clientBusinessRegNo"
  ).value;
  var clientBusinessNature = document.getElementById(
    "clientBusinessNature"
  ).value;

  var clentIncomeEmp = document.getElementById("clentIncomeEmp").value;

  var clentIncomeOther = document.getElementById("clentIncomeOther").value;
  var clientTotalIncome = document.getElementById("clientTotalIncome").value;
  var clientCostLiving = document.getElementById("clientCostLiving").value;
  var clientLoanRepayment = document.getElementById(
    "clientLoanRepayment"
  ).value;
  var clientNetIncome = document.getElementById("clientNetIncome").value;

  var clientCreditObtainedCheckBox = document.getElementById(
    "clientCreditObtainedCheckBox"
  ).checked;

  var clientMotorVehicleCheckBox = document.getElementById(
    "clientMotorVehicleCheckBox"
  ).checked;
  var clientPropertyCheckBox = document.getElementById(
    "clientPropertyCheckBox"
  ).checked;

  var form = new FormData();
  form.append("fileNo", fileNo);
  form.append("clientFullName", clientFullName);
  form.append("clientNameWithInitial", clientNameWithInitial);
  form.append("clientAddress", clientAddress);
  form.append("clientDOB", clientDOB);
  form.append("clientNIC", clientNIC);
  form.append("clientTel", clientTel);
  form.append("clientMobile", clientMobile);
  form.append("clientTitle", clientTitle);
  form.append("clientNicFrontPhoto", clientNicFrontPhoto);
  form.append("clientNicBackPhoto", clientNicBackPhoto);

  form.append("clientMarrageStatusCheckBox", clientMarrageStatusCheckBox);
  form.append("clientSpouseFullName", clientSpouseFullName);
  form.append("clientSpouseNIC", clientSpouseNIC);
  form.append("clientSpouseTel", clientSpouseTel);
  form.append("clientSpouseProfession", clientSpouseProfession);

  form.append("clientEmpName", clientEmpName);
  form.append("clientEmpAddress", clientEmpAddress);
  form.append("clientBusinessRegNo", clientBusinessRegNo);
  form.append("clientBusinessNature", clientBusinessNature);

  form.append("clentIncomeEmp", clentIncomeEmp);
  form.append("clentIncomeOther", clentIncomeOther);
  form.append("clientTotalIncome", clientTotalIncome);
  form.append("clientCostLiving", clientCostLiving);
  form.append("clientLoanRepayment", clientLoanRepayment);
  form.append("clientNetIncome", clientNetIncome);

  form.append("clientCreditObtainedCheckBox", clientCreditObtainedCheckBox);
  form.append("clientMotorVehicleCheckBox", clientMotorVehicleCheckBox);
  form.append("clientPropertyCheckBox", clientPropertyCheckBox);

  // clientCreditObtainedBody
  var clientCreditObtainedBody = document.getElementById(
    "clientCreditObtainedBody"
  );
  var clientCreditObtainedBodyRows = clientCreditObtainedBody.rows;

  for (var i = 0; i < clientCreditObtainedBodyRows.length; i++) {
    var clientCreditObtainedInstitute = clientCreditObtainedBodyRows[
      i
    ].querySelector('input[name="clientCreditObtainedInstitute"]').value;
    var clientCreditObtainedAmount = clientCreditObtainedBodyRows[
      i
    ].querySelector('input[name="clientCreditObtainedAmount"]').value;
    var clientCreditObtainedPresentOutstanding = clientCreditObtainedBodyRows[
      i
    ].querySelector(
      'input[name="clientCreditObtainedPresentOutstanding"]'
    ).value;

    form.append(
      "clientCreditObtainedInstitute[]",
      clientCreditObtainedInstitute
    );
    form.append("clientCreditObtainedAmount[]", clientCreditObtainedAmount);
    form.append(
      "clientCreditObtainedPresentOutstanding[]",
      clientCreditObtainedPresentOutstanding
    );
  }
  // clientCreditObtainedBody

  // clientBankDeatilsBody
  var clientBankDeatilsBody = document.getElementById("clientBankDeatilsBody");
  var clientBankDeatilsBodyRows = clientBankDeatilsBody.rows;

  for (var i = 0; i < clientBankDeatilsBodyRows.length; i++) {
    var clientNameOfBankBranch = clientBankDeatilsBodyRows[i].querySelector(
      'input[name="clientNameOfBankBranch"]'
    ).value;
    var clientBankAccountNo = clientBankDeatilsBodyRows[i].querySelector(
      'input[name="clientBankAccountNo"]'
    ).value;
    var clientBankType = clientBankDeatilsBodyRows[i].querySelector(
      'input[name="clientBankType"]'
    ).value;

    form.append("clientNameOfBankBranch[]", clientNameOfBankBranch);
    form.append("clientBankAccountNo[]", clientBankAccountNo);
    form.append("clientBankType[]", clientBankType);
  }

  // clientBankDeatilsBody

  // clientPropertyTableBody
  var clientPropertyTableBody = document.getElementById(
    "clientPropertyTableBody"
  );
  var clientPropertyTableBodyRow = clientPropertyTableBody.rows;
  for (var i = 0; i < clientPropertyTableBodyRow.length; i++) {
    var clientPropertyLocation = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyLocation"]'
    ).value;
    var clientPropertyExtent = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyExtent"]'
    ).value;
    var clientPropertyValue = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyValue"]'
    ).value;
    var clientPropertyMortgaged = clientPropertyTableBodyRow[i].querySelector(
      'input[name="clientPropertyMortgaged"]'
    ).checked;

    form.append("clientPropertyLocation[]", clientPropertyLocation);
    form.append("clientPropertyExtent[]", clientPropertyExtent);
    form.append("clientPropertyValue[]", clientPropertyValue);
    form.append("clientPropertyMortgaged[]", clientPropertyMortgaged);
  }

  // clientPropertyTableBody

  // clientMotorVehicleTableBody

  var clientMotorVehicleTableBody = document.getElementById(
    "clientMotorVehicleTableBody"
  );
  var clientMotorVehicleTableBodyRow = clientMotorVehicleTableBody.rows;

  for (var i = 0; i < clientMotorVehicleTableBodyRow.length; i++) {
    var clientVehicleRegNo = clientMotorVehicleTableBodyRow[i].querySelector(
      'input[name="clientVehicleRegNo"]'
    ).value;
    var clientVehicleType = clientMotorVehicleTableBodyRow[i].querySelector(
      'select[name="clientVehicleType"]'
    ).value;
    var clientVehicleMarketValue = clientMotorVehicleTableBodyRow[
      i
    ].querySelector('input[name="clientVehicleMarketValue"]').value;

    form.append("clientVehicleRegNo[]", clientVehicleRegNo);
    form.append("clientVehicleType[]", clientVehicleType);
    form.append("clientVehicleMarketValue[]", clientVehicleMarketValue);
  }

  // clientMotorVehicleTableBody

  var clientItemRequiredtype = document.getElementById(
    "clientItemRequiredtype"
  ).value;
  var clientItemRequiredSupplier = document.getElementById(
    "clientItemRequiredSupplier"
  ).value;
  var clientItemRequiredModel = document.getElementById(
    "clientItemRequiredModel"
  ).value;
  var clientItemRequiredFaclityAmount = document.getElementById(
    "clientItemRequiredFaclityAmount"
  ).value;
  var clientItemRequiredColour = document.getElementById(
    "clientItemRequiredColour"
  ).value;
  var clientItemRequiredLeasePeriod = document.getElementById(
    "clientItemRequiredLeasePeriod"
  ).value;
  var clientItemRequiredPurposeOfUse = document.getElementById(
    "clientItemRequiredPurposeOfUse"
  ).value;
  var clientOtherDetails = document.getElementById("clientOtherDetails").value;

  form.append("clientItemRequiredtype", clientItemRequiredtype);
  form.append("clientItemRequiredSupplier", clientItemRequiredSupplier);
  form.append("clientItemRequiredModel", clientItemRequiredModel);
  form.append(
    "clientItemRequiredFaclityAmount",
    clientItemRequiredFaclityAmount
  );
  form.append("clientItemRequiredColour", clientItemRequiredColour);
  form.append("clientItemRequiredLeasePeriod", clientItemRequiredLeasePeriod);
  form.append("clientItemRequiredPurposeOfUse", clientItemRequiredPurposeOfUse);
  form.append("clientOtherDetails", clientOtherDetails);

  fetch("updateClientFormProcess.php", {
    method: "POST",
    body: form,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Something Wrong Try Again") {
        window.location = "add-file.php";
      } else if (data == "Updated") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function updateGuarantorForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");

  var guarantorFullName = document.getElementById("guarantorFullName").value;
  var guarantorNameWithInitial = document.getElementById(
    "guarantorNameWithInitial"
  ).value;
  var guarantorAddress = document.getElementById("guarantorAddress").value;
  var guarantorDOB = document.getElementById("guarantorDOB").value;
  var guarantorNIC = document.getElementById("guarantorNIC").value;
  var guarantorTelNo = document.getElementById("guarantorTelNo").value;
  var guarantorMobile = document.getElementById("guarantorMobile").value;
  var guarantorTitle = document.getElementById("guarantorTitle").value;
  var guarantorNicFrontPhoto = document.getElementById("guarantorNicFrontPhoto")
    .files[0];
  var guarantorNicBackPhoto = document.getElementById("guarantorNicBackPhoto")
    .files[0];

  var guarantorMarrageStatusCheckBox = document.getElementById(
    "guarantorMarrageStatusCheckBox"
  ).checked;
  var guarantorSpouseFullName = document.getElementById(
    "guarantorSpouseFullName"
  ).value;
  var guarantorSpouseNIC = document.getElementById("guarantorSpouseNIC").value;
  var guarantorSpouseTel = document.getElementById("guarantorSpouseTel").value;
  var guarantorSpouseProfession = document.getElementById(
    "guarantorSpouseProfession"
  ).value;

  var guarantorEmpName = document.getElementById("guarantorEmpName").value;
  var guarantorEmpAddress = document.getElementById(
    "guarantorEmpAddress"
  ).value;
  var guarantorBusinessRegNo = document.getElementById(
    "guarantorBusinessRegNo"
  ).value;
  var guarantorBusinessNature = document.getElementById(
    "guarantorBusinessNature"
  ).value;

  var guarantorIncomeEmp = document.getElementById("guarantorIncomeEmp").value;

  var guarantorIncomeOther = document.getElementById(
    "guarantorIncomeOther"
  ).value;
  var guarantorCostLiving = document.getElementById(
    "guarantorCostLiving"
  ).value;
  var guarantorLoanRepayment = document.getElementById(
    "guarantorLoanRepayment"
  ).value;

  var guarantorCreditObtainedCheckBox = document.getElementById(
    "guarantorCreditObtainedCheckBox"
  ).checked;
  var guarantorPropertyCheckBox = document.getElementById(
    "guarantorPropertyCheckBox"
  ).checked;
  var guarantorMotorVehicleCheckBox = document.getElementById(
    "guarantorMotorVehicleCheckBox"
  ).checked;

  var guarantorOtherDetails = document.getElementById(
    "guarantorOtherDetails"
  ).value;

  var form = new FormData();
  form.append("fileNo", fileNo);
  form.append("guarantorFullName", guarantorFullName);
  form.append("guarantorNameWithInitial", guarantorNameWithInitial);
  form.append("guarantorAddress", guarantorAddress);
  form.append("guarantorDOB", guarantorDOB);
  form.append("guarantorNIC", guarantorNIC);
  form.append("guarantorTelNo", guarantorTelNo);
  form.append("guarantorMobile", guarantorMobile);
  form.append("guarantorTitle", guarantorTitle);
  form.append("guarantorNicFrontPhoto", guarantorNicFrontPhoto);
  form.append("guarantorNicBackPhoto", guarantorNicBackPhoto);

  form.append("guarantorMarrageStatusCheckBox", guarantorMarrageStatusCheckBox);
  form.append("guarantorSpouseFullName", guarantorSpouseFullName);
  form.append("guarantorSpouseNIC", guarantorSpouseNIC);
  form.append("guarantorSpouseTel", guarantorSpouseTel);
  form.append("guarantorSpouseProfession", guarantorSpouseProfession);

  form.append("guarantorEmpName", guarantorEmpName);
  form.append("guarantorEmpAddress", guarantorEmpAddress);
  form.append("guarantorBusinessRegNo", guarantorBusinessRegNo);
  form.append("guarantorBusinessNature", guarantorBusinessNature);

  form.append("guarantorIncomeEmp", guarantorIncomeEmp);
  form.append("guarantorIncomeOther", guarantorIncomeOther);
  form.append("guarantorCostLiving", guarantorCostLiving);
  form.append("guarantorLoanRepayment", guarantorLoanRepayment);

  form.append(
    "guarantorCreditObtainedCheckBox",
    guarantorCreditObtainedCheckBox
  );
  form.append("guarantorPropertyCheckBox", guarantorPropertyCheckBox);
  form.append("guarantorMotorVehicleCheckBox", guarantorMotorVehicleCheckBox);

  form.append("guarantorOtherDetails", guarantorOtherDetails);

  // clientCreditObtainedBody
  var guarantorCreditObtainedBody = document.getElementById(
    "guarantorCreditObtainedBody"
  );
  var guarantorCreditObtainedBodyRows = guarantorCreditObtainedBody.rows;

  for (var i = 0; i < guarantorCreditObtainedBodyRows.length; i++) {
    var guarantorCreditObtainedInstitute = guarantorCreditObtainedBodyRows[
      i
    ].querySelector('input[name="guarantorCreditObtainedInstitute"]').value;
    var guarantorCreditObtainedAmount = guarantorCreditObtainedBodyRows[
      i
    ].querySelector('input[name="guarantorCreditObtainedAmount"]').value;
    var guarantorCreditObtainedPresentOutstanding =
      guarantorCreditObtainedBodyRows[i].querySelector(
        'input[name="guarantorCreditObtainedPresentOutstanding"]'
      ).value;

    form.append(
      "guarantorCreditObtainedInstitute[]",
      guarantorCreditObtainedInstitute
    );
    form.append(
      "guarantorCreditObtainedAmount[]",
      guarantorCreditObtainedAmount
    );
    form.append(
      "guarantorCreditObtainedPresentOutstanding[]",
      guarantorCreditObtainedPresentOutstanding
    );
  }
  // clientCreditObtainedBody

  // clientBankDeatilsBody
  var guarantorBankDeatilsBody = document.getElementById(
    "guarantorBankDeatilsBody"
  );
  var guarantorBankDeatilsBodyRows = guarantorBankDeatilsBody.rows;

  for (var i = 0; i < guarantorBankDeatilsBodyRows.length; i++) {
    var guarantorNameOfBankBranch = guarantorBankDeatilsBodyRows[
      i
    ].querySelector('input[name="guarantorNameOfBankBranch"]').value;
    var guarantorBankAccountNo = guarantorBankDeatilsBodyRows[i].querySelector(
      'input[name="guarantorBankAccountNo"]'
    ).value;
    var guarantorBankType = guarantorBankDeatilsBodyRows[i].querySelector(
      'input[name="guarantorBankType"]'
    ).value;

    form.append("guarantorNameOfBankBranch[]", guarantorNameOfBankBranch);
    form.append("guarantorBankAccountNo[]", guarantorBankAccountNo);
    form.append("guarantorBankType[]", guarantorBankType);
  }

  // clientBankDeatilsBody

  // clientPropertyTableBody
  var guarantorPropertyTableBody = document.getElementById(
    "guarantorPropertyTableBody"
  );
  var guarantorPropertyTableBodyRow = guarantorPropertyTableBody.rows;
  for (var i = 0; i < guarantorPropertyTableBodyRow.length; i++) {
    var guarantorPropertyLocation = guarantorPropertyTableBodyRow[
      i
    ].querySelector('input[name="guarantorPropertyLocation"]').value;
    var guarantorPropertyExtent = guarantorPropertyTableBodyRow[
      i
    ].querySelector('input[name="guarantorPropertyExtent"]').value;
    var guarantorPropertyValue = guarantorPropertyTableBodyRow[i].querySelector(
      'input[name="guarantorPropertyValue"]'
    ).value;
    var guarantorPropertyMortgaged = guarantorPropertyTableBodyRow[
      i
    ].querySelector('input[name="guarantorPropertyMortgaged"]').checked;

    form.append("guarantorPropertyLocation[]", guarantorPropertyLocation);
    form.append("guarantorPropertyExtent[]", guarantorPropertyExtent);
    form.append("guarantorPropertyValue[]", guarantorPropertyValue);
    form.append("guarantorPropertyMortgaged[]", guarantorPropertyMortgaged);
  }

  // clientPropertyTableBody

  // clientMotorVehicleTableBody

  var guarantorMotorVehicleTableBody = document.getElementById(
    "guarantorMotorVehicleTableBody"
  );
  var guarantorMotorVehicleTableBodyRow = guarantorMotorVehicleTableBody.rows;

  for (var i = 0; i < guarantorMotorVehicleTableBodyRow.length; i++) {
    var guarantorVehicleRegNo = guarantorMotorVehicleTableBodyRow[
      i
    ].querySelector('input[name="guarantorVehicleRegNo"]').value;
    var guarantorVehicleType = guarantorMotorVehicleTableBodyRow[
      i
    ].querySelector('select[name="guarantorVehicleType"]').value;
    var guarantorVehicleMarketValue = guarantorMotorVehicleTableBodyRow[
      i
    ].querySelector('input[name="guarantorVehicleMarketValue"]').value;

    form.append("guarantorVehicleRegNo[]", guarantorVehicleRegNo);
    form.append("guarantorVehicleType[]", guarantorVehicleType);
    form.append("guarantorVehicleMarketValue[]", guarantorVehicleMarketValue);
  }

  fetch("updateGuarantorFormProcess.php", {
    method: "POST",
    body: form,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Something Wrong Try Again") {
        window.location = "add-file.php";
      } else if (data == "Updated") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function updateVehicleForm(fileNo) {
  document.getElementById("loading").classList.remove("d-none");
  var f = new FormData();

  var vehicleType = document.getElementById("vehicleType").value;
  var vehicleProposer = document.getElementById("vehicleProposer").value;
  var vehicleRegNo = document.getElementById("vehicleRegNo").value;
  var vehicleEngineNo = document.getElementById("vehicleEngineNo").value;
  var vehicleChassisNo = document.getElementById("vehicleChassisNo").value;
  var vehicleDateOfInspection = document.getElementById(
    "vehicleDateOfInspection"
  ).value;
  var vehicleMeterReading = document.getElementById(
    "vehicleMeterReading"
  ).value;
  var vehicleModel = document.getElementById("vehicleModel").value;
  var vahicleValuerName = document.getElementById("vahicleValuerName").value;
  var vehicleEstimateValue = document.getElementById(
    "vehicleEstimateValue"
  ).value;
  var vehicleManufactureYear = document.getElementById(
    "vehicleManufactureYear"
  ).value;
  var vehicleInspectedAt = document.getElementById("vehicleInspectedAt").value;
  var vehicleInsuranceRenewDate = document.getElementById(
    "vehicleInsuranceRenewDate"
  ).value;
  var vehicLelicenseRenewDate = document.getElementById(
    "vehicLelicenseRenewDate"
  ).value;

  var vehicleRBookImg = document.getElementById("vehicleRBook").files[0];

  var vehicleFrontImg = document.getElementById("vehicleFrontImg").files[0];
  var vehicleBackImg = document.getElementById("vehicleBackImg").files[0];
  var vehicleEngineNoImg =
    document.getElementById("vehicleEngineNoImg").files[0];
  var vehicleChassisNoImg = document.getElementById("vehicleChassisNoImg")
    .files[0];

  var vehiclefactoryFittedAccessories = document.querySelectorAll(
    'input[name="factoryFittedAccessories"]:checked'
  );
  const selectedVehiclefactoryFittedAccessories = [];

  vehiclefactoryFittedAccessories.forEach((vehiclefactoryFittedAccessory) => {
    selectedVehiclefactoryFittedAccessories.push(
      vehiclefactoryFittedAccessory.value
    );
  });

  var vehicleOtherfactoryFittedAccessory = document.getElementById(
    "vehicleOtherfactoryFittedAccessory"
  ).value;
  var vehicleDuplicateKey = document.getElementById(
    "vehicleDuplicateKey"
  ).checked;

  var vehicleBodyType = document.getElementById("vehicleBodyType").value;

  var vehicleGeneralApperance = document.getElementsByName(
    "vehicleGeneralApperanceStatus"
  );
  let vehicleGeneralApperanceStatus = null;

  for (let status of vehicleGeneralApperance) {
    if (status.checked) {
      vehicleGeneralApperanceStatus = status.value;
      break;
    }
  }

  var vehiclePainWorkColor = document.getElementById(
    "vehiclePainWorkColor"
  ).value;

  var vehiclePainWork = document.getElementsByName("vehiclePainWorkStatus");
  let vehiclePainWorkStatus = null;

  for (let status of vehiclePainWork) {
    if (status.checked) {
      vehiclePainWorkStatus = status.value;
      break;
    }
  }

  var vehicleUpholsteryColor = document.getElementById(
    "vehicleUpholsteryColor"
  ).value;

  var vehicleUpholstery = document.getElementsByName("vehicleUpholsteryStatus");
  let vehicleUpholsteryStatus = null;

  for (let status of vehicleUpholstery) {
    if (status.checked) {
      vehicleUpholsteryStatus = status.value;
      break;
    }
  }
  //
  var vehicleTypeTyresBox = document.getElementById("vehicleTypeTyresBox");
  var vehicleTypeTyresBoxRow = vehicleTypeTyresBox.rows;

  for (var i = 0; i < vehicleTypeTyresBoxRow.length; i++) {
    var vehicleTyreId = vehicleTypeTyresBoxRow[i].querySelector(
      'input[name="vehicleTyreId"]'
    ).value;

    var vehicleTyre = document.getElementsByName(vehicleTyreId);
    let vehicleTyreStatus = null;

    for (let status of vehicleTyre) {
      if (status.checked) {
        vehicleTyreStatus = status.value;
      }
    }

    f.append("vehicleTyreId[]", vehicleTyreId);
    f.append("vehicleTyreStatus[]", vehicleTyreStatus);
  }

  var vehicleBattery = document.getElementsByName("vehicleBatteryStatus");
  let vehicleBatteryStatus = null;

  for (let status of vehicleBattery) {
    if (status.checked) {
      vehicleBatteryStatus = status.value;
      break;
    }
  }

  var vehicleOtherAccessiries = document.getElementById(
    "vehicleOtherAccessiries"
  ).value;

  f.append("fileNo", fileNo);
  f.append("vehicleType", vehicleType);
  f.append("vehicleProposer", vehicleProposer);
  f.append("vehicleRegNo", vehicleRegNo);
  f.append("vehicleEngineNo", vehicleEngineNo);
  f.append("vehicleChassisNo", vehicleChassisNo);
  f.append("vehicleDateOfInspection", vehicleDateOfInspection);
  f.append("vehicleMeterReading", vehicleMeterReading);
  f.append("vehicleModel", vehicleModel);
  f.append("vahicleValuerName", vahicleValuerName);
  f.append("vehicleEstimateValue", vehicleEstimateValue);
  f.append("vehicleManufactureYear", vehicleManufactureYear);
  f.append("vehicleInspectedAt", vehicleInspectedAt);
  f.append("vehicleInsuranceRenewDate", vehicleInsuranceRenewDate);
  f.append("vehicLelicenseRenewDate", vehicLelicenseRenewDate);
  f.append("vehicleRBookImg", vehicleRBookImg);

  f.append("vehicleFrontImg", vehicleFrontImg);
  f.append("vehicleBackImg", vehicleBackImg);
  f.append("vehicleEngineNoImg", vehicleEngineNoImg);
  f.append("vehicleChassisNoImg", vehicleChassisNoImg);

  selectedVehiclefactoryFittedAccessories.forEach((status) =>
    f.append("selectedVehiclefactoryFittedAccessories[]", status)
  );

  f.append(
    "vehicleOtherfactoryFittedAccessory",
    vehicleOtherfactoryFittedAccessory
  );
  f.append("vehicleDuplicateKey", vehicleDuplicateKey);
  f.append("vehicleBodyType", vehicleBodyType);

  f.append("vehicleGeneralApperanceStatus", vehicleGeneralApperanceStatus);
  f.append("vehiclePainWorkStatus", vehiclePainWorkStatus);
  f.append("vehicleUpholsteryStatus", vehicleUpholsteryStatus);
  f.append("vehicleBatteryStatus", vehicleBatteryStatus);
  f.append("vehicleOtherAccessiries", vehicleOtherAccessiries);
  f.append("vehiclePainWorkColor", vehiclePainWorkColor);
  f.append("vehicleUpholsteryColor", vehicleUpholsteryColor);

  fetch("updateVehicleFormProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Something Wrong Try Again") {
        window.location = "add-file.php";
      } else if (data == "Updated") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function changeFileStatus(fileID) {
  document.getElementById("loading").classList.remove("d-none");
  var selectedFileStatus = document.getElementById("selectedFileStatus").value;
  var stausMessage = document.getElementById("stausMessage").value;

  const f = new FormData();
  f.append("fileID", fileID);
  f.append("selectedFileStatus", selectedFileStatus);
  f.append("stausMessage", stausMessage);

  fetch("changeFileStatusProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success" || data == "Updated") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function updateUserStatus(userId) {
  document.getElementById("loading").classList.remove("d-none");
  const f = new FormData();
  f.append("userId", userId);

  fetch("updateUserStatusProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText =
          "Changed Status";
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      loading.hide();
      alert(error);
    });
}

function searchUsers() {
  document.getElementById("loading").classList.remove("d-none");
  var sName = document.getElementById("sName").value;
  var sEmail = document.getElementById("sEmail").value;
  var sMobile = document.getElementById("sMobile").value;
  var sType = document.getElementById("sType").value;
  var sStatus = document.getElementById("sStatus").value;

  const f = new FormData();
  f.append("sName", sName);
  f.append("sEmail", sEmail);
  f.append("sMobile", sMobile);
  f.append("sType", sType);
  f.append("sStatus", sStatus);

  fetch("searchUsersProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      document.getElementById("usersTableBody").innerHTML = data;
    })
    .catch((error) => {
      loading.hide();
      alert(error);
    });
}

function addNewUser() {
  document.getElementById("loading").classList.remove("d-none");

  var fullName = document.getElementById("fullName").value;
  var nameWithInitial = document.getElementById("nameWithInitial").value;
  var empNo = document.getElementById("empNo").value;
  var email = document.getElementById("email").value;
  var mobile = document.getElementById("mobile").value;
  var nic = document.getElementById("nic").value;
  var address = document.getElementById("address").value;
  var userType = document.getElementById("userType").value;

  const f = new FormData();
  f.append("fullName", fullName);
  f.append("nameWithInitial", nameWithInitial);
  f.append("empNo", empNo);
  f.append("email", email);
  f.append("mobile", mobile);
  f.append("nic", nic);
  f.append("address", address);
  f.append("userType", userType);

  fetch("addNewUserProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      loading.hide();
      alert(error);
    });
}

function updateMyProfile() {
  document.getElementById("loading").classList.remove("d-none");

  var fullName = document.getElementById("fullName").value;
  var nameWithInitial = document.getElementById("nameWithInitial").value;
  var mobile = document.getElementById("mobile").value;
  var password = document.getElementById("password").value;
  var cPassword = document.getElementById("cPassword").value;
  var address = document.getElementById("address").value;

  const f = new FormData();
  f.append("fullName", fullName);
  f.append("nameWithInitial", nameWithInitial);
  f.append("mobile", mobile);
  f.append("password", password);
  f.append("cPassword", cPassword);
  f.append("address", address);

  fetch("updateMyProfileProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function installmentCalc() {
  document.getElementById("loading").classList.remove("d-none");
  var amount = document.getElementById("amount").value;
  var tenure = document.getElementById("tenure").value;
  var percentage = document.getElementById("percentage").value;

  var f = new FormData();
  f.append("amount", amount);
  f.append("tenure", tenure);
  f.append("percentage", percentage);

  fetch("installmentCalcProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      document.getElementById("interestBody").innerHTML = data;
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function approvedPaymentDetails(fileId) {
  document.getElementById("loading").classList.remove("d-none");

  var paymentBankName = document.getElementById("paymentBankName").value;
  var paymentDate = document.getElementById("paymentDate").value;
  var paymentCheckNo = document.getElementById("paymentCheckNo").value;
  var paymentAmount = document.getElementById("paymentAmount").value;

  var f = new FormData();
  f.append("fileId", fileId);
  f.append("paymentBankName", paymentBankName);
  f.append("paymentDate", paymentDate);
  f.append("paymentCheckNo", paymentCheckNo);
  f.append("paymentAmount", paymentAmount);

  fetch("approvedPaymentDetailsProccess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (
        data == "Updated Payment Details" ||
        data == "Saved Payment Details"
      ) {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function payNow(fileId) {
  document.getElementById("loading").classList.remove("d-none");

  var paymentAmount = document.getElementById("paymentAmount").value;
  var paymentDate = document.getElementById("paymentDate").value;
  var paymentOtherDetails = document.getElementById(
    "paymentOtherDetails"
  ).value;

  var f = new FormData();
  f.append("fileId", fileId);
  f.append("paymentAmount", paymentAmount);
  f.append("paymentDate", paymentDate);
  f.append("paymentOtherDetails", paymentOtherDetails);

  fetch("payNowProccess.php", {
    method: "POST",
    body: f,
  })
    // .then((response) => response.text())
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data.success) {
        document.getElementById("successAlertText").innerText = data.message;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.open("receipt.php?receiptId=" + data.receiptId, "_blank");
            // window.location="receipt.php?receiptId="+data.receiptId;
          });
      } else {
        document.getElementById("warningAlertText").innerText = data.message;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }

      // if (data == "Success") {
      //   document.getElementById("successAlertText").innerText = data;
      //   successAlertBox = new bootstrap.Modal(
      //     document.getElementById("successAlertBox")
      //   );
      //   successAlertBox.show();
      //   document
      //     .getElementById("successAlertOkButton")
      //     .addEventListener("click", function () {
      //       window.location.reload();
      //     });
      // } else {
      //   document.getElementById("warningAlertText").innerText = data;
      //   warningAlertBox = new bootstrap.Modal(
      //     document.getElementById("warningAlertBox")
      //   );
      //   warningAlertBox.show();
      // }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function requestLeave() {
  document.getElementById("loading").classList.remove("d-none");

  var leaveType = document.getElementById("leaveType").value;
  var leaveDays = document.getElementById("leaveDays").value;
  var leaveDate = document.getElementById("leaveDate").value;
  var leaveDetails = document.getElementById("leaveDetails").value;

  var f = new FormData();
  f.append("leaveType", leaveType);
  f.append("leaveDays", leaveDays);
  f.append("leaveDate", leaveDate);
  f.append("leaveDetails", leaveDetails);

  fetch("requestLeaveProccess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function searchPaymentInsuranceFiles() {
  document.getElementById("loading").classList.remove("d-none");

  var sFileNo = document.getElementById("sFileNo").value;
  var sFileVehicleNo = document.getElementById("sFileVehicleNo").value;
  var sFileClientNic = document.getElementById("sFileClientNic").value;
  var sFileType = document.getElementById("sFileType").value;

  var f = new FormData();
  f.append("sFileNo", sFileNo);
  f.append("sFileVehicleNo", sFileVehicleNo);
  f.append("sFileClientNic", sFileClientNic);
  f.append("sFileType", sFileType);

  fetch("insuranceFilePaymentSearchProcess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      document.getElementById("filesTableBody").innerHTML = data;
    })
    .catch((error) => {
      alert(error);
      console.log(error);
    });
}

function approveEmpLeave(leaveId) {
  document.getElementById("loading").classList.remove("d-none");
  fetch("approveEmpLeaveProccess.php?leaveId=" + leaveId, {
    method: "GET",
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      alert(error);
    });
}

function rejectEmpLeave(leaveId) {
  document.getElementById("loading").classList.remove("d-none");
  fetch("rejectEmpLeaveProccess.php?leaveId=" + leaveId, {
    method: "GET",
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function resetPassword(userId) {
  document.getElementById("loading").classList.remove("d-none");
  fetch("resetPasswordProcess.php?userId=" + userId, {
    method: "GET",
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function payServiceCharge(fileId) {
  document.getElementById("loading").classList.remove("d-none");

  var serviceChargeAmount = document.getElementById(
    "serviceChargeAmount"
  ).value;
  var serviceChargePaymentDate = document.getElementById(
    "serviceChargePaymentDate"
  ).value;

  var f = new FormData();
  f.append("fileId", fileId);
  f.append("serviceChargeAmount", serviceChargeAmount);
  f.append("serviceChargePaymentDate", serviceChargePaymentDate);

  fetch("payServiceChargeProccess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");

      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function searchReport() {
  document.getElementById("loading").classList.remove("d-none");

  var selectedDate = document.getElementById("selectedDate").value;

  var f = new FormData();
  f.append("selectedDate", selectedDate);

  fetch("searchReportProccess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");

      document.getElementById("reportDate").innerHTML =
        "Date : " + selectedDate;
      document.getElementById("tableDiv").innerHTML = data;
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function saveItemInventory() {
  document.getElementById("loading").classList.remove("d-none");

  var itemTitle = document.getElementById("itemTitle").value;
  var itemDescription = document.getElementById("itemDescription").value;

  var itemImg1 = document.getElementById("itemImg1").files[0];
  var itemImg2 = document.getElementById("itemImg2").files[0];

  var f = new FormData();
  f.append("itemTitle", itemTitle);
  f.append("itemDescription", itemDescription);
  f.append("itemImg1", itemImg1);
  f.append("itemImg2", itemImg2);

  fetch("saveItemInventoryProccess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      const modalElement = document.getElementById("inventryItem");
      const modal = bootstrap.Modal.getInstance(modalElement);
      modal.hide();
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function removeInventoryItem(id) {
  document.getElementById("loading").classList.remove("d-none");

  fetch("removeInventoryItemProccess.php?itemId="+id, {
    method: "GET",
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}

function changeAnnualPresentage() {
  document.getElementById("loading").classList.remove("d-none");

  var annualpresentage = document.getElementById("annualpresentage").value;

  var f = new FormData();
  f.append("annualpresentage", annualpresentage);

  fetch("changeAnnualPresentageProccess.php", {
    method: "POST",
    body: f,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("loading").classList.add("d-none");
      if (data == "Success") {
        document.getElementById("successAlertText").innerText = data;
        successAlertBox = new bootstrap.Modal(
          document.getElementById("successAlertBox")
        );
        successAlertBox.show();
        document
          .getElementById("successAlertOkButton")
          .addEventListener("click", function () {
            window.location.reload();
          });
      } else {
        document.getElementById("warningAlertText").innerText = data;
        warningAlertBox = new bootstrap.Modal(
          document.getElementById("warningAlertBox")
        );
        warningAlertBox.show();
      }
    })
    .catch((error) => {
      console.log(error);
      alert(error);
    });
}