<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">


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
                                Uploaded Files
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>file/new_upload/new" class="btn yellow-gold"> Upload New File </a>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="row" style="margin-top: 60px;">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover" id="tbFileList" >
                                                    <thead>
                                                        <tr>
                                                            <th class="font-yellow-gold"> Transaction Id </th>
                                                            <th class="font-yellow-gold"> Owner Name </th>
                                                            <th class="font-yellow-gold"> Uploader Name </th>
                                                            <th class="font-yellow-gold"> File Name </th>
                                                            <th class="font-yellow-gold"> Date </th>
                                                            <th class="font-grey-salsa"> Actions </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($fileList as $fileListItem){?>
                                                            <tr class="input-large">
                                                                <td style="padding-top: 15px; padding-bottom: 15px;"> <a href="<?php echo base_url();?>request/status/<?php echo $fileListItem['TRANS_ID'];?>" class="btn btn-link"><?php echo $fileListItem['TRANS_ID'];?></a>  </td>
                                                                <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $fileListItem['USER_NAME'];?> </td>
                                                                <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $fileListItem['UPLOADER_USER_NAME'];?> </td>
                                                                <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $fileListItem['FILE_NAME'];?> </td>
                                                                <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d H:m:s', $fileListItem['CREATED_AT']);?> </td>
                                                                <td style="padding-top: 15px; padding-bottom: 15px;">
                                                                    <a href="<?php echo base_url();?>file/download_file/<?php echo $fileListItem['ID'];?>" class="btn default green-stripe"> Download </a>
                                                                    <a href="<?php echo base_url().$fileListItem['FILE_PATH'];?>" target="_blank" class="btn default blue-madison-stripe"> View </a>
                                                                    <a href="<?php echo base_url();?>file/remove_file/<?php echo $fileListItem['ID'];?>" class="btn default red-stripe"> Delete </a></td>
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
<script src="<?php echo base_url();?>assets/pages/scripts/admin_file_list.js" type="text/javascript"></script>

</body>
</html>