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
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                All Cards
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">

                            <div class="row" id="containerSystemAllCards">
                                <div class="col-sm-12" style="margin-top: 70px;">
                                    <table class="table table-striped table-bordered table-hover" id="tbSystemCardUsers">
                                        <thead>
                                        <tr>
                                            <th> UserName </th>
                                            <th> FullName </th>
                                            <th> Account Creation Date </th>
                                            <th> Card Number </th>
                                            <th> Card Type </th>
                                            <th> Status </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($cardUserList as $item):?>
                                            <tr class="input-large">
                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <?php echo $item['NAME'];?> </td>
                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <?php echo $item['FULL_NAME'];?> </td>
                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <?php echo date('Y-m-d', $item['CREATED_AT']);?> </td>
                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <?php
                                                    $item['CARD_NUMBER'] = str_replace(' ', '',$item['CARD_NUMBER']);
                                                    $item['CARD_NUMBER'] = str_replace('-', '',$item['CARD_NUMBER']);
                                                    $arr_card_num = str_split($item['CARD_NUMBER'], 4);
                                                    $prtVal = "";
                                                    foreach ( $arr_card_num as $item1){
                                                        $prtVal .= ($item1."-");
                                                    }
                                                    $prtVal = substr($prtVal, 0, -1);
                                                    echo $prtVal;
                                                    ?> </td>
                                                <td style="padding-top: 35px; padding-bottom: 35px;"> Visa Mater </td>
                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <?php echo $item['DESCRIPTION'];?> </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

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
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_report_system_cards.js" type="text/javascript"></script>
</body>
</html>