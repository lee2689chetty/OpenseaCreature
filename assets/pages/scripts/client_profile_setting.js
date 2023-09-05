/**
 * Created by rock on 1/19/18.
 */

var UpdateInit = function() {
    var formValidationInit = function()
    {
        $('#formSetting').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            messages: {
                txtSecurityAnswer: {
                    required: "Answer is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit
                $('.alert-danger', $('#formSetting')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit(); // form validation success, call ajax form submit
            }
        });
    };

    var handleDropDown = function () {
        $('#selectSecurity').change(function() {
            InitTextContent();
            $('#txtSecurityAnswer').val("");
        });
    };
    var InitTextContent = function()
    {
        var txtAnswer = $('#txtSecurityAnswer');
        if(parseInt($('#selectSecurity').val()) > 0) {
            txtAnswer.rules('add','required');
            txtAnswer.addClass('required');
            txtAnswer.prop('disabled', false);
        }
        else {
            txtAnswer.rules('remove','required');
            txtAnswer.removeClass('required');
            txtAnswer.prop('disabled',true);
        }
    };
    return {
        init: function() {
            formValidationInit();
            handleDropDown();
            InitTextContent();
        }
    };
}();

jQuery(document).ready(function() {
    UpdateInit.init();
});