/**
 * Created by rock on 1/19/18.
 */
var InitSystemOutgoingReportTableView = function () {

    var initSystemReport = function () {
        var table = $('#tbOutgoingList');
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

var OutgoingFormsInit = function() {
    var handleOutgoingForm = function(){
        $('#btSystemOutgoingGenerate').on('click', function(){
            var formData = new FormData();
            formData.append("currency", jQuery('#systemOutgoingCurrency').val());
            formData.append("fromDate", jQuery('#fromOutgoingDate').val());
            formData.append("toDate", jQuery('#toOutgoingDate').val());

            var uploadHandler = $.ajax({
                url: "../../report/SystemOutgoing",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSystemOutgoing');
                var jsonValue = JSON.parse(msg);
                UpdateSytemNecessaryViews.OutgoingNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSystemOutgoing');
                InitSystemNecessaryViews.OutgoingNecessaryView();
            });

        });
    };

    return {
        init: function() {
            handleOutgoingForm();
        }
    };

}();

var InitSystemNecessaryViews = function() {
    var InitOutgoingViews = function() {
        jQuery('#txtOutgoingStart').text(jQuery('#fromOutgoingDate').val());
        jQuery('#txtOutgoingEnd').text(jQuery('#toOutgoingDate').val());
        jQuery('#txtOutgoingCurrency').text(jQuery('#systemOutgoingCurrency').text());
        jQuery('#txtOutgoingDebit').text("------");
        jQuery('#txtOutgoingCredit').text("------");
        InitSystemTableView.OutgoingTableInit();
    };
    return {
        OutgoingNecessaryView:function(){
            InitOutgoingViews();
        }
    };
}();

var InitSystemTableView = function() {
    return {
        OutgoingTableInit:function()
        {
            var table = $('#tbOutgoingList').dataTable();
            table.fnClearTable();
        }
    };
}();

var UpdateSytemNecessaryViews = function() {
    var UpdateOutgoingNecessaryViews = function(jsonStringValue) {
        if(jsonStringValue === undefined)
            return;
        jQuery('#txtOutgoingStart').text(jQuery('#fromOutgoingDate').val());
        jQuery('#txtOutgoingEnd').text(jQuery('#toOutgoingDate').val());
        jQuery('#txtOutgoingCurrency').text(jsonStringValue.CURRENCY_TITLE[0].TITLE);
        jQuery('#txtOutgoingDebit').text(jsonStringValue.TOTAL_DEBIT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        jQuery('#txtOutgoingCredit').text(jsonStringValue.TOTAL_CREDIT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        InitSystemTableView.OutgoingTableInit();
        var table = $('#tbOutgoingList').dataTable();
        if(jsonStringValue.dataList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
        {
            var valueTmp = jsonStringValue.dataList[i];
            // var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD");
            var Status = "";
            var amount = '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ (parseFloat(valueTmp.AMOUNT) + parseFloat(valueTmp.TRANSACTION_FEE))+'(' + valueTmp.TITLE + ')</td>';

            if(valueTmp.STATUS === '1')
            {
                //TRANSFER_REQUESTED
                Status = '<td style="padding-top: 20px; padding-bottom: 20px;"> Requested </td>';
            }
            else if(valueTmp.STATUS === '2')
            {
                //TRANSFER_AWAITING_APPROVAL
                Status = '<td style="padding-top: 20px; padding-bottom: 20px;"> Awaiting </td>';
            }
            else if(valueTmp.STATUS === '3')
            {
                //TRANSFER_APPROVED
                Status = '<td style="padding-top: 20px; padding-bottom: 20px;"> Approved </td>';
            }
            else if(valueTmp.STATUS === '4')
            {
                //TRANSFER_COMPLETE
                Status = '<td style="padding-top: 20px; padding-bottom: 20px;"> Completed </td>';
            }
            else if(valueTmp.STATUS === '5')
            {
                //TRANSFER_CANCELLED
                Status = '<td style="padding-top: 20px; padding-bottom: 20px;"> Cancelled </td>';
            }

            var description = '<a href="../../request/status/' + valueTmp.ID + '" class="btn btn-link">' + valueTmp.DESCRIPTION +'</a>';

            table.fnAddData([
                '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.CREATED_AT +' </td>',
                '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.USER_NAME +' </td>',
                '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.USER_FULL_NAME +' </td>',
                '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ valueTmp.ACCOUNT_TYPE +' </td>',
                '<td style="padding-top: 20px; padding-bottom: 20px;"> '+ '# ' + valueTmp.ID +' </td>',
                '<td style="padding-top: 20px; padding-bottom: 20px;"> ' + description + '</td>',
                amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                Status
            ]);
        }

    };

    return {
        OutgoingNecessaryViews: function(jsonStringValue){
            UpdateOutgoingNecessaryViews(jsonStringValue);
        }
    }
}();

jQuery(document).ready(function() {
    InitSystemOutgoingReportTableView.init();
    UpdateSytemNecessaryViews.OutgoingNecessaryViews();
    OutgoingFormsInit.init();
});