<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>

<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white">


<?php echo $topbar;?>
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php echo $sidebar;?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE BASE CONTENT -->
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Fee Profiles
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>admin/profile/new_feeprofile" class="btn yellow-gold"> create new fee </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                                <div class="row" style="margin-top: 70px;">
                                    <div class="col-sm-12">
                                        <table class="table table-striped table-hover" id="tbFeeList">
                                            <thead>
                                            <tr>
                                                <th class="font-grey-salsa"> # </th>
                                                <th class="font-yellow-gold"> Account Type </th>

                                                <th class="font-grey-salsa"> IWT </th>
                                                <th class="font-grey-salsa"> OWT </th>
                                                <th class="font-grey-salsa"> CFT </th>
                                                <th class="font-grey-salsa"> Currency Conversion Rate </th>
                                                <th class="font-yellow-gold"> Date </th>
                                                <th class="font-grey-salsa">  </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 0 ; $i < count($feeProfileList); $i++){?>
                                                    <tr class="input-large">

                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $i + 1;?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $feeProfileList[$i]['ACCOUNT_TYPE'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $feeProfileList[$i]['IWT_AMOUNT'].' ( '.$feeProfileList[$i]['IWT_TYPE'].' ) ';?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $feeProfileList[$i]['OWT_AMOUNT'].' ( '.$feeProfileList[$i]['OWT_TYPE'].' ) ';?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $feeProfileList[$i]['CFT_AMOUNT'].' ( '.$feeProfileList[$i]['CFT_TYPE'].' ) ';?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $feeProfileList[$i]['CURRENCY_CONVERSION_RATE'].' ( % ) ';?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d H:m:s', $feeProfileList[$i]['CREATED_AT']);?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;">
                                                            <a href="<?php echo base_url();?>admin/profile/update_fee/<?php echo $feeProfileList[$i]['ID'];?>" class="btn default red-stripe"> View </a>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- END DASHBOARD STATS 1-->
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_fee_profile_view.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>