/**
 * Created by rock on 1/19/18.
 */
var InitSystemManualReportTableView = function () {

    var initSystemReport = function () {
        var table = $('#tbSystemManual');
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
            initSystemReport();
        }
    };
}();

var UpdateManualView = function(jsonStringValue) {
    ClearManualView();
    var table = $('#tbSystemManual').dataTable();
    if(jsonStringValue.dataList.length === 0)
        return;
    for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
    {
        var valueTmp = jsonStringValue.dataList[i];
        var timestamp =  moment.unix(valueTmp.DATE).format("YYYY-MM-DD HH:mm:ss");

        var CreditOrDebit = "";
        if(parseInt(valueTmp.AMOUNT) < 0)
        {
            CreditOrDebit = '<td style="padding-top: 20px; padding-bottom: 20px;"> <span> <p class="font-red"> ' + (parseFloat(valueTmp.AMOUNT).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) + ' </p> </span> </td>';
        }
        else
        {
            CreditOrDebit = '<td style="padding-top: 20px; padding-bottom: 20px;"> <span> <p class="font-green"> ' + (parseFloat(valueTmp.AMOUNT).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")) + ' </p> </span> </td>';
        }

        status = '<td style="padding-top: 35px; padding-bottom: 35px;">' + valueTmp.STATUS_DESCRIPTION + '</td>';
        var transferId = '<a href="../../request/status/' + valueTmp.REQUEST_ID + '" class="btn btn-link">' + '#' + valueTmp.REQUEST_ID +'</a>';
        table.fnAddData([
            '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ timestamp +' </td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.USER_NAME +' </td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.FULL_NAME +' </td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.ACCOUNT_TYPE +' </td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> ' + transferId + '</td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> ' + valueTmp.TRANSFER_TYPE_STRING + '</td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> ' + valueTmp.TRANS_DESCRIPTION + '</td>',
            '<td style="padding-top: 20px; padding-bottom: 20px;"> ' + valueTmp.CURRENCY + '</td>',
            CreditOrDebit,
            '<td style="padding-top: 20px; padding-bottom: 20px;"> ' + valueTmp.REVENUE + '</td>'
        ]);
    }
};

var ClearManualView = function(){
    var table = $('#tbSystemManual').dataTable();
    table.fnClearTable();
};
var SystemFormsInit = function() {

    var handleManualTransactionForm = function() {
        $('#btManualTrans').on('click', function(){
            App.blockUI({
                target:'#containerSystemManualTrans',
                animate:true
            });
            var formData = new FormData();
            formData.append("fromDate", jQuery('#fromAllDate').val());
            formData.append("toDate", jQuery('#toAllDate').val());
            var uploadHandler = $.ajax({
                url: "../../report/SystemManualTrans",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSystemManualTrans');
                var jsonValue = JSON.parse(msg);
                UpdateManualView(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSystemManualTrans');
                ClearManualView();
            });

        });

    };

    return {
        init: function() {
            handleManualTransactionForm();
        }
    };
}();

jQuery(document).ready(function() {
    InitSystemManualReportTableView.init();
    SystemFormsInit.init();
});