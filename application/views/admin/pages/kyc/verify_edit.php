<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

</head>

<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<?php echo $topbar;?>
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>

<div class="page-container">

    <?php echo $sidebar;?>

    <div class="page-content-wrapper">

        <div class="page-content">
            <div class="clearfix"></div>
            <div class="col-sm-12">
                <div class="portlet box yellow-gold">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon icon-cloud-upload"></i>
                            Identify Information Documents From <?php echo $kycData['USER_DATA']['FULL_NAME'];?>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form">
                           <form class="form-horizontal form-bordered" method="post" action="#" enctype="application/x-www-form-urlencoded">
                               <div class="form-body">
                                   <div class="form-group">
                                       <label class="col-sm-2 control-label"> Name <span class="font-red"> * </span></label>
                                       <div class="col-sm-4">
                                           <input type="text" disabled class="form-control" placeholder="First Name" id="userFName" name="userLName" value="<?php echo $kycData['USER_FNAME'];?>">
                                       </div>

                                       <div class="col-sm-4">
                                           <input type="text" disabled class="form-control" placeholder="Last Name" id="userLName" name="userLName" value="<?php echo $kycData['USER_LNAME'];?>">
                                       </div>
                                   </div>

                                   <div class="form-group">
                                       <label class="col-sm-2 control-label"> Date of Birth <span class="font-red"> * </span></label>
                                       <div class="col-sm-8">
                                           <input class="form-control" disabled placeholder="mm/dd/yyyy" id="dob" name="dob" type="text" value="<?php echo $kycData['USER_DOB'];?>"/>
                                       </div>
                                   </div>

                                   <div class="form-group">
                                       <label class="col-sm-2 control-label"> Identify Number <span class="font-red"> * </span></label>
                                       <div class="col-sm-8">
                                           <input type="text" disabled class="form-control" placeholder="Passport Number, ID Card Number" value="<?php echo $kycData['USER_ID_NUMBER'];?>" id="userIdNumber" name="userIdNumber">
                                       </div>
                                   </div>

                                   <div class="form-group">
                                       <label class="col-sm-2 control-label"> Proof of Identify Number <span class="font-red"> * </span></label>
                                       <div class="col-sm-8">
                                           <?php if($kycData['USER_ID_APPROVE_PATH'] == ''):?>
                                               <img src="<?php echo base_url();?>assets/pages/img/passport-placeholder.jpg" alt="" style="width: 450px;"/>
                                           <?php else:?>
                                               <img src="<?php echo base_url().$kycData['USER_ID_APPROVE_PATH'];?>" alt="" style="width: 450px;"/>
                                           <?php endif;?>
                                       </div>
                                       <div class="col-sm-2">
                                           <a href="<?php echo base_url()?>admin/kyc/download_file?TICKET_NUMBER=<?php echo $kycData['TICKET_NUMBER'];?>&KIND=0" class="btn btn-success"> Download </a>
                                       </div>
                                   </div>

                                    <div class="form-actions">
                                        <?php if($kycData['IDENTIFY_APPROVE'] == '0'):?>
                                           <a href="<?php echo base_url();?>admin/kyc/identify_approve/<?php echo $kycData['TICKET_NUMBER'];?>" style="width: 150px;" class="col-sm-offset-1 btn btn yellow-gold"> Approve </a>
                                           <a href="<?php echo base_url();?>admin/kyc/identify_deny/<?php echo $kycData['TICKET_NUMBER'];?>" style="width: 150px;" class="col-sm-offset-1 btn btn-danger"> Deny </a>
                                        <?php endif;?>
                                    </div>
                               </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="portlet  box yellow-gold margin-top-30">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon icon-cloud-upload"></i>
                            Address Information Documents From <?php echo $kycData['USER_DATA']['FULL_NAME'];?>
                        </div>
                        <div class="tools"> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form">
                            <form class="form-horizontal form-bordered">

                            <div class="form-body">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"> Address <span class="font-red"> * </span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $kycData['USER_ADDR'];?>" disabled placeholder="User current address" id="userAddress" name="userAddress">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"> Proof of address <span class="font-red"> * </span></label>
                                    <div class="col-sm-8">
                                        <input type="text" placeholder="Uploaded Document Type" class="form-control form-control-static" disabled value="<?php echo $kycData['ADDR_DOC_KIND'];?>" name="addressProofType" id="addressProofType">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">  </label>
                                    <div class="col-sm-8">
                                        <?php if($kycData['ADDR_APPROVE_DOC'] == ''):?>
                                            <img src="<?php echo base_url();?>assets/pages/img/Idcard-placeholder.jpg" alt="" style="width: 450px;"/>
                                        <?php else:?>
                                            <img src="<?php echo base_url().$kycData['ADDR_APPROVE_DOC'];?>" alt="" style="width: 450px;"/>
                                        <?php endif;?>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php if($kycData['ADDR_APPROVE_DOC'] != ''):?>
                                            <a href="<?php echo base_url()?>admin/kyc/download_file?TICKET_NUMBER=<?php echo $kycData['TICKET_NUMBER'];?>&KIND=1" class="btn btn-success"> Download </a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>


                            <div class="form-actions">
                                <?php if($kycData['ADDRESS_APPROVE'] == '0'):?>
                                    <a href="<?php echo base_url();?>admin/kyc/address_approve/<?php echo $kycData['TICKET_NUMBER'];?>" style="width: 150px;" class="col-sm-offset-1 btn btn yellow-gold"> Approve </a>
                                    <a href="<?php echo base_url();?>admin/kyc/address_deny/<?php echo $kycData['TICKET_NUMBER'];?>" style="width: 150px;" class="col-sm-offset-1 btn btn-danger"> Deny </a>
                                <?php endif;?>
                            </div>
                        </form>
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
<!--<script src="../assets/pages/scripts/account_view.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/client_kyc_upload.js" type="text/javascript"></script>
</body>

</html>