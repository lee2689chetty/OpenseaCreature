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
                    <?php if($available_amount):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Failed to request transfer. Available amount of account is not enough. </span>
                        </div>
                    <?php endif;?>

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
                    <?php if($currency):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to request transfer. Choose card with same curreny first. </span>
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
                                Card Funding Transfer
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form"  method="post" action="../transfer/cards" class="form-horizontal" id="formSubmit">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Debit From <span class="font-red"> * </span></label>
                                                <div class="col-sm-9">
                                                    <select class="bs-select form-control" name="fromAccount" id="fromAccount">
                                                        <option value="0"> Select Account </option>
                                                        <?php
                                                            foreach ($accounts as $accountItem){
                                                                echo ("<option value=\"".$accountItem['ID']."\" data-content=\""
                                                                    .$accountItem['ACCOUNT_NUMBER']." <span class='label label-sm label-success'> ".$accountItem['CURRENCY_TITLE']. "  ".$accountItem['CURRENT_AMOUNT']." </span>\"> </option>");
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Credit To <span class="font-red"> * </span></label>
                                                <div class="col-sm-9">
                                                    <select class="bs-select form-control" name="toCard">
                                                        <option value="0"> Select Card </option>
                                                        <?php
                                                            foreach ($cards as $cardItem){
                                                                echo ("<option value=\"".$cardItem['ACCOUNT_ID']."\" data-content=\""
                                                                    .$cardItem['CARD_NUMBER']." <span class='label label-sm label-success'> ".$cardItem['CURRENCY_TITLE']. "  ".$cardItem['CURRENT_AMOUNT']." </span>\"> </option>");
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="form-section font-yellow-gold font-sm">
                                        Transfer Details
                                    </h3>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Amount to transfer <span class="font-red"> * </span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="amount" id="amount" required class="form-control" placeholder="Amount to transfer">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" style="padding: 0px !important;">
                                            <span>
                                                <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                                                   data-trigger="hover" data-placement="top" data-content="Card Funding Transfer Fee" data-original-title="Information"> CFT Fee <span class="font-red">  </span> </a>
                                            </span>
                                        </label>

                                        <div class="col-sm-3">
                                            <input type="hidden" id="feeValue">
                                            <input type="hidden" id="feeType">
                                            <input type="text" class="form-control" readonly id="txtFee" required name="fee">
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
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.formatCurrency.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/client_transfer_between_cards.js" type="text/javascript"></script>
</body>
</html>