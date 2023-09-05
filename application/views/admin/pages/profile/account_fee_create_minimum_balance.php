

<div class="col-sm-12 col-md-12 form-group">
    <label class="col-sm-2 control-label font-yellow-gold uppercase"> Minimum balance </label>
    <div class="col-sm-10">
        <input type="checkbox" class="form-control checkbox" name="chkMinibalance" <?php if ($isUpdate == TRUE && $originAccount['IS_MINIMUM_BALANCE'] == TRUE) echo 'checked';?>>
    </div>
</div>

<div class="col-sm-12 col-md-12 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Limit Amount </label>
    <div class="col-sm-12">
        <input type="text" class="form-control" placeholder="Limit Amount" name="mbLimitAccount" id="mbLimitAccount"
               value="<?php if($isUpdate == TRUE) { echo $originAccount['MINIMUM_LIMIT_AMOUNT']; }
               else { echo '0.00'; } ?>">
    </div>
</div>

<div class="col-sm-12 col-md-6 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Fee Amount </label>
    <div class="col-sm-12">
        <input class="form-control" placeholder="Fee Amount" name="mbFeeAmount" id="mbFeeAmount"
               value="<?php if($isUpdate == TRUE) { echo $originAccount['MINIMUM_LIMIT_FEE_AMOUNT']; }
               else { echo '0'; } ?>">
    </div>
</div>

<div class="col-sm-12 col-md-6 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Charge day </label>
    <div class="col-sm-12">
        <select class="bs-select form-control" name="mbChargeDay">
            <option value="0"> - None - </option>
            <?php foreach ($mbChargeDay as $mbChargeDayItem){?>
                <option value="<?php echo $mbChargeDayItem['ID']?>"
                    <?php if ($isUpdate == TRUE && $originAccount['MINIMUM_CHARGE_DAY'] == $mbChargeDayItem['ID'])
                    {
                        echo 'selected';
                    }?>> <?php echo $mbChargeDayItem['DESCRIPTION'];?></option>
            <?php }?>
        </select>
    </div>
</div>