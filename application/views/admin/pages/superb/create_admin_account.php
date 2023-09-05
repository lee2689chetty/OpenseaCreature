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
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Create Administrator
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" class="form-horizontal" id="formAdminCreate" method="post" action="<?php echo base_url();?>admin/supers/create_admin">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> User Level <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <select class="bs-select form-control" name="levelType" id="levelType" required>
                                                <?php foreach ($levelList as $levelListItem):?>
                                                    <option value="<?php echo $levelListItem['ID'];?>">
                                                        <?php echo $levelListItem['TITLE'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Account Name <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Account Name" id="accountName" name="accountName">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Full Name <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Full Name" id="fullName" name="fullName">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Email Address <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input id="userInfoEmail" name="userInfoEmail" type="email" autocomplete="false" class="form-control" placeholder="Email address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> New Password <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input id="newPassword" name="newPassword" type="password" autocomplete="false" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Confirm Password <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <input id="confirmPassword" name="confirmPassword" type="password" autocomplete="false" class="form-control" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Status <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <select class="bs-select form-control" name="userStatus" id="userStatus" required>
                                                <?php foreach ($statusArray as $statusArrayItem):?>
                                                    <option value="<?php echo $statusArrayItem['ID'];?>">
                                                        <?php echo $statusArrayItem['DESCRIPTION'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" style="width: 150px;" class="col-sm-offset-1 btn btn yellow-gold"> Save </button>
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
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_admin_detail_edit.js" type="text/javascript"></script>
</body>
</html>