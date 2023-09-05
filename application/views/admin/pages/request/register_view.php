<?php echo $header;?>
<link href="../../assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="../../assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
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
            <!-- BEGIN PAGE BASE CONTENT -->
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Registration Requests
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <!-- CHANGE PASSWORD TAB -->


                                        <form class="form-horizontal bg-grey" method="post" action="#">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-12 col-md-5 form-group" style="margin-left: 0px;">
                                                        <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                                        <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                            <input type="text" class="form-control" name="fromVirtualAccountDate" id="fromVirtualAccountDate">
                                                            <span class="input-group-addon"> to </span>
                                                            <input type="text" class="form-control" name="toVirtualAccountDate" id="toVirtualAccountDate">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2 form-actions">
                                                        <input type="submit" class="btn yellow-gold" style="margin-top: 25px;" value="Generate">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row" style="margin-top: 90px;">
                                            <div class="col-sm-12">
                                                <table class="table table-striped table-bordered table-hover" id="tbAllRegisterList">
                                                    <thead>
                                                    <tr>
                                                        <th> Id </th>
                                                        <th> Date </th>
                                                        <th> Account Name </th>
                                                        <th> Email </th>
                                                        <th> Status </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!--                                                        --><?php //for($i = 0 ; $i < 4; $i+=2){?>
                                                    <!--                                                            <tr class="input-large">-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> 2017-12-07 </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> zT04689 </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> --><?php //echo ($i + 800);?><!-- </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> Outgoing transaction </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-red"> -2100 </p> </span> </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> 201283 </td>-->
                                                    <!--                                                            </tr>-->
                                                    <!--                                                            <tr class="input-large">-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> 2017-12-08 </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> zT04689 </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> --><?php //echo ($i + 800);?><!-- </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> Outgoing transaction </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> <span> <p class="font-green"> 2100 </p> </span> </td>-->
                                                    <!--                                                                <td style="padding-top: 35px; padding-bottom: 35px;"> 201283 </td>-->
                                                    <!--                                                            </tr>-->
                                                    <!--                                                        --><?php //}?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                            <!-- END CHANGE PASSWORD TAB -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<?php echo $footer;?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/admin_register_request_view.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>