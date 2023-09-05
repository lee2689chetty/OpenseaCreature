<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
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
                                All Transaction Report
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row" id="containerSpeficAllTrans" >

                                <div class="col-sm-12">

                                    <div class="form-horizontal bg-grey margin-top-20">
                                        <div class="col-sm-12 col-md-4 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;">User Name</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2 select2-allow-clear" id="allUserID">
                                                    <option value="" data-anumber="All User" data-currency="" data-amount="">  </option>
                                                    <?php foreach ($userList as $accountItem):?>
                                                        <option value="<?php echo $accountItem['ID'];?>" data-anumber="<?php echo $accountItem['NAME'];?>" data-currency = "<?php echo $accountItem['FULL_NAME'];?>" data-amount = ""> <?php echo $accountItem['FULL_NAME'];?> </option>");
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 form-group">
                                            <label class="col-sm-12 control-label" style="text-align: left;">Filter</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="allUserFilter">
                                                    <option value="0"> All </option>
                                                    <option value="1"> Completed </option>
                                                    <option value="2"> Pending </option>
                                                    <option value="3"> Cancelled </option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                            <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" name="fromAllDate" id="fromAllDate">
                                                <span class="input-group-addon"> to </span>
                                                <input type="text" class="form-control" name="toAllDate" id="toAllDate">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1 form-group">
                                            <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btSpeicifedAllGenerate"> Generate </button>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="row" style="margin-top: 90px;">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered table-hover" id="tbSpecificAllReport">
                                                <thead>
                                                <tr>
                                                    <th> Date </th>
                                                    <th> Account # </th>
                                                    <th> Parent #</th>
                                                    <th> ID </th>
                                                    <th> Trans.Type </th>
                                                    <th> Description </th>
                                                    <th> Currency </th>
                                                    <th> Debit/Credit </th>
                                                </tr>
                                                </thead>
                                                <tbody>

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
    </div>
</div>
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_report_specified_alltrans.js" type="text/javascript"></script>
>
</body>
</html>