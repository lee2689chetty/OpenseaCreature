
<div class="col-sm-12 col-md-12 form-group">
    <label class="col-sm-2 control-label font-yellow-gold uppercase"> Line of Credit </label>
    <div class="col-sm-10">
        <input type="checkbox" class="form-control checkbox" name="chkLoc" <?php if ($isUpdate == TRUE && $originAccount['IS_LOC'] == TRUE) echo 'checked';?>>
    </div>
</div>

<div class="col-sm-12 col-md-6 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Limit Amount </label>
    <div class="col-sm-12">
        <input type="text" class="form-control" placeholder="Limit Amount" name="locLimitAmount" id="locLimitAmount"
               value="<?php if($isUpdate == TRUE) { echo $originAccount['LOC_LIMIT_AMOUNT']; }
               else { echo '0.00'; } ?>">
    </div>
</div>

<div class="col-sm-12 col-md-6 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Annual Interest Rate(%) </label>
    <div class="col-sm-12">
        <input type="text" class="form-control" placeholder="Annual Interest Rate" name="locAnnualInterest" id="locAnnualInterest"
               value="<?php if($isUpdate == TRUE) { echo $originAccount['LOC_ANNUAL_RATE']; }
               else { echo '0.00'; } ?>">
    </div>
</div>

<div class="col-sm-12 col-md-6 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Method </label>
    <div class="col-sm-12">
        <select class="bs-select form-control" name="locMethod">
            <?php foreach ($locMethod as $locMethodItem){?>
                <option value="<?php echo $locMethodItem['ID']?>"
                    <?php if ($isUpdate == TRUE && $originAccount['LOC_METHOD'] == $locMethodItem['ID'])
                    {
                        echo 'selected';
                    }?>> <?php echo $locMethodItem['DESCRIPTION'];?></option>
            <?php }?>
        </select>
    </div>
</div>

<div class="col-sm-12 col-md-6 form-group">
    <label class="col-sm-12 control-label" style="text-align: left;"> Charge Period </label>
    <div class="col-sm-12">
        <select class="bs-select form-control" name="locChargePeriod">
            <option> - None - </option>
            <?php foreach ($locChargePeriod as $locChargePeriodItem){?>
                <option value="<?php echo $locChargePeriodItem['ID']?>"
                    <?php if ($isUpdate == TRUE && $originAccount['LOC_CHARGE_PERIOD'] == $locChargePeriodItem['ID'])
                    {
                        echo 'selected';
                    }?>> <?php echo $locChargePeriodItem['DESCRIPTION'];?></option>
            <?php }?>
        </select>
    </div>
</div>
