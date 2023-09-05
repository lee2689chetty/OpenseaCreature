<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                All Transactions
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row" id="containerSystemAllTrans">
                                <div class="form-horizontal bg-grey">

                                    <div class="col-sm-12 margin-top-20">
                                        <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" id="fromSytemAllTransDate">
                                                <span class="input-group-addon"> to </span>
                                                <input type="text" class="form-control" id="toSystemAllTransDate">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 form-actions">
                                            <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btSystemAllTransGenerate">Generate</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-12" style="margin-top: 20px;">
                                    <table class="table table-striped table-bordered table-hover" id="tbSystemAllTransactionList">
                                        <thead>
                                        <tr>
                                            <th> Date </th>
                                            <th> UserName </th>
                                            <th> FullName </th>
                                            <th> Account Number </th>
                                            <th> Account Type </th>
                                            <th> Trans.ID </th>
                                            <th> Trans.Type </th>
                                            <th> Description </th>
                                            <th> Currency </th>
                                            <th> Debit/Credit </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_report_system_all.js" type="text/javascript"></script>
</body>
</html>