<?php echo $header;?>
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white">


<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <?php if($success):?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span> Revenue account create successful </span>
                        </div>
                    <?php endif;?>

                    <?php if($failed):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to create revenue account </span>
                        </div>
                    <?php endif;?>
                    <?php
                    $resultValid = validation_errors();
                    if($resultValid != null && $resultValid != ""): ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> <?php echo $resultValid;?> </span>
                        </div>
                    <?php endif; ?>

                    <div class="portlet box yellow-gold">
                        <div class="portlet-title ">
                            <div class="caption">
                                Create New Revenue Account
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <form id="newForm" role="form" method="post" action="<?php echo base_url();?>admin/account/new_revenue">
                                <div class="form-body">
                                    <div class="form-group col-sm-7">
                                        <label class="col-sm-12 control-label"> Currency <span class="font-red">*</span> </label>
                                        <div class="col-sm-12">
                                            <select class="bs-select form-control" name="currencyType">
                                                <?php foreach ($currencyList as $currencyListItem){?>
                                                    <option value="<?php echo $currencyListItem['ID']?>"> <?php echo $currencyListItem['TITLE'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-7">
                                        <label class="col-sm-12 control-label"> Account Name <span class="font-red">*</span> </label>
                                        <div class="col-sm-12">
                                            <input  class="form-control" type="text" required placeholder="Account Name" name="revenueName">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-7">
                                        <label class="col-sm-12 control-label"> Initial Amount <span class="font-red">*</span> </label>
                                        <div class="col-sm-12">
                                            <input  class="form-control" type="text" required placeholder="Initial Amount" name="revenueAmount" id="revenueAmount">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group col-sm-5">
                                                <button type="submit" class="btn yellow-gold">Submit</button>
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

<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_revenue_new_formvalidation.js" type="text/javascript"></script>
</body>
</html>