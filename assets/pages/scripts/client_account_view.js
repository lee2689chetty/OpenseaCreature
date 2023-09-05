/**
 * Created by rock on 1/19/18.
 */

var Login = function() {
    var handleGetTransHistory = function() {
        $('#formTransfer').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                fromAccount: {
                    required: true
                },
                toAccount: {
                    required: true
                },
                amount:{
                    required:true,
                    number:true
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
    var handleDropDown = function () {
        $('#account').change(function() {
            //if choosed correct currency, then get fee rate for outgoing
            if(this.value !== "") {
                App.blockUI({
                    target:'#tab_1_1',
                    animate:true
                });

                var formData = new FormData();
                formData.append("accountId", this.value);
                var uploadHandler = $.ajax({
                    url: "../account/getBankAccountAjax",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false
                });

                uploadHandler.done(function (msg) {
                    App.unblockUI('#tab_1_1');
                    var jsonValue = JSON.parse(msg);
                    UpdateNecessaryViews(jsonValue);
                });

                uploadHandler.fail(function (jqXHR, textStatus) {
                    App.unblockUI('#tab_1_1');
                    InitNecessaryViews();
                });

            }
            else
            {
                InitNecessaryViews();
            }
        });

    };

    return {
        init: function() {
            handleGetTransHistory();
            handleDropDown();
            // handleSearchFormSubmit();
        }
    };
}();
var InitNecessaryViews = function()
{
    jQuery('#txtCurrentBalance').text("No data");
    jQuery('#txtAvailableDesc').text("-----------");
    jQuery('#txtAccountType').text("-----");
    jQuery('#txtCurrencyType').text("-----");
    InitTableView();
};

var InitTableView = function()
{
    var table = $('#tbHistoryList').dataTable();
    table.fnClearTable();
};

var UpdateNecessaryViews = function(jsonStringValue)
{
  //convert json value to array and update its value
    jQuery('#txtCurrentBalance').text(jsonStringValue[0].CURRENCY_TITLE + " " + jsonStringValue[0].CURRENT_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    jQuery('#txtAvailableDesc').text(jsonStringValue[0].CURRENCY_TITLE + " " + jsonStringValue[0].AVAILABLE_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " available");
    jQuery('#txtAccountType').text(jsonStringValue[0].FEE_TYPE);
    jQuery('#txtCurrencyType').text(jsonStringValue[0].CURRENCY_TITLE);
    InitTableView();
    var table = $('#tbHistoryList').dataTable();

    console.log(jsonStringValue);
    if(jsonStringValue[0].transaction.length < 1)
        return;
    for (var i = 0, len = jsonStringValue[0].transaction.length; i < len; i++) {
        var valueTmp = jsonStringValue[0].transaction[i];
        var timestamp =  moment.unix(valueTmp.UPDATED_AT).format("YYYY-MM-DD HH:mm:ss");
        var CreditOrDebit = "";
        var availableAmount = "";
        var status = "";
        var currentAmount = "";
        if(jsonStringValue[0].ID === valueTmp.FROM_ACCOUNT)
        {
            CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
            availableAmount = valueTmp.FROM_AVAILABLE_BALANCE;
            currentAmount = valueTmp.FROM_CURRENT_BALANCE;
        }
        else
        {
            CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
            availableAmount = valueTmp.TO_AVAILABLE_BALANCE;
            currentAmount = valueTmp.TO_CURRENT_BALANCE;
        }

        var description = '<a href="../request/status/' + valueTmp.ID + '" class="btn btn-link">' + '#' + valueTmp.ID +'</a>';

        status = '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.STATUS_DESCRIPTION + ' </td>';
        table.fnAddData(['<td style="padding-top: 35px; padding-bottom: 35px;"> ' + timestamp + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + description + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.DESCRIPTION + ' </td>',
            CreditOrDebit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + currentAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + availableAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' </td>',

            status
        ]);
    }
};

jQuery(document).ready(function() {
    Login.init();
    InitNecessaryViews();
});