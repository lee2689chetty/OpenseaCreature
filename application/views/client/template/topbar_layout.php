
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="index.html">
                <img src="<?php echo base_url();?>assets/layouts/img/logo-light.png" alt="logo" style="display: block;" class="logo-default" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu pull-right">

            <ul class="nav navbar-nav pull-right">
                <li class="separator hide"> </li>

                <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <?php
                        $countNotification = count($topBarData);
                        if($countNotification > 0) {?>
                            <span class="badge badge-success"> <?php echo count($topBarData);?> </span>
                        <?php }?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>
                            <span class="bold"><?php echo $countNotification;?> unread</span> notifications</h3>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 280px;" data-handle-color="#637283">
                                <?php foreach ($topBarData as $topBarDataItem) {
                                    if(intval($topBarDataItem['REASON_TYPE']) == NOTIFY_NEW_ACCOUNT_CREATE) {
                                        //account creation
                                        ?>
                                        <li>
                                            <a href="<?php echo base_url();?>account/view">
                                                <span class="time"><?php echo date('Y-m-d', $topBarDataItem['CREATED_AT']);?></span>
                                                <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-user-plus"></i>
                                                        </span> New account created. </span>
                                            </a>
                                        </li>
                                <?php
                                    }
                                    else if(intval($topBarDataItem['REASON_TYPE']) == NOTIFY_NEW_MESSAGE_RECEIVED) { ?>
                                        <li>
                                            <a href="<?php echo base_url();?>message/view">
                                                <span class="time"><?php echo date('Y-m-d', $topBarDataItem['CREATED_AT']);?></span>
                                                <span class="details">
                                                                <span class="label label-sm label-icon label-warning">
                                                                    <i class="fa fa-envelope"></i>
                                                                </span> New message received. </span>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    else if(intval($topBarDataItem['REASON_TYPE']) == NOTIFY_VERIFY_REQUESTED) {?>

                                        <li>
                                            <a href="<?php echo base_url();?>/profile/me">
                                                <span class="time"><?php echo date('Y-m-d', $topBarDataItem['CREATED_AT']);?></span>
                                                <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-check"></i>
                                                        </span> KYC action is required. </span>
                                            </a>
                                        </li>

                                    <?php
                                    }
                                    else if(intval($topBarDataItem['REASON_TYPE']) == NOTIFY_NEW_TRANS_CREATE) { ?>
                                        <li>
                                            <a href="<?php echo base_url();?>request/status/<?php echo $topBarDataItem['LINK_ID'];?>">
                                                <span class="time"><?php echo date('Y-m-d', $topBarDataItem['CREATED_AT']);?></span>
                                                <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-dollar"></i>
                                                        </span>

                                                            <?php
                                                                if(intval($topBarDataItem['CONTENT']) == Transfer_Between_Accounts){
                                                                    echo 'Transfer Between Accounts';
                                                                }
                                                                else if(intval($topBarDataItem['CONTENT']) == Transfer_Between_Users) {
                                                                    echo 'Transfer Between Users';
                                                                }
                                                                else if(intval($topBarDataItem['CONTENT']) == Outgoing_Wire_Transfer) {
                                                                    echo 'Outgoing Wire Transfer';
                                                                }
                                                                else if(intval($topBarDataItem['CONTENT']) == Card_Funding_Transfer) {
                                                                    echo 'Card Funding Transfer';
                                                                }
                                                                else if(intval($topBarDataItem['CONTENT']) == Incoming_Wire_Transfer) {
                                                                    echo 'Incoming Wire Transfer';
                                                                }
                                                                else if(intval($topBarDataItem['CONTENT']) == Account_Debit_Transfer) {
                                                                    echo 'Account Debit Transfer';
                                                                }
                                                                else if(intval($topBarDataItem['CONTENT']) == Account_Credit_Transfer) {
                                                                    echo 'Account Credit Transfer';
                                                                }
                                                            ?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="separator hide"> </li>

                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?php echo base_url();?>assets/layouts/img/avatar.png" />
                        <span class="username username-hide-on-mobile"> <?php print_r($adminDataName);?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?php echo base_url();?>profile/me">
                                <i class="icon-user"></i> Profile </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>profile/setting">
                                <i class="icon-settings"></i> Settings </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>auth/logout">
                                <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>


<!-- END HEADER -->