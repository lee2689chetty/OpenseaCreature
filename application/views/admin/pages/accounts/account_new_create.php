<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" >
<link href="<?php echo base_url();?>assets/pages/css/profile.css" rel="stylesheet" type="text/css">
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">


<?php echo $topbar;?>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
                    <form class="form" id="contentForm" role="form" method="POST" action = "<?php echo base_url();?>admin/account/new_account">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption font-yellow-gold">
                                    <i class="icon icon-user font-yellow-gold"></i>Create New Account Type
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
                                                <span> Failed to create profile </span>
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
                                                <span> Success to create profile </span>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="col-sm-12 col-md-8 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Fee Profile <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="feeType" required>
                                                    <option value=""> -- Nothing selected -- </option>
                                                    <?php foreach ($feeTypeList as $feeTypeListItem){?>
                                                        <option value="<?php echo $feeTypeListItem['ID']?>"> <?php echo $feeTypeListItem['ACCOUNT_TYPE'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> &nbsp; </label>
                                            <div class="col-sm-12">
                                                <a href="<?php echo base_url();?>admin/profile/new_feeprofile" class=" btn btn-block yellow-gold">Add new fee profile</a>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Account Number <span class="required">*</span> </label>
                                            <div class="col-sm-12">
                                                <div class="input-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <label style="margin-bottom: 0px !important;" id="spAccountNumberPrefix">  </label>
                                                        </span>
                                                        <input type="text" class="form-control"  placeholder="Account Number" required name="accountNumber">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Account User Name <span class="required">*</span> </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="userName" required>
                                                    <option value=""> -- Nobody selected -- </option>
                                                    <?php foreach ($accountUserList as $accountUserListItem){?>
                                                        <option value="<?php echo $accountUserListItem['ID']?>"> <?php echo $accountUserListItem['NAME'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-8 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Currency <span class="required">*</span> </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="userCurrency" required>
                                                    <?php foreach ($currencyList as $currencyListItem){?>
                                                        <option value="<?php echo $currencyListItem['ID']?>"> <?php echo $currencyListItem['TITLE'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Description </label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="description" placeholder="Description" rows="5"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Account Type <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" id="accountType" name="accountType" required>
                                                    <option value=""> -- Nobody selected -- </option>
                                                    <?php foreach ($accountTypeList as $accountTypeListItem){?>
                                                        <option value="<?php echo $accountTypeListItem['ID']?>"> <?php echo $accountTypeListItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--- Begin of Show hide region based on card ---->
                                        <div class="col-sm-12 col-md-4 form-group" id="divCardHolder">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Holder Name</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="Holder Name" name="cardHolder" id="cardHolder">
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-4 form-group" id="divCardCVC">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Card CVC </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="Card CVC" name="cardCVC" id="cardCVC" maxlength="4">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-2 form-group" id="divValidYear">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Card Valid Year </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="cardValYear">
                                                    <?php for ($year = 2010 ; $year < 2020; $year ++){?>
                                                        <option value="<?php echo $year?>"> <?php echo $year;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-2 form-group" id="divValidMonth">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Card Valid Month </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="cardValMonth">
                                                    <?php for ($month = 1 ; $month < 13; $month ++){?>
                                                        <option value="<?php echo $month?>"> <?php echo $month;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <!--- End of Show hide region on card ---->

                                        <div class="col-sm-12 col-md-8 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Status </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="userStatus">
                                                    <option value=""> -- Nobody selected -- </option>
                                                    <?php foreach ($statusList as $statusListItem){?>
                                                        <option value="<?php echo $statusListItem['ID']?>"> <?php echo $statusListItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-8 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Initial Balance <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="initialBalance" name="initialBalance" value="0" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 form-group">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" name="allowWithdraw"> Allow Withdrawals
                                            </div>
                                        </div>

                                        <div class="col-sm-12 form-group">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" name="allowDeposit"> Allow Deposits
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-2 control-label font-yellow-gold uppercase"> Interests </label>
                                            <div class="col-sm-10">
                                                &nbsp;
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-2 control-label"> Payout Options <span class="required"> * </span> </label>
                                            <div class="col-sm-12">
                                                <input type="radio" class="form-control radio" checked name="radioPayoutOptions" value="1"> Add to same account
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="radio" class="form-control radio" name="radioPayoutOptions" value="2"> Add to other account
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Payout day </label>
                                            <div class="col-sm-12">
                                                <select class="bs-select form-control" name="payoutDay" required>
                                                    <option value=""> -- None -- </option>
                                                    <?php foreach ($payoutList as $payoutListItem){?>
                                                        <option value="<?php echo $payoutListItem['ID']?>"> <?php echo $payoutListItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 form-actions">
                                            <a href="<?php echo base_url();?>admin/account/view" type="submit" class="btn btn-outline yellow-gold" style="width: 150px;"> cancel </a>
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

<script src="<?php echo base_url();?>assets/pages/scripts/admin_account_new_create.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>