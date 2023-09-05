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
                                Transfer Requests
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">

                                <form class="form-horizontal bg-grey" method="post" action="<?php echo base_url();?>admin/request/transfer_view" role="form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="col-sm-6 col-md-2 form-group">
                                                <label class="col-sm-12 control-label" style="text-align: left;"> Request ID </label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" placeholder="Request ID" name="requestId"
                                                           value="<?php
                                                           if(array_key_exists('a.ID', $whereArray))
                                                           {
                                                               echo $whereArray['a.ID'];
                                                           }
                                                           ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                                <div class="col-sm-12">
                                                    <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                                        <input type="text" class="form-control" name="fromVirtualAccountDate" id="fromVirtualAccountDate"
                                                               value="<?php
                                                               if(array_key_exists('a.CREATED_AT >=', $whereArray))
                                                               {
                                                                   echo   date('Y-m-d', $whereArray['a.CREATED_AT >=']);
                                                               }
                                                               ?>">
                                                        <span class="input-group-addon"> to </span>
                                                        <input type="text" class="form-control" name="toVirtualAccountDate" id="toVirtualAccountDate"
                                                               value="<?php
                                                               if(array_key_exists('a.CREATED_AT <=', $whereArray))
                                                               {
                                                                   echo date('Y-m-d', $whereArray['a.CREATED_AT <=']);
                                                               }
                                                               ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3 form-group">
                                                <label class="col-sm-12 control-label" style="text-align: left;"> Types </label>
                                                <div class="col-sm-12">
                                                    <select class="bs-select form-control" name="transferKind" id="transferKind">
                                                        <!--                                                        <option value="0"-->
                                                        <!--                                                        -->
                                                        <?php if(!array_key_exists('a.TRANSACTION_TYPE', $whereArray)){
                                                            $whereArray['a.TRANSACTION_TYPE'] = 1;
                                                        }?>
                                                        <!--All Types </option>-->
                                                        <?php foreach ($transferKind as $transferKindItem) {?>
                                                            <option value="<?php echo $transferKindItem['ID'];?>"
                                                                <?php if(array_key_exists('a.TRANSACTION_TYPE', $whereArray)):?>
                                                                    <?php if($whereArray['a.TRANSACTION_TYPE'] == $transferKindItem['ID']):?>
                                                                        selected
                                                                    <?php endif;?>
                                                                <?php endif;?>
                                                            > <?php echo $transferKindItem['DESCRIPTION'];?> </option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2 form-group">
                                                <label class="col-sm-12 control-label" style="text-align: left;"> Status </label>
                                                <div class="col-sm-12">
                                                    <select class="bs-select form-control" name="transferStatus">
                                                        <option value="0"
                                                            <?php if(!array_key_exists('a.STATUS', $whereArray)):?>
                                                                selected
                                                            <?php endif;?>>All Status </option>
                                                        <?php foreach ($transferStatus as $transferStatusItem) {?>

                                                            <option value="<?php echo $transferStatusItem['ID'];?>"
                                                                <?php if(array_key_exists('a.STATUS', $whereArray)):?>
                                                                    <?php if($whereArray['a.STATUS'] == $transferStatusItem['ID']):?>
                                                                        selected
                                                                    <?php endif;?>
                                                                <?php endif;?>> <?php echo $transferStatusItem['DESCRIPTION'];?> </option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-1 form-group">
                                                <label class="col-sm-12 control-label" style="text-align: left;">  </label>
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn yellow-gold" style="margin-top: 15px;" value="Submit"> Submit </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>

                            <div class="row" style="margin-top: 90px;">
                                <div class="col-sm-12">
                                    <table class="table table-hover" id="tbContent">
                                        <thead>
                                            <tr>
                                                <th class="font-grey-salsa"> # </th>
                                                <th class="font-yellow-gold"> Id </th>
                                                <th class="font-grey-salsa"> Date </th>
                                                <th class="font-yellow-gold"> Name </th>
                                                <th class="font-yellow-gold"> Subject </th>
                                                <th class="font-yellow-gold"> Status </th>
                                                <th class="font-yellow-gold"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($transferHistory as $transferHistoryItem){?>
                                                <?php if($transferHistoryItem['STATUS'] == TRANSFER_SUSPENDED):?>
                                                    <tr class="input-large">
                                                        <td class=" font-red-flamingo"> <?php echo $i++;?></td>
                                                        <td class=" font-red-flamingo"> <?php echo $transferHistoryItem['ID'];?></td>
                                                        <td class=" font-red-flamingo"> <?php echo date('Y-m-d H:m:s', $transferHistoryItem['CREATED_AT']);?> </td>
                                                        <td class=" font-red-flamingo"> <?php echo $transferHistoryItem['FULL_NAME'];?> </td>
                                                        <td class=" font-red-flamingo"> <?php echo $transferHistoryItem['SUBJECT'];?></td>
                                                        <td class=" font-red-flamingo"> <?php echo $transferHistoryItem['STATUS_TITLE'];?> </td>
                                                        <td class="">
                                                            <a href="./status/<?php echo $transferHistoryItem['ID'];?>" class="btn btn-circle btn-icon-only green-meadow"> <i class="fa fa-eye"></i> </a>
                                                            <a href="./transfer/<?php echo $transferHistoryItem['ID'];?>" class="btn btn-circle btn-icon-only yellow-gold"> <i class="fa fa-edit"></i> </a>
                                                        </td>
                                                    </tr>
                                                <?php else:?>
                                                    <tr class="input-large">
                                                        <td class=""> <?php echo $i++;?></td>
                                                        <td class=""> <?php echo $transferHistoryItem['ID'];?></td>
                                                        <td class=""> <?php echo date('Y-m-d H:m:s', $transferHistoryItem['CREATED_AT']);?> </td>
                                                        <td class=""> <?php echo $transferHistoryItem['FULL_NAME'];?> </td>
                                                        <td class=""> <?php echo $transferHistoryItem['SUBJECT'];?></td>
                                                        <td class=""> <?php echo $transferHistoryItem['STATUS_TITLE'];?> </td>
                                                        <td class="">
                                                            <a href="./status/<?php echo $transferHistoryItem['ID'];?>" class="btn btn-circle btn-icon-only green-meadow"> <i class="fa fa-eye"></i> </a>
                                                            <a href="./transfer/<?php echo $transferHistoryItem['ID'];?>" class="btn btn-circle btn-icon-only yellow-gold"> <i class="fa fa-edit"></i> </a>
                                                        </td>
                                                    </tr>
                                               <?php endif;?>
                                        <?php }?>
                                        </tbody>
                                    </table>
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
<script src="../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="../../assets/pages/scripts/admin_transfer_request_view.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>