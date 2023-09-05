/**
 * Created by rock on 1/19/18.
 */

var InitSystemReportBalance = function () {

    var initSystemReportBalance = function () {
        var table = $('#tbSystemBalance');
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
                    "orderable": true
                },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    },
                    {
                        "orderable": true
                    }],

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            "order":[[2, "desc"]],
            // set the initial value
            "pageLength": 15,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initSystemReportBalance();
        }
    };
}();

var SystemFormsInit = function() {

    var handleBalanceForm = function(){
        $('#btSystemBalanceGenerate').on('click', function(){
            var formData = new FormData();
            formData.append("fromDate", jQuery('#fromSystemBalanceDate').val());
            var uploadHandler = $.ajax({
                url: "../../report/SystemBalance",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSystemAllTrans');
                var jsonValue = JSON.parse(msg);
                UpdateSytemNecessaryViews.BalanceNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSystemAllTrans');
                InitSystemNecessaryViews.BalanceNecessaryView();
            });

        });
    };

    return {
        init: function() {
            handleBalanceForm();
        }
    };

}();

var InitSystemNecessaryViews = function() {

    var InitBalanceViews = function() {
        InitSystemTableView.BalanceTableInit();
    };
    return {
        BalanceNecessaryView:function(){
            InitBalanceViews();
        }
    };
}();

var InitSystemTableView = function() {
    return {

        BalanceTableInit:function()
        {
            var table = $('#tbSystemBalance').dataTable();
            table.fnClearTable();
        }
    };
}();

var UpdateSytemNecessaryViews = function() {

    var UpdateBalanceNecessaryViews = function(jsonStringValue) {
        InitSystemTableView.BalanceTableInit();
        var table = $('#tbSystemBalance').dataTable();
        if(jsonStringValue.dataList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
        {
            var valueTmp = jsonStringValue.dataList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD HH:mm:ss");

            table.fnAddData([
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.NAME +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.USER_FULLNAME +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.FEE_TYPE +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.CURRENCY_TITLE + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.AVAILABLE_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.CURRENT_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.STATUS_DESCRIPTION + '</td>',
            ]);
        }

    };

    return {
        BalanceNecessaryViews: function(jsonStringValue){
            UpdateBalanceNecessaryViews(jsonStringValue);
        }
    }
}();

jQuery(document).ready(function() {
    InitSystemReportBalance.init();
    SystemFormsInit.init();

});