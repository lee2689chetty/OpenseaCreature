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
                                Balances Report
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row" id="containerSpecifcBalance">
                                <div class="col-sm-12">
                                    <div class="form-horizontal bg-grey margin-top-20">
                                        <div class="col-sm-12 col-md-4 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;">User Name</label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" id="balanceUserID">
                                                    <option value=""> Choose User </option>
                                                    <?php
                                                    foreach ($userList as $userItem){
                                                        echo ("<option value=\"".$userItem['ID']."\" data-content=\""
                                                            .$userItem['NAME']." <span class='label label-sm label-success'> ".$userItem['FULL_NAME']." </span>\"> </option>");
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1 form-group">
                                            <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btBalanceReportGenerate"> Generate </button>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="row"  >
                                        <div class="col-sm-12 col-md-12" style="margin-right: 30px;">
                                            <div class="row panel panel-default">
                                                <div class="panel-body">
                                                    <h3 class="lead col-sm-12 font-yellow-lemon"> User Details </h3>
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-2">
                                                            <label class="font-grey-salsa uppercase">User Name:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label id="txtBalanceUserName">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-2">
                                                            <label class="font-grey-salsa uppercase">Full Name:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label id="txtBalanceFullname">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-2">
                                                            <label class="font-grey-salsa uppercase">Profile Creation:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label id="txtBalanceProfileCreation">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12" style="margin-top: 90px;">
                                            <table class="table table-striped table-bordered table-hover" id="tbBalanceReport">
                                                <thead>
                                                <tr>
                                                    <th> Account Creation Date </th>
                                                    <th> Account Number </th>
                                                    <th> Account Type </th>
                                                    <th> Currency </th>
                                                    <th> Available Balance </th>
                                                    <th> Current Balance </th>
                                                    <th> Status </th>
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

<script src="<?php echo base_url();?>assets/pages/scripts/admin_report_specified_balance.js" type="text/javascript"></script>
</body>
</html>