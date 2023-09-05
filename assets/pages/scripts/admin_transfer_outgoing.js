 /**
 * Created by rock on 1/19/18.
 */
 var accountValueArray = [];
var OutgoingHandler = function() {

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

        $('#txtFee').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
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

        $('#resultFee').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
    };

    var OutgoingFormValidator = function() {
        $('#formOutgoing').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore:"",
            rules: {
                userList: {
                    required: true
                },
                accountList: {
                    required: true
                },
                bankSwift: {
                    required: true
                },
                bankAddress:{
                    required:true
                },
                bankName:{
                    required:true
                },
                bankLocation:{
                    required:true
                },
                bankCountry:{
                    required:true
                },
                bankABA:{
                    required:false
                },
                beneficaryName:{
                    required:true
                },
                beneficaryAddr:{
                    required:true
                },
                beneficaryAcc:{
                    required:true
                },
                addionAddress:{
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
                makeJsonForFee();
                form.submit(); // form validation success, call ajax form submit
            }
        });

        $('#transferAmount').on('input', function(e){
            if($('#transferCurrency')[0].value !== "Currency") {
                UpdateFeeTextView();
                calculateTotalFee();
                jQuery('#resultAmount').val(calculateResultOutgoingAmount());

            }
            else {
                initFeeAmountTextView();
            }
        });

        $('#resultAmount').on('input', function(e){
            if($('#transferCurrency')[0].value !== "Currency") {
                $('#transferAmount').val(calculateSourceAmountFromResultAmount());
                UpdateFeeTextView();
                calculateTotalFee();

            }
            else {
                initFeeAmountTextView();
            }
        });
    };

    var OutgoingUserAccountHandler = function(){
        $('#userList').change(function(){

            App.blockUI({
                target:'#formOutgoing',
                animate:true
            });

            initFeeUnitValue();
            UpdateFeeTextView();
            jQuery('#resultAmount').val(calculateResultOutgoingAmount());
            var formData = new FormData();
            formData.append("userId", this.value);
            var accountReadHandler1 = $.ajax({
                url: "../../admin/transfer/GetAccountForOutGoing",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            accountReadHandler1.done(function (msg) {
                App.unblockUI('#formOutgoing');
                var jsonValue = JSON.parse(msg);
                UpdateNecessaryViews(jsonValue);
            });

            accountReadHandler1.fail(function (jqXHR, textStatus) {
                App.unblockUI('#formOutgoing');
                InitNecessaryViews();
            });
        });
    };

    var GetOutgoingFeeFromAccountHandler = function(){
      $('#accountList').change(function(e){
          App.blockUI({
              target:'#formOutgoing',
              animate:true
          });
          if(parseInt(this.value) === -1)
          {
              initFeeUnitValue();
              initFeeAmountTextView();
              UpdateFeeTextView();
              jQuery('#resultAmount').val(calculateResultOutgoingAmount());
              App.unblockUI('#formOutgoing');
              return;
          }

          var formData = new FormData();
          formData.append("accountId", this.value);
          var getFeeHandler = $.ajax({
              url: "../../admin/transfer/GetFeeValueFromAccount",
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              cache: false
          });

          getFeeHandler.done(function (msg) {
              App.unblockUI('#formOutgoing');
              var jsonValue = JSON.parse(msg);
              jQuery('#feeValue').val(jsonValue[0].OWT_AMOUNT);
              jQuery('#feeType').val(jsonValue[0].OWT_TYPE);
              jQuery('#accountCurrencyConversionRate').val(jsonValue[0].CURRENCY_CONVERSION_RATE);
              jQuery('#currencyConversionRate').val(calculateConversionFee());

          });

          getFeeHandler.fail(function (jqXHR, textStatus) {
              App.unblockUI('#formOutgoing');
              initFeeUnitValue();
              jQuery('#accountCurrencyConversionRate').val("");
              initFeeAmountTextView();
          });


          /***
           * Change Currency Kind
           */
          var accountSelectedValue = accountValueArray[$('#accountList').prop('selectedIndex') - 1];
               //it is eWallet
          $('#transferCurrency').val(accountSelectedValue.CURRENCY_TYPE).trigger('change');
          jQuery('#vpayRate').val("1");
          $("#accountCurrencyDisp").val(accountSelectedValue.CURRENCY_TITLE);

      });

    };

    var GetCurrencyListChangeHandler = function() {
        $('#transferCurrency').on('select2:select', function(e){
            //check if account is selected or not.
             if(jQuery('#accountList').val() === null || jQuery('#accountList').val() === "-1"){
                 initFeeAmountTextView();
                 initFeeUnitValue();
             }
             else {
                 var formData1 = new FormData();
                 formData1.append("accountId", jQuery('#accountList').val());
                 formData1.append("targetCurrency", e.params.data.id);

                 var getConversionFeeHandler = $.ajax({
                     url: "../../admin/transfer/GetCurrencyConversionRate",
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
                         jQuery('#resultAmount').val('0');
                     }
                     else {
                         jQuery('#vpayRate').val(jsonValue.vpayRate);
                         jQuery('#currencyConversionRate').val(calculateConversionFee());
                         UpdateFeeTextView();
                         jQuery('#resultAmount').val(calculateResultOutgoingAmount());
                     }
                 });

                 getConversionFeeHandler.fail(function (jqXHR, textStatus) {
                     initFeeAmountTextView();
                 });
             }
        });
    };

    var initConversionRateListener = function() {
        jQuery('#currencyConversionRate').on('input', function(e) {
            if(jQuery('#currencyConversionRate').val() !== "") {
                jQuery('#resultAmount').val(calculateResultOutgoingAmount());
            }
            else {
                jQuery('#currencyConversionRate').val('0');
            }
        });

        jQuery('#txtFee').on('input' , function(e) {
           if(jQuery('#txtFee').val() !== "") {
               // jQuery('#resultAmount').val(calculateResultOutgoingAmount());
               calculateTotalFee();
           }
           else {
               jQuery('#txtFee').val("0");
           }
        });

        jQuery('#btAddFee').on('click', function(e) {
            jQuery('#divAdditionalFeeContainer').append("<div class=\"form-group\"> " +
                                                        "<div class=\"col-sm-offset-2 col-sm-3\"> " +
                                                        "<input type=\"text\" class=\"form-control  margin-top-5 txtadditionfee\" value=\"0\" > </div> " +
                                                        "<div class=\"col-sm-5\"> " +
                                                        "<input type=\"text\" class=\"form-control  margin-top-5 txtadditiondesc\" placeholder=\"Additional Fee Description\"> " +
                                                        "</div>" +
                                                        "<div class=\"col-sm-1\"> <button type=\"button\" class=\"btn btn-block red removeadditionfee\"> Remove </button></div> " +
                                                        "</div>");


            $('.txtadditionfee').formatCurrencyLive({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: 2,
                symbol:'',
                eventOnDecimalsEntered: true
            });

        });

        jQuery('#divAdditionalFeeContainer').on('click', 'button', function(e) {
            var removeDiv = e.target.closest('.form-group');
           removeDiv.remove();
            calculateTotalFee();
        });

        jQuery('#divAdditionalFeeContainer').on('input', 'input.txtadditionfee', function(){
            calculateTotalFee();
        });

        // jQuery('#test').on('click', function(){
        //     makeJsonForFee();
        // });
    };

    return {
        init: function() {
            InitCurrencyFormat();
            OutgoingFormValidator();
            OutgoingUserAccountHandler();
            GetOutgoingFeeFromAccountHandler();
            GetCurrencyListChangeHandler();
            initConversionRateListener();
        }
    };
}();

