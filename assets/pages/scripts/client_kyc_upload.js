var DOBInit = function() {
    var maskDoBField = function() {
        $("#dob").inputmask("m/d/y", {
            placeholder: "mm/dd/yyyy"
        });
    };

    return {
        init : function () {
            maskDoBField();
        }
    }
}();
jQuery(document).ready(function() {
    DOBInit.init();
});