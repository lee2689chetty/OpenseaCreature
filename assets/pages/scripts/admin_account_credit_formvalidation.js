/**
 * Created by rock on 1/19/18.
 */

var FormValidatorHandler = function() {

    var InitCurrencyFormat = function () {
        $('#creditAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
    };

    var handleCreditForm = function() {
        $('#creditForm').validate({
            errorElement: 'span',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
                creditAmount: {
                    required: true
                },
                creditDescription: {
                    required: true
                }
            },

            messages: {

            },

            invalidHandler: function(event, validator) { //display error alert on form submit

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

    return {
        init: function() {
            InitCurrencyFormat();
            handleCreditForm();
        }
    };
}();

jQuery(document).ready(function() {
    FormValidatorHandler.init();
});