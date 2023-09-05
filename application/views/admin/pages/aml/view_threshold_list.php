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
                                Threshold of Transactions per Countries
                            </div>
                            <div class="actions">

                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="row" style="margin-top: 60px;">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover" id="tbThresholdList" >
                                        <thead>
                                        <tr>
                                            <th class="font-grey-salsa"> No </th>
                                            <th class="font-yellow-gold"> Country </th>
                                            <th class="font-yellow-gold"> Threshold ( USD ) </th>
                                            <th class="font-yellow-gold"> Date </th>
                                            <th class="font-grey-salsa"> Action </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php for($i = 0 ; $i < count($thresholdList) ; $i++):?>
                                                <tr class="input-large">
                                                    <td> <?php echo $i + 1;?></td>
                                                    <td> <?php echo $thresholdList[$i]['COUNTRY_DESC'];?></td>
                                                    <td> <?php echo $thresholdList[$i]['THRESHOLD_AMOUNT'] == '0' ? 'Undefined':number_format($thresholdList[$i]['THRESHOLD_AMOUNT'], 2, '.', ',');?></td>
                                                    <td> <?php echo date('Y-m-d H:m:s', $thresholdList[$i]['UPDATED_AT']);?></td>
                                                    <td> <a href="<?php echo base_url();?>admin/aml/edit_threshold/<?php echo $thresholdList[$i]['ID']?>" class="btn btn-success"> Edit </a> </td>
                                                </tr>
                                            <?php endfor;?>
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
<script src="<?php echo base_url();?>assets/pages/scripts/admin_aml_threshold_list.js" type="text/javascript"></script>

</body>
</html>