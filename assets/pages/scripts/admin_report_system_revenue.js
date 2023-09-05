var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#tbReveneList');

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
                        "orderable": true
                    },
                    {
                        "orderable": true
                    }
                ],
            
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
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
        }
    };
}();

var AjaxCommunication = function () {
    var initAjaxCom = function(){
        $('#btGenerate').on('click', function(){
            var formData = new FormData();
            formData.append("currency", jQuery('#baseCurrency').val());
            formData.append("fromDate", jQuery('#fromAllDate').val());
            formData.append("toDate", jQuery('#toAllDate').val());
            formData.append("transType", jQuery('#baseType').val());

            var uploadHandler = $.ajax({
                url: "../../report/SystemRevenue",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false
            });

            uploadHandler.done(function (msg) {
                App.unblockUI('#containerSystemRevenue');
                var jsonValue = JSON.parse(msg);
                UpdateSystemNecessaryViews(jsonValue);
            });

            uploadHandler.fail(function (jqXHR, textStatus) {
                App.unblockUI('#containerSystemRevenue');
                InitSystemNecessaryViews();
            });

        });
    };

    var UpdateSystemNecessaryViews = function(jsonValue){
        InitSystemNecessaryViews();
        var table = $('#tbReveneList').dataTable();
        for(var i = 0 ; i < jsonValue.transList.length; i++)
        {
            var valueTmp = jsonValue.transList[i];
            var timestamp =  moment.unix(valueTmp.created_at).format("YYYY-MM-DD");
            var CreditOrDebit = "";
            if(valueTmp.amount > 0)
            {
                CreditOrDebit = '<td style="padding-top: 15px; padding-bottom: 15px;"> <span> <p class="font-green"> ' + valueTmp.amount + ' </p> </span> </td>';
            }
            else
            {
                CreditOrDebit = '<td style="padding-top: 15px; padding-bottom: 15px;"> <span> <p class="font-red"> ' + valueTmp.amount + ' </p> </span> </td>';
            }

            table.fnAddData([
                '<td style="padding-top: 15px; padding-bottom: 15px;"> '+ timestamp +' </td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> '+ valueTmp.username +' </td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> '+ valueTmp.fullname +' </td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> '+ valueTmp.account_number +' </td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> '+ valueTmp.account_type +' </td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> ' + valueTmp.transaction_id + '</td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> ' + valueTmp.transaction_type + '</td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> ' + valueTmp.description + '</td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> ' + valueTmp.current + '</td>',
                '<td style="padding-top: 15px; padding-bottom: 15px;"> ' + CreditOrDebit + '</td>',
            ]);
        }
    };

    var InitSystemNecessaryViews = function(){
        var table = $('#tbReveneList').dataTable();
        table.fnClearTable();
    };
    return{
        init:function(){
            initAjaxCom();
        }
    };
}();
jQuery(document).ready(function() {
    TableDatatablesButtons.init();
    AjaxCommunication.init();

});