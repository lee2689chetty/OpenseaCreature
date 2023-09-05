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
                                Detail of Warning Transactions
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
                                            <th class="font-yellow-gold"> Transfer Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php for ($i = 0 ; $i < count($transfer_history) ;$i++):?>
                                            <tr class="input-large">
                                                <td> <?php echo date('Y-m-d H:m:s', $transfer_history[$i]['UPDATED_AT']);?></td>
                                                <td> <a href="<?php echo base_url();?>admin/request/transfer/<?php echo $transfer_history[$i]['ID'];?>"> <?php echo $transfer_history[$i]['ID'];?> </a> </td>
                                                <td> <a href="<?php
                                                    if(intval($transfer_history[$i]['userInfo']['fromUserProfileId']) == 0) {
                                                        // it is administrator or bank
                                                        echo "javascript:;";
                                                    }
                                                    else {
                                                        echo base_url().'admin/profile/edit/'.$transfer_history[$i]['userInfo']['fromUserProfileId'];
                                                    }?>"> <?php echo $transfer_history[$i]['userInfo']['fromUserName'];?> </a>
                                                </td>

                                                <td>
                                                    <a href="<?php
                                                    if(intval($transfer_history[$i]['userInfo']['toUserProfileId']) == 0) {
                                                        echo "javascript:;";
                                                    }
                                                    else {
                                                        echo base_url().'admin/profile/edit/'.$transfer_history[$i]['insArr']['toUserProfileId'];
                                                    }?>"> <?php echo $transfer_history[$i]['userInfo']['toUserName'];?> </a>
                                                </td>
                                                <td> <?php echo $transfer_history[$i]['AMOUNT'];?> </td>

                                                <td><?php
                                                    switch ($transfer_history[$i]['TRANSACTION_TYPE']) {
                                                        case Transfer_Between_Accounts:
                                                            echo 'TRANSFER BETWEEN ACCOUNTS';
                                                            break;
                                                        case Transfer_Between_Users:
                                                            echo 'TRANSFER BETWEEN USERS';
                                                            break;
                                                        case Outgoing_Wire_Transfer:
                                                            echo 'OUTGOING WIRE TRANSFER';
                                                            break;
                                                        case Card_Funding_Transfer:
                                                            echo 'CARD FUNDING TRANSFER';
                                                            break;
                                                        case Incoming_Wire_Transfer:
                                                            echo 'INCOMING WIRE TRANSFER';
                                                            break;
                                                        case Account_Debit_Transfer:
                                                            echo 'ACCOUNT DEBIT TRANSFER';
                                                            break;
                                                        case Account_Credit_Transfer:
                                                            echo 'ACCOUNT CREDIT TRANSFER';
                                                            break;
                                                    }

                                                    ?></td>
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
        </div>
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_aml_warning_trans_list.js" type="text/javascript"></script>

</body>
</html>