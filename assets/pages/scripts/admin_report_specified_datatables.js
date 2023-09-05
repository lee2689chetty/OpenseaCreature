var InitSpecifiedReportTableView = function () {

    var initSpecifiedAccountReportTableView = function () {
        var table = $('#tbSpecificAccountReport');
        init6RowsTable(table);
    };
    var initSpecifiedAllReportTableView = function () {
        var table = $('#tbSpecificAllReport');
        init6RowsTable(table);
    };
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
            // set the initial value
            "pageLength": 15,
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        });
    };
    return {
        //main function to initiate the module
        init: function () {
            initSpecifiedAccountReportTableView();
            initSpecifiedAllReportTableView();
            initSpecifiedBalanceReportTableView();
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
                }],

        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 15,
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
    });
}
jQuery(document).ready(function() {
    InitSpecifiedReportTableView.init();
});