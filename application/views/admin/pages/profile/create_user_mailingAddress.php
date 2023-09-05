
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
            <input type="text" class="form-control" placeholder="Address" name="mailingAddress" id="mailingAddress">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Address(2nd line) </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Address 2nd Line" name="mailing2ndAddress" id="mailing2ndAddress">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> City </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="City" name="mailingCity" id="mailingCity">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> State </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="State, Province, Region" name="mailingProvince" id="mailingProvince">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Zip/Postal </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Zip Postal Code" name="mailingZipPostal" id="mailingZipPostal">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Country </label>
        <div class="col-sm-7">
            <select class="select2 select2-allow-clear form-control" name="mailingCountry" id="mailingCountry">
                <?php foreach ($countryList as $countryListItem){?>
                    <option value="<?php echo $countryListItem['ID'];?>" ><?php echo $countryListItem['DESCRIPTION'];?> </option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-5 control-label"> Phone Number </label>
        <div class="col-sm-7">
            <input type="text" class="form-control" placeholder="Phone Number" name="mailingPhone" id="mailingPhone">
        </div>
    </div>
</div>
<!--Mailing address-->