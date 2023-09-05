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
                                Outgoing Wire Transfers
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row" id="containerSystemOutgoing">
                                <div class="form-horizontal bg-grey">

                                    <div class="col-sm-12 margin-top-20">
                                        <div class="col-sm-12 col-md-4 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Currency </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="systemOutgoingCurrency" id="systemOutgoingCurrency" required>
                                                    <?php foreach ($currencyList as $currencyItem){?>
                                                        <option value="<?php echo $currencyItem['ID']?>"> <?php echo $currencyItem['TITLE'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" id="fromOutgoingDate">
                                                <span class="input-group-addon"> to </span>
                                                <input type="text" class="form-control" id="toOutgoingDate">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-2 form-actions">
                                            <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btSystemOutgoingGenerate">Generate</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h3 class="lead col-sm-12 font-yellow-lemon"> Summary </h3>
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 col-md-2">
                                                    <label class="font-grey-salsa uppercase">Start Date:</label>
                                                </div>
                                                <div class="col-sm-12 col-md-7">
                                                    <label id="txtOutgoingStart">&nbsp;</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="col-sm-12 col-md-2">
                                                    <label class="font-grey-salsa uppercase">End Date:</label>
                                                </div>
                                                <div class="col-sm-12 col-md-7">
                                                    <label id="txtOutgoingEnd">&nbsp;</label>
                                                </div>
                                            </div>


                                            <div class="col-sm-12">
                                                <div class="col-sm-12 col-md-2">
                                                    <label class="font-grey-salsa uppercase">Currency:</label>
                                                </div>
                                                <div class="col-sm-12 col-md-7">
                                                    <label id="txtOutgoingCurrency">&nbsp;</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="col-sm-12 col-md-2">
                                                    <label class="font-grey-salsa uppercase">Total Debit:</label>
                                                </div>
                                                <div class="col-sm-12 col-md-7">
                                                    <label id="txtOutgoingDebit">&nbsp;</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="col-sm-12 col-md-2">
                                                    <label class="font-grey-salsa uppercase">Total Credit:</label>
                                                </div>
                                                <div class="col-sm-12 col-md-7">
                                                    <label id="txtOutgoingCredit">&nbsp;</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" style="margin-top: 70px;">

                                    <table class="table table-striped table-bordered table-hover" id="tbOutgoingList">
                                        <thead>
                                        <tr>
                                            <th> Date </th>
                                            <th> UserName </th>
                                            <th> FullName </th>
                                            <th> Account Number </th>
                                            <th> Account Type </th>
                                            <th> Trx.ID </th>
                                            <th> Description </th>
                                            <th> Amount </th>
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
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_report_system_outgoing.js" type="text/javascript"></script>
</body>
</html>