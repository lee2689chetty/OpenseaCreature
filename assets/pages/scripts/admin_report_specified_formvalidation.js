/**
 * Created by rock on 1/19/18.
 */

var SpecifiedFormsInit = function() {
    var handleSpcifiedAccountReport = function() {
        $('#btSpeicifedAccountGenerate').on('click', function(){
            var formData = new FormData();
            formData.append("accountNumber", jQuery('#specifiedAccountNumber').val());
            formData.append("fromDate", jQuery('#fromSpecificAllDate').val());
            formData.append("toDate", jQuery('#toSpecificAllDate').val());
            var uploadHandler = $.ajax({
                url: "../../admin/report/SpecifiedAccountReport",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSpecificAccount');
                var jsonValue = JSON.parse(msg);
                UpdateSpecificNecessaryView.UpdateSpecificAccountNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSpecificAccount');
                InitSpecificNecessaryViews.InitSpecifiedAccountNecessaryView();
            });

        });
    };

    var handleAllAccountReport = function() {
        $('#btSpeicifedAllGenerate').on('click', function(){
            App.blockUI({
                target:'#containerSpecificAllTrans',
                animate:true
            })
            var formData = new FormData();
            formData.append("userId", jQuery('#allUserID').val());
            formData.append("fromDate", jQuery('#fromAllDate').val());
            formData.append("toDate", jQuery('#toAllDate').val());
            var uploadHandler = $.ajax({
                url: "../../admin/report/SpecifiedAllReport",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSpeficAllTrans');
                var jsonValue = JSON.parse(msg);
                UpdateSpecificNecessaryView.UpdateSpecificAllNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSpeficAllTrans');
                InitSpecificNecessaryViews.InitSpecifiedAllNecessaryView();
            });

        });
    };

    var handleBalanceReport = function() {
        $('#btBalanceReportGenerate').on('click', function(){
            var formData = new FormData();
            formData.append("userId", jQuery('#balanceUserID').val());
            var uploadHandler = $.ajax({
                url: "../../admin/report/SpecifiedBalanceReport",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSpecifcBalance');
                var jsonValue = JSON.parse(msg);
                UpdateSpecificNecessaryView.UpdateSpecificBalanceNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSpecifcBalance');
                InitSpecificNecessaryViews.InitSpecifiedBalanceNecessaryView();
            });

        });
    };

    return {
        init: function() {
            handleSpcifiedAccountReport();
            handleAllAccountReport();
            handleBalanceReport();
        }
    };
}();


var InitSpecificNecessaryViews = function() {
    var InitSpecificAccountNecessaryViews = function() {
        jQuery('#txtSpecificAccountUserName').text("------");
        jQuery('#txtSpecificAccountUserFullName').text("------");
        jQuery('#txtSpecificAccountUserCreatedAt').text("------");
        jQuery('#txtSpecificAccountCreatedAt').text("-----");
        jQuery('#txtSpecificAccountNumber').text("-----");
        jQuery('#txtSpecificAccountType').text("-----");
        jQuery('#txtSpecificAccountCurrency').text("-----");
        jQuery('#txtSpecificAccountAvailableBalance').text("-----");
        jQuery('#txtSpecificAccountCurrentBalance').text("-----");
        InitSpecificTableView.InitSpecifiedAccountTableInit();
    };
    var InitSpecificAllNecessaryViews = function() {
        InitSpecificTableView.InitSpecifiedAllReportTableInit();
    };

    var InitSpecificBalanceNecessaryViews = function() {
        jQuery('#txtBalanceUserName').text("------");
        jQuery('#txtBalanceFullname').text("------");
        jQuery('#txtBalanceProfileCreation').text("------");
        InitSpecificTableView.InitSpecifiedBalanceReportTableInit();
    };

    return {
      InitSpecifiedAccountNecessaryView:function(){
          InitSpecificAccountNecessaryViews();
      },
        InitSpecifiedAllNecessaryView:function(){
            InitSpecificAllNecessaryViews();
        },
        InitSpecifiedBalanceNecessaryView:function(){
            InitSpecificBalanceNecessaryViews();
        }
    };
}();

var InitSpecificTableView = function() {
    return {
        InitSpecifiedAccountTableInit:function()
        {
            var table = $('#tbSpecificAccountReport').dataTable();
            table.fnClearTable();
        },
        InitSpecifiedAllReportTableInit:function()
        {
            var table = $('#tbSpecificAllReport').dataTable();
            table.fnClearTable();
        },
        InitSpecifiedBalanceReportTableInit:function()
        {
            var table = $('#tbBalanceReport').dataTable();
            table.fnClearTable();
        }
    };
}();

