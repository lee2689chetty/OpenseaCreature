var InitSpecifiedReportTableView = function () {

    var initSpecifiedBalanceReportTableView = function () {
        var table = $('#tbBalanceReport');
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
                    }],

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            "order":[[0, "desc"]],
            // set the initial value
            "pageLength": 15,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initSpecifiedBalanceReportTableView();
        }
    };
}();


var SpecifiedFormsInit = function() {

    var handleBalanceReport = function() {
        $('#btBalanceReportGenerate').on('click', function(){
            var formData = new FormData();
            formData.append("userId", jQuery('#balanceUserID').val());
            var uploadHandler = $.ajax({
                url: "../../report/SpecifiedBalanceReport",
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
            handleBalanceReport();
        }
    };
}();


var InitSpecificNecessaryViews = function() {

    var InitSpecificBalanceNecessaryViews = function() {
        jQuery('#txtBalanceUserName').text("------");
        jQuery('#txtBalanceFullname').text("------");
        jQuery('#txtBalanceProfileCreation').text("------");
        InitSpecificTableView.InitSpecifiedBalanceReportTableInit();
    };

    return {
        InitSpecifiedBalanceNecessaryView:function(){
            InitSpecificBalanceNecessaryViews();
        }
    };
}();

var InitSpecificTableView = function() {
    return {
        InitSpecifiedBalanceReportTableInit:function()
        {
            var table = $('#tbBalanceReport').dataTable();
            table.fnClearTable();
        }
    };
}();

var UpdateSpecificNecessaryView = function()
{
    var UpdateSpeificBalanceNecessaryViews = function(jsonStringValue) {
        if(jsonStringValue.userData.length == 0)
            return;
        var userData = jsonStringValue.userData[0];
        jQuery('#txtBalanceUserName').text(userData.NAME);
        jQuery('#txtBalanceFullname').text(userData.FULL_NAME);
        var userCreationDateTime =  moment.unix(userData.CREATED_AT).format("YYYY-MM-DD HH:mm:ss");
        jQuery('#txtBalanceProfileCreation').text(userCreationDateTime);

        InitSpecificTableView.InitSpecifiedBalanceReportTableInit();
        var table = $('#tbBalanceReport').dataTable();
        if(jsonStringValue.accountList.length === 0)
            return;
        for(var i = 0 ; i < jsonStringValue.accountList.length; i++)
        {
            var valueTmp = jsonStringValue.accountList[i];
            var timestamp =  moment.unix(valueTmp.CREATED_AT).format("YYYY-MM-DD HH:mm:ss");

            table.fnAddData([
                '<td> '+ timestamp +' </td>',
                '<td> '+ valueTmp.ACCOUNT_NUMBER +' </td>',
                '<td> ' + valueTmp.ACCOUNT_TYPE_DESC + '</td>',
                '<td> '+ valueTmp.CURRENCY_TITLE +' </td>',
                '<td> '+ valueTmp.AVAILABLE_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' </td>',
                '<td> '+ valueTmp.CURRENT_AMOUNT.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' </td>',
                '<td> ' + valueTmp.STATUS_DESCRIPTION + '</td>'
            ]);
        }

    };

    return {
        UpdateSpecificBalanceNecessaryViews: function(jsonStringValue){
            UpdateSpeificBalanceNecessaryViews(jsonStringValue);
        }
    }
}();



jQuery(document).ready(function() {
    InitSpecifiedReportTableView.init();
    SpecifiedFormsInit.init();
});