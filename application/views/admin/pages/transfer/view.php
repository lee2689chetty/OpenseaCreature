<?php echo $header;?>
<link href="<?php echo base_url();?>assets/pages/css/about.css" rel="stylesheet" type="text/css">

<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white">


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
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet box yellow-gold">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-exchange"></i>
                                Transfer Types
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel col-sm-6 col-md-4 margin-right-10" style="border-radius: 5px; border-width:1px; border-color: #f1ecec;">
                                        <a href="../transfer/baccounts">
                                            <span>
                                                <div class="panel-body" style="height:  280px;">
                                                    <div class="card-icon">
                                                        <i class="icon-user font-yellow-gold theme-font"></i>
                                                    </div>
                                                    <div class="card-desc">
                                                        <label class="lead bold"> Transfer between Accounts </label>
                                                    </div>
                                                </div>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="panel col-sm-6 col-md-4 margin-right-10" style="border-radius: 5px; border-width:1px; border-color: #f1ecec;">
                                        <a href="../transfer/busers">
                                            <span>
                                                <div class="panel-body" style="height:  280px;">
                                                    <div class="card-icon">
                                                        <i class="icon-users font-green-meadow theme-font" style="border: 1px solid #1BBC9B!important;"></i>
                                                    </div>
                                                    <div class="card-desc">
                                                        <label class="lead bold"> Transfer between Users </label>
                                                    </div>
                                                </div>
                                            </span>
                                        </a>
                                    </div>

                                    <div class="panel col-sm-6 col-md-4 margin-right-10" style="border-radius: 5px; border-width:1px; border-color: #f1ecec;">
                                        <a href="../transfer/outgoing">
                                            <span>
                                                <div class="panel-body" style="height:  280px;">
                                                    <div class="card-icon">
                                                        <i class="icon-trophy font-red-flamingo theme-font" style="border: 1px solid #EF4836!important;"></i>
                                                    </div>
                                                    <div class="card-desc">
                                                        <label class="lead bold"> Outgoing Wire Transfer </label>
                                                    </div>
                                                </div>
                                            </span>
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- END DASHBOARD STATS 1-->
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>