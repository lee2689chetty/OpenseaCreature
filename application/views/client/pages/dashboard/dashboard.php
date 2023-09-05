<?php echo $header;?>
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">

<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo $countTotalAccount;?>">0</span>
                            </div>
                            <div class="desc"> Total Accounts </div>
                        </div>
                        <a class="more" href="<?php echo base_url();?>account/view"> View more
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="fa fa-newspaper-o"></i>
                        </div>

                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo $countRecentMessages;?>">0</span> </div>
                            <div class="desc"> New Messages </div>
                        </div>

                        <a class="more" href="<?php echo base_url();?>message/view"> View more
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-tasks"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo $countPendingTrans;?>">0</span>
                            </div>
                            <div class="desc"> Requsted Transactions </div>
                        </div>
                        <a class="more" href="<?php echo base_url();?>report/view#tab_all_account"> View more
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="portlet light bordered bg-inverse">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-blue"></i>
                                <span class="caption-subject font-blue bold uppercase">Recent Activities</span>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="reload" data-load="true" data-url="<?php echo base_url();?>dash/recent/<?php echo time();?>"></a>
                            </div>
                        </div>
                        <div class="portlet-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php echo $footer;?>
</body>
</html>