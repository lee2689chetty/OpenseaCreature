<form role="form" class="form-horizontal" id="formPassChange" method="post" action="<?php echo base_url();?>profile/updatepass">
    <div class="form-body row">
            <div class="form-group">
                <label class="col-sm-2 control-label"> Current Password <span class="font-red"> * </span></label>
                <div class="col-sm-8">
                    <input type="password" autocomplete="false" class="form-control" placeholder="Current Password" id="userInfoCurrentPassword" name="userInfoCurrentPassword">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"> New Password <span class="required"> * </span></label>
                <div class="col-sm-8">
                    <input name="userInfoNewPassword" id="userInfoNewPassword" type="password" class="form-control" placeholder="New Password">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"> Confirm Password <span class="required">  *</span></label>
                <div class="col-sm-8">
                    <input name="userInfoConfirmNewPassword" id="userInfoConfirmNewPassword" type="password" class="form-control" placeholder="Confirm New Password">
                </div>
            </div>
    </div>

    <div class="form-actions">
        <button type="submit" style="width: 150px;" class="col-sm-offset-2 btn btn yellow-gold"> Save </button>
    </div>
</form>