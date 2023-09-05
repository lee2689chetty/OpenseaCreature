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
                                All Suspended Transactions
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
                                            <th class="font-grey-salsa"> Type </th>
                                            <th class="font-grey-salsa"> Related Trans</th>
                                            <th class="font-grey-salsa"> Action </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($amlList as $amlListItem):?>
                                            <tr>
                                                <td> <?php echo date('Y-m-d H:m:s', $amlListItem['UPDATED_AT']);?></td>
                                                <td> <a href="<?php echo base_url();?>admin/request/transfer/<?php echo $amlListItem['TRANSACTION_ID'];?>"> <?php echo $amlListItem['TRANSACTION_ID'];?> </a> </td>
                                                <td> <a href="<?php
                                                    if(intval($amlListItem['detailItem']['fromUserProfileId']) == 0) {
                                                        // it is administrator or bank
                                                        echo "javascript:;";
                                                    }
                                                    else {
                                                        echo base_url().'admin/profile/edit/'.$amlListItem['detailItem']['fromUserProfileId'];
                                                    }?>"> <?php echo $amlListItem['detailItem']['fromUserName'];?> </a>
                                                </td>

                                                <td>
                                                    <a href="<?php
                                                        if(intval($amlListItem['detailItem']['toUserProfileId']) == 0) {
                                                            echo "javascript:;";
                                                        }
                                                        else {
                                                            echo base_url().'admin/profile/edit/'.$amlListItem['detailItem']['toUserProfileId'];
                                                        }?>"> <?php echo $amlListItem['detailItem']['toUserName'];?> </a>
                                                </td>

                                                <td> <?php if($amlListItem['REASON'] == '1') {
                                                        echo 'Destination is restricted area';
                                                    } else { echo 'Transfer amount is exceed to limitation';}?></td>
                                                <td> <?php echo $amlListItem['countOfRelation'];?> </td>
                                                <td>
                                                    <?php if($amlListItem['REASON'] != '1' && intval($amlListItem['countOfRelation']) > 0):?>
                                                        <a href="<?php echo base_url();?>admin/aml/approve_all/<?php echo $amlListItem['ID'];?>" class="btn btn-success"> Approve All Transactions</a>
                                                        <a href="<?php echo base_url();?>admin/aml/view_related_trans/<?php echo $amlListItem['ID'];?>" class="btn btn-danger"> See Related Trans</a>
                                                    <?php else:?>
                                                        <a href="<?php echo base_url();?>admin/aml/approve_one/<?php echo $amlListItem['ID'];?>" class="btn btn-success"> Approve Transaction </a>
                                                    <?php endif;?>
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                All Warning Transactions
                            </div>
                            <div class="actions">

                            </div>
                        </div>

                        <div class="portlet-body">
                            <div class="row" style="margin-top: 60px;">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover" id="tbWarnTransList" >
                                        <thead>
                                        <tr>
                                            <th class="font-grey-salsa"> Date </th>
                                            <th class="font-yellow-gold"> To </th>
                                            <th class="font-grey-salsa"> Amount </th>
                                            <th class="font-grey-salsa"> Related Trans</th>
                                            <th class="font-grey-salsa"> Action </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($warningList as $amlListItem):?>
                                            <tr>
                                                <td> <?php echo date('Y-m-d H:m:s', $amlListItem['UPDATED_AT']);?></td>
                                                <td>
                                                    <?php echo $amlListItem['userName'];?>
                                                </td>
                                                <td> <?php echo $amlListItem['AMOUNT'];?>
                                                <td> <?php echo $amlListItem['counter'];?> </td>
                                                <td>
                                                    <a href="<?php echo base_url();?>admin/aml/view_warnings?to_user=<?php echo $amlListItem['TO_USER_ID'];?>&amount=<?php echo $amlListItem['AMOUNT']?>" class="btn btn-success"> View Transaction </a>
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
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_aml_trans_list.js" type="text/javascript"></script>

</body>
</html>