var input = document.querySelector("#wa_stokis"),
    errorMsg = document.querySelector("#error_hp"),
    validMsg = document.querySelector("#valid_hp");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Nomor Handphone tidak valid.", "Kode Negara tidak valid.", "Terlalu pendek.", "Terlalu panjang", "Nomor Handphone tidak valid."];

// initialise plugin
var iti = window.intlTelInput(input, {
    separateDialCode: true,
    preferredCountries: ["id", "my"],
    hiddenInput: "no_handphone",
    formatOnDisplay: true,
    // onlyCountries: ["id", "my"],
    utilsScript: "assets/plugins/intlTellInput/js/utils.js?1638200991544"
});

var reset = function () {
    input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function () {
    reset();
    if (input.value.trim()) {
        if (iti.isValidNumber()) {
            validMsg.classList.remove("hide");
        } else {
            input.classList.add("error");
            var errorCode = iti.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
        }
    }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
