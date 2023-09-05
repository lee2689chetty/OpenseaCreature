<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <form role="form" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo base_url();?>admin/report/system_overview">
                        <div class="row">
                                <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                    <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" name="fromAllDate" id="fromAllDate" value="<?php echo $startDate;?>">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control" name="toAllDate" id="toAllDate" value="<?php echo $endDate;?>">
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-1 form-actions">
                                    <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btGenerate">Generate</button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-yellow-gold">
                        Profile overviews
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <span class="font-grey-salsa"> Pending Registration: </span>  4
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <span class="font-grey-salsa"> Active Profiles: </span><?php echo $ovActiveProfile;?>
                            </div>
                    </div>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-yellow-gold">
                        Deposits
                    </div>
                </div>
                <div class="portlet-body">

                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th> Deposit </th>
                                <?php for($i = 0 ; $i < count($ovCurrencyDeposit); $i++):?>
                                    <th> <?php echo $ovCurrencyDeposit[$i]['CURRENCY_TITLE'];?> </th>
                                <?php endfor;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($feeTypeIndex = 0 ; $feeTypeIndex < count($ovDepositContent); $feeTypeIndex++):?>
                                <tr>
                                    <td>
                                        <?php echo $ovDepositContent[$feeTypeIndex]['ACCOUNT_TYPE'];?>
                                    </td>
                                    <?php for($currencyIndex = 0 ; $currencyIndex < count($ovCurrencyDeposit) ; $currencyIndex++):?>
                                    <td>
                                        <?php
                                            $value = number_format(floatval($ovDepositContent[$feeTypeIndex][$ovCurrencyDeposit[$currencyIndex]['CURRENCY_TYPE']][0]['TOTAL_BALANCE']), 2, '.', ',');
                                            if($value > 0)
                                                echo ("<span class=\"font-green\">".$value."</span>");
                                            else
                                                echo ("<span class=\"font-grey-salsa\">".$value."</span>");
                                        ?>
                                    </td>
                                    <?php endfor;?>
                                </tr>
                            <?php endfor;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-yellow-gold">
                        Revenue Account Balance
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> Revenue Account </th>
                                <?php for($i = 0 ; $i < count($ovCurrencyRevenue); $i++):?>
                                    <th> <?php echo $ovCurrencyRevenue[$i]['CURRENCY_TITLE'];?> </th>
                                <?php endfor;?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> All generated revenues</td>
                                <?php for($i = 0 ; $i < count($ovCurrencyRevenue); $i++):?>
                                    <td> <?php echo number_format(floatval($ovCurrencyRevenue[$i]['CURRENT_AMOUNT']), 2, '.', ',');?> </td>
                                <?php endfor;?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-yellow-gold">
                        Currency overviews
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row" id="containerSystemRevenue">
                        <div class="col-sm-12" >
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th> Currency Overview </th>
                                        <?php for($i = 0 ; $i < count($ovCurrencyDeposit); $i++):?>
                                            <th> <?php echo $ovCurrencyDeposit[$i]['CURRENCY_TITLE'];?> </th>
                                        <?php endfor;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Total balance </td>
                                        <?php foreach ($ovCurrencyDeposit as $item) {
                                            echo ("<td>".number_format(floatval($covTotalBalance[$item['CURRENCY_TYPE']][0]['TOTAL_BALANCE']), 2, '.',',')."</td>");
                                        }?>
                                    </tr>
                                    <tr>
                                        <td> Total Pending transactions </td>
                                        <?php foreach ($ovCurrencyDeposit as $item) {
                                            echo ("<td>".number_format(floatval($covTotalPending[$item['CURRENCY_TYPE']][0]['TOTAL_BALANCE']), 2, '.', ',')."</td>");
                                        }?>
                                    </tr>
                                    <tr>
                                        <td> Future balance </td>
                                        <?php foreach ($ovCurrencyDeposit as $item) {
                                            echo ("<td>".$covTotalFuture[$item['CURRENCY_TYPE']]."</td>");
                                        }?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
</body>

</html>