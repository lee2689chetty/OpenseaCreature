<?php echo $header;?>

<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/pages/css/profile.css" rel="stylesheet" type="text/css">

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
                    <form class="form" id="contentForm" role="form" method="POST"
                          action = <?php if($isUpdate == TRUE)
                                        {
                                            echo base_url()."admin/profile/update_fee/".$originAccount['ID'];
                                        }
                                        else
                                        {
                                            echo base_url()."admin/profile/new_feeprofile";
                                        } ?>>
                        <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-user font-yellow-gold"></i>
                                <?php if($isUpdate == FALSE):?>
                                    Create New Account Fee Profile
                                <?php else:?>
                                    Update Account Fee Profile
                                <?php endif;?>
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
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
                                            <span>
                                                <?php if($isUpdate == TRUE):?>
                                                    Failed to update profile
                                                <?php else:?>
                                                    Failed to create profile
                                                <?php endif;?>
                                            </span>
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
                                            <span>
                                                <?php if($isUpdate == TRUE):?>
                                                    Updated Fee Profile Successfully
                                                <?php else:?>
                                                    Created Fee Profile Successfully
                                                <?php endif;?>

                                            </span>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                    <div class="col-sm-12 col-md-12 form-group">
                                        <label class="col-sm-12 control-label" style="text-align: left;"> Fee Profile Name <span class="required">*</span> </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Fee Profile Name" required name="accountType"
                                             value="<?php if($isUpdate == TRUE){ echo $originAccount['ACCOUNT_TYPE'];} ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 form-group">
                                        <label class="col-sm-2 control-label font-yellow-gold uppercase"> Transfer Fees </label>
                                    </div>

                                    <div class="col-sm-12 col-md-8 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Incoming Wire Transfer (IWT) </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Incoming Wire Transfer Amount"  name="iwtAmount" id="iwtAmount"
                                                   value="<?php if($isUpdate == TRUE){ echo $originAccount['IWT_AMOUNT'];}
                                                                else{echo '0.00';}?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Type </label>
                                        <div class="col-sm-12">
                                            <select class="bs-select form-control" name="iwtType">
                                                <option value="%" <?php if($isUpdate == TRUE && $originAccount['IWT_TYPE'] == '%') echo 'selected';?>> % </option>
                                                <option value="#" <?php if($isUpdate == TRUE && $originAccount['IWT_TYPE'] == '#') echo 'selected';?>> # </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-8 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Outgoing Wire Transfer (OWT) </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Outgoing Wire Transfer Amount" name="owtAmount" id="owtAmount"
                                                value = <?php if($isUpdate == TRUE){ echo $originAccount['OWT_AMOUNT'];}
                                                else{echo '0.00';}?>>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Type </label>
                                        <div class="col-sm-12">
                                            <select class="bs-select form-control" name="owtType">
                                                <option value="%" <?php if($isUpdate == TRUE && $originAccount['OWT_TYPE'] == '%') echo 'selected';?>> % </option>
                                                <option value="#" <?php if($isUpdate == TRUE && $originAccount['OWT_TYPE'] == '#') echo 'selected';?>> # </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-8 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Card Funding Transfer (CFT) </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Card Funding Transfer" name="cftAmount" id="cftAmount"
                                              value =  <?php if($isUpdate == TRUE) { echo $originAccount['CFT_AMOUNT']; }
                                                else { echo '0.00'; } ?>>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Type </label>
                                        <div class="col-sm-12">
                                            <select class="bs-select form-control" name="cftType">
                                                <option value="%" <?php if($isUpdate == TRUE && $originAccount['CFT_TYPE'] == '%') echo 'selected';?>> % </option>
                                                <option value="#" <?php if($isUpdate == TRUE && $originAccount['CFT_TYPE'] == '#') echo 'selected';?>> # </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-12 form-group">
                                        <label class="col-sm-4 control-label uppercase"> Currency Conversion Rate </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Currency Conversion Rate" name="currencyRate" id="currencyRate"
                                                   value="<?php if($isUpdate == TRUE) { echo $originAccount['CURRENCY_CONVERSION_RATE']; }
                                            else { echo '0.00'; } ?>">
                                        </div>
                                    </div>

                                    <!-- Begin Min, Max Fee-->
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label class="col-sm-12 control-label" style="text-align: left;"> Min. Fee </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Fee Amount" name="minTransFeeAmount" id="minTransFeeAmount"
                                                   value="<?php if($isUpdate == TRUE) { echo $originAccount['MIN_TRANS_FEE']; }
                                                   else { echo '0.00'; } ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label class="col-sm-12 control-label" style="text-align: left;"> Max. Fee </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Fee Amount" name="maxTransFeeAmount" id="maxTransFeeAmount"
                                                   value="<?php if($isUpdate == TRUE) { echo $originAccount['MAX_TRANS_FEE']; }
                                                   else { echo '1,000.00'; } ?>">
                                        </div>
                                    </div>
                                    <!-- End Min, Max Fee -->


                                    <div class="col-sm-12 col-md-12 form-group">
                                        <label class="col-sm-2 control-label font-yellow-gold uppercase"> Monthly maintenance </label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" class="form-control checkbox" name="chkMonthlymaintenance" value="1"
                                                   <?php if ($isUpdate == TRUE && $originAccount['IS_MONTHLY_MAINTENANCE'] == TRUE) echo 'checked';?>>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 form-group">
                                        <label class="col-sm-12 control-label" style="text-align: left;"> Fee Amount </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" placeholder="Fee Amount" name="monthlyFeeAmount" id="monthlyFeeAmount"
                                                   value="<?php if($isUpdate == TRUE) { echo $originAccount['MONTHLY_FEE_AMOUNT']; }
                                                   else { echo '0.00'; } ?>">
                                        </div>
                                    </div>

                                    <?php include_once 'account_fee_create_minimum_balance.php';?>
                                    <?php include_once 'account_fee_create_line_of_credit.php';?>
                                    <?php include_once 'account_fee_create_interest_generating.php';?>

                                    <div class="col-sm-12 form-actions">
                                        <a href="<?php echo base_url();?>admin/profile/fee_view" type="submit" class="btn btn-outline yellow-gold" style="width: 150px;"> cancel </a>
                                        <button type="submit" class="btn yellow-gold" style="width: 150px;"> save </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php echo $footer;?>

<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/admin_account_fee_profile_create.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
</body>

</html>