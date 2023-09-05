var InitSpecifiedReportTableView = function () {

    var initSpecifiedAccountReportTableView = function () {
        var table = $('#tbSpecificAccountReport');
        init6RowsTable(table);
    };

    return {
        //main function to initiate the module
        init: function () {
            initSpecifiedAccountReportTableView();
        }
    };
}();
var init6RowsTable = function(table)
{
    var oTable = table.dataTable({
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No entries found",
            "infoFiltered": "(filtered1 from _MAX_ total entries)",
            "lengthMenu": "_MENU_ entries",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        },
        "pagingType": "bootstrap_full_number",
        buttons: [
            { extend: 'print', className: 'btn dark btn-outline' },
            { extend: 'pdf', className: 'btn green btn-outline' },
            { extend: 'csv', className: 'btn purple btn-outline ' }
        ],

        // setup responsive extension: http://datatables.net/extensions/responsive/
        responsive: true,
        "columns":
            [{
                "orderable": false
            },
                {
                    "orderable": false
                },
                {
                    "orderable": false
                },
                {
                    "orderable": false
                },
                {
                    "orderable": false
                },
                {
                    "orderable": false
                },
                {
                    "orderable": false
                },
                {
                    "orderable": false
                }],

        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"] // change per page values here
        ],
        "order": [[ 0, "desc" ]],
        // set the initial value
        "pageLength": 15,
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>" // horizobtal scrollable datatable
    });
};

var SpecifiedFormsInit = function() {
    var handleSpcifiedAccountReport = function() {
        $('#btSpeicifedAccountGenerate').on('click', function(){
            InitSpecificNecessaryViews.InitSpecifiedAccountNecessaryView();
            var formData = new FormData();
            formData.append("accountNumber", jQuery('#specifiedAccountNumber').val());
            formData.append("fromDate", jQuery('#fromSpecificAllDate').val());
            formData.append("toDate", jQuery('#toSpecificAllDate').val());
            var uploadHandler = $.ajax({
                url: "../../report/SpecifiedAccountReport",
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

            });

        });
    };
    return {
        init: function() {
            handleSpcifiedAccountReport();
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

    return {
        InitSpecifiedAccountNecessaryView:function(){
            InitSpecificAccountNecessaryViews();
        }
    };
}();

var InitSpecificTableView = function() {
    return {
        InitSpecifiedAccountTableInit:function()
        {
            var table = $('#tbSpecificAccountReport').dataTable();
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
        jQuery('#txtSpecificAccountAvailableBalance').text(accountData.AVAILABLE_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        jQuery('#txtSpecificAccountCurrentBalance').text(accountData.CURRENT_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

        // jQuery('#txtSpecificAccountAvailableBalance').formatCurrency({ roundToDecimalPlace: 2, suppressCurrencySymbol:false, symbol:''});
        // jQuery('#txtSpecificAccountCurrentBalance').formatCurrency({ roundToDecimalPlace: 2, suppressCurrencySymbol:false, symbol:''});

        InitSpecificTableView.InitSpecifiedAccountTableInit();

        var table = $('#tbSpecificAccountReport').dataTable();
        if(jsonStringValue.dataList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
        {
            var valueTmp = jsonStringValue.dataList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD HH:mm:ss");
            var CreditOrDebit, availableAmount, currentAmount, status, description;
            if(valueTmp.DETAIL_TYPE === '1')
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

            if(valueTmp.STATUS < 3 || valueTmp.STATUS === 5)
            {
                status = '<td style="padding-top: 35px; padding-bottom: 35px;"> <i class="font-lg icon-check font-grey-salsa"></i> </td>';
            }
            else
            {
                //approve
                status = '<td style="padding-top: 35px; padding-bottom: 35px;"> <i class="font-lg icon-check font-green-meadow"></i> </td>';
            }

            var transactionType = "";
            switch (parseInt(valueTmp.TRANSACTION_TYPE))
            {
                case 1:
                    transactionType = "Transfer Between Accounts";
                    break;
                case 2:
                    transactionType = "Transfer Between Users";
                    break;
                case 3:
                    transactionType = "Outgoing Wire Transfer";
                    break;
                case 4:
                    transactionType = "Card Funding Transfer";
                    break;
                case 5:
                    transactionType = "Incoming Wire Transfer";
                    break;
                case 6:
                    transactionType = "Account Debit Transfer";
                    break;
                case 7:
                    transactionType = "Account Credit Transfer";
                    break;
            }
            description = '<a href="../../request/status/' + valueTmp.ID + '" class="btn btn-link">' + valueTmp.DESCRIPTION +'</a>';
            table.fnAddData([
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ '#' + valueTmp.ID +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + description + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + transactionType + '</td>',
                CreditOrDebit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + availableAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + currentAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>',
                status
            ]);
        }

    };

    return {
        UpdateSpecificAccountNecessaryViews: function(jsonStringValue){
            UpdateSpeificAccountNecessaryViews(jsonStringValue);
        }
    }
}();

var InitUserDropDown = function()
{
    function InitUserSelect() {
        $('#specifiedUserId').change(function () {

            App.blockUI({
                target: '#containerSpecificAccount',
                animate: true
            });
            var senderReadAjaxData = new FormData();
            senderReadAjaxData.append("userId", this.value);
            senderReadAjaxData.append("accountType", "");
            var senderReadAjaxHandler = $.ajax({
                url: "../../transfer/AccountFromUser",
                type: "POST",
                data: senderReadAjaxData,
                processData: false,
                contentType: false,
                cache: false
            });

            senderReadAjaxHandler.done(function (msg) {
                App.unblockUI('#containerSpecificAccount');
                var jsonValue = JSON.parse(msg);
                UpdateAccountDropdown(jsonValue);
            });

            senderReadAjaxHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSpecificAccount');
                InitAccountDropdown();
            });
        });
    }
    var accountDropDown = $('#specifiedAccountNumber');
    function UpdateAccountDropdown(jsonStringValue) {
        InitAccountDropdown();
        if(jsonStringValue.length === 0) {return;}
        // accountDropDown.empty();

        for(i = 0 ; i < jsonStringValue.length ; i++) {
            accountDropDown.append("<option value=\"" + jsonStringValue[i].ID + "\" data-anumber=\""
                +  jsonStringValue[i].ACCOUNT_NUMBER + "\" data-currency=\"" + jsonStringValue[i].CURRENCY_TITLE
                +"\" data-amount=\"" + jsonStringValue[i].CURRENT_AMOUNT + "\">" + jsonStringValue[i].ACCOUNT_NUMBER
                + "</option>");
        }
        accountDropDown.select2("val", "");
    }

    function InitAccountDropdown(){
        accountDropDown.empty();
        accountDropDown.select2("val", "");
        // accountDropDown.select2("destroy");
        // accountDropDown.select2();
    }

    return {
        init: function(){
            InitUserSelect();
        }
    }
}();


jQuery(document).ready(function() {
    InitSpecifiedReportTableView.init();
    SpecifiedFormsInit.init();
    InitSpecificNecessaryViews.InitSpecifiedAccountNecessaryView();
    InitUserDropDown.init();
});