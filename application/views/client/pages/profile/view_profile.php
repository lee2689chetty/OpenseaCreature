<div class="row">
    <div class="col-md-10">
        <div class="profile-info">

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

            <div class="col-sm-12 list-separated" style="border-bottom: 1px solid #f0f4f7 !important;"></div>
            <h3 class="font-yellow-gold sbold uppercase"> <?php echo $myProfileData['NAME'];?> <span> <label class="font-grey-salsa small"> <?php echo $myProfileData['FULL_NAME'];?></label> </span></h3>
            <div class="portlet light border-grey">
                <div class="portlet-title">
                    <div class="caption font-yellow-lemon">
                        <i class="fa fa-user-secret font-yellow-lemon"></i>
                        Information
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <label class="col-sm-4 font-grey-salsa">
                            Email
                        </label>
                        <label class="col-sm-8">
                            <?php echo $myProfileData['EMAIL'];?>
                        </label>
                        <label class="col-sm-4 font-grey-salsa">
                            Date of Birth
                        </label>
                        <label class="col-sm-8">
                            <?php echo $myProfileData['DOB'];?>&nbsp;
                        </label>
                        <label class="col-sm-4 font-grey-salsa">
                            Profile Type
                        </label>
                        <label class="col-sm-8">
                            <?php echo $myProfileData['PROFILE_DESC'];?>&nbsp;
                        </label>
                        <label class="col-sm-4 font-grey-salsa">
                            Status
                        </label>
                        <label class="col-sm-8">
                            <?php echo $myProfileData['STATUS_DESCRIPTION'];?>&nbsp;
                        </label>
                    </div>
                </div>
            </div>

            <div class="portlet light border-blue">
                <div class="portlet-title">
                    <div class="caption font-yellow-lemon">
                        <i class="fa fa-globe font-yellow-lemon"></i>
                        Last Login
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <div class="row">

                        <label class="col-sm-4 font-grey-salsa">
                            Date
                        </label>
                        <label class="col-sm-8">
                        <?php echo date('Y-m-d H:m:s', $loginHistory['UPDATED_AT']);?>
                        </label>
                        <label class="col-sm-4 font-grey-salsa">
                            Ip Address
                        </label>
                        <label class="col-sm-8">
                            <?php echo $loginHistory['FROM_IP'];?>
                        </label>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>