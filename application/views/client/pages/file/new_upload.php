<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" /
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <?php if($uploadSuccess):?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span> Uploaded file Successfully </span>
                        </div>
                    <?php endif;?>

                    <?php if($uploadError):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to upload file </span>
                        </div>
                    <?php endif;?>

                    <div class="portlet box yellow-gold">
                        <div class="portlet-title ">
                            <div class="caption">
                                Upload New File
                            </div>

                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <form id="uploadForm"  enctype="multipart/form-data" role="form" method="post" action="<?php echo base_url();?>file/new_upload<?php if($transId == "") $transId = "new"; echo '/'.$transId;?>">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="form-group col-sm-7">
                                            <label class="col-sm-12 control-label"> Transaction ID <span class="font-red">*</span> </label>
                                            <div class="col-sm-12">
                                                <input class="form-control" placeholder="Transction Id" required name="transId" id="transId" value="<?php if($transId != "new") echo $transId;?>">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-7">
                                            <label class="col-sm-12 control-label"> File <span class="font-red">*</span> </label>
                                            <div class="col-sm-12">
                                                <input type="file"  class="form-control" name="fileToUpload" id="fileToUpload" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                    <button type="submit" class="btn yellow-gold" style="margin-left: 16px;"> Submit </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTAINER -->

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_file_new_upload.js" type="text/javascript"></script>

</body>

</html>