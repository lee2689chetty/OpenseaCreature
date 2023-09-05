<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white
    <?php if($adminDisp == false){ echo 'page-sidebar-closed';}?>">

<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1>
                        Transfer Status Details
                    </h1>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Transfer Request Details
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-responsive table-light">
                                <tbody>
                                    <tr>
                                        <td><p class="font-grey-salsa"> FROM </p></td>
                                        <td><p> <span class="margin-right-10"> <?php echo $FromUserData['USER_NAME'];?></span><span class="label label-success"> <?php echo $FromUserData['ACCOUNT_NUMBER'];?> </span></p></td>
                                    </tr>
                                    <tr>
                                        <td><p class="font-grey-salsa"> TO </p></td>
                                        <td><p> <span class="margin-right-10"> <?php echo $toUserData['USER_NAME'];?></span><span class="label label-success"> <?php echo $toUserData['ACCOUNT_NUMBER'];?> </span></p></td>
                                    </tr>
                                    <tr>
                                        <td><p class="font-grey-salsa"> AMOUNT </p></td>
                                        <td><p> <span class="margin-right-10"> <?php echo number_format($requestDetail['AMOUNT'],2 , ".", ",");?></span><span class="label label-danger">
                                                    <?php
                                                        if($FromUserData['CURRENCY_TITLE'] == ""){
                                                            echo $toUserData['CURRENCY_TITLE'];
                                                        }
                                                        else{
                                                            echo $FromUserData['CURRENCY_TITLE'];
                                                        }
                                                    ?></span> </p></td>
                                    </tr>
                                    <tr>
                                        <td><p class="font-grey-salsa"> SUBJECT </p></td>
                                        <td><p> <?php echo $transactionType['DESCRIPTION'];?> </p></td>
                                    </tr>
                                    <tr>
                                        <td><p class="font-grey-salsa"> DESCRIPTION </p></td>
                                        <td><p> <?php echo $requestDetail['DESCRIPTION'];?> </p></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Status History
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="font-yellow-gold"> Date </th>
                                    <th class="font-yellow-gold"> Status </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($TransferHistory as $historyDetailItem):?>
                                    <tr class="input-large">
                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d H:m:s', $historyDetailItem['UPDATED_AT']);?> </td>
                                        <td style="padding-top: 15px; padding-bottom: 15px;">
                                            <?php if(intval($historyDetailItem['STATUS_ID']) == TRANSFER_APPROVED || intval($historyDetailItem['STATUS_ID']) == TRANSFER_COMPLETE)
                                            {
                                                ?>
                                                    <p class="font-green">
                                            <?php
                                            }
                                            else if(intval($historyDetailItem['STATUS_ID']) == TRANSFER_CANCELLED || intval($historyDetailItem['STATUS_ID'] == TRANSFER_SUSPENDED))
                                            {?>
                                                    <p class="font-red">
                                            <?php
                                            }
                                            else
                                            {?>
                                                    <p class="font-yellow-gold">
                                            <?php }?>
                                                    <?php echo $historyDetailItem['DESCRIPTION'];?> </p>
                                        </td>

                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Uploaded Files For this request
                            </div>
                            <div class="tools"> </div>
                            <div class="actions">
                                <?php if(count($TransferHistory) > 0 ) :?>
                                <a href="<?php echo base_url();?>admin/file/new_upload/<?php print_r($TransferHistory[0]['REQUEST_ID']);?>" class="btn yellow-gold"> Add New File </a>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="font-yellow-gold"> Date </th>
                                    <th class="font-yellow-gold"> File Name </th>
                                    <th class="font-yellow-gold"> Document For</th>
                                    <th class="font-yellow-gold"> Uploader Name </th>
                                    <th class="font-grey-salsa"> Actions </th>
                                </tr>
                                </thead>
                                <tbody>

                                        <?php foreach ($uploadFiles as $docItem):?>
                                        <tr class="input-large">
                                            <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d H:m:s', $docItem['CREATED_AT']);?> </td>
                                            <td style="padding-top: 15px; padding-bottom: 15px;">
                                                <?php echo $docItem['FILE_NAME'];?>
                                            </td>
                                            <td>
                                                <?php echo $docItem['USER_NAME'];?>
                                            </td>
                                            <td>
                                                <?php echo $docItem['UPLOADER_USER_NAME'];?>
                                            </td>
                                            <td>
                                                <a href="<?php
                                                if($adminDisp == false) echo base_url();
                                                else echo base_url().'admin/'; ?>file/download_file/<?php echo $docItem['ID'];
                                                ?>" class="btn btn-success"> Download </a>
                                                <a href="<?php echo base_url().$docItem['FILE_PATH'];?>" class="btn btn-warning"> View </a>
                                                <?php if($adminDisp){ ?>
                                                <a href="<?php echo base_url();?>admin/request/remove_file/<?php echo $docItem['ID'];?>?>" class="btn btn-danger"> Delete </a>
                                                <?php }?>
                                            </td>
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

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>