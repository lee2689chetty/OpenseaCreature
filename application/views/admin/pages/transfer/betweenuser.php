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
                                <i class="fa fa-users"></i>
                                Transfer Between Users
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form form-horizontal form-bordered" id="formBetweenUser" method="post" action="<?php echo base_url();?>admin/transfer/busers">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label"> Select User <span class="font-red"> * </span></label>
                                                <div class="col-sm-3">
                                                    <select class="bs-select form-control" id="bUserList1" name="bUserList1">
                                                        <option> Select User </option>
                                                        <?php foreach ($userList as $userListItem){?>
                                                            <option value="<?php echo $userListItem['ID'];?>" data-content = "<?php echo $userListItem['NAME'];?>"> <?php echo $userListItem['NAME'];?> </option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label"> Debit From <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <select class="bs-select form-control" id="bAccountList1" name="bAccountList1">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <h3 class="form-section font-yellow-gold font-sm">
                                        Credit to
                                    </h3>

                                    <div class="row">

                                        <div class="col-sm-12 col-md-12">

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label"> User Name <span class="font-red"> * </span></label>
                                                <div class="col-sm-3">
                                                    <select class="bs-select form-control" id="bUserList2" name="bUserList2">
                                                        <option> Select User </option>
                                                        <?php foreach ($userList as $userListItem){?>
                                                            <option value="<?php echo $userListItem['ID'];?>" data-content = "<?php echo $userListItem['NAME'];?>"> <?php echo $userListItem['NAME'];?> </option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-1 control-label"> Account <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <select class="bs-select form-control" id="bAccountList2" name="bAccountList2">

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
                                            <input required type="text" class="form-control" placeholder="Amount to transfer" name="bAmount" id="bAmount">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Description <span class="required"> * </span> </label>
                                        <div class="col-sm-6">
                                            <textarea required class="form-control" placeholder="Description" rows="5" name="bDescription"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-1 col-md-offset-7">
                                                <input type="submit" class="btn yellow-gold" value="Submit">
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

<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_transfer_between_users.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>