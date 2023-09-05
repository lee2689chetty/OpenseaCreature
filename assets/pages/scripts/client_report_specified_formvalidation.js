/**
 * Created by rock on 1/19/18.
 */

var FormsInit = function() {
    var handleSpcifiedForm = function() {
        $('#btSpecAccountSubmit').on('click', function(){
            if(jQuery('#accountNumber').val() === "") return;

            App.blockUI({
                target:'#formSpecified',
                animate:true
            });
            var formData = new FormData();
            formData.append("accountNumber", jQuery('#accountNumber').val());
            formData.append("fromDate", jQuery('#fromDate').val());
            formData.append("toDate", jQuery('#toDate').val());
            var uploadHandler = $.ajax({
                url: "../report/SpecificAccountData",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#formSpecified');
                var jsonValue = JSON.parse(msg);
                UpdateNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#formSpecified');
                InitNecessaryViews();
            });
        });
    };

    return {
        init: function() {
            handleSpcifiedForm();
        }
    };
}();

var InitNecessaryViews = function()
{
    jQuery('#txtAvailable').text("No data");
    jQuery('#txtAvailableDesc').text("-----------");
    jQuery('#txtAccountType').text("-----");
    jQuery('#txtCurrencyType').text("-----");
    jQuery('#txtAccountOwner').text("-----");

    InitTableView();
};

var InitTableView = function()
{
    var table = $('#tbTransHistory').dataTable();
    table.fnClearTable();
};

var UpdateNecessaryViews = function(jsonStringValue)
{
    if(jsonStringValue.accountData.length == 0)
        return;
    jQuery('#txtAvailable').text(jsonStringValue.accountData[0].CURRENCY_TITLE + " " + jsonStringValue.accountData[0].CURRENT_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    jQuery('#txtAvailableDesc').text(jsonStringValue.accountData[0].CURRENCY_TITLE + " " + jsonStringValue.accountData[0].AVAILABLE_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " available");
    jQuery('#txtAccountType').text(jsonStringValue.accountData[0].FEE_TYPE);
    jQuery('#txtCurrencyType').text(jsonStringValue.accountData[0].CURRENCY_TITLE);
    jQuery('#txtAccountOwner').text(jsonStringValue.accountData[0].NAME);
    InitTableView();
    var table = $('#tbTransHistory').dataTable();
    if(jsonStringValue.dataList.length === 0)
        return;
    for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
    {
        var valueTmp = jsonStringValue.dataList[i];
        var timestamp =  moment.unix(valueTmp.UPDATED_AT).format("YYYY-MM-DD HH:mm:ss");

        if(valueTmp.DETAIL_TYPE === '1')
        {
            CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -' + (parseFloat(valueTmp.AMOUNT).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) + ' </p> </span> </td>';
            availableAmount = valueTmp.FROM_AVAILABLE_BALANCE.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        else
        {
            CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) + ' </p> </span> </td>';
            availableAmount = valueTmp.TO_AVAILABLE_BALANCE.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        status = '<td style="padding-top: 35px; padding-bottom: 35px;">' + valueTmp.STATUS_DESCRIPTION + '</td>';

        var transferId = '<a href="../request/status/' + valueTmp.TRANS_ID + '" class="btn btn-link">' + '#' + valueTmp.TRANS_ID +'</a>';

        table.fnAddData([
            '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ transferId +' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.DESCRIPTION + '</td>',
            CreditOrDebit,
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + availableAmount + '</td>',
            status
        ]);
    }
};


jQuery(document).ready(function() {
    FormsInit.init();
    InitNecessaryViews();
});