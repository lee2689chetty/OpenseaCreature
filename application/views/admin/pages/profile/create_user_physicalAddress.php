
                                        
<!--Physical address-->
<div class="col-md-6">
    <h4 class="font-yellow-gold bold">
        Physical Address
    </h4>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Address </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Address " name="physicalAddress" id="physicalAddress">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Address(2nd line) </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Address 2nd Line" name="physical2ndAddress" id="physical2ndAddress">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> City </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="City" name="physicalCity" id="physicalCity">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> State </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="State, Province, Region" name="physicalState" id="physicalState">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Zip/Postal </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Zip Postal Code" name="physicalZipPostal" id="physicalZipPostal">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Country </label>
        <div class="col-sm-7">
            <select class="select2 select2-allow-clear form-control" name="physicalCountry" id="physicalCountry">
                <?php foreach ($countryList as $countryListItem){?>
                    <option value="<?php echo $countryListItem['ID'];?>"><?php echo $countryListItem['DESCRIPTION'];?> </option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Phone Number </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Phone Number" name="physicalPhone" id="physicalPhone">
        </div>
    </div>
</div>
<!--Physical address-->