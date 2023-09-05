<?php echo $header;?>
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
                                Detail of <?php echo $accountData['ACCOUNT_NUMBER'];?>
                            </div>

<!--                            <ul class="nav nav-tabs">-->
<!--                                <li class="active">-->
<!--                                    <a href="#tab_1_1" data-toggle="tab">View</a>-->
<!--                                </li>-->
<!--                            </ul>-->
                            <div class="actions">
                                <a href="<?php echo base_url();?>admin/account/edit/<?php echo $accountData['ID'];?>" class="btn yellow-gold"> Edit </a>
                            </div>
                        </div>
                        <div class="portlet-body">
<!--                            <div class="tab-content" style="padding: 20px;">-->
                                <!-- PERSONAL INFO TAB -->
<!--                                <div class="tab-pane active" id="tab_1_1">-->
                            <div class="row">
                                        <div class="col-sm-4">
                                            <p class="uppercase font-grey-salsa"> user name </p>
                                            <p class="uppercase font-grey-salsa"> account type </p>
                                            <p class="uppercase font-grey-salsa"> Status </p>
                                            <p class="uppercase font-grey-salsa"> Currency </p>
                                            <p class="uppercase font-grey-salsa"> Current balance </p>
                                            <p class="uppercase font-grey-salsa"> Available balance </p>
                                            <p class="uppercase font-grey-salsa"> allow withdrawals </p>
                                            <p class="uppercase font-grey-salsa"> allow deposits </p>
                                            <p class="uppercase font-grey-salsa"> payment options </p>
                                            <p class="uppercase font-grey-salsa"> fee profile </p>
                                        </div>
                                        <div class="col-sm-8">
                                            <p><a class="font-blue-madison"> <?php echo $accountData['NAME'];?> </a></p>
                                            <p><a class="font-blue"> <?php echo $accountData['ACCOUNT_TYPE_DESC'];?> </a></p>
                                            <p > <?php echo $statusData['DESCRIPTION'];?> </p>
                                            <p > <?php echo $currencyType[0]['TITLE'];?></p>
                                            <p > <?php echo number_format($accountData['CURRENT_AMOUNT'], 2, ".", ",");?> </p>
                                            <p > <?php echo number_format($accountData['AVAILABLE_AMOUNT'],2, ".", ",");?> </p>
                                            <p > <?php
                                                if(intval($accountData['ALLOW_WITHDRAW']) == 1) {
                                                    echo 'YES';
                                                }
                                                else
                                                {
                                                    echo 'NO';
                                                } ?> </p>
                                            <p > <?php
                                                if(intval($accountData['ALLOW_DEPOSIT']) == 1) {
                                                    echo 'YES';
                                                }
                                                else
                                                {
                                                    echo 'NO';
                                                } ?>
                                            <p > <?php echo ($paymentOption['DESCRIPTION']);?> </p>
                                            <p > <a href="<?php echo base_url();?>admin/profile/update_fee/<?php echo $accountData['FEE_TYPE_INDEX'];?>" class="btn btn-link"> <?php echo ($accountData['FEE_TYPE']);?> </a> </p>
                                        </div>
<!--                                    </div>-->
<!--                                </div>-->
                                <!-- END PERSONAL INFO TAB -->

                                <!-- CHANGE PASSWORD TAB -->
<!--                                <div class="tab-pane" id="tab_1_2">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-md-12">-->
<!---->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <!-- END CHANGE PASSWORD TAB -->
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
</body>

</html>