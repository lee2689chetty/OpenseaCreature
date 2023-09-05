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
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">


<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Virtual Accounts
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>admin/account/new_account" class="btn yellow-gold"> Create new Account </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal bg-grey" method="post" action="<?php echo base_url();?>admin/account/bank_view">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12 col-md-4 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Account Owner </label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control select2" name="accountOwner" id="accountOwner">
                                                            <option value="0" <?php if(!array_key_exists('a.USER_ID', $whereArray)):?>
                                                                selected
                                                            <?php endif;?>> Choose Account Owners </option>
                                                            <?php foreach ($accountOwners as $accountOwnerItem):?>
                                                                <option value="<?php echo $accountOwnerItem['ID'];?>"
                                                                    <?php if(array_key_exists('a.USER_ID', $whereArray)):?>
                                                                        <?php if($whereArray['a.USER_ID'] == $accountOwnerItem['ID']):?>
                                                                            selected
                                                                        <?php endif;?>
                                                                    <?php endif;?>> <?php echo $accountOwnerItem['NAME'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-3 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Account Number </label>
                                                    <div class="col-sm-12">
                                                        <select class="bs-select form-control" name="accountId" id="accountId">
                                                            <option value="0"
                                                                <?php if(!array_key_exists('a.ID', $whereArray)):?>
                                                                        selected
                                                                <?php endif;?>> Choose Account number </option>

                                                            <?php foreach ($accountNumberList as $accountNumberItem):?>
                                                                <option value="<?php echo $accountNumberItem['ID'];?>"
                                                                    <?php if(array_key_exists('a.ID', $whereArray)):?>
                                                                        <?php if($whereArray['a.ID'] == $accountNumberItem['ID']):?>
                                                                            selected
                                                                        <?php endif;?>
                                                                    <?php endif;?>> <?php echo $accountNumberItem['ACCOUNT_NUMBER'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
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

                                                <div class="col-sm-12 col-md-1 form-actions">
                                                    <input type="submit" class="btn yellow-gold" style="margin-top: 25px;" value="Submit">
                                                </div>

                                                <div class="col-sm-12 col-md-4 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Types </label>
                                                    <div class="col-sm-12">
                                                        <select class="bs-select form-control" name="accountTypes">
                                                            <option value="0"
                                                                <?php if(!array_key_exists('a.ACCOUNT_TYPE', $whereArray)):?>
                                                                        selected
                                                                <?php endif;?>>All Types </option>
                                                            <?php foreach ($accountKind as $accountKindItem) {?>
                                                                <option value="<?php echo $accountKindItem['ID'];?>"
                                                                    <?php if(array_key_exists('a.ACCOUNT_TYPE', $whereArray)):?>
                                                                        <?php if($whereArray['a.ACCOUNT_TYPE'] == $accountKindItem['ID']):?>
                                                                            selected
                                                                        <?php endif;?>
                                                                    <?php endif;?>
                                                                > <?php echo $accountKindItem['DESCRIPTION'];?> </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-3 form-group">
                                                    <label class="col-sm-12 control-label" style="text-align: left;"> Status </label>
                                                    <div class="col-sm-12">
                                                        <select class="bs-select form-control" name="accountStatus">
                                                            <option value="0" <?php if(!array_key_exists('a.STATUS', $whereArray)):?>
                                                                    selected
                                                            <?php endif;?>> All Status </option>
                                                            <?php foreach ($accountStatus as $accountStatusItem) {?>
                                                                <option value="<?php echo $accountStatusItem['ID'];?>"
                                                                    <?php if(array_key_exists('a.STATUS', $whereArray)):?>
                                                                        <?php if($whereArray['a.STATUS'] == $accountStatusItem['ID']):?>
                                                                            selected
                                                                        <?php endif;?>
                                                                    <?php endif;?>
                                                                > <?php echo $accountStatusItem['DESCRIPTION'];?> </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </form>
                            <div class="row" style="margin-top: 80px;">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover" id="tbContent">
                                                <thead>
                                                    <tr>
                                                        <th class="font-yellow-gold"> Creation Date </th>
                                                        <th class="font-yellow-gold"> Account Owner </th>
                                                        <th class="font-yellow-gold"> Account # </th>
                                                        <th class="font-yellow-gold"> Account Type </th>
                                                        <th class="font-yellow-gold"> Currency </th>
                                                        <th class="font-grey-salsa"> Available </th>
                                                        <th class="font-grey-salsa"> Running </th>
                                                        <th class="font-yellow-gold"> Status </th>
                                                        <th class="font-grey-salsa"> Actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($accountList as $accountListItem){?>
                                                    <tr class="input-large">
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo date('Y-m-d H:m:s', $accountListItem['CREATED_AT']);?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['NAME'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['ACCOUNT_NUMBER'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['ACCOUNT_TYPE_DESC'];?></td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['CURRENCY_TITLE'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo number_format($accountListItem['AVAILABLE_AMOUNT'], 2, '.', ',');?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo number_format($accountListItem['CURRENT_AMOUNT'], 2, '.', ',');?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;"> <?php echo $accountListItem['STATUS_DESCRIPTION'];?> </td>
                                                        <td style="padding-top: 15px; padding-bottom: 15px;">
                                                            <a href="<?php echo base_url();?>admin/account/detail/<?php echo $accountListItem['ID'];?>" class="btn default red-stripe"> View </a>
                                                            <a href="<?php echo base_url();?>admin/account/edit/<?php echo $accountListItem['ID'];?>" class="btn default yellow-gold-stripe"> Edit </a>
                                                            <a href="./debit/<?php echo $accountListItem['ID'];?>" class="btn default green-stripe"> Debit </a>
                                                            <a href="./credit/<?php echo $accountListItem['ID'];?>" class="btn default blue-stripe"> Credit </a>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                                </tbody>
                                            </table>
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
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_account_view.js" type="text/javascript"></script>
</body>
</html>