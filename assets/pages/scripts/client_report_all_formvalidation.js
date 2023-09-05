var AllAccountForms = function() {
    var handleAllAccountsForm = function() {
        $('#btAllReportSubmit').on('click', function(){
            App.blockUI({
                target:'#reportAllAccountContainer',
                animate:true
            });
            var formData = new FormData();
            formData.append("fromDate", jQuery('#fromAllDate').val());
            formData.append("toDate", jQuery('#toAllDate').val());
            var uploadHandler = $.ajax({
                url: "../report/AllAccountData",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#reportAllAccountContainer');
                var jsonValue = JSON.parse(msg);
                UpdateAllformNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#reportAllAccountContainer');
                InitAllAccountTableView();
            });

        });
    };

    return {
        init: function() {
            handleAllAccountsForm();
        }
    };
}();

var InitAllAccountTableView = function()
{
    var table = $('#tbAllAccountTransactionList').dataTable();
    table.fnClearTable();
};

var UpdateAllformNecessaryViews = function(jsonStringValue)
{
    InitAllAccountTableView();
    var table = $('#tbAllAccountTransactionList').dataTable();
    if(jsonStringValue.dataList.length == 0) return;
    for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
    {
        var valueTmp = jsonStringValue.dataList[i];
        var timestamp =  moment.unix(valueTmp.UPDATED_AT).format("YYYY-MM-DD HH:mm:ss");
        if(valueTmp.DETAIL_TYPE === '1')
        {
            //debt
            CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
            availableAmount = valueTmp.FROM_AVAILABLE_BALANCE;
        }
        else
        {
            //credit
            CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
            availableAmount = valueTmp.TO_AVAILABLE_BALANCE;
        }
        var description = '<a href="../request/status/' + valueTmp.ID + '" class="btn btn-link">' + '#' + valueTmp.ID +'</a>';
        table.fnAddData([
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + timestamp + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.ACCOUNT_NUMBER + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + description + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + '#' + valueTmp.TRANS_ID + ' </td>',
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.DESCRIPTION + '</td>',
            CreditOrDebit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + availableAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>'
        ]);
    }
};


jQuery(document).ready(function() {
    AllAccountForms.init();
    InitAllAccountTableView();
});