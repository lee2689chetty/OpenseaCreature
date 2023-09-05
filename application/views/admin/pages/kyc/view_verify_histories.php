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
                                <?php echo $userData['FULL_NAME'];?>'s KYC History
                            </div>
                            <div class="actions">
                            </div>
                        </div>

                        <div class="portlet-body">
                            <table class="table table-striped table-hover" id="tbHistory" style="margin-top: 90px;">
                                                <thead>
                                                    <tr>
                                                        <th class="font-yellow-gold"> # </th>
                                                        <th class="font-yellow-gold"> Requested </th>
                                                        <th class="font-yellow-gold"> Closed </th>
                                                        <th class="font-yellow-gold"> Operator </th>
                                                        <th class="font-yellow-gold"> Identify </th>
                                                        <th class="font-yellow-gold"> Address </th>
                                                        <th class="font-yellow-gold"> Ticket Number </th>
                                                        <th class="font-grey-salsa"> Actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for($i = 0 ; $i < count($history) ; $i++){?>
                                                        <tr class="input-large">
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $i+1;?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d', $history[$i]['VERIFY_REQUEST_DATE']);?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php
                                                                if($history[$i]['VERIFY_UPDATE_DATE'] == 0) echo "NOT FINISHED";
                                                                else echo date('Y-m-d', $history[$i]['VERIFY_UPDATE_DATE']);?>
                                                            </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $history[$i]['admin']['FULL_NAME'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                <?php if(intval($history[$i]['IDENTIFY_APPROVE']) == 0){?>
                                                                    <label class="label label-danger"> NOT APPROVED</label>
                                                                <?php }else { ?>
                                                                    <label class="label label-success"> APPROVED </label>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                <?php if(intval($history[$i]['ADDRESS_APPROVE']) == 0){?>
                                                                    <label class="label label-danger"> NOT APPROVED</label>
                                                                <?php }else { ?>
                                                                    <label class="label label-success"> APPROVED </label>
                                                                <?php } ?>
                                                            </td>

                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $history[$i]['TICKET_NUMBER'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                <a href="<?php echo base_url();?>admin/kyc/verify_edit/<?php echo $history[$i]['ID'];?>" class="btn default red-stripe"> Detail </a>
                                                            </td>
                                                        </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
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
<script src="<?php echo base_url();?>assets/pages/scripts/admin_kyc_history.js" type="text/javascript"></script>

</body>
</html>