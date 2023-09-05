var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#tbContent');

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
            buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'csv', className: 'btn purple btn-outline ' }
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,
            "columns":
                [
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
                        "orderable": false
                    }
                ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,
            "order": [[ 0, "desc" ]],
            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    };

    var initUserDropDownList = function(){
        $('#accountOwner').on('select2:select', function(e){
           var data = e.params.data;
           if(parseInt(data.id) > 0)
           {
               //get account regarding account owner
               var formData = new FormData();
               formData.append("userId", data.id);
               var uploadHandler = $.ajax({
                   url: "../account/GetAccounts",
                   type: "POST",
                   data: formData,
                   processData: false,
                   contentType: false,
                   cache: false
               });

               uploadHandler.done(function (msg) {
                   var jsonValue = JSON.parse(msg);
                   console.log(jsonValue);
                   EmptyAccountIdDropdownList();
                   FillOutAccountIdDropDownList(jsonValue);
               });

               uploadHandler.fail(function (jqXHR, textStatus) {
                   EmptyAccountIdDropdownList();
               });

           }
           else
           {
               EmptyAccountIdDropdownList();
           }
        });

        if(parseInt($('#accountOwner').val()) === 0)
        {
            EmptyAccountIdDropdownList();
        }
    };
    var FillOutAccountIdDropDownList = function(jsonValues)
    {
        for(var i = 0 ; i < jsonValues.length ; i++)
        {
            $('#accountId').append('<option value="' + jsonValues[i].ID + '"> ' + jsonValues[i].ACCOUNT_NUMBER + '</option>');
        }
        $('#accountId').selectpicker('refresh');
    };

    var EmptyAccountIdDropdownList = function()
    {
        $('#accountId').empty();
        $('#accountId').append('<option value="0" data-content = "Choose Account number">Choose Account number</option>');
        $('#accountId').selectpicker('refresh');
    };
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
            initUserDropDownList();
        }
    };
}();


jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});