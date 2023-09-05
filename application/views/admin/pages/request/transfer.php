<?php echo $header;?>

<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">

<?php echo $topbar;?>
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php echo $sidebar;?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Transfer Request Details

                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>

            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                System Request Details
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p class="font-grey-salsa"> DATE/TIME </p>
                                        <p class="font-grey-salsa"> FROM </p>
                                        <p class="font-grey-salsa"> USERNAME </p>
                                        <p class="font-grey-salsa"> STATUS </p>
                                        <p class="font-grey-salsa"> SUBJECT </p>
                                    </div>
                                    <div class="col-md-7">
                                        <p> <?php echo date('d-m-Y h:m:s a', $requestDetail['CREATED_AT']);?> </p>
                                        <p> <?php echo $fromUserData['ACCOUNT_NUMBER'];?> </p>
                                        <p> <?php echo $fromUserData['USER_NAME'];?> </p>
                                        <p> <?php echo $requestDetail['STATUS_DESCRIPTION'];?> </p>
                                        <p> <?php echo $transactionType['DESCRIPTION'];?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Transfer History <span class="label label-danger" style="margin-left: 25px;"> Parent Transaction ID: <?php print_r($requestDetail['ID']);?> </span>
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-sm-12">

                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="font-yellow-gold"> Date </th>
                                                <th class="font-yellow-gold"> Id </th>
                                                <th class="font-grey-salsa"> Account </th>
                                                <th class="font-yellow-gold"> Description </th>
                                                <th class="font-grey-salsa"> Currency </th>
                                                <th class="font-grey-salsa"> Debit/Credit </th>
                                                <th class="font-yellow-gold"> Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($historyDetail as $historyDetailItem): ?>
                                                <?php if($historyDetailItem['AMOUNT'] > 0 && $historyDetailItem['ACCOUNT_NUMBER'] != ""):?>
                                                <tr class="input-large">
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('d-m-Y h:m:s a', $historyDetailItem['UPDATED_AT']);?> </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $historyDetailItem['ID'];?> </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $historyDetailItem['ACCOUNT_NUMBER'];?> </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $historyDetailItem['DESCRIPTION'];?> </td>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $historyDetailItem['CURRENCY_TITLE'];?> </td>
                                                    <?php if($historyDetailItem['DETAIL_TYPE'] == '1'):?>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <p class="font-red"> -<?php echo number_format($historyDetailItem['AMOUNT'], 2, ".", ",");?></p> </td>
                                                    <?php else:?>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <p class="font-green"> <?php echo number_format($historyDetailItem['AMOUNT'], 2, ".", ",");?> </p> </td>
                                                    <?php endif;?>
                                                    <td style="padding-top: 15px; padding-bottom: 15px;">
                                                    <?php if(intval($requestDetail['STATUS']) == TRANSFER_APPROVED || intval($requestDetail['STATUS']) == TRANSFER_COMPLETE)
                                                        {
                                                            ?>
                                                                <p class="font-green">
                                                    <?php
                                                        }
                                                        else if(intval($requestDetail['STATUS']) == TRANSFER_CANCELLED)
                                                        {
                                                            ?>
                                                             <p class="font-red">
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                                <p class="font-yellow-gold">
                                                    <?php
                                                        } echo $statusArray[$requestDetail['STATUS'] - 1]['DESCRIPTION'];?> </p></td>

                                                </tr>
                                            <?php endif;?>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php
                switch(intval($requestDetail['TRANSACTION_TYPE']))
                {
                    case Transfer_Between_Accounts:
                        //between accounts
                        include_once('transfer_sub_detail_accounts.php');
                        break;
                    case Transfer_Between_Users:
                        //between users
                        include_once('transfer_sub_detail_users.php');
                        break;
                    case Outgoing_Wire_Transfer:
                        //outgoing
                        include_once('transfer_sub_detail_outgoing.php');
                        break;
                    case Card_Funding_Transfer:
                        //card funding
                        include_once('transfer_sub_detail_cards.php');
                        break;
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/datatables.js" type="text/javascript"></script>

</body>
</html>