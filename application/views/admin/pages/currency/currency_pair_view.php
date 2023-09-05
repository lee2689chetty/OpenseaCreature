<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
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
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Currency Pair
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>admin/currency/addpair_view" class="btn yellow-gold"> Add New Currency Pair</a>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <!-- BEGIN TRANSFER FEE TAB -->
                                <div class="row" style="margin-top: 70px;">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover" id="tbCurrency">
                                            <thead>
                                            <tr>
                                                <th class="font-yellow-gold"> ID </th>
                                                <th class="font-yellow-gold"> Title </th>
                                                <th class="font-yellow-gold"> Interbank Rate  </th>
                                                <th class="font-yellow-gold"> ValorPay Rate  </th>
                                                <th class="font-yellow-gold"> Creation Time </th>
                                                <th class="font-grey-salsa">  </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($currency as $currencyListItem){?>
                                                <tr class="input-large">
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $currencyListItem['ID'];?> </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $currencyListItem['BASE_CURRENCY_TITLE'].'/'.$currencyListItem['SECONDARY_CURRENCY_TITLE'];?>  </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> 1/<?php echo $currencyListItem['INTER_BANK_RATE'];?>  </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> 1/<?php echo $currencyListItem['VALOR_PAY_RATE'];?>  </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d', $currencyListItem['CREATED_AT']);?> </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;">
                                                        <a href="<?php echo base_url();?>admin/currency/editpair_view/<?php echo $currencyListItem['ID'];?>" class="btn default red-stripe"> Edit </a>
                                                        <a href="javascript:;" class="btn default red-stripe delete"> Remove </a>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_currency_rate_view.js" type="text/javascript"></script>
</body>

</html>