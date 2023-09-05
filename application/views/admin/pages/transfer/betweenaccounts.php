<?php echo $header;?>
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
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <?php if($result):?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span> Transfer Request Successful </span>
                        </div>
                    <?php endif;?>
                    <?php if($available_amount):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request transfer. Available amount of account is not enough.</span>
                        </div>
                    <?php endif;?>
                    <?php if($show_alert):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request transfer </span>
                        </div>
                    <?php endif;?>
                    <?php if($aml):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Transfer is suspended. System Administrator will check it manually. Sorry for inconvenience. </span>
                        </div>
                    <?php endif;?>
                    <?php if($currencypair):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Currency pair doesn't exist </span>
                        </div>
                    <?php endif;?>
                    <?php if($create_revenue):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Failed to request transfer. Create revenue account first </span>
                        </div>
                    <?php endif;?>
                    <?php if($target_wallet):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request transfer. Create eWallet account first. </span>
                        </div>
                    <?php endif;?>
                    <?php
                    $resultValid = validation_errors();
                    if($resultValid != null && $resultValid != "") {?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> <?php echo $resultValid;?> </span>
                        </div>
                    <?php } ?>

                    <div class="portlet box yellow-gold">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>
                                Transfer Between Accounts
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <form id="formbaAccounts" role="form" class="form-horizontal" method="post" action="<?php echo base_url();?>admin/transfer/baccounts">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label"> Select User <span class="font-red"> * </span></label>
                                                <div class="col-sm-3">
                                                    <select class="bs-select form-control" id="baUserList" name="baUserList">
                                                        <option> Select User </option>
                                                            <?php foreach ($userList as $userListItem){?>
                                                                <option value="<?php echo $userListItem['ID'];?>" data-content = "<?php echo $userListItem['NAME'];?>"> <?php echo $userListItem['NAME'];?> </option>
                                                            <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Debit From <span class="font-red"> * </span></label>
                                                <div class="col-sm-9">
                                                    <select class="bs-select form-control" id="baAccountFrom" name="baAccountFrom">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Credit To <span class="font-red"> * </span></label>
                                                <div class="col-sm-9">
                                                    <select class="bs-select form-control" id="baAccountTo" name="baAccountTo">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="form-section font-yellow-gold font-sm">
                                        Transfer Details
                                    </h3>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Amount to transfer <span class="font-red"> * </span></label>
                                        <div class="col-sm-6">
                                            <input type="text" required class="form-control" id="baAmount" name="baAmount" placeholder="Amount to transfer">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Description </label>
                                        <div class="col-sm-6">
                                            <textarea required class="form-control" placeholder="Transfer Description" rows="5" id="baDescription" name="baDescription"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-1 col-md-offset-7">
                                                <input type="submit" class="btn yellow-gold" value="Continue">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/admin_transfer_between_accounts.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>