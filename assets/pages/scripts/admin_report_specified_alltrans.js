var InitSpecifiedReportTableView = function () {
    var initSpecifiedAllReportTableView = function () {
        var table = $('#tbSpecificAllReport');
        init7RowsTable(table);
    };

    return {
        //main function to initiate the module
        init: function () {
            initSpecifiedAllReportTableView();
        }
    };
}();
var init7RowsTable = function(table)
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


var SpecifiedFormsInit = function() {

    var handleAllAccountReport = function() {
        $('#btSpeicifedAllGenerate').on('click', function(){
            App.blockUI({
                target:'#containerSpecificAllTrans',
                animate:true
            });
            var formData = new FormData();
            formData.append("userId", jQuery('#allUserID').val());
            formData.append("allUserFilter", jQuery("#allUserFilter").val());
            formData.append("fromDate", jQuery('#fromAllDate').val());
            formData.append("toDate", jQuery('#toAllDate').val());
            var uploadHandler = $.ajax({
                url: "../../report/SpecifiedAllReport",
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
            });

        });
    };

    return {
        init: function() {
            handleAllAccountReport();
        }
    };
}();

var InitSpecificTableView = function() {
    return {
        InitSpecifiedAllReportTableInit:function()
        {
            var table = $('#tbSpecificAllReport').dataTable();
            table.fnClearTable();
        }
    };
}();

var UpdateSpecificNecessaryView = function()
{

    var UpdateSpeificAllNecessaryViews = function(jsonStringValue) {
        InitSpecificTableView.InitSpecifiedAllReportTableInit();
        var table = $('#tbSpecificAllReport').dataTable();
        if(jsonStringValue.dataList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.dataList.length; i++)
        {
            var valueTmp = jsonStringValue.dataList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD HH:mm:ss");
            var CreditOrDebit, availableAmount, status, description;
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

            description = '<a href="../../request/status/' + valueTmp.ID + '" class="btn btn-link">' + valueTmp.DESCRIPTION +'</a>';
            table.fnAddData([
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ '#' + valueTmp.ID +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ '#' + valueTmp.TRANS_ID/*valueTmp.ID*/ +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> '+ valueTmp.TRANS_DESC +' </td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + description + '</td>',
                '<td style="padding-top: 35px; padding-bottom: 35px;"> ' + valueTmp.TITLE + '</td>',
                CreditOrDebit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ]);
        }

    };

    return {
        UpdateSpecificAllNecessaryViews: function(jsonStringValue){
            UpdateSpeificAllNecessaryViews(jsonStringValue);
        }
    }
}();



jQuery(document).ready(function() {
    InitSpecifiedReportTableView.init();
    SpecifiedFormsInit.init();
});