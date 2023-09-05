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
                                Main Suspended Transaction
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>admin/aml/approve_all/<?php echo $mainTrans[0]['ID'];?>" class="btn yellow-gold"> Approve these transactions </a>
                            </div>
                        </div>

                        <div class="portlet-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover" >
                                        <thead>
                                        <tr>
                                            <th class="font-grey-salsa"> Date </th>
                                            <th class="font-yellow-gold"> Id </th>
                                            <th class="font-yellow-gold"> From </th>
                                            <th class="font-yellow-gold"> To </th>
                                            <th class="font-grey-salsa"> Type </th>
                                            <th class="font-grey-salsa"> Amount </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td> <?php echo date('Y-m-d H:m:s', $mainTrans[0]['UPDATED_AT']);?></td>
                                                <td> <a href="<?php echo base_url();?>admin/request/transfer/<?php echo $mainTrans[0]['TRANSACTION_ID'];?>"> <?php echo $mainTrans[0]['TRANSACTION_ID'];?> </a> </td>
                                                <td> <a href="<?php
                                                    if(intval($mainTrans['detailItem']['fromUserProfileId']) == 0) {
                                                        // it is administrator or bank
                                                        echo "javascript:;";
                                                    }
                                                    else {
                                                        echo base_url().'admin/profile/edit/'.$mainTrans['detailItem']['fromUserProfileId'];
                                                    }?>"> <?php echo $mainTrans['detailItem']['fromUserName'];?> </a>
                                                </td>
                                                <td>
                                                    <a href="<?php
                                                        if(intval($mainTrans['detailItem']['toUserProfileId']) == 0) {
                                                            echo "javascript:;";
                                                        }
                                                        else {
                                                            echo base_url().'admin/profile/edit/'.$mainTrans['detailItem']['toUserProfileId'];
                                                        }?>"> <?php echo $mainTrans['detailItem']['toUserName'];?> </a>
                                                </td>

                                                <td> <?php if($mainTrans[0]['REASON'] == '1') {
                                                        echo 'Destination is restricted area';
                                                    } else { echo 'Transfer amount is exceed to limitation';}?></td>
                                                <td> <?php echo $mainTrans['transAmount'];?> </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Related Transactions
                            </div>
                            <div class="actions">

                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="row" style="margin-top: 60px;">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover" id="tbTransList" >
                                        <thead>
                                        <tr>
                                            <th class="font-grey-salsa"> Date </th>
                                            <th class="font-yellow-gold"> Id </th>
                                            <th class="font-yellow-gold"> From </th>
                                            <th class="font-yellow-gold"> To </th>
                                            <th class="font-grey-salsa"> Amount </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($relatedTrans as $amlListItem):?>
                                            <tr>
                                                <td> <?php echo date('Y-m-d H:m:s', $amlListItem['UPDATED_AT']);?></td>
                                                <td> <a href="<?php echo base_url();?>admin/request/transfer/<?php echo $amlListItem['TRANS_ID'];?>"> <?php echo $amlListItem['TRANS_ID'];?> </a> </td>
                                                <td> <a href="<?php
                                                    if(intval($amlListItem[0]['insArr']['fromUserProfileId']) == 0) {
                                                        // it is administrator or bank
                                                        echo "javascript:;";
                                                    }
                                                    else {
                                                        echo base_url().'admin/profile/edit/'.$amlListItem[0]['insArr']['fromUserProfileId'];
                                                    }?>"> <?php echo $amlListItem[0]['insArr']['fromUserName'];?> </a>
                                                </td>

                                                <td>
                                                    <a href="<?php
                                                    if(intval($amlListItem[0]['insArr']['toUserProfileId']) == 0) {
                                                        echo "javascript:;";
                                                    }
                                                    else {
                                                        echo base_url().'admin/profile/edit/'.$amlListItem[0]['insArr']['toUserProfileId'];
                                                    }?>"> <?php echo $amlListItem[0]['insArr']['toUserName'];?> </a>
                                                </td>
                                                <td> <?php echo $amlListItem[0]['transAmount'];?> </td>
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
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_aml_related_trans_list.js" type="text/javascript"></script>

</body>
</html>