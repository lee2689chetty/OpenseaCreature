/**
 * Created by rock on 1/19/18.
 */

var NewCurrencyPair = function() {
    var handlNewCurrencyPair = function() {
        $('#formCurrency').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                baseCurrency: {
                    required: true
                },
                secondaryCurrency: {
                    required: true
                },
                interbankRate:{
                    required:true
                },
                valorPayRate:{
                    required:true
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
            handlNewCurrencyPair();
        }
    };
}();

jQuery(document).ready(function() {
    NewCurrencyPair.init();
});