<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

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
                                Revenue Accounts
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>admin/account/new_revenue" class="btn yellow-gold"> Create new Account </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content" style="padding: 20px;">

                                    <div class="row" style="margin-top: 60px;">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-hover" id="tbContent">
                                                <thead>
                                                    <tr>
                                                        <th class="font-yellow-gold"> Account # </th>
                                                        <th class="font-yellow-gold"> Currency </th>
                                                        <th class="font-yellow-gold"> Available </th>
                                                        <th class="font-yellow-gold"> Current </th>
                                                        <th class="font-grey-salsa"> Actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($accountList as $accountListItem){?>
                                                        <tr class="input-large">
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['REVENUE_NAME'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['CURRENCY_TITLE'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo number_format($accountListItem['AVAILABLE_AMOUNT'], 2, '.', ','); ?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo number_format($accountListItem['CURRENT_AMOUNT'], 2, '.', ',');?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                <a href="./revenue_history/<?php echo $accountListItem['ID'];?>" class="btn default red-stripe"> View </a>
                                                                <a href="./revenue_debit/<?php echo $accountListItem['ID'];?>" class="btn default green-stripe"> Debit </a>
                                                                <a href="./revenue_credit/<?php echo $accountListItem['ID'];?>" class="btn default blue-stripe"> Credit </a>
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
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_revenue_view.js" type="text/javascript"></script>
</body>
</html>