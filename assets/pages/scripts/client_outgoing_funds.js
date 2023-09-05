/**
 * Created by rock on 1/19/18.
 */
var InitFormViews = function() {
    var InitCurrencyFormat = function () {
        $('#transferAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
        $('#currencyConversionRate').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 4,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#resultAmount').formatCurrencyLive({
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
            ignore:"",
            rules: {
                fromAccount: {
                    required: true
                },
                swiftbic: {
                    required: true
                },
                bankaddress:{
                    required:true
                },
                banklocation:{
                    required:true
                },
                bankcountry:{
                    required:true
                },
                abartn:{
                    required:false
                },
                customername:{
                    required:true
                },
                customeraddress:{
                    required:true
                },
                customeriban:{
                    required:true
                },
                additionname:{
                    required:true
                },
                transferAmount:{
                    required:true
                },
                transferCurrency:{
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
        $('#transferCurrency').change(function() {
            if(this.value !== "Currency") {
                UpdateFeeTextView();
                jQuery('#resultAmount').val(calculateResultOutgoingAmount());
            }
            else
            {
                initFeeAmountTextView();
            }
        });

        $('#transferAmount').on('input', function(e){
            if($('#transferCurrency')[0].value !== "Currency") {
                UpdateFeeTextView();
                jQuery('#resultAmount').val(calculateResultOutgoingAmount());
            }
            else
            {
                initFeeAmountTextView();
            }
        });

        $('#resultAmount').on('input', function(e){
            if($('#transferCurrency')[0].value !== "Currency") {
                $('#transferAmount').val(calculateSourceAmountFromResultAmount());
                UpdateFeeTextView();
            }
            else
            {
                initFeeAmountTextView();
            }
        });

        $('#fromAccount').change(function(){
            if(this.value === '') {
                jQuery('#feeValue').val('');
                jQuery('#feeType').val('');
                UpdateFeeTextView();
                return;
            }
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
                jQuery('#feeValue').val(jsonValue[0].OWT_AMOUNT);
                jQuery('#feeType').val(jsonValue[0].OWT_TYPE);
                jQuery('#accountCurrencyConversionRate').val(jsonValue[0].CURRENCY_CONVERSION_RATE);

                if(jQuery('#transferAmount').val() === "" || jQuery('#transferAmount').val() === null) {
                    jQuery('#currencyConversionRate').val("0");
                }
                else {
                    jQuery('#currencyConversionRate').val(calculateConversionFee());
                }

                $('#transferCurrency').val($("#fromAccount").find(":selected").data("currency")).trigger('change');
                $("#accountCurrencyDisp").val($("#fromAccount").find(":selected").data("ctitle"));
                jQuery('#vpayRate').val("1");
                UpdateFeeTextView();
                jQuery('#resultAmount').val(calculateResultOutgoingAmount());
            });

            getFeeHandler.fail(function (jqXHR, textStatus) {
                initFeeAmountTextView();
                initFeeUnitValue();
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

var GetCurrencyListChangeHandler = function() {
    $('#transferCurrency').on('select2:select', function(e){
        //check if account is selected or not.
        if(jQuery('#fromAccount').val() === null || jQuery('#fromAccount').val() === "-1"){
            initFeeAmountTextView();
            initFeeUnitValue();
        }
        else {
            var formData1 = new FormData();
            formData1.append("accountId", jQuery('#fromAccount').val());
            formData1.append("targetCurrency", e.params.data.id);

            var getConversionFeeHandler = $.ajax({
                url: "../transfer/GetCurrencyConversionRate",
                type: "POST",
                data: formData1,
                processData: false,
                contentType: false,
                cache: false
            });

            getConversionFeeHandler.done(function (msg) {
                var jsonValue = JSON.parse(msg);
                if(jsonValue.vpayRate === -1) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-top-right",
                        "onclick": null,
                        "showDuration": "1000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr['error']("Can't find the matching currency pair. Create it first, please", "Currency Pair not exist");
                    initFeeAmountTextView();
                    jQuery('#resultAmount').val(calculateResultOutgoingAmount());
                }
                else {
                    jQuery('#vpayRate').val(jsonValue.vpayRate);
                    jQuery('#currencyConversionRate').val(calculateConversionFee());
                    UpdateFeeTextView();
                    jQuery('#resultAmount').val(calculateResultOutgoingAmount());
                }
            });

            getConversionFeeHandler.fail(function (jqXHR, textStatus) {
                initFeeUnitValue();
                initFeeAmountTextView();
            });

        }
    });
};

var UpdateFeeTextView = function() {
    var valueAmount = jQuery('#transferAmount').val();
    valueAmount = valueAmount.replace(new RegExp(',', 'g'), '');

    var rateFee = jQuery('#feeValue').val();
    rateFee = rateFee.replace(new RegExp(',', 'g'), '');
    var feeType = jQuery('#feeType').val();
    feeType = feeType.replace(new RegExp(',', 'g'), '');
    var txtFeeValue = jQuery('#txtFee');
    if(valueAmount === 0 || isNaN(valueAmount))
    {
        txtFeeValue.val("0");
    }
    else
    {

        if(rateFee === 'undefined' || feeType === '')
        {
            txtFeeValue.val("0");
            return;
        }
        else
        {
            if(feeType === '%')
            {
                var feeFloat = parseFloat(rateFee * valueAmount / 100);
                txtFeeValue.val(feeFloat.toFixed(2));
                $('#txtFee').formatCurrency({
                    colorize: true,
                    negativeFormat: '-%s%n',
                    roundToDecimalPlace: 2,
                    symbol:'',
                    eventOnDecimalsEntered: true
                });
            }
            else
            {
                var feeFloat = parseFloat(rateFee);
                txtFeeValue.val(feeFloat.toFixed(2));
                txtFeeValue.formatCurrency({
                    colorize: true,
                    negativeFormat: '-%s%n',
                    roundToDecimalPlace: 2,
                    symbol:'',
                    eventOnDecimalsEntered: true
                });
            }

            // if(parseFloat(jQuery('#currencyConversionRate').val()) === 1 || jQuery('#currencyConversionRate').val() === '0'){
                jQuery('#currencyConversionRate').val(calculateConversionFee());
            // }
        }

    }
};

var InitSpecifyIntermediatryBank = function(){
    var InitCheckBox = function(){
        jQuery('#intermediatrybank').on('change', function(e){
            if(this.checked) {
                ShowSpecifyViews();
            }
            else{
                HideSpecifyViews();
            }
        });
    };
    var HideSpecifyViews = function(){
        jQuery('#interSwift').val('');
        jQuery('#interSwift').closest('.form-group').hide();
        jQuery('#interName').val('');
        jQuery('#interName').closest('.form-group').hide();
        jQuery('#interAddress').val('');
        jQuery('#interAddress').closest('.form-group').hide();
        jQuery('#interLocation').val('');
        jQuery('#interLocation').closest('.form-group').hide();
        jQuery('#interCountry').val('').trigger('change');
        jQuery('#interCountry').closest('.form-group').hide();
        jQuery('#interABA').val('');
        jQuery('#interABA').closest('.form-group').hide();
        jQuery('#interACC').val('');
        jQuery('#interACC').closest('.form-group').hide();
    };
    var ShowSpecifyViews = function(){
        jQuery('#interSwift').closest('.form-group').show();
        jQuery('#interName').closest('.form-group').show();
        jQuery('#interAddress').closest('.form-group').show();
        jQuery('#interLocation').closest('.form-group').show();
        jQuery('#interCountry').closest('.form-group').show();
        jQuery('#interABA').closest('.form-group').show();
        jQuery('#interACC').closest('.form-group').show();
    };
    return {
        init: function() {
            InitCheckBox();
            HideSpecifyViews();
        }
    };
}();

var initFeeAmountTextView = function() {
    jQuery('#txtFee').val("0");
    jQuery('#currencyConversionRate').val("0");
};

var initFeeUnitValue = function() {
    jQuery('#feeValue').val("0");
    jQuery('#feeType').val("");
    jQuery('#accountCurrencyConversionRate').val("0");
    jQuery('#vpayRate').val("1");
};

var calculateResultOutgoingAmount = function() {
    var totalAmount = jQuery('#transferAmount').val();
    totalAmount = totalAmount.replace(new RegExp(',', 'g'), '');
    var conversionRate = jQuery('#currencyConversionRate').val();
    conversionRate = conversionRate.replace(new RegExp(',', 'g'), '');
    var retVal =  (parseFloat(totalAmount) * parseFloat(conversionRate)).toFixed(2);// - parseFloat(otf) - parseFloat(additionalFee);
    if(retVal === "NaN") {
        retVal = 0;
    }
    return retVal;
};

var calculateSourceAmountFromResultAmount = function() {
    var sourceAmount = jQuery('#resultAmount').val();
    sourceAmount = sourceAmount.replace(new RegExp(',', 'g'), '');
    var conversionRate = jQuery('#currencyConversionRate').val();
    conversionRate = conversionRate.replace(new RegExp(',', 'g'), '');
    var retVal =  (parseFloat(sourceAmount) / parseFloat(conversionRate)).toFixed(2);// - parseFloat(otf) - parseFloat(additionalFee);
    if(retVal === "NaN") {
        retVal = 0;
    }
    return retVal;
};

var calculateConversionFee = function() {
    var totalAmount = jQuery('#transferAmount').val();
    totalAmount = totalAmount.replace(new RegExp(',', 'g'), '');
    if(totalAmount === "") totalAmount = 1;
    var valorPayConversion = jQuery('#vpayRate').val();
    valorPayConversion = valorPayConversion.replace(new RegExp(',','g'), '');

    var accountCurrencyConversionRate = jQuery('#accountCurrencyConversionRate').val();
    accountCurrencyConversionRate = accountCurrencyConversionRate.replace(new RegExp(',','g'),'');

    if(parseFloat(valorPayConversion) === 1) {
        return 1;
    }
    else {
        var calcRate = ((totalAmount - ((accountCurrencyConversionRate / 100) * totalAmount)) * valorPayConversion) / totalAmount;
        return parseFloat(calcRate).toFixed(4);
    }
};

jQuery(document).ready(function() {
    InitFormViews.init();
    InitSpecifyIntermediatryBank.init();
    initFeeAmountTextView();
    GetCurrencyListChangeHandler();
});

var showConfirmModal = function() {
    var result  =jQuery('#formSubmit').valid();
    if(result) {
        /**
         * Initialize variables here
         */
        jQuery('#dlgAccount').html($("#fromAccount").find(":selected").data("content"));
        jQuery('#dlgSwiftBic').html($("#swiftbic").val());
        jQuery('#dlgBenificaryName').html($("#bankname").val());
        jQuery('#dlgBenificaryAddr').html($("#bankaddress").val());
        jQuery('#dlgBenificaryLocation').html($('#banklocation').val());
        jQuery('#dlgBenificaryCountry').html($('#bankcountry').find(':selected').html());
        jQuery('#dlgBenificaryABA').html($('#abartn').val());
        jQuery('#dlgCustomerName').html($('#customername').val());
        jQuery('#dlgCustomerAddr').html($('#customeraddress').val());
        jQuery('#dlgCustomerAcc').html($('#customeriban').val());
        jQuery('#dlgAdditionInfo').html($('#additionname').val());


        jQuery('#dlgTransferAmount').html($('#transferAmount').val());
        jQuery('#dlgWalletCurrency').html($('#accountCurrencyDisp').val());
        jQuery('#dlgReceiveAmount').html($('#resultAmount').val());
        jQuery('#dlgTransferCurrency').html($('#transferCurrency').find(':selected').html());
        jQuery('#dlgTransferFee').html($('#txtFee').val() + " " + $('#accountCurrencyDisp').val());
        jQuery('#dlgTransferDesc').html($('#description').val());
        jQuery('#dlgConversionRateValue').html($('#currencyConversionRate').val());

        jQuery('#responsive').modal();
    }
};

var printDialog = function() {
    var content = "<html> <head> " +
        "<meta charset=\"utf-8\" /> " +
        "<title> Outgoing Transfer Description </title> " +
        "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"> " +
        "<meta content=\"width=device-width, initial-scale=1\" name=\"viewport\" /> " +
        "<style>" +
            ".title { width: 15%; text-align: center; height: 40px; }" +
            ".content { padding-left: 10px; width: 38%; text-align: left; }" +
            ".header-title { height: 45px; text-align: center; background: #eeeeee; }" +
        "</style> </head> <body onload=\"window.print()\"> " +
        "<table border=\"1\" style=\"border: 1px solid black; border-collapse: collapse; width:96%; margin: 35px;\"> " +
        "<tr> " +
            "<td class=\"title\"> Account </td>" +
            "<td class=\"content\" colspan=\"3\" >" + jQuery('#dlgAccount').html()+" </td> " +
        "</tr> " +
        "<tr> " +
            "<td colspan=\"4\" class=\"header-title\"> SPECIFY BENEFICARY BANK </td>" +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> SWIFT/BIC </td> " +
            "<td class=\"content\" colspan=\"3\">" + jQuery('#dlgSwiftBic').html()+" </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Name </td> " +
            "<td class=\"content\" colspan=\"3\">" + jQuery('#dlgBenificaryName').html()+ "</td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Address </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgBenificaryAddr').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Location </td> " +
            "<td class=\"content\" > " + jQuery('#dlgBenificaryLocation').html()+ " </td> " +
            "<td class=\"title\"> Country </td> " +
            "<td class=\"content\" > " + jQuery('#dlgBenificaryCountry').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> ABA/RTN </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgBenificaryABA').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td colspan=\"4\" class=\"header-title\"> SPECIFY BENEFICIARY CUSTOMER </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Name </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgCustomerName').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Address </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgCustomerAddr').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Acc#/IBAN </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgCustomerAcc').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td colspan=\"4\" class=\"header-title\"> ADDITIONAL INFORMATION </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\"> Reference Message </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgAdditionInfo').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td colspan=\"4\" class=\"header-title\"> TRANSFER DESCRIPTION </td> " +
        "</tr> " +
        "<tr>" +
            "<td class=\"title\"> eWallet Debit Amount </td> " +
            "<td class=\"content\"> " + jQuery('#dlgTransferAmount').html()+ " </td> " +
            "<td class=\"title\"> eWallet Currency </td> " +
            "<td class=\"content\"> " + jQuery('#dlgWalletCurrency').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\">  Receive Amount </td> " +
            "<td class=\"content\"> " + jQuery('#dlgReceiveAmount').html()+ " </td> " +
            "<td class=\"title\">  Receive Currency </td> " +
            "<td class=\"content\"> " + jQuery('#dlgTransferCurrency').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\">  OWT Fee </td> " +
            "<td class=\"content\"> " + jQuery('#dlgTransferFee').html()+ " </td> " +
            "<td class=\"title\">  CCR </td> " +
            "<td class=\"content\"> " + jQuery('#dlgConversionRateValue').html()+ " </td> " +
        "</tr> " +
        "<tr> " +
            "<td class=\"title\">  Description </td> " +
            "<td class=\"content\" colspan=\"3\"> " + jQuery('#dlgTransferDesc').html()+ " </td> " +
        "</tr> " +
    "</table> </body> </html>";

        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write(content);
        newWin.document.close();
        // setTimeout(function(){newWin.close();},10);
};
