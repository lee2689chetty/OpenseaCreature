/**
 * Created by rock on 1/19/18.
 */

var FormsInit = function() {
    var InitCurrencyFormat = function () {
        $('#baAmount').formatCurrencyLive({
            colorize: true,
            negativeFormat: '-%s%n',
            roundToDecimalPlace: 2,
            symbol:'',
            eventOnDecimalsEntered: true
        });
    };

    var handleBetweenAccounts = function() {
        $('#baUserList').change(function(){
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
                var jsonValue = JSON.parse(msg);
                UpdateSenderView(jsonValue);
            });

            senderReadAjaxHandler.fail(function (jqXHR, textStatus) {
                InitSenderView();
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
                var jsonValue = JSON.parse(msg);
                UpdateReceiverView(jsonValue);
            });

            receiverReadAjaxHandler.fail(function (jqXHR, textStatus) {
                InitReceiverView();
            });
        });
    };

    var handleAccountTransferFormValidator = function(){
        $('#formbaAccounts').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                baUserList: {
                    required: true
                },

                baAccountFrom: {
                    required: true
                },

                baAccountTo: {
                    required: true
                },

                baAmount: {
                    required: true,
                    number:true
                },

                baDescription: {
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
            handleAccountTransferFormValidator();
            handleBetweenAccounts();
        }
    };
}();

var InitSenderView = function()
{
    $('#baAccountFrom').empty();
    $('#baAccountFrom').selectpicker('refresh');
};
var InitReceiverView = function()
{
    $('#baAccountTo').empty();
    $('#baAccountTo').selectpicker('refresh');
};

var UpdateSenderView = function(jsonStringValue)
{
    if(jsonStringValue.length == 0)
    {
        InitSenderView();
        return;
    }
    $('#baAccountFrom').empty();
    for(i = 0 ; i < jsonStringValue.length ; i++)
    {
        $('#baAccountFrom').append("<option value=\"" + jsonStringValue[i].ID + "\" data-content=\""
        +  jsonStringValue[i].ACCOUNT_NUMBER + " <span class='label label-sm label-success'> " + jsonStringValue[i].CURRENCY_TITLE
                + "  " + jsonStringValue[i].AVAILABLE_AMOUNT + " </span>\"> </option>");
    }
    $('#baAccountFrom').selectpicker('refresh');
};

var UpdateReceiverView = function(jsonStringValue)
{
    if(jsonStringValue.length == 0)
    {
        InitReceiverView();
        return;
    }
    $('#baAccountTo').empty();

    for(i = 0 ; i < jsonStringValue.length ; i++)
    {
        $('#baAccountTo').append("<option value=\"" + jsonStringValue[i].ID + "\" data-content=\""
            + jsonStringValue[i].ACCOUNT_NUMBER + " <span class='label label-sm label-success'> " + jsonStringValue[i].CURRENCY_TITLE
            + "  " + jsonStringValue[i].CURRENT_AMOUNT + " </span>\"> </option>");
    }
    $('#baAccountTo').selectpicker('refresh');
};

jQuery(document).ready(function() {
    FormsInit.init();
    InitSenderView();
    InitReceiverView();
});