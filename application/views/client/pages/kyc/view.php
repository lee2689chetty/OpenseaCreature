<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

</head>

<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">


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

            <?php if(intval($kycData['VERIFY_UPDATE_DATE']) > 0):?>
                <div class="alert alert-warning">
                    <span> <i class="fa fa-spin"></i> We're checking the document you uploaded on 2018-09-08. It will take 2~3 business days. Thanks for your cooperation.</a></span>
                </div>
            <?php endif;?>

            <?php if($kycData['IDENTIFY_APPROVE'] == '1'):?>
                <div class="alert alert-success">
                    <span> <i class="fa fa-spin"></i> Your identify is verified. </a></span>
                </div>
            <?php endif;?>

            <?php if($kycData['ADDRESS_APPROVE'] == '1'):?>
                <div class="alert alert-success">
                    <span> <i class="fa fa-spin"></i> Your address is verified. </a></span>
                </div>
            <?php endif;?>

            <div class="portlet  box yellow-gold">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon icon-cloud-upload"></i>
                        Upload Verification Document
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <div class="form">
                        <form id="formSubmit" class="form-horizontal form-bordered" action="<?php echo base_url();?>kyc/upload/<?php echo $kycData['TICKET_NUMBER'];?>" method="post" enctype="multipart/form-data">
                       <div class="form-body">
                           <div class="form-group">
                               <label class="col-sm-2 control-label"> Name <span class="font-red"> * </span></label>
                               <div class="col-sm-5">
                                   <input type="text" autocomplete="disabled" required <?php if($kycData['IDENTIFY_APPROVE'] == '1') {echo 'disabled';}?> class="form-control" placeholder="First Name" id="userFName" name="userFName" value="<?php print_r($kycData['USER_FNAME']);?>">
                               </div>
                               <div class="col-sm-5">
                                   <input type="text" autocomplete="disabled" required <?php if($kycData['IDENTIFY_APPROVE'] == '1') {echo 'disabled';}?> class="form-control" placeholder="Last Name" id="userLName" name="userLName" value="<?php print_r($kycData['USER_LNAME']);?>">
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label"> Date of Birth <span class="font-red"> * </span></label>
                               <div class="col-sm-10">
                                   <input class="form-control" autocomplete="disabled" <?php if($kycData['IDENTIFY_APPROVE'] == '1') {echo 'disabled';}?> id="dob" required name="dob" type="text" value="<?php print_r($kycData['USER_DOB']);?>"/>
                                   <span class="help-block"> Input your date of birth </span>
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label"> Identify Number <span class="font-red"> * </span></label>
                               <div class="col-sm-10">
                                   <input type="text" value="<?php echo $kycData['USER_ID_NUMBER'];?>" autocomplete="disabled" <?php if($kycData['IDENTIFY_APPROVE'] == '1') {echo 'disabled';}?> class="form-control" required placeholder="Passport Number, ID Card Number" id="userIdNumber" name="userIdNumber">
                               </div>
                           </div>

                           <?php if($kycData['IDENTIFY_APPROVE'] != '1'):?>
                               <div class="form-group">
                                   <label class="col-sm-2 control-label"> Proof of Identify Number <span class="font-red"> * </span></label>
                                   <div class="col-sm-10">
                                       <div class="fileinput fileinput-new" data-provides="fileinput">
                                           <div class="fileinput-new thumbnail" style="width: 350px; height: 250px;">

                                               <?php if($kycData['USER_ID_APPROVE_PATH'] == ""):?>
                                                    <img src="<?php echo base_url();?>assets/pages/img/passport-placeholder.jpg" alt="" /> </div>
                                               <?php else:?>
                                                   <img src="<?php echo base_url().$kycData['USER_ID_APPROVE_PATH'];?>" alt="" /> </div>
                                               <?php endif;?>

                                           <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 350px; max-height: 250px;"> </div>
                                           <div>
                                                                <span class="btn default btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="file" name="passimg" required> </span>
                                               <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                           </div>
                                       </div>
                                       <div class="clearfix margin-top-10">
                                           <span class="label label-danger">NOTE!</span><br><br>
                                           1. Government-issued ID card(or Passport & Driver's License)
                                           holding in your hand and revealing your face<br>
                                           2. Support JPG, JEPG, PNG, BMP, GIF format<br>
                                           3. Picture size less than 5M<br>
                                       </div>

                                   </div>
                               </div>
                           <?php endif;?>

                           <div class="form-group">
                               <label class="col-sm-2 control-label"> Address <span class="font-red"> * </span></label>
                               <div class="col-sm-10">
                                   <input  value="<?php echo $kycData['USER_ADDR'];?>" type="text" <?php if($kycData['ADDRESS_APPROVE'] == '1') {echo 'disabled';}?> required class="form-control" placeholder="Your current address" id="userAddress" name="userAddress">
                               </div>
                           </div>

                           <div class="form-group">
                               <label class="col-sm-2 control-label"> Proof of address <span class="font-red"> * </span></label>
                               <div class="col-sm-10">
                                   <select required class="bs-select form-control" name="addressProofType" id="addressProofType" <?php if($kycData['ADDRESS_APPROVE'] == '1') {echo 'disabled';}?>>
                                       <option value="Utility Bills" <?php if($kycData['ADDR_DOC_KIND'] == 'Utility Bills') {echo 'selected';}?>> Utility Bills </option>
                                       <option value="Tax paper" <?php if($kycData['ADDR_DOC_KIND'] == 'Tax paper') {echo 'selected';}?>> Tax paper </option>
                                       <option value="ID Card" <?php if($kycData['ADDR_DOC_KIND'] == 'ID Card') {echo 'selected';}?>> ID Card </option>
                                   </select>
                               </div>
                           </div>

                           <?php if($kycData['ADDRESS_APPROVE'] != '1'):?>
                               <div class="form-group">
                                   <label class="col-sm-2 control-label">  </label>
                                   <div class="col-sm-10">
                                       <div class="fileinput fileinput-new" data-provides="fileinput">
                                           <div class="fileinput-new thumbnail" style="width: 350px; height: 250px;">
                                               <?php if($kycData['ADDR_DOC_KIND'] == ""):?>
                                                    <img src="<?php echo base_url();?>assets/pages/img/Idcard-placeholder.jpg" alt="" /> </div>
                                               <?php else:?>
                                                    <img src="<?php echo base_url().$kycData['USER_ID_APPROVE_PATH'];?>" alt="" /> </div>
                                               <?php endif;?>
                                           <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 350px; max-height: 200px;"> </div>
                                           <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input required type="file" name="billimg">
                                                </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                           </div>
                                       </div>
                                       <div class="clearfix margin-top-10">
                                           <span class="label label-danger">NOTE!</span> Document shows your address completely and only accept the document that is issued 6 months ago.
                                       </div>
                                   </div>
                               </div>
                           <?php endif;?>
                       </div>

                       <div class="form-actions">
                           <button type="submit" style="width: 150px;" class="col-sm-offset-1 btn btn yellow-gold"> Submit </button>
                       </div>
                   </form>
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