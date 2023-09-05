var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#tbAllRegisterList');

        var oTable = table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
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
            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},


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
                    "orderable": false
                }],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });

        // table.on('click', '.delete', function (e) {
        //     e.preventDefault();
        //     console.log($(this).attr('data-value'));
        //     if (confirm("Are you sure to delete this row ?") == false) {
        //         return;
        //     }
        //
        //     var nRow = $(this).parents('tr')[0];
        //     oTable.fnDeleteRow(nRow);
        //     App.blockUI({
        //         target:'#tbUserList',
        //         animate:true
        //     });
        //
        //     requestRemove = $.ajax({
        //                             url:"./uremove/" + $(this).attr('data-value'),
        //                             type: "POST",
        //                             cache:false
        //                            });
        //
        //     requestRemove.done(function(msg) {
        //         App.unblockUI($('#tbUserList'));
        //
        //     });
        //
        //     requestRemove.fail(function(jqXHR, textStatus) {
        //         App.unblockUI($('#tbUserList'));
        //     });
        // });
    }
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
        }
    };
}();

jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});