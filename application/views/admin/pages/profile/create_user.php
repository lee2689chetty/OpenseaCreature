<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                    if($error == true)
                    {
                        ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Failed to create user </span>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if($duplicate_email == true)
                    {
                        ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Email address is already in use. </span>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if($duplicate_name == true)
                    {
                        ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> User name is already in use. </span>
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
                            <span> Created Profile Successfully </span>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-user font-yellow-gold"></i>Create New User
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                                <form role="form" id="contentForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="../profile/user_create">
                                    <div class="form-body row">
                                        <?php include_once 'create_user_userInformation.php';?>
                                        <?php include_once 'create_user_benifical_owner.php';?>
                                    </div>
                                    <div class="form-body row">
                                        <?php include_once 'create_user_physicalAddress.php';?>
                                        <?php include_once 'create_user_mailingAddress.php';?>
                                    </div>
                                    <div class="form-body row">
                                        <!--Mailing address--->
                                        <div class="col-md-12">
                                            <h4 class="font-yellow-gold bold">
                                                Internal Notes
                                            </h4>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <textarea rows="5" class="form-control" placeholder="internal notes" name="txtInternalNote"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <a href="../profile/user_view" style="width: 150px;" class="btn btn-outline yellow-gold margin-right-10"> Cancel </a>
                                        <button type="submit" style="width: 150px;" class="btn btn yellow-gold"> Create </button>
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
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_profile_create.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>