var InitNecessaryViews = function() {
    $('#accountList').empty();
    $('#accountList').selectpicker('refresh');
};

var UpdateNecessaryViews = function(jsonStringValue) {
    if(jsonStringValue.length === 0)
    {
        InitNecessaryViews();
        return;
    }
    var accountList = $('#accountList');
    accountValueArray = [];
    accountList.empty();
    accountList.append("<option value=\"-1\" data-content=\"Choose Account\"> </option>");
    for(i = 0 ; i < jsonStringValue.length ; i++)
    {
        accountValueArray.push(jsonStringValue[i]);
        $('#accountList').append("<option value=\"" + jsonStringValue[i].ID + "\" data-content=\""
            + jsonStringValue[i].ACCOUNT_NUMBER + " <span class='label label-sm label-success'> " + jsonStringValue[i].CURRENCY_TITLE
            + "  " + jsonStringValue[i].CURRENT_AMOUNT + " </span>\"> </option>");
    }
    accountList.selectpicker('refresh');
};

var UpdateFeeTextView = function() {
    var valueAmount = jQuery('#transferAmount').val();
    valueAmount = valueAmount.replace(new RegExp(',', 'g'), '');
    var rateFee = jQuery('#feeValue').val();
    rateFee = rateFee.replace(new RegExp(',', 'g'), '');
    var rateType = jQuery('#feeType').val();
    rateType = rateType.replace(new RegExp(',', 'g'), '');

    if(rateType === "") {
        // jQuery('#txtFee').hide();
        // jQuery('#currencyConversionRate').hide();
        jQuery('#txtFee').val("0");
        jQuery('#currencyConversionRate').val("0");
        return;
    }

    if(valueAmount === 0 || isNaN(valueAmount)) {
        jQuery('#txtFee').val("0");
        jQuery('#currencyConversionRate').val("0");
    }
    else {
        if(rateType === "%") {
            var feeFloat = parseFloat(rateFee * valueAmount / 100);
            jQuery('#txtFee').val(parseFloat(feeFloat).toFixed(2));
        }
        else {
            jQuery('#txtFee').val(parseFloat(rateFee).toFixed(2));
        }

        $('#txtFee').formatCurrency({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        calculateTotalFee();
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
};

var initFeeUnitValue = function() {
    jQuery('#feeValue').val("");
    jQuery('#feeType').val("");
    jQuery('#accountCurrencyConversionRate').val("");
    jQuery('#vpayRate').val("");
};

var makeJsonForFee = function() {
    var arrFee = jQuery('#divAdditionalFeeContainer .txtadditionfee');
    var arrDesc = jQuery('#divAdditionalFeeContainer .txtadditiondesc');
    var resultVal = [];

    for(var i = 0 ; i < arrFee.length ; i++) {
        var feeVal = arrFee[i].value;
        var descVal = arrDesc[i].value;
        var obj = Object();
        obj.fee = feeVal;
        obj.desc = descVal;
        resultVal.push(obj);
    }
    var myJsonString = JSON.stringify(resultVal);
    jQuery('#additionalFeeTotal').val(myJsonString);
};

var calculateTotalFee = function() {
    var arrController = jQuery('#divAdditionalFeeContainer .txtadditionfee');
    var totalValue = 0;
    jQuery.each(arrController, function(index, itemTxt){
        var valueItem = itemTxt.value;
        valueItem = valueItem.replace(new RegExp(',', 'g'), '');
        totalValue += parseFloat(valueItem);
    });

    totalValue = totalValue.toFixed(2);

    var otf = jQuery('#txtFee').val();
    otf = otf.replace(new RegExp(',', 'g'), '');
    totalValue = parseFloat(totalValue) + parseFloat(otf);
    totalValue = totalValue.toFixed(2);
    jQuery('#resultFee').val(totalValue);
};

var calculateConversionFee = function() {
    var totalAmount = jQuery('#transferAmount').val();
    totalAmount = totalAmount.replace(new RegExp(',', 'g'), '');
    if(totalAmount === "") totalAmount = 1;
    var valorPayConversion = jQuery('#vpayRate').val();
    valorPayConversion = valorPayConversion.replace(new RegExp(',', 'g'), '');
    var accountCurrencyConversionRate = jQuery('#accountCurrencyConversionRate').val();
    accountCurrencyConversionRate = accountCurrencyConversionRate.replace(new RegExp(',', 'g'), '');

    if(parseFloat(valorPayConversion) === 1) {
        return 1;
    }
    else {
        var calcRate = ((totalAmount - ((accountCurrencyConversionRate / 100) * totalAmount)) * valorPayConversion) / totalAmount;
        return parseFloat(calcRate).toFixed(4);
    }
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

jQuery(document).ready(function() {
    OutgoingHandler.init();
    InitNecessaryViews();
    InitSpecifyIntermediatryBank.init();
    initFeeAmountTextView();
});

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

 var showConfirmModal = function() {
     var result  =jQuery('#formOutgoing').valid();
     if(result) {
         /**
          * Initialize variables here
          */
         jQuery('#dlgAccount').html($("#accountList").find(":selected").data("content"));
         jQuery('#dlgSwiftBic').html($("#bankSwift").val());
         jQuery('#dlgBenificaryName').html($("#bankName").val());
         jQuery('#dlgBenificaryAddr').html($("#bankAddress").val());
         jQuery('#dlgBenificaryLocation').html($('#bankLocation').val());
         jQuery('#dlgBenificaryCountry').html($('#bankCountry').find(':selected').html());
         jQuery('#dlgBenificaryABA').html($('#bankABA').val());

         jQuery('#dlgCustomerName').html($('#beneficaryName').val());
         jQuery('#dlgCustomerAddr').html($('#beneficaryAddr').val());
         jQuery('#dlgCustomerAcc').html($('#beneficaryAcc').val());
         jQuery('#dlgAdditionInfo').html($('#addionAddress').val());

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