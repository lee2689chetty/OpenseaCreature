<div class="form-horizontal bg-grey" id="formSpecified">
    <div class="row">
        <div class="col-sm-12">

            <div class="col-sm-12 col-md-3 form-group">
                <label class="col-sm-12 control-label" style="text-align: left;">Account Number</label>
                <div class="col-sm-12">
                    <select class="bs-select form-control" name="accountNumber" id="accountNumber">
                        <option value=""> Choose Account Number </option>
                        <?php
                            foreach ($accountList as $accountItem){
                                echo ("<option value=\"".$accountItem['ID']."\" data-content=\""
                                    .$accountItem['ACCOUNT_NUMBER']." <span class='label label-sm label-success'> ".$accountItem['CURRENCY_TITLE']. "  ".$accountItem['CURRENT_AMOUNT']." </span>\"> </option>");
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control" name="fromDate" id="fromDate">
                    <span class="input-group-addon"> to </span>
                    <input type="text" class="form-control" name="toDate" id="toDate">
                </div>
            </div>

            <div class="col-sm-12 col-md-2 form-actions">
                <input type="button" class="btn yellow-gold margin-bottom-10" value="Generate" style="margin-top: 25px;" id="btSpecAccountSubmit">
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 90px;">

    <div class="col-sm-12 col-md-4">

        <label class="control-label">Current Balance</label>
        <div>
            <label class="font-yellow-gold margin-top-10 margin-bottom-5" id="txtAvailable" style="font-size: 24px;"> </label>
        </div>

        <div class="margin-bottom-20">
            <label class="font-grey-salsa" id="txtAvailableDesc"> </label>
        </div>

        <div class="col-sm-12 col-md-6 margin-bottom-10">
            <label class="bold">Account type</label><br>
            <label class="bold">CURRENCY</label><br>
            <label class="bold"> Account Owner </label>
        </div>

        <div class="col-sm-12 col-md-6 margin-bottom-10">
            <label id="txtAccountType"></label><br>
            <label id="txtCurrencyType"></label><br>
            <label id="txtAccountOwner"></label>
        </div>

    </div>
    <div class="col-sm-12 col-md-8">
        <table class="table table-striped table-bordered table-hover" id="tbTransHistory">
            <thead>
                <tr>
                    <th class="font-yellow-gold"> Date </th>
                    <th class="font-yellow-gold"> ID </th>
                    <th class="font-yellow-gold"> Description </th>
                    <th class="font-yellow-gold"> Debit/Credit </th>
                    <th class="font-yellow-gold"> Available Balance </th>
                    <th class="font-yellow-gold"> Status </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>