var UpdateSpecificNecessaryView = function()
{
    var UpdateSpeificAccountNecessaryViews = function(jsonStringValue) {
        if(jsonStringValue.accountData.length == 0)
            return;
        var accountData = jsonStringValue.accountData[0];
        jQuery('#txtSpecificAccountUserName').text(accountData.NAME);
        jQuery('#txtSpecificAccountUserFullName').text(accountData.USER_FULLNAME);
        var userCreationDateTime =  moment.unix(accountData.USER_CREATED_AT).format("YYYY-MM-DD");
        jQuery('#txtSpecificAccountUserCreatedAt').text(userCreationDateTime);
        var accountCreationDateTime =  moment.unix(accountData.CREATED_AT).format("YYYY-MM-DD");
        jQuery('#txtSpecificAccountCreatedAt').text(accountCreationDateTime);
        jQuery('#txtSpecificAccountNumber').text(accountData.ACCOUNT_NUMBER);
        jQuery('#txtSpecificAccountType').text(accountData.FEE_TYPE);
        jQuery('#txtSpecificAccountCurrency').text(accountData.CURRENCY_TITLE);
        jQuery('#txtSpecificAccountAvailableBalance').text(accountData.AVAILABLE_AMOUNT);
        jQuery('#txtSpecificAccountCurrentBalance').text(accountData.CURRENT_AMOUNT);
        InitSpecificTableView.InitSpecifiedAccountTableInit();

         var table = $('#tbSpecificAccountReport').dataTable();
         if(jsonStringValue.dataList.length === 0)
         return;
         for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
         {
         var valueTmp = jsonStringValue.dataList[i];
         var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD");

         if(valueTmp.DETAIL_TYPE === '1')
         {
             CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
             availableAmount = valueTmp.FROM_AVAILABLE_BALANCE;
         }
         else
         {
             CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
             availableAmount = valueTmp.TO_AVAILABLE_BALANCE;
         }

         if(valueTmp.STATUS === '0')
         {
             status = '<td style="padding-top: 35px; padding-bottom: 35px;"> <i class="font-lg icon-check font-grey-salsa"></i> </td>';
         }
         else
         {
             //approve
             status = '<td style="padding-top: 35px; padding-bottom: 35px;"> <i class="font-lg icon-check font-green-meadow"></i> </td>';
         }

         table.fnAddData([
             '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
             '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ '#' + valueTmp.ID +' </td>',
             '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.DESCRIPTION + '</td>',
             CreditOrDebit,
             '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + availableAmount + '</td>',
             status
         ]);
         }

    };
    var UpdateSpeificAllNecessaryViews = function(jsonStringValue) {
        InitSpecificTableView.InitSpecifiedAllReportTableInit();
        var table = $('#tbSpecificAllReport').dataTable();
        if(jsonStringValue.dataList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
        {
            var valueTmp = jsonStringValue.dataList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD");

            if(valueTmp.DETAIL_TYPE === '1')
            {
                CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
                availableAmount = valueTmp.FROM_AVAILABLE_BALANCE;
            }
            else
            {
                CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT)) + ' </p> </span> </td>';
                availableAmount = valueTmp.TO_AVAILABLE_BALANCE;
            }

            if(valueTmp.STATUS === '0')
            {
                status = '<td style="padding-top: 35px; padding-bottom: 35px;"> <i class="font-lg icon-check font-grey-salsa"></i> </td>';
            }
            else
            {
                //approve
                status = '<td style="padding-top: 35px; padding-bottom: 35px;"> <i class="font-lg icon-check font-green-meadow"></i> </td>';
            }

            table.fnAddData([
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ '#' + valueTmp.ID +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.DESCRIPTION + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.TITLE + '</td>',
                CreditOrDebit
            ]);
        }

    };

    var UpdateSpeificBalanceNecessaryViews = function(jsonStringValue) {
        if(jsonStringValue.userData.length == 0)
            return;
        var userData = jsonStringValue.userData[0];
        jQuery('#txtBalanceUserName').text(userData.NAME);
        jQuery('#txtBalanceFullname').text(userData.FULL_NAME);
        var userCreationDateTime =  moment.unix(userData.CREATED_AT).format("YYYY-MM-DD");
        jQuery('#txtBalanceProfileCreation').text(userCreationDateTime);

        InitSpecificTableView.InitSpecifiedBalanceReportTableInit();
        var table = $('#tbBalanceReport').dataTable();
        if(jsonStringValue.accountList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.accountList.length; i++)
        {
            var valueTmp = jsonStringValue.accountList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD");

            table.fnAddData([
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.ACCOUNT_TYPE_DESC + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.CURRENCY_TITLE +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.AVAILABLE_AMOUNT +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.CURRENT_AMOUNT +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.STATUS_DESCRIPTION + '</td>'
            ]);
        }

    };

    return {
        UpdateSpecificAccountNecessaryViews: function(jsonStringValue){
            UpdateSpeificAccountNecessaryViews(jsonStringValue);
        },
        UpdateSpecificAllNecessaryViews: function(jsonStringValue){
            UpdateSpeificAllNecessaryViews(jsonStringValue);
        },
        UpdateSpecificBalanceNecessaryViews: function(jsonStringValue){
            UpdateSpeificBalanceNecessaryViews(jsonStringValue);
        }
    }
}();


jQuery(document).ready(function() {
    SpecifiedFormsInit.init();
    InitSpecificNecessaryViews.InitSpecifiedAccountNecessaryView();
});