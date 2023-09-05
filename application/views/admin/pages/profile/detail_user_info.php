<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-user font-yellow-gold"></i>User Name
                            </div>
                            <div class="actions">
                                <button type="button" onclick="{jQuery('#userNameForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <form role="form" id="userNameForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_name/<?php echo $userDetail['ID'];?>">
                                <div class="form-body row">
                                    <!--User Information-->
                                    <input type="hidden" name="userId" value="<?php echo $userDetail['USER_ID'];?>">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Profile Type <span class="required"> * </span></label>
                                        <div class="col-sm-10">
                                            <select class="bs-select form-control" id="profileType" name="profileType" required>
                                                <?php foreach ($profileList as $profileListItem){?>
                                                    <option value="<?php echo $profileListItem['ID'];?>" <?php if($userDetail['PROFILE_KIND'] == $profileListItem['ID']) echo 'selected';?>>
                                                        <?php echo $profileListItem['DESCRIPTION'];?>
                                                    </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group" id="divCompanyName">
                                        <label class="col-sm-2 control-label"> Company Name <span class="required"> * </span></label>
                                        <div class="col-sm-10">
                                            <input type="text" value="<?php echo $userDetail['COMPANY_NAME'];?>" id="companyName" class="form-control" placeholder="Company Name" name="companyName">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> First Name <span class="required"> * </span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="First Name" name="firstName" value="<?php echo $userDetail['FIRST_NAME'];?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Last Name <span class="required"> * </span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Last Name" name="lastName" required value="<?php echo $userDetail['LAST_NAME'];?>">
                                        </div>
                                    </div>

                                    <!--- Should not start with number.. only should start with alphabetic --->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> User Name <span class="required"> * </span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="User Name" name="userName" required value="<?php echo $userDetail['USER_NAME'];?>">
                                            <div class="help-block"> Spaces are allowed; punctation is not allowed except for periods, hyphens, apostrophes, and underscores. </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Status <span class="required"> * </span> </label>
                                        <div class="col-sm-10">
                                            <select class="bs-select form-control" name="statusList" id="statusList" required>
                                                <?php foreach ($statusList as $statusListItem){?>
                                                    <option value="<?php echo $statusListItem['ID'];?>" <?php if($statusListItem['ID'] == $userDetail['STATUS']) {
                                                        echo 'selected';
                                                    }?> data-content = "<?php echo $statusListItem['DESCRIPTION'];?>"> </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <!--User Information-->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-yellow-gold">
                                        <i class="icon icon-envelope font-yellow-gold"></i> Email
                                    </div>
                                    <div class="actions">
                                        <button onclick="{jQuery('#emailForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                        <form role="form" id="emailForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_email/<?php echo $userDetail['ID'];?>">
                                            <div class="form-body row">
                                                <!--User Information-->
                                                <input type="hidden" name="userId" value="<?php echo $userDetail['USER_ID'];?>">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"> Email Address <span class="required"> * </span></label>
                                                    <div class="col-sm-10">
                                                        <input type="email" autocomplete="false" class="form-control" required placeholder="Email address" id="emailAddress" name="emailAddress" value="<?php echo $userDetail['EMAIL'];?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"> Confirm Email <span class="required"> * </span></label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" placeholder="Confirm Email" required name="confirmEmail">
                                                    </div>
                                                </div>
                                                <!--User Information-->
                                            </div>
                                        </form>
                                </div>
                            </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-lock font-yellow-gold"></i> Password
                            </div>
                            <div class="actions">
                                <button onclick="{jQuery('#passForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" id="passForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_pass/<?php echo $userDetail['ID'];?>">
                                <div class="form-body row">
                                    <!--User Information-->
                                    <input type="hidden" name="userId" value="<?php echo $userDetail['USER_ID'];?>">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Password <span class="required"> * </span> </label>
                                        <div class="col-sm-10">
                                            <input type="password" autocomplete="false" class="form-control" required placeholder="New Password" name="passwordInput" id="passwordInput">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Confirm Password <span class="required"> * </span> </label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" placeholder="Confirm New Password" required autocomplete="false" name="confirmPassword">
                                        </div>
                                    </div>



                                    <!--User Information-->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-user-following font-yellow-gold"></i>Identification
                            </div>
                            <div class="actions">
                                <button onclick="{jQuery('#identificationForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <?php if(intval($userDetail['VERIFY_STATUS']) == 0){?>
                                <div class="note note-danger">
                                    <span>User Identification is not verified yet. <a class="btn btn-link" href="<?php echo base_url();?>admin/kyc/add/<?php echo $userDetail['USER_ID'];?>"> Click here to request verification of user identification.</a></span>
                                </div>
                            <?php } else if(intval($userDetail['VERIFY_STATUS']) == 1) {?>
                                <div class="note note-warning">
                                    <span>User is in KYC progress now. <a class="btn btn-link" href="<?php echo base_url();?>admin/kyc/history/<?php echo $userDetail['USER_ID'];?>"> Click here to see progress information.</a></span>
                                </div>
                            <?php } else if(intval($userDetail['VERIFY_STATUS']) == 2) {?>
                                <div class="note note-success">
                                    This user identify is already verified.<a class="btn btn-link" href="<?php echo base_url();?>admin/kyc/history/<?php echo $userDetail['USER_ID'];?>"> Click here to see verification information.</a></span>
                                </div>
                            <?php } ?>

                            <form role="form" id="identificationForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_identification/<?php echo $userDetail['ID'];?>">
                                <div class="form-body row">
                                    <!--User Information-->
                                    <input type="hidden" name="userId" value="<?php echo $userDetail['USER_ID'];?>">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Date of Birth </label>
                                        <div class="col-sm-10">
                                            <input class="form-control date-picker" type="text" name="birthday" value="<?php echo $userDetail['DOB'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" style="padding: 0px !important;">
                                            <span>
                                                <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                                                   data-trigger="hover" data-placement="top" data-content="Upload Passport or ID card in image format" data-original-title="Information"> Identification </a>
                                            </span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input class="form-control" size="16" type="file" name="identification" accept="image/*" value="<?php echo $userDetail['ID_CARD'];?>">
                                            <?php if ($userDetail['ID_CARD'] != ""):?>
                                                <span class="help-block"> <a href="<?php echo base_url().$userDetail['ID_CARD'];?>" target="_blank"> Click here to see uploaded document </a> </span>
                                            <?php endif;?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" style="padding: 0px !important;">
                                            <span>
                                                <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                                                   data-trigger="hover" data-placement="top" data-content="Type your Passport number" data-original-title="Information"> Passport </a>
                                            </span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Passport Number" name="passport" value="<?php echo $userDetail['PASSPORT_NUMBER'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Country </label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2 select2-allow-clear" name="countryList" id="countryList" >
                                                <option value="" <?php if($userDetail['COUNTRY_INDEX'] == 0) echo "selected";?>> -- NONE -- </option>
                                                <?php foreach ($countryList as $countryListItem){?>
                                                    <option value="<?php echo $countryListItem['ID'];?>"
                                                        <?php if($countryListItem['ID'] == $userDetail['COUNTRY_INDEX']):?> selected <?php endif;?>
                                                    ><?php echo $countryListItem['DESCRIPTION'];?> </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" > City </label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2 select2-allow-clear" name="cityList" id="cityList" >
                                                <option value="" <?php if($userDetail['CITY_INDEX'] == 0 ) echo "selected";?>> -- NONE -- </option>
                                                <?php foreach ($cityList as $cityListItem){?>
                                                    <option value="<?php echo $cityListItem['ID'];?>"
                                                        <?php if($cityListItem['ID'] == $userDetail['CITY_INDEX']):?> selected <?php endif;?>
                                                    ><?php echo $cityListItem['DESCRIPTION'];?> </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Phone </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="<?php echo $userDetail['PHONE'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Home </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Home Phone" name="homePhone" value="<?php echo $userDetail['HOME_PHONE'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Office </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Office Number" name="officePhone" value="<?php echo $userDetail['OFFICE_PHONE'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Fax </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Fax" name="fax" value="<?php echo $userDetail['FAX'];?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">


                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-wallet font-yellow-gold"></i> Benefical Owner
                            </div>
                            <div class="actions">
                                <button onclick="{jQuery('#beneficalForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" id="beneficalForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_benefical/<?php echo $userDetail['ID'];?>">
                                <div class="form-body row">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Full Name </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Full Name" name="benefitFullName" value="<?php echo $userDetail['BENEFICAL_FULL_NAME'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Date of Birth </label>
                                        <div class="col-sm-10">
                                            <input class="form-control date-picker" size="16" type="text" name="benefitDOB" value="<?php echo $userDetail['BENIFICAL_DOB'];?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> RelationShip </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="RelationShip" name="benefitRelation" value="<?php echo $userDetail['BENIFICAL_RELATION'];?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Address </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Address" name="benefitAddress" value="<?php echo $userDetail['BENIFICAL_ADDR'];?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Phone </label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" placeholder="Phone Number" name="benefitPhone" value="<?php echo $userDetail['BENIFICAL_PHONE'];?>">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-badge font-yellow-gold"></i> Address
                            </div>
                            <div class="actions">
                                <button onclick="{jQuery('#addressForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" id="addressForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_address/<?php echo $userDetail['ID'];?>">
                                <div class="form-body row">
                                    <!--Physical address-->
                                    <div class="col-md-6">
                                        <h4 class="font-yellow-gold bold">
                                            Physical Address
                                        </h4>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Address </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Address " name="physicalAddress" id="physicalAddress" value="<?php echo $userDetail['PHYSICAL_ADDR'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Address(2nd line) </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Address 2nd Line" name="physical2ndAddress" id="physical2ndAddress" value="<?php echo $userDetail['PHYSICAL_ADDR2'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> City </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="City" name="physicalCity" id="physicalCity" value="<?php echo $userDetail['PHYSICAL_CITY'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> State </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="State, Province, Region" name="physicalState" id="physicalState" value="<?php echo $userDetail['PHYSICAL_STATE'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Zip/Postal </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Zip Postal Code" name="physicalZipPostal" id="physicalZipPostal" value="<?php echo $userDetail['PHYSICAL_ZIP'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Country </label>
                                            <div class="col-sm-7">
                                                <select class="select2 select2-allow-clear form-control" name="physicalCountry" id="physicalCountry">
                                                    <?php foreach ($countryList as $countryListItem){?>
                                                        <option value="<?php echo $countryListItem['ID'];?>"
                                                            <?php if($countryListItem['ID'] == $userDetail['PHYSICAL_COUNTRY']):?> selected <?php endif;?>
                                                        ><?php echo $countryListItem['DESCRIPTION'];?> </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Phone Number </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Phone Number" value="<?php echo $userDetail['PHYSICAL_PHONE'];?>" name="physicalPhone" id="physicalPhone">
                                            </div>
                                        </div>
                                    </div>
                                    <!--Physical address-->

                                    <!--Mailing address--->
                                    <div class="col-md-6">
                                        <h4 class="font-yellow-gold bold">
                                            Mailing Address
                                        </h4>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="checkbox" class="form-control" id="chkSamePhysical" name="chkSamePhysical"> Same as Physical
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Address </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Address" name="mailingAddress" id="mailingAddress" value="<?php echo $userDetail['MAILING_ADDR'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Address(2nd line) </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Address 2nd Line" name="mailing2ndAddress" id="mailing2ndAddress" value="<?php echo $userDetail['MAILING_ADDR2'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> City </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="City" name="mailingCity" id="mailingCity" value="<?php echo $userDetail['MAILING_CITY'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> State </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="State, Province, Region" name="mailingProvince" id="mailingProvince" value="<?php echo $userDetail['MAILING_STATE'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Zip/Postal </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Zip Postal Code" name="mailingZipPostal" id="mailingZipPostal" value="<?php echo $userDetail['MAILING_ZIP'];?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Country </label>
                                            <div class="col-sm-7">
                                                <select class="select2 select2-allow-clear form-control" name="mailingCountry" id="mailingCountry">
                                                    <?php foreach ($countryList as $countryListItem){?>
                                                        <option value="<?php echo $countryListItem['ID'];?>"
                                                            <?php if($countryListItem['ID'] == $userDetail['MAILING_COUNTRY']) echo 'selected';?>
                                                        ><?php echo $countryListItem['DESCRIPTION'];?> </option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-5 control-label"> Phone Number </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" placeholder="Phone Number" name="mailingPhone" id="mailingPhone" value="<?php echo $userDetail['MAILING_PHONE'];?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!--Mailing address-->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                <i class="icon icon-pencil font-yellow-gold"></i> Internal Notes
                            </div>
                            <div class="actions">
                                <button onclick="{jQuery('#internalNoteForm').submit();}" class="btn btn-outline yellow-gold"> Update </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form role="form" id="internalNoteForm" enctype="multipart/form-data" class="form-horizontal" style="padding: 10px;" method="POST" action="<?php echo base_url();?>admin/profile/update_detail_internal/<?php echo $userDetail['ID'];?>">
                                <div class="form-body row">
                                    <!--Mailing address--->

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <textarea rows="5" class="form-control" placeholder="internal notes" name="txtInternalNote"><?php echo $userDetail['INTERNAL_MESSAGE'];?></textarea>
                                            </div>
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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


<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/admin_profile_detail_edit.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

</body>

</html>