var DropDownLists = function () {

    var InitCurrencyFormat = function () {
        $('#iwtAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
        $('#owtAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#cftAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#currencyRate').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 4,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#minTransFeeAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
        $('#maxTransFeeAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#monthlyFeeAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#mbLimitAccount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#mbFeeAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#locLimitAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
        $('#locAnnualInterest').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

        $('#txtAnnualInterest').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });

    };

    var initCountryDropDown = function () {
        $('#countryList').change(function() {
            if(this.value !== "") {
                App.blockUI({
                    target:'#contentForm',
                    animate:true
                });

                var formData = new FormData();
                formData.append("COUNTRY", this.value);
                var uploadHandler = $.ajax({
                    url: "../../admin/profile/getCitiesFromCountry",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false
                });

                uploadHandler.done(function (msg) {
                    App.unblockUI('#contentForm');
                    var jsonValue = JSON.parse(msg);
                    UpdateNecessaryViews(jsonValue);
                });

                uploadHandler.fail(function (jqXHR, textStatus) {
                    App.unblockUI('#contentForm');
                    InitNecessaryViews();
                });

            }
            else
            {
                InitNecessaryViews();
            }

        });
    };

    var InitNecessaryViews = function()
    {
        $('#cityList').empty();
        $('#cityList').append('<option value="" data-content = "--NONE--">--NONE--</option>');
        $('#cityList').selectpicker('refresh');
    };

    var UpdateNecessaryViews = function(jsonValue)
    {
        $('#cityList').empty();
        for(i = 0 ; i < jsonValue.length ; i++)
        {
            $('#cityList').append('<option value="'+jsonValue[i].ID+'" data-content = "'+jsonValue[i].DESCRIPTION+'">'+jsonValue[i].DESCRIPTION+'</option>');
        }
        $('#cityList').selectpicker('refresh');
    };
    return {
        //main function to initiate the module
        init: function () {
            initCountryDropDown();
            InitCurrencyFormat();
        }
    };
}();


var FormValidator = function(){
    var validateFormInit = function(){
        $('#contentForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                accountType: {
                    required: true
                },
                monthlyFeeAmount: {
                    required: false
                },
                mbLimitAccount: {
                    required: false
                },
                mbFeeAmount: {
                    required: false
                },
                locLimitAmount: {
                    required: false,
                },
                locAnnualInterest: {
                    required: false
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

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
                if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    };
    return{
        init:function(){
            validateFormInit();
        }
    };
}();

jQuery(document).ready(function() {
    DropDownLists.init();
    FormValidator.init();
});