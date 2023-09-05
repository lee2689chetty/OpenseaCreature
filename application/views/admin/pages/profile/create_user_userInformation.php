<!--User Information-->
<div class="col-md-6">
    <h4 class="font-yellow-gold bold">
        User Information
    </h4>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Profile Type <span class="required"> * </span></label>
        <div class="col-sm-7">
            <select class="bs-select form-control" id="profileType" name="profileType" required>
                <?php foreach ($profileList as $profileListItem){?>
                    <option value="<?php echo $profileListItem['ID'];?>"><?php echo $profileListItem['DESCRIPTION'];?></option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="form-group" id="divCompanyName">
        <label class="col-sm-5 control-label"> Company Name <span class="required"> * </span></label>
        <div class="col-sm-7">
            <input type="text" id="companyName" class="form-control" placeholder="Company Name" name="companyName">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> First Name <span class="required"> * </span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="First Name" name="firstName" required>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Last Name <span class="required"> * </span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Last Name" name="lastName" required>
        </div>
    </div>

    <!--- Should not start with number.. only should start with alphabetic --->
    <div class="form-group">
        <label class="col-sm-5 control-label"> User Name <span class="required"> * </span></label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="User Name" name="userName" required>
            <div class="help-block"> Spaces are allowed; punctation is not allowed except for periods, hyphens, apostrophes, and underscores. </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Email Address <span class="required"> * </span></label>
        <div class="col-sm-7">
            <input type="email" autocomplete="false" class="form-control" required placeholder="Email address" id="emailAddress" name="emailAddress">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Confirm Email <span class="required"> * </span></label>
        <div class="col-sm-7">
            <input type="email" class="form-control" placeholder="Confirm Email" required name="confirmEmail">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Password <span class="required"> * </span> </label>
        <div class="col-sm-7">
            <input type="password" autocomplete="false" class="form-control" required placeholder="New Password" name="passwordInput" id="passwordInput">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Confirm Password <span class="required"> * </span> </label>
        <div class="col-sm-7">
            <input type="password" class="form-control" placeholder="Confirm New Password" required autocomplete="false" name="confirmPassword">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Status <span class="required"> * </span> </label>
        <div class="col-sm-7">
            <select class="bs-select form-control" name="statusList" id="statusList" required>
                <?php foreach ($statusList as $statusListItem){?>
                    <option value="<?php echo $statusListItem['ID'];?>" data-content = "<?php echo $statusListItem['DESCRIPTION'];?>"> </option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Date of Birth </label>
        <div class="col-sm-7">
            <input class="form-control date-picker" size="16" type="text" name="birthday" >
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label" style="padding: 0px !important;">
            <span>
                <a class="btn btn-link popovers" data-container="body" style="border-bottom: dashed 1px #0088cc;"
                   data-trigger="hover" data-placement="top" data-content="Upload Passport or ID card in image format" data-original-title="Information"> Identification </a>
            </span>
        </label>
        <div class="col-sm-7">
            <input class="form-control" size="16" type="file" name="identification" accept="image/*">
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
            <input type="text" class="form-control" placeholder="Passport Number" name="passport" >
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Country </label>
        <div class="col-sm-7">
            <select class="form-control select2 select2-allow-clear" name="countryList" id="countryList" >
                <option value=""> -- NONE -- </option>
                <?php foreach ($countryList as $countryListItem){?>
                    <option value="<?php echo $countryListItem['ID'];?>"><?php echo $countryListItem['DESCRIPTION'];?> </option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label" > City </label>
        <div class="col-sm-7">
            <select class="bs-select form-control" name="cityList" id="cityList" >
                <option> -- NONE -- </option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Phone </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Phone Number" name="phone" >
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Home </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Home Phone" name="homePhone" >
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Office </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Office Number" name="officePhone" >
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Fax </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Fax" name="fax" >
        </div>
    </div>
</div>
<!--User Information-->