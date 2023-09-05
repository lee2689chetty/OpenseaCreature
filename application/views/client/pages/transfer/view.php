<?php echo $header;?>
<link href="../assets/pages/css/about.css" rel="stylesheet" type="text/css">
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
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
                                        <a href="<?php echo base_url();?>transfer/accounts">
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
                                        <a href="<?php echo base_url();?>transfer/users">
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
                                        <a href="<?php echo base_url();?>transfer/outgoing">
                                            <span>
                                                <div class="panel-body" style="height:  280px;">
                                                    <div class="card-icon">
                                                        <i class="icon-trophy font-red-flamingo theme-font" style="border: 1px solid #EF4836!important;"></i>
                                                    </div>
                                                    <div class="card-desc">
                                                        <label class="lead bold"> Outgoing Transfer </label>
                                                    </div>
                                                </div>
                                            </span>
                                        </a>

                                    </div>

                                    <div class="panel col-sm-6 col-md-4 margin-right-10" style="border-radius: 5px; border-width:1px; border-color: #f1ecec;">
                                        <a href="<?php echo base_url();?>transfer/cards">
                                            <span>
                                                <div class="panel-body" style="height:  280px;">
                                                    <div class="card-icon">
                                                        <i class="icon-credit-card font-blue-madison theme-font" style="border: 1px solid #578ebe!important;"></i>
                                                    </div>
                                                    <div class="card-desc">
                                                        <label class="lead bold"> Card Funding Transfer </label>
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
        </div>
    </div>
</div>
<?php echo $footer;?>
</body>

</html>