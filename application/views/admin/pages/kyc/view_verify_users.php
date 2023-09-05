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
                                KYC Progress
                            </div>
                            <div class="actions">
                            </div>
                        </div>

                        <div class="portlet-body">
                            <table class="table table-striped table-hover" id="tbUserList" style="margin-top: 90px;">
                                                <thead>
                                                    <tr>
                                                        <th class="font-yellow-gold"> User Name # </th>
                                                        <th class="font-yellow-gold"> Full Name </th>
                                                        <th class="font-yellow-gold"> Email </th>
                                                        <th class="font-yellow-gold"> Status </th>
                                                        <th class="font-yellow-gold"> Last Login </th>
                                                        <th class="font-yellow-gold"> Requested </th>
                                                        <th class="font-yellow-gold"> Verify </th>
                                                        <th class="font-grey-salsa"> Actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($userList as $userListItem){?>
                                                        <tr class="input-large">
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['NAME'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['FULL_NAME'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['EMAIL'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $statusList[$userListItem['STATUS'] - 1]['DESCRIPTION'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['last_login_time'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['REQUESTED_TIME'];?> </td>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                <?php if(intval($userListItem['VERIFY_STATUS']) == 1){?>
                                                                    <label class="label label-warning"> Requested </label>
                                                                <?php } else if(intval($userListItem['VERIFY_STATUS']) == 2){?>
                                                                    <label class="label label-success"> Verified </label>
                                                                <?php
                                                                    }
                                                                ?>
                                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                <a href="<?php echo base_url();?>admin/kyc/history/<?php echo $userListItem['ID'];?>" class="btn default red-stripe"> Detail </a>
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
<script src="<?php echo base_url();?>assets/pages/scripts/admin_kyc_user_list.js" type="text/javascript"></script>

</body>
</html>