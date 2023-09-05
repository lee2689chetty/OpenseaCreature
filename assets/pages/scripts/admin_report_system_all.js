/**
 * Created by rock on 1/19/18.
 */
var InitSystemReportAll = function () {

    var InitSystemReportAll = function () {
        var table = $('#tbSystemAllTransactionList');
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
                    },
                    {
                        "orderable": true
                    }],

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            "order": [[ 0, "desc" ]],
            // set the initial value
            "pageLength": 15,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            InitSystemReportAll();
        }
    };
}();

var SystemFormsInit = function() {

    var handleAllTransactionForm = function() {
        $('#btSystemAllTransGenerate').on('click', function(){
            App.blockUI({
                target:'#containerSystemAllTrans',
                animate:true
            });
            var formData = new FormData();
            formData.append("fromDate", jQuery('#fromSytemAllTransDate').val());
            formData.append("toDate", jQuery('#toSystemAllTransDate').val());
            var uploadHandler = $.ajax({
                url: "../../report/SystemAllTrans",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSystemAllTrans');
                var jsonValue = JSON.parse(msg);
                UpdateSytemNecessaryViews.AllTransactionNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSystemAllTrans');
                InitSystemNecessaryViews.AllTransNecessaryView();
            });

        });

    };

    return {
        init: function() {
            handleAllTransactionForm();
        }
    };
}();

var InitSystemNecessaryViews = function() {
    var InitAllTransViews = function() {
        InitSystemTableView.AllTransactionTableInit();
    };

    return {
        AllTransNecessaryView:function(){
            InitAllTransViews();
        }
    };
}();

var InitSystemTableView = function() {
    return {
        AllTransactionTableInit:function()
        {
            var table = $('#tbSystemAllTransactionList').dataTable();
            table.fnClearTable();
        }
    };
}();

var UpdateSytemNecessaryViews = function() {
    var UpdateSpeificAccountNecessaryViews = function(jsonStringValue) {
        InitSystemTableView.AllTransactionTableInit();
        var table = $('#tbSystemAllTransactionList').dataTable();
        if(jsonStringValue.dataList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
        {
            var valueTmp = jsonStringValue.dataList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD HH:mm:ss");

            if(valueTmp.DETAIL_TYPE === '1')
            {
                CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -' + (parseFloat(valueTmp.AMOUNT).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) + ' </p> </span> </td>';
            }
            else
            {
                CreditOrDebit = '<td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) + ' </p> </span> </td>';
            }
            var transferId = '<a href="../../request/status/' + valueTmp.ID + '" class="btn btn-link">' + '#' + valueTmp.ID +'</a>';

            table.fnAddData([
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.USER_NAME +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.FULL_NAME +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.ACCOUNT_TYPE +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ transferId +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.TRANS_DESC +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.DESCRIPTION + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.TITLE + '</td>',
                CreditOrDebit
            ]);
        }

    };


    return {
        AllTransactionNecessaryViews: function(jsonStringValue){
            UpdateSpeificAccountNecessaryViews(jsonStringValue);
        }
    }
}();

jQuery(document).ready(function() {
    InitSystemReportAll.init();
    SystemFormsInit.init();
});