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
                            <span> Credit Request Successful </span>
                        </div>
                    <?php endif;?>

                    <?php if($failed):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request credit </span>
                        </div>
                    <?php endif;?>
                    <?php if($revenue):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Create Revenue Account first. </span>
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
                    <div class="note note-success">
                        <h4> Account Information </h4>
                        <p>
                            Currency Type : <strong><?php echo $currencyType;?></strong><br>
                            Current Balance : <strong><?php echo $currentBalance;?></strong><br>
                            Available Balance : <strong><?php echo $availableBalance;?></strong>
                        </p>
                    </div>

                    <div class="portlet box yellow-gold">
                        <div class="portlet-title ">
                            <div class="caption">
                                Credit account <?php echo $accountName;?> (<?php echo $userName;?>)
                            </div>

                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <form id="creditForm" role="form" method="post" action="<?php echo base_url();?>admin/account/credit/<?php echo $accountId;?>">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="form-group col-sm-7">
                                            <label class="col-sm-12 control-label"> Amount<span class="font-red">*</span> </label>
                                            <div class="col-sm-12">
                                                <input type="text" id="creditAmount" class="form-control" placeholder="Amount" name="creditAmount">
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-7">
                                            <label class="col-sm-12 control-label"> Description <span class="font-red">*</span> </label>
                                            <div class="col-sm-12">
                                                <textarea  class="form-control" rows="6" placeholder="Description" name="creditDescription"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-7">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" name="creditRevenue"> Debit this transaction from revenue account
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-7">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" name="iwtFee"> Apply Incoming Wire Transfer(IWT) Fee
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn yellow-gold">Submit</button>
                                                </div>
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
<!-- END CONTAINER -->

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/admin_account_credit_formvalidation.js" type="text/javascript"></script>

</body>

</html>