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
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">


<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">

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
            if($OLD_MISMATCH == true)
            {
                ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Old Password is not matched. </span>
                </div>
                <?php
            }
            ?>
            <?php
            if($PASS_MISMATCH == true)
            {
                ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> New Password is not matched. </span>
                </div>
                <?php
            }
            ?>
            <?php
            if($SUCCESS_CHANGE == true)
            {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button>
                    <span> Password changed successfully. </span>
                </div>
                <?php
            }
            ?>

            <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Change Password
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form-horizontal" id="formPassUpdate" method="post" action="<?php echo base_url();?>admin/supers/password/<?php echo $USER_ID;?>">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Old Password <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" placeholder="Old Password" id="oldPassword" name="oldPassword">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> New Password <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" placeholder="New Password" id="newPassword" name="newPassword">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Confirm New Password <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input id="confirmPassword" name="confirmPassword" type="password" class="form-control" placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" style="width: 150px;" class="col-sm-offset-1 btn btn yellow-gold"> Save </button>
                                </div>
                            </form>
                        </div>
                    </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_admin_change_pass.js" type="text/javascript"></script>
</body>
</html>