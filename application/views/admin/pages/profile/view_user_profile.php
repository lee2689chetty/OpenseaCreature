<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

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
            <!-- BEGIN PAGE BASE CONTENT -->
            <!-- BEGIN DASHBOARD STATS 1-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <div class="caption font-yellow-gold">
                                User Profiles
                            </div>
                            <div class="actions">
                                <a href="../profile/user_create" class="btn yellow-gold"> Create New User </a>
                            </div>

                        </div>
                        <div class="portlet-body">
                                <!-- Begin View User Profile-->
                                    <form class="form-horizontal bg-grey" method="post" action="<?php echo base_url();?>admin/profile/user_view">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6 col-md-2 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Select User </label>
                                                    <div class="col-sm-12">
                                                        <select class="bs-select form-control" name="userId">
                                                            <option value="0"
                                                                <?php if(!array_key_exists('b.ID', $whereArray)):?>
                                                                        selected
                                                                <?php endif;?>> All Users </option>
                                                            <?php foreach ($userList as $userListItem){?>
                                                                <option value="<?php echo $userListItem['USER_ID'];?>" data-content = "<?php echo $userListItem['NAME'];?>"
                                                                <?php if(array_key_exists('b.ID', $whereArray)):?>
                                                                    <?php if ($whereArray['b.ID'] == $userListItem['USER_ID']):?>
                                                                        selected
                                                                    <?php endif;?>
                                                                <?php endif;?>> <?php echo $userListItem['NAME'];?> </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-3 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Select email </label>
                                                    <div class="col-sm-12">
                                                        <select class="bs-select form-control" name="email">
                                                            <option value="0"
                                                                <?php if(!array_key_exists('b.EMAIL', $whereArray)):?>
                                                                    selected
                                                                <?php endif;?>> All Emails</option>
                                                            <?php foreach ($userList as $userListItem){?>
                                                                <option value="<?php echo $userListItem['EMAIL'];?>" data-content = "<?php echo $userListItem['EMAIL'];?>"
                                                                <?php if(array_key_exists('b.EMAIL', $whereArray)):?>
                                                                    <?php if ($whereArray['b.EMAIL'] == $userListItem['EMAIL']):?>
                                                                        selected
                                                                    <?php endif;?>
                                                                <?php endif;?>> <?php echo $userListItem['EMAIL'];?> </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-2 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> All Status </label>
                                                    <div class="col-sm-12">
                                                        <select class="bs-select form-control" name="status">
                                                            <option value="0"
                                                                <?php if(!array_key_exists('b.STATUS', $whereArray)):?>
                                                                    selected
                                                                <?php endif;?>> All Status </option>
                                                            <?php foreach ($statusList as $statusListItem){?>
                                                                <option value="<?php echo $statusListItem['ID'];?>" data-content = "<?php echo $statusListItem['DESCRIPTION'];?>"
                                                                    <?php if(array_key_exists('b.STATUS', $whereArray)):?>
                                                                        <?php if ($whereArray['b.STATUS'] == $statusListItem['ID']):?>
                                                                            selected
                                                                        <?php endif;?>
                                                                    <?php endif;?>> <?php echo $statusListItem['DESCRIPTION'];?> </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                                                    <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                                        <input type="text" class="form-control" name="from">
                                                        <span class="input-group-addon"> to </span>
                                                        <input type="text" class="form-control" name="to">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-1 form-group" style="margin-top: 25px;">
                                                    <button type="submit" class="btn yellow-gold uppercase margin-right-10"> filter </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                    <div class="row" style="margin-top: 90px;">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-hover" id="tbContent">
                                                <thead>
                                                <tr>
                                                    <th class="font-yellow-gold"> UserName </th>
                                                    <th class="font-yellow-gold"> E-Mail </th>
                                                    <th class="font-yellow-gold"> Company </th>
                                                    <th class="font-yellow-gold"> First Name </th>
                                                    <th class="font-grey-salsa"> Last Name </th>
                                                    <th class="font-yellow-gold"> ID Card </th>
                                                    <th class="font-yellow-gold"> Creation Date </th>
                                                    <th class="font-grey-salsa"> Status </th>
                                                    <th class="font-grey-salsa">  </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($userDispArray as $userListItem){?>
                                                    <tr class="input-large">
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['NAME'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['EMAIL'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php
                                                            if($userListItem['PROFILE_KIND'] == 2)
                                                                echo $userListItem['COMPANY_NAME'];
                                                            ?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['FIRST_NAME'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['LAST_NAME'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;">
                                                            <?php
                                                                if($userListItem['ID_CARD'] != ""){
                                                                    echo "<a class=\"btn default green-stripe\" href=\"".base_url().$userListItem['ID_CARD']."\"> View </a>";
                                                                }?>
                                                        </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d H:m:s', $userListItem['CREATED_AT']);?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $userListItem['STATUS_DESCRIPTION'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;">
                                                            <a href="./detail/<?php echo $userListItem['ID'];?>" class="btn default red-stripe"> Settings </a>
                                                            <a href="./edit/<?php echo $userListItem['ID'];?>" class="btn default blue-stripe"> Edit </a>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <!-- End View User Profile-->
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
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_profile_view.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>