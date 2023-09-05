/**
 * Created by rock on 1/19/18.
 */

var FormsInit = function() {

    var InitCurrencyFormat = function () {
        $('#bAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
    };

    var handleBetweenUsers = function() {
        $('#bUserList1').change(function(){

            App.blockUI({
                target:'#formBetweenUser',
                animate:true
            });
            var senderReadAjaxData = new FormData();
            senderReadAjaxData.append("userId", this.value);
            senderReadAjaxData.append("accountType", "wallet");
            var senderReadAjaxHandler = $.ajax({
                url: "../../admin/transfer/AccountFromUser",
                type: "POST",
                data: senderReadAjaxData,
                processData: false,
                contentType: false,
                cache: false
            });

            senderReadAjaxHandler.done(function (msg) {
                App.unblockUI('#formBetweenUser');
                var jsonValue = JSON.parse(msg);
                UpdateNecessaryViews1(jsonValue);
            });

            senderReadAjaxHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#formBetweenUser');
                InitNecessaryViews1();
            });
        });
        $('#bUserList2').change(function(){

            App.blockUI({
                target:'#formBetweenUser',
                animate:true
            });
            var receiverReadAjaxData = new FormData();
            receiverReadAjaxData.append("userId", this.value);
            receiverReadAjaxData.append("accountType", "iban");

            var receiverReadAjaxHandler = $.ajax({
                url: "../../admin/transfer/AccountFromUser",
                type: "POST",
                data: receiverReadAjaxData,
                processData: false,
                contentType: false,
                cache: false
            });

            receiverReadAjaxHandler.done(function (msg) {
                App.unblockUI('#formBetweenUser');
                var jsonValue = JSON.parse(msg);
                UpdateNecessaryViews2(jsonValue);
            });

            receiverReadAjaxHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#formBetweenUser');
                InitNecessaryViews2();
            });
        });
    };

    var handleUserTransferFormValidator = function(){
        $('#formBetweenUser').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                bUserList1: {
                    required: true
                },

                bAccountList1: {
                    required: true
                },

                bUserList2: {
                    required: true
                },
                bAccountList2:{
                    required:true
                },
                bAmount: {
                    required: true
                },
                bDescription: {
                    required: true
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
    return {
        init: function() {
            InitCurrencyFormat();
            handleUserTransferFormValidator();
            handleBetweenUsers();
        }
    };
}();

var InitNecessaryViews1 = function()
{
    $('#bAccountList1').empty();
    $('#bAccountList1').selectpicker('refresh');
};

var InitNecessaryViews2 = function()
{
    $('#bAccountList2').empty();
    $('#bAccountList2').selectpicker('refresh');
};


var UpdateNecessaryViews1 = function(jsonStringValue)
{
    if(jsonStringValue.length == 0)
    {
        InitNecessaryViews1();
        return;
    }

    $('#bAccountList1').empty();

    for(i = 0 ; i < jsonStringValue.length ; i++)
    {
        $('#bAccountList1').append("<option value=\"" + jsonStringValue[i].ID + "\" data-content=\""
        +  jsonStringValue[i].ACCOUNT_NUMBER + " <span class='label label-sm label-success'> " + jsonStringValue[i].CURRENCY_TITLE
                + "  " + jsonStringValue[i].CURRENT_AMOUNT + " </span>\"> </option>");
    }

    $('#bAccountList1').selectpicker('refresh');
};

var UpdateNecessaryViews2 = function(jsonStringValue)
{
    if(jsonStringValue.length == 0)
    {
        InitNecessaryViews2();
        return;
    }

    $('#bAccountList2').empty();

    for(i = 0 ; i < jsonStringValue.length ; i++)
    {
        $('#bAccountList2').append("<option value=\"" + jsonStringValue[i].ID + "\" data-content=\""
            + jsonStringValue[i].ACCOUNT_NUMBER + " <span class='label label-sm label-success'> " + jsonStringValue[i].CURRENCY_TITLE
            + "  " + jsonStringValue[i].CURRENT_AMOUNT + " </span>\"> </option>");
    }

    $('#bAccountList2').selectpicker('refresh');
};


jQuery(document).ready(function() {
    FormsInit.init();
    InitNecessaryViews1();
    InitNecessaryViews2();
});