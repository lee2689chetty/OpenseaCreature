<?php echo $header;?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <?php if($result):?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span> Transfer Request Successful </span>
                        </div>
                    <?php endif;?>
                    <?php if($currencypair):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Currency pair doesn't exist </span>
                        </div>
                    <?php endif;?>
                    <?php if($aml):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Transfer is suspended. System Administrator will check it manually. Sorry for inconvenience. </span>
                        </div>
                    <?php endif;?>

                    <?php if($show_alert):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request transfer </span>
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
                        if($resultValid != null && $resultValid != "")
                        {
                            ?>
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <span> <?php echo $resultValid;?> </span>
                            </div>
                        <?php } ?>
                    <div class="portlet box yellow-gold">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-credit-card"></i>
                                Transfer Between Users
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">

                            <form id="formTransfer" action="<?php echo base_url();?>transfer/users" method="post" role="form" class="form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Debit From <span class="font-red"> * </span></label>
                                                <div class="col-sm-9">
                                                    <select class="bs-select form-control" required name="fromAccount"  data-show-subtext="true">
                                                        <option value = ""> Select Account </option>
                                                        <?php foreach ($accounts as $accountItem) {
                                                            echo("<option value=\"" . $accountItem['ID'] . "\" data-content=\""
                                                                . $accountItem['ACCOUNT_NUMBER'] . " <span class='label label-sm label-success'> " . $accountItem['CURRENCY_TITLE'] . "  " . $accountItem['CURRENT_AMOUNT'] . " </span>\"> </option>");
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Credit To <span class="font-red"> * </span></label>
                                                <div class="col-sm-9">
                                                    <select required class="bs-select form-control" name="toAccount">
                                                        <option> Select User </option>
                                                        <?php foreach ($users as $userItem){
                                                            echo ("<option value=\"".$userItem['ID']."\">".$userItem['NAME']." </option>");
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="form-section font-yellow-gold font-sm">
                                        TRANSFER DETAILS
                                    </h3>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Amount to transfer <span class="font-red"> * </span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="amount" name="amount" required class="form-control" placeholder="Amount to transfer">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Description </label>
                                        <div class="col-sm-6">
                                            <textarea name="description" class="form-control" placeholder="Description" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-1 col-md-offset-7">
                                            <input type="submit" class="btn yellow-gold" value="Continue">
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
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/client_transfer_between_users.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>