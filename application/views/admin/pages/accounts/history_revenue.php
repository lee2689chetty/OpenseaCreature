<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

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
                                Revenue
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row" id="containerSystemRevenue">
                                <div class="col-sm-12 margin-top-20">
                                    <div class="col-sm-12 col-md-4 form-group">
                                        <label class="col-sm-12 control-label" style="text-align: left;"> Type </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="baseType" id="baseType" required>
                                                <option value="0"> All </option>
                                                <option value="1"> System </option>
                                                <option value="2"> Manual </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                        <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                        <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control" name="fromAllDate" id="fromAllDate">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control" name="toAllDate" id="toAllDate">
                                            <input type="hidden" class="form-control" name="currencyType" id="currencyType" value="<?php echo $ACCOUNT_ID;?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-1 form-actions">
                                        <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btGenerate">Generate</button>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin-top: 70px;">
                                    <table class="table table-striped table-bordered table-hover" id="tbReveneList">
                                        <thead>
                                            <tr>
                                                <th> Date </th>
                                                <th> User </th>
                                                <th> Full Name </th>
                                                <th> Account Number </th>
                                                <th> Account Type </th>
                                                <th> Trans. ID </th>
                                                <th> Trans. Type </th>
                                                <th> Description </th>
                                                <th> Current </th>
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
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_account_revenue_history.js" type="text/javascript"></script>
</body>

</html>