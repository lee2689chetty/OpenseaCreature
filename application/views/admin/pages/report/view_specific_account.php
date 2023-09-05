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
                        <div class="portlet-title ">
                            <div class="caption font-yellow-gold">
                                Specific Account Report
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="containerSpecificAccount">
                                <div class="form-horizontal bg-grey margin-top-20">
                                    <div class="col-sm-12 col-md-3 form-group">
                                        <label class="col-sm-12 control-label" style="text-align: left;">User </label>
                                        <div class="col-sm-12">
                                            <select class="form-control select2 select2-allow-clear" id="specifiedUserId">
                                                <option value="" data-anumber="Choose User" data-currency="" data-amount="">  </option>
                                                <?php foreach ($userList as $accountItem):?>
                                                    <option value="<?php echo $accountItem['ID'];?>" data-anumber="<?php echo $accountItem['NAME'];?>" data-currency = "<?php echo $accountItem['FULL_NAME'];?>" data-amount = ""> <?php echo $accountItem['FULL_NAME'];?> </option>");
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;">Account Number</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2 select2-allow-clear" id="specifiedAccountNumber">
<!--                                                    <option value="" data-anumber="Choose Account Number" data-currency="" data-amount="">  </option>-->
<!--                                                    --><?php //foreach ($accountList as $accountItem):?>
<!--                                                        <option value="--><?php //echo $accountItem['ID'];?><!--" data-anumber="--><?php //echo $accountItem['ACCOUNT_NUMBER'];?><!--" data-currency = "--><?php //echo $accountItem['CURRENCY_TITLE'];?><!--" data-amount = "--><?php //echo $accountItem['CURRENT_AMOUNT'];?><!--"> --><?php //echo $accountItem['ACCOUNT_NUMBER'];?><!-- </option>");-->
<!--                                                    --><?php //endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" name="fromSpecificAllDate" id="fromSpecificAllDate">
                                                <span class="input-group-addon"> to </span>
                                                <input type="text" class="form-control" name="toSpecificAllDate" id="toSpecificAllDate">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1 form-group">
                                            <button class="btn yellow-gold margin-bottom-10" id="btSpeicifedAccountGenerate" style="margin-top: 25px;"> Generate </button>
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-sm-12 col-md-4" style="margin-right: 30px;">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <h3 class="lead col-sm-12 font-yellow-lemon"> User Details </h3>
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">User Name:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountUserName">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Full Name:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountUserFullName">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Profile Creation:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountUserCreatedAt">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-7">
                                            <div class="row panel panel-default">
                                                <div class="panel-body">
                                                    <h3 class="lead col-sm-12 font-yellow-lemon"> Account Details </h3>
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Creation Date:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountCreatedAt">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Number:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountNumber">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Type:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountType">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Currency:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label  id="txtSpecificAccountCurrency">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Available Balance:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label id="txtSpecificAccountAvailableBalance">&nbsp;</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="col-sm-12 col-md-5">
                                                            <label class="font-grey-salsa uppercase">Current Balance:</label>
                                                        </div>
                                                        <div class="col-sm-12 col-md-7">
                                                            <label id="txtSpecificAccountCurrentBalance">&nbsp;</label>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" style="margin-top: 90px;">
                                            <table class="table table-striped table-bordered table-hover" id="tbSpecificAccountReport">
                                                <thead>
                                                <tr>
                                                    <th> Date </th>
                                                    <th> ID </th>
                                                    <th> Description </th>
                                                    <th> Transaction Type </th>
                                                    <th> Debit/Credit </th>
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
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_report_specified_account.js" type="text/javascript"></script>
</body>
</html>