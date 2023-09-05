<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>

<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">


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
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_profile" data-toggle="tab">Profile</a>
                                </li>

                                <li>
                                    <a href="#tab_edit" data-toggle="tab">Edit Profile</a>
                                </li>
                                <li>
                                    <a href="#tab_changepass" data-toggle="tab">Change Password</a>
                                </li>
                            </ul>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content" style="padding: 5px;">
                                <!-- Begin View User Profile-->
                                <div class="tab-pane active" id="tab_profile">
                                    <div class="profile">
                                        <?php include 'view_profile.php';?>
                                    </div>
                                </div>
                                <!-- End View User Profile-->

                                <!-- Begin Edit User Profile -->
                                <div class="tab-pane" id="tab_edit">


                                    <?php
                                    $resultValid = validation_errors();
                                    if($resultValid != null && $resultValid != "")
                                    {
                                        ?>
                                        <div class="alert alert-danger">
                                            <button class="close" data-close="alert"></button>
                                            <span> <?php echo $resultValid;?> </span>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if($success == true)
                                    {
                                        ?>
                                        <div class="alert alert-info">
                                            <button class="close" data-close="alert"></button>
                                            <span> Updated Profile Successfully </span>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <?php include 'edit_profile.php'; ?>
                                </div>
                                <!-- End Edit User Profile -->
                                <!-- Begin Edit User Profile -->
                                <div class="tab-pane" id="tab_changepass">

                                    <div class="alert alert-info" id="alertChangePass" hidden>
                                        <button class="close" data-close="alert"></button>
                                        <span> Updated Profile Successfully </span>
                                    </div>

                                    <div class="alert alert-danger" id="alertNewPassMatch" hidden>
                                        <button class="close" data-close="alert"></button>
                                        <span> Current Password is not matched. </span>
                                    </div>
                                    <div class="alert alert-danger" id="alertCurrentPassError" hidden>
                                        <button class="close" data-close="alert"></button>
                                        <span> Current Password is not matched. </span>
                                    </div>
                                    <?php include 'change_pass.php'; ?>
                                </div>
                                <!-- End Edit User Profile -->
                            </div>
                        </div>
                    </div>
<!--                </div>-->
<!--            </div>-->
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
<!--<script src="../assets/pages/scripts/account_view.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/client_profile_update.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>