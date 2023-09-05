<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">

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
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <?php if($available_amount):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request transfer. Available amount of account is not enough.</span>
                        </div>
                    <?php endif;?>
                    <?php if($result):?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button>
                            <span> Transfer Request Successful </span>
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
                    if($resultValid != null && $resultValid != "") {?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> <?php echo $resultValid;?> </span>
                        </div>
                    <?php } ?>

                    <div class="portlet box yellow-gold">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-trophy"></i>
                                Outgoing WireTransfer
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <!---->
                            <form role="form" class="form-horizontal form form-bordered" id="formOutgoing" method="post" action="<?php echo base_url();?>admin/transfer/outgoing"">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"> Select User <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <select required class="bs-select form-control" id="userList" name="userList">
                                                        <option value=""> Select User </option>
                                                        <?php foreach ($userList as $userListItem){?>
                                                            <option value="<?php echo $userListItem['ID'];?>" data-content = "<?php echo $userListItem['NAME'];?>"> <?php echo $userListItem['NAME'];?> </option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"> Debit From <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <select required class="bs-select form-control" id="accountList" name="accountList">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <p class="uppercase font-yellow-gold"> Specify Beneficary bank </p>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label uppercase"> swift/bic <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input required type="text" class="form-control" id="bankSwift" name="bankSwift">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> name <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input required type="text" class="form-control" name="bankName" id="bankName">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Address <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input required type="text" class="form-control" id="bankAddress" name="bankAddress">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Location <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input required type="text" class="form-control" id="bankLocation" name="bankLocation">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Country <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <select required class="form-control select2 select2-allow-clear" id="bankCountry" name="bankCountry">
                                                        <option value=""> Select Country </option>
                                                        <?php foreach ($countries as $countryItem){?>
                                                            <option value="<?php echo $countryItem['ID'];?>"> <?php echo $countryItem['DESCRIPTION'];?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> ABA/RTN </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="bankABA" id="bankABA">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <p class="uppercase font-yellow-gold"> Specify Beneficary Customer </p>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Name <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="beneficaryName" id="beneficaryName">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Address <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="beneficaryAddr" id="beneficaryAddr">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Acc#/IBAN <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="beneficaryAcc" id="beneficaryAcc">
                                                </div>
                                            </div>
                                            <p class="uppercase  font-yellow-gold"> Additional information </p>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Reference Message <span class="font-red"> * </span></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="addionAddress" id="addionAddress">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-5">
                                                    <p class="uppercase font-yellow-gold"> Specify intermediary bank </p>
                                                </div>
                                                <div class="col-sm-7">
                                                    <input type="checkbox" class="checkbox" name="chkIntermediaryBank" id="intermediatrybank">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> SWIFT / BIC </label>
                                                <div class="col-sm-7">
                                                    <input type="text"  class="form-control" name="interSwift" id="interSwift">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Name </label>
                                                <div class="col-sm-7">
                                                    <input type="text"  class="form-control" name="interName" id="interName">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Address </label>
                                                <div class="col-sm-7">
                                                    <input type="text"  class="form-control" name="interAddress" id="interAddress">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Location </label>
                                                <div class="col-sm-7">
                                                    <input type="text"  class="form-control" name="interLocation" id="interLocation">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> Country </label>
                                                <div class="col-sm-7">
                                                    <select class="select2 select2-allow-clear form-control" name="interCountry" id="interCountry">
                                                        <option value=""> Select Country </option>
                                                        <?php foreach ($countries as $countryItem){?>
                                                            <option value="<?php echo $countryItem['ID'];?>"> <?php echo $countryItem['DESCRIPTION'];?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> ABA/RTN </label>
                                                <div class="col-sm-7">
                                                    <input type="text"  class="form-control" name="interABA" id="interABA">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label "> ACC#/IBAN </label>
                                                <div class="col-sm-7">
                                                    <input type="text"  class="form-control" name="interACC" id="interACC">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <h3 class="form-section font-yellow-gold font-sm">
                                        Transfer Details
                                    </h3>



                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> eWallet Debit Amount: <span class="font-red"> * </span></label>
                                        <div class="col-sm-3">
                                            <input type="text" required class="form-control" placeholder="Amount to transfer" name="transferAmount" id="transferAmount">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="control-label"> eWallet Currency Type: </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" readonly value="" id="accountCurrencyDisp" name="accountCurrencyDisp">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" style="padding: 0px !important;">
                                            <span>
                                                <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                                                   data-trigger="hover" data-placement="top" data-content="Currency Conversion Rate" data-original-title="Information"> CCR <span class="font-red">  </span> </a>
                                            </span>
                                        </label>

                                        <div class="col-sm-3">
                                            <input type="hidden" id="vpayRate" name="vpayRate">
                                            <input type="hidden" id="accountCurrencyConversionRate"/>
                                            <input type="text" class="form-control  margin-top-5" value="1" id="currencyConversionRate" name="currencyConversionRate">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Total Receive Amount </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control  margin-top-5" value="0" id="resultAmount" name="resultAmount">
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="control-label"> Receive Currency type: </label>
                                        </div>


                                        <div class="col-sm-4">
                                            <select class="select2 select2-allow-clear form-control" name="transferCurrency" id="transferCurrency">
                                                <?php foreach ($currencies as $currencyItem){?>
                                                    <option value="<?php echo $currencyItem['ID'];?>"> <?php echo $currencyItem['TITLE'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" style="padding: 0px !important;">
                                            <span>
                                                <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                                                   data-trigger="hover" data-placement="top" data-content="Outgoing Transfer Fee" data-original-title="Information"> OWT Fee <span class="font-red">  </span> </a>
                                            </span>
                                        </label>

                                        <div class="col-sm-9">
                                            <input type="hidden" id="feeValue">
                                            <input type="hidden" id="feeType">
                                            <input type="text" class="form-control  margin-top-5" value="0" id="txtFee" required name="fee">
                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label class="col-sm-2 control-label "> Additional Fee </label>

                                        <div class="col-sm-9">
                                            <input id="btAddFee" type="button" class="btn btn-block yellow-gold" value="Add Additional Fee">
                                        </div>

                                    </div>

                                    <div id="divAdditionalFeeContainer">

                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" id="additionalFeeTotal" name="additionalFeeTotal" value="">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Total Fee Amount </label>
                                        <div class="col-sm-9">
                                            <input type="text" readonly class="form-control  margin-top-5" value="0" id="resultFee" name="resultFee">
                                        </div>
                                    </div>

                                    <h3 class="form-section font-yellow-gold font-sm">
                                        Transfer Result
                                    </h3>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Description </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" placeholder="Transfer Description" rows="5" name="description" id="description"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-1 col-md-offset-10">
                                            <input type="button" onclick="showConfirmModal();" class="btn yellow-gold" value="Continue">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="responsive" class="modal fade" tabindex="-1" data-width="780">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Outgoing Transfer Description</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <p class="label font-grey-salsa"> Account </p>
                                        </div>
                                        <div class="col-md-10">
                                            <p id="dlgAccount" class="label font-grey-gallery">  </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 margin-top-20">
                                            <h6 class="font-yellow-gold"> SPECIFY BENEFICARY BANK </h6>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> SWIFT/BIC </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgSwiftBic" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Name </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgBenificaryName" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Address </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgBenificaryAddr" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Location </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgBenificaryLocation" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Country </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgBenificaryCountry" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> ABA/RTN </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgBenificaryABA" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 margin-top-20">
                                            <h6 class="font-yellow-gold"> SPECIFY BENEFICIARY CUSTOMER </h6>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Name </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgCustomerName" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Address </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgCustomerAddr" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <div class="col-md-4">
                                                <p class="label font-grey-salsa"> Acc#/IBAN </p>
                                            </div>
                                            <div class="col-md-8">
                                                <p id="dlgCustomerAcc" class="label font-grey-gallery">  </p>
                                            </div>
                                        </div>

                                        <div class="col-md-12 margin-top-20">
                                            <h6 class="font-yellow-gold"> ADDITIONAL INFORMATION </h6>
                                        </div>
                                        <div class="col-md-12">
                                            <p id="dlgAdditionInfo" class="label font-grey-gallery"> John </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12 margin-top-20">
                                            <h6 class="font-yellow-gold"> TRANSFER DETAILS </h6>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="label font-grey-salsa"> eWallet Debit Amount </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="dlgTransferAmount" class="label font-grey-gallery">  </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="label font-grey-salsa"> eWallet Currency </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="dlgWalletCurrency" class="label font-grey-gallery">  </p>
                                        </div>
                                    </div>

                                    <div class="col-md-12 margin-top-10">
                                        <div class="col-md-3">
                                            <p class="label font-grey-salsa"> Receive Amount </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="dlgReceiveAmount" class="label font-grey-gallery">  </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="label font-grey-salsa"> Receive Currency </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="dlgTransferCurrency" class="label font-grey-gallery">  </p>
                                        </div>
                                    </div>


                                    <div class="col-md-12 margin-top-10">
                                        <div class="col-md-3">
                                            <p class="label font-grey-salsa"> OWT Fee </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="dlgTransferFee" class="label font-grey-gallery">  </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="label font-grey-salsa"> CCR </p>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="dlgConversionRateValue" class="label font-grey-gallery">  </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 margin-top-10">
                                        <div class="col-md-2">
                                            <p class="label font-grey-salsa"> Description </p>
                                        </div>
                                        <div class="col-md-10">
                                            <p id="dlgTransferDesc" class="label font-grey-gallery">  </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" onclick="printDialog();" class="btn btn-outline blue-madison"> Print </button>
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark"> Cancel </button>
                                <button type="button" data-dismiss="modal" onclick="$('#formOutgoing').submit();" class="btn green">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_transfer_outgoing.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>