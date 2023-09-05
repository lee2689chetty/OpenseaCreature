<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <form class="form" role="form" id="formCurrency" action="<?php echo base_url();?>admin/currency/addpair_view" method="post">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-yellow-gold">
                            Add New Currency Pair
                        </div>
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
                                        <span> Failed to add Currency Pair </span>
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
                                        <span> Successfully created Currency Pair </span>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label class="col-sm-12 control-label" style="text-align: left;"> Base Currency <span class="required"> * </span> </label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="baseCurrency" required>
                                            <?php foreach ($currency as $currencyItem){?>
                                                <option value="<?php echo $currencyItem['ID']?>"> <?php echo $currencyItem['TITLE'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="secondaryCurrency" class="col-sm-12 control-label" style="text-align: left;"> Secondary Currency <span class="required"> * </span> </label>
                                    <div class="col-sm-12">
                                        <select class="form-control select2" name="secondaryCurrency" required>
                                            <?php foreach ($currency as $currencyItem){?>
                                                <option value="<?php echo $currencyItem['ID']?>"> <?php echo $currencyItem['TITLE'];?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 form-group">
                                    <label class="col-sm-12 control-label" style="text-align: left;"> Interbank Rate <span class="required"> * </span> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" required type="number" min="0" name="interbankRate">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 form-group">
                                    <label class="col-sm-12 control-label" style="text-align: left;"> ValorPay Rate <span class="required"> * </span> </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" required type="number" min="0" name="valorPayRate">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 form-actions">
                                    <a href="<?php echo base_url();?>admin/currency/currencypair_view" type="submit" class="btn btn-outline yellow-gold" style="width: 150px;"> cancel </a>
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
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_new_currency_pair.js" type="text/javascript"></script>
</body>
</html>