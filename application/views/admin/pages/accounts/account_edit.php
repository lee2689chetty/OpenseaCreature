<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" >
<link href="<?php echo base_url();?>assets/pages/css/profile.css" rel="stylesheet" type="text/css">
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">


<?php echo $topbar;?>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
                    <form class="form" id="contentForm" role="form" method="POST" action = "<?php echo base_url();?>admin/account/edit/<?php echo $accountData['ID'];?>">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption font-yellow-gold">
                                    <i class="icon icon-user font-yellow-gold"></i>Edit Account
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
                                                <span> Failed to update account information </span>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if($duplicate_number == true)
                                        {
                                            ?>
                                            <div class="alert alert-danger">
                                                <button class="close" data-close="alert"></button>
                                                <span> Account number is already in use. </span>
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
                                                <span> Success to update account information </span>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> User Name <span class="required">*</span> </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="userName" required>
                                                    <?php foreach ($accountUserList as $accountUserListItem){?>
                                                        <option value="<?php echo $accountUserListItem['ID']?>"
                                                            <?php if($accountUserListItem['ID'] == $accountData['USER_ID']) echo 'selected';?>
                                                        > <?php echo $accountUserListItem['NAME'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Account Number <span class="required">*</span> </label>
                                            <div class="col-sm-12">
                                                <div class="input-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label style="margin-bottom: 0px !important;" id="spAccountNumberPrefix">
                                                                <?php echo substr($accountData['ACCOUNT_NUMBER'], 0,3);?>
                                                            </label>
                                                        </span>
                                                        <input type="text" class="form-control"  placeholder="Account Number" required name="accountNumber"
                                                        value="<?php echo substr($accountData['ACCOUNT_NUMBER'], 3);?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Status </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="userStatus">
                                                    <?php foreach ($statusList as $statusListItem){?>
                                                        <option value="<?php echo $statusListItem['ID']?>"
                                                            <?php if($accountData['STATUS'] == $statusListItem['ID']) echo 'selected';?>
                                                        > <?php echo $statusListItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Currency <span class="required">*</span> </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="userCurrency" required>
                                                    <?php foreach ($currencyList as $currencyListItem){?>
                                                        <option
                                                            <?php if($accountData['CURRENCY_TYPE'] == $currencyListItem['ID']) echo 'selected';?>
                                                                value="<?php echo $currencyListItem['ID']?>"> <?php echo $currencyListItem['TITLE'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Fee Profile <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="feeType" required>
                                                    <?php foreach ($feeTypeList as $feeTypeListItem){?>
                                                        <option value="<?php echo $feeTypeListItem['ID']?>"
                                                            <?php if($accountData['FEE_TYPE'] == $feeTypeListItem['ID']) echo 'selected';?>
                                                        > <?php echo $feeTypeListItem['ACCOUNT_TYPE'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Account Type <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" id="accountType" name="accountType" required>
                                                    <?php foreach ($accountTypeList as $accountTypeListItem){?>
                                                        <option value="<?php echo $accountTypeListItem['ID']?>"
                                                            <?php if($accountData['ACCOUNT_TYPE'] == $accountTypeListItem['ID']) echo 'selected';?> > <?php echo $accountTypeListItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Description </label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="description" placeholder="Description" rows="5"><?php echo $accountData['DESCRIPTION'];?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Current Balance <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" readonly id="initialBalance" name="initialBalance" value="<?php echo $accountData['CURRENT_AMOUNT'];?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Available Balance <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" readonly id="availableBalance" name="availableBalance" value="<?php echo $accountData['AVAILABLE_AMOUNT'];?>" required>
                                            </div>

                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" name="allowWithdraw"
                                                    <?php if($accountData['ALLOW_WITHDRAW'] == 1) echo 'checked';?>> Allow Withdrawals
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" name="allowDeposit" <?php if($accountData['ALLOW_DEPOSIT'] == 1) echo 'checked';?>> Allow Deposits
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-4 control-label"> Payout Options <span class="required"> * </span> </label>
                                            <div class="col-sm-8">
                                                <input type="radio" class="form-control radio"
                                                       <?php if($accountData['PAYMENT_OPTIONS'] == 1) echo 'checked';?>
                                                       name="radioPayoutOptions" value="1"> Add to same account
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="radio" class="form-control radio" name="radioPayoutOptions"
                                                    <?php if($accountData['PAYMENT_OPTIONS'] == 2) echo 'checked';?>
                                                       value="2"> Add to other account
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Payout day </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="payoutDay" required>
                                                    <?php foreach ($payoutList as $payoutListItem){?>
                                                        <option value="<?php echo $payoutListItem['ID']?>"
                                                            <?php if($payoutListItem['ID'] == $accountData['PAYOUT_DAY']) {
                                                                echo 'selected';
                                                            }?>> <?php echo $payoutListItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-actions">
                                            <a href="<?php echo base_url();?>admin/account/detail/<?php echo $accountData['ID'];?>" type="submit" class="btn btn-outline yellow-gold" style="width: 150px;"> cancel </a>
                                            <button type="submit" class="btn yellow-gold" style="width: 150px;"> save </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
</div>

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_account_edit.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>