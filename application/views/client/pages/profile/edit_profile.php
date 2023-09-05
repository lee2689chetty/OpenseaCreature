<form role="form" class="form-horizontal" id="formProfileUpdate" method="post" action="<?php echo base_url();?>profile/me">

    <?php if($myProfileData['VERIFY_STATUS'] == '0'):?>
        <div class="alert alert-warning">
            <span> <i class="img-circle fa fa-user"></i> You didn't verify your identification yet. </span> <a href="javascript:;"> Learn More</a>
        </div>
    <?php elseif($myProfileData['VERIFY_STATUS'] == '1'):?>
        <div class="alert alert-danger">
            <span> <i class="img-circle fa fa-user"></i> We need to verify your identify to keep a secure market place for vpay. Please, verify your identify. Thanks for your cooperation. </span> <a href="javascript:;"> Learn More</a>
        </div>
        <a href="<?php echo base_url();?>kyc/view/<?php echo $kycData['TICKET_NUMBER'];?>" class="btn btn-link bold"> Verify My identify</a>
    <?php elseif($myProfileData['VERIFY_STATUS'] == '2'):?>
        <div class="alert alert-success">
            <span> <i class="img-circle fa fa-user"></i> We verified your identify to keep a secure market place for vpay. You can't change your profile information. Thanks for your cooperation. </span> <a href="javascript:;"> Learn More</a>
        </div>
    <?php endif;?>

    <div class="form-body row">
        <div class="col-md-3">
            <h4 class="font-yellow-lemon bold">
                User Information
            </h4>
            <div class="form-group">
                <label class="col-sm-5 control-label"> Profile Type <span class="font-red"> * </span></label>
                <div class="col-sm-7">
                    <select class="bs-select form-control" name="profileType" id="profileType" required>
                        <?php foreach ($profileList as $profileListItem){?>
                            <option value="<?php echo $profileListItem['ID'];?>"
                                <?php if($currentProfileData[0]['PROFILE_KIND'] == $profileListItem['ID']):?>
                                    selected
                                <?php endif;?>>
                                <?php echo $profileListItem['DESCRIPTION'];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> First Name <span class="font-red"> * </span></label>
                <div class="col-sm-7">
                    <input type="text" <?php if ($currentProfileData[0]['VERIFY_STATUS'] == '2') echo 'readonly';?> class="form-control" placeholder="First Name" value="<?php echo $currentProfileData[0]['FIRST_NAME'];?>" id="userInfoFirstName" name="userInfoFirstName">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-5 control-label"> Last Name <span class="font-red"> * </span></label>
                <div class="col-sm-7">
                    <input type="text" <?php if ($currentProfileData[0]['VERIFY_STATUS'] == '2') echo 'readonly';?>  class="form-control" placeholder="Last Name" value="<?php echo $currentProfileData[0]['LAST_NAME'];?>" id="userInfoLastName" name="userInfoLastName">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Email Address <span class="font-red"> * </span></label>
                <div class="col-sm-7">
                    <input id="userInfoEmail" name="userInfoEmail" type="email" autocomplete="false" class="form-control" placeholder="Email address" value="<?php echo $currentProfileData[0]['EMAIL'];?>">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-5 control-label"> Confirm Email <span class="required"> * </span></label>
                <div class="col-sm-7">
                    <input id="userInfoConfirmEmail" name="userInfoConfirmEmail" type="email" class="form-control" placeholder="Confirm Email" value="<?php echo $currentProfileData[0]['EMAIL'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Date of Birth </label>
                <div class="col-sm-7">
                    <input <?php if ($currentProfileData[0]['VERIFY_STATUS'] == '2') echo 'readonly';?>  name="userInfoDOB" class="form-control date-picker" size="16" type="text" value="<?php echo $currentProfileData[0]['DOB'];?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label" style="padding: 0px !important;">
                                                        <span>
                                                            <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                                                               data-trigger="hover" data-placement="top" data-content="Type your Passport number" data-original-title="Information"> Passport </a>
                                                        </span>
                </label>

                <div class="col-sm-7">
                    <input name="userInfoPassport" <?php if ($currentProfileData[0]['VERIFY_STATUS'] == '2') echo 'readonly';?>  type="text" class="form-control" placeholder="Passport Number" value="<?php echo $currentProfileData[0]['PASSPORT_NUMBER'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Country </label>
                <div class="col-sm-7">
                    <select class="form-control select2 select2-allow-clear" name="userInfoCountryList" id="userInfoCountryList" >
                        <option value="" <?php if($currentProfileData[0]['COUNTRY_INDEX'] == 0) echo 'selected';?>> -- NONE -- </option>
                        <?php foreach ($countryList as $countryListItem){?>
                            <option value="<?php echo $countryListItem['ID'];?>"
                                <?php if($currentProfileData[0]['COUNTRY_INDEX'] == $countryListItem['ID']):?>
                                    selected
                                <?php endif;?>> <?php echo $countryListItem['DESCRIPTION'];?> </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> City </label>
                <div class="col-sm-7">
                    <select class="form-control select2 select2-allow-clear" name="userInfoCityList" id="userInfoCityList">
                        <option value=""> -- NONE -- </option>
                        <?php foreach ($cityList as $cityListItem){?>
                            <option value="<?php echo $cityListItem['ID'];?>"
                                <?php if($currentProfileData[0]['CITY_INDEX'] == $cityListItem['ID']):?>
                                    selected
                                <?php endif;?>> <?php echo $cityListItem['DESCRIPTION'];?> </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Phone </label>
                <div class="col-sm-7">
                    <input name="userInfoPhoneNumber" type="text" class="form-control" placeholder="Phone Number" value="<?php echo $currentProfileData[0]['PHONE'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Home </label>
                <div class="col-sm-7">
                    <input type="text" name="userInfoHomePhone" class="form-control" placeholder="Home Phone" value="<?php echo $currentProfileData[0]['HOME_PHONE'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Office </label>
                <div class="col-sm-7">
                    <input type="text" name="userInfoOfficePhone" class="form-control" placeholder="Office Number" value="<?php echo $currentProfileData[0]['OFFICE_PHONE'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Fax </label>
                <div class="col-sm-7">
                    <input type="text" name="userInfoFax" class="form-control" placeholder="Fax" value="<?php echo $currentProfileData[0]['FAX'];?>">
                </div>
            </div>
        </div>
        <!--User Information-->

        <!---Begin of Benifit owner-->
        <div class="col-md-3">
            <h4 class="font-yellow-lemon bold">
                Benifical Owner
            </h4>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Full Name </label>
                <div class="col-sm-7">
                    <input type="text" name="benificalFullName" class="form-control" placeholder="Full Name" value="<?php echo $currentProfileData[0]['BENEFICAL_FULL_NAME'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Date of Birth </label>
                <div class="col-sm-7">
                    <input name="benificalDOB" class="form-control date-picker" size="16" type="text" value="<?php echo $currentProfileData[0]['BENIFICAL_DOB'];?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> RelationShip </label>
                <div class="col-sm-7">
                    <input type="text" name="benificalRelationShip" class="form-control" placeholder="RelationShip" value="<?php echo $currentProfileData[0]['BENIFICAL_RELATION'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Address </label>
                <div class="col-sm-7">
                    <input type="text" name="benificalAddress" class="form-control" placeholder="Address" value="<?php echo $currentProfileData[0]['BENIFICAL_ADDR'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Phone </label>
                <div class="col-sm-7">
                    <input type="number" name="benificalPhone" class="form-control" placeholder="Phone Number" value="<?php echo $currentProfileData[0]['BENIFICAL_PHONE'];?>">
                </div>
            </div>
        </div>
        <!-- End of Benifit owner -->

        <!--Physical address-->
        <div class="col-md-3">
            <h4 class="font-yellow-lemon bold">
                Physical Address
            </h4>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Address </label>
                <div class="col-sm-7">
                    <input name="physicalAddress" id="physicalAddress"  type="text" class="form-control" placeholder="Address" value="<?php echo $currentProfileData[0]['PHYSICAL_ADDR'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Address(2nd line) </label>
                <div class="col-sm-7">
                    <input type="text" name="physicalAddress_2" id="physicalAddress_2" class="form-control" placeholder="Address 2nd Line" value="<?php echo $currentProfileData[0]['PHYSICAL_ADDR2'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> City </label>
                <div class="col-sm-7">
                    <input type="text" name="physicalCity" id="physicalCity" class="form-control" placeholder="City" value="<?php echo $currentProfileData[0]['PHYSICAL_CITY'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> State </label>
                <div class="col-sm-7">
                    <input name="physicalState" id="physicalState" type="text" class="form-control" placeholder="State, Province, Region" value="<?php echo $currentProfileData[0]['PHYSICAL_STATE'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Zip/Postal </label>
                <div class="col-sm-7">
                    <input type="text" name="physicalZip" id="physicalZip" class="form-control" placeholder="Zip Postal Code" value="<?php echo $currentProfileData[0]['PHYSICAL_ZIP'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Country </label>
                <div class="col-sm-7">
                    <select class="form-control select2 select2-allow-clear" name="physicalCountryList" id="physicalCountryList" >
                        <option value=""> -- NONE -- </option>
                        <?php foreach ($countryList as $countryListItem){?>
                            <option value="<?php echo $countryListItem['ID'];?>"
                                <?php if($countryListItem['ID'] == $currentProfileData[0]['PHYSICAL_COUNTRY']):?>
                                    selected
                                <?php endif;?>> <?php echo $countryListItem['DESCRIPTION'];?> </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Phone Number </label>
                <div class="col-sm-7">
                    <input name="physicalPhone" id="physicalPhone"  type="text" class="form-control" placeholder="Phone Number" value="<?php echo $currentProfileData[0]['PHYSICAL_PHONE'];?>">
                </div>
            </div>
        </div>
        <!--Physical address-->
        <!--Mailing address--->
        <div class="col-md-3">
            <h4 class="font-yellow-lemon bold">
                Mailing Address
            </h4>

            <div class="form-group">
                <div class="col-sm-12">
                    <input name="physicalCheck" id="physicalCheck" type="checkbox" class="form-control"> Same as Physical
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Address </label>
                <div class="col-sm-7">
                    <input type="text" name="mailingAddress" id="mailingAddress" class="form-control" placeholder="Address" value="<?php echo $currentProfileData[0]['MAILING_ADDR'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Address(2nd line) </label>
                <div class="col-sm-7">
                    <input type="text" name="mailingAddress_2" id="mailingAddress_2" class="form-control" placeholder="Address 2nd Line" value="<?php echo $currentProfileData[0]['MAILING_ADDR2'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> City </label>
                <div class="col-sm-7">
                    <input type="text" name="mailingCity" id="mailingCity" class="form-control" placeholder="City" value="<?php echo $currentProfileData[0]['MAILING_CITY'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> State </label>
                <div class="col-sm-7">
                    <input type="text" name="mailingState" id="mailingState" class="form-control" placeholder="State, Province, Region" value="<?php echo $currentProfileData[0]['MAILING_STATE'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Zip/Postal </label>
                <div class="col-sm-7">
                    <input type="text" name="mailingZip" id="mailingZip" class="form-control" placeholder="Zip Postal Code" value="<?php echo $currentProfileData[0]['MAILING_ZIP'];?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Country </label>
                <div class="col-sm-7">
                    <select class="form-control select2 select2-allow-clear" name="mailingCountryList" id="mailingCountryList" >
                        <option value=""> -- NONE -- </option>
                        <?php foreach ($countryList as $countryListItem){?>
                            <option value="<?php echo $countryListItem['ID'];?>"
                                <?php if($countryListItem['ID'] == $currentProfileData[0]['MAILING_COUNTRY']):?>
                                    selected
                                <?php endif;?>> <?php echo $countryListItem['DESCRIPTION'];?> </option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label"> Phone Number </label>
                <div class="col-sm-7">
                    <input type="text" name="mailingPhoneNumber" id="mailingPhoneNumber" class="form-control" placeholder="Phone Number" value="<?php echo $currentProfileData[0]['MAILING_PHONE'];?>">
                </div>
            </div>
        </div>
        <!--Mailing address-->


    </div>

    <div class="form-actions">
        <button type="submit" style="width: 150px;" class="col-sm-offset-1 btn btn yellow-gold"> Save </button>
    </div>
</form>