/**
 * Created by rock on 1/19/18.
 */
var HandleTransferCard = function() {
    var InitCurrencyFormat = function () {
        $('#amount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
    };

    var handleLogin = function() {
        $('#formSubmit').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                fromAccount: {
                    required: true
                },
                toCard: {
                    required: true
                },
                amount:{
                    required:true
                },
                fee:{
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

        $('#amount').on('input', function(e){
            UpdateFeeTextView();
        });

        $('#fromAccount').change(function(){
            if(this.value === '') return;
            var formData = new FormData();
            formData.append("accountId", this.value);
            var getFeeHandler = $.ajax({
                url: "../transfer/getFeeValue",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            getFeeHandler.done(function (msg) {
                var jsonValue = JSON.parse(msg);
                $('#feeValue').val(jsonValue[0].CFT_AMOUNT);
                $('#feeType').val(jsonValue[0].CFT_TYPE);
                UpdateFeeTextView();
            });

            getFeeHandler.fail(function (jqXHR, textStatus) {
                jQuery('#feeValue').val('');
                jQuery('#feeType').val('');
            });
        });
    };

    return {
        init: function() {
            InitCurrencyFormat();
            handleLogin();
        }
    };
}();

var UpdateFeeTextView = function() {

    var valueAmount = jQuery('#amount').val();
    valueAmount = valueAmount.replace(new RegExp(',', 'g'), '');
    var rateFee = parseFloat(jQuery('#feeValue').val());
    var feeType = jQuery('#feeType').val();

    if(valueAmount === 0 || isNaN(valueAmount)) {
        jQuery('#txtFee').hide();
        jQuery('#txtFee').val("");
    }
    else {
        jQuery('#txtFee').show();
        if(feeType === '%') {
            var feeFloat = parseFloat(rateFee * valueAmount / 100);
            jQuery('#txtFee').val(feeFloat.toFixed(2));
            $('#txtFee').formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: 4,
                symbol:'',
                eventOnDecimalsEntered: true
            });
        }
        else {
            var feeFloat = parseFloat(rateFee);
            jQuery('#txtFee').val(feeFloat.toFixed(2));
            $('#txtFee').formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: 4,
                symbol:'',
                eventOnDecimalsEntered: true
            });
        }
    }
};

jQuery(document).ready(function() {
    HandleTransferCard.init();
    jQuery('#txtFee').hide();
});