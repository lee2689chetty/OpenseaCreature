<?php echo $header;?>
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
                                <i class="icon icon-settings font-yellow-gold"></i>Settings
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">

                                <div class="row">
                                    <form role="form" class=" form-horizontal form-horizontal" id="formSetting" method="post" action="../update_profile/<?php echo $userDetail['ID'];?>">
                                        <div class="form-body col-sm-12">
                                            <!--User Information-->
                                            <div class="col-md-6">
                                                <h4 class="font-yellow-lemon bold">
                                                    Notifications
                                                </h4>
                                                <label class="lead uppercase small font-grey-salsa">
                                                    Internal Message Notification
                                                </label>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-10" style="text-align: left !important;"> When Pending transactions are executed </label>
                                                    <div class="col-sm-2" style="height: 28px;">
                                                        <input type="checkbox" name="chkNotifyPendingExecuted" <?php if($userDetail['NOTIFY_PENDING_EXECUTED'] == 1) echo 'checked';?> class="make-switch" data-on-color="warning" data-off-color="danger" data-size="small">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-10" style="text-align: left !important;"> When a Transfer from Other User is Received </label>
                                                    <div class="col-sm-2" style="height: 28px;">
                                                        <input type="checkbox" name="chkNotifyFundReceive" <?php if($userDetail['NOTIFY_FUND_RECEIVE'] == 1) echo 'checked';?> class="make-switch" data-on-color="warning" data-off-color="danger" data-size="small">
                                                    </div>
                                                </div>

                                                <label class="lead uppercase small font-grey-salsa">
                                                    Email Notification
                                                </label>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-10" style="text-align: left !important;"> When a internal message is received </label>
                                                    <div class="col-sm-2" style="height: 28px;">
                                                        <input type="checkbox" name="chkNotifyInternalMsg" <?php if($userDetail['NOTIFY_INTERNAL_MESSAGE'] == 1) echo 'checked';?> class="make-switch" data-on-color="warning" data-off-color="danger" data-size="small">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-10" style="text-align: left !important;"> When Login Attempt Fails </label>
                                                    <div class="col-sm-2" style="height: 28px;">
                                                        <input type="checkbox" name="chkNotifyLoginAttempt" <?php if($userDetail['NOTIFY_LOGIN_FAILS'] == 1) echo 'checked';?> class="make-switch " data-on-color="warning" data-off-color="danger" data-size="small">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-10" style="text-align: left !important;"> When Funds are added to my Account </label>
                                                    <div class="col-sm-2" style="height: 28px;">
                                                        <input type="checkbox" name="chkNotifyFundAdd" <?php if($userDetail['NOTIFY_FUND_ADD'] == 1) echo 'checked';?> class="make-switch " data-on-color="warning" data-off-color="danger" data-size="small">
                                                    </div>
                                                </div>

                                            </div>
                                            <!--User Information-->

                                            <!---Begin of Benifit owner-->
                                            <div class="col-md-6">
                                                <h4 class="font-yellow-lemon bold">
                                                    Security Question
                                                </h4>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"> Question <span class="font-red"> * </span></label>
                                                    <div class="col-sm-9">
                                                        <select class="bs-select form-control" name="selectSecurity" id="selectSecurity">
                                                            <option value="0"> --None-- </option>
                                                            <?php foreach ($securityQuestions as $securityItem){?>
                                                                <option value="<?php echo $securityItem['ID']?>" <?php if($userDetail['SECURY_QUESTION_ID'] == $securityItem['ID']) echo 'selected';?>> <?php echo $securityItem['DESCRIPTION'];?> </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label"> Answer <span class="font-red"> * </span></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder="Answer" name="txtSecurityAnswer" id="txtSecurityAnswer" value="<?php echo $userDetail['SECURITY_ANSWER'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Benifit owner -->
                                        </div>

                                        <div class="form-actions row">
                                            <div class="col-sm-offset-1 col-sm-8">
                                                <a type="button" style="width: 150px;" class="pull-left btn btn-outline yellow-gold margin-right-10" href="../user_view"> Back to List </a>
                                                <button type="submit" style="width: 150px;" class="pull-left btn yellow-gold"> Save </button>
                                            </div>
                                        </div>

                                    </form>
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
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/client_profile_setting.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>