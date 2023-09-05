<form class="form-horizontal">
    <div class="row">
        <div class="profile-sidebar" style="background-color: #f4f4f4; padding: 10px;">
            <div class="col-sm-12">
                <div class="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Account Number</label>
                            <div>
                                <select class="bs-select form-control" id="account" name="account">
                                    <option value = ""> Account Number </option>
                                    <?php foreach ($accounts as $accountItem){
                                        echo ("<option value=\"".$accountItem['ID']."\" data-content=\""
                                            .$accountItem['ACCOUNT_NUMBER']." <span class='label label-sm label-success'> ".$accountItem['CURRENCY_TITLE']. "  ".$accountItem['CURRENT_AMOUNT']." </span>\"> </option>");
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Current Balance</label>
                            <div>
                                <label class="font-yellow-gold margin-top-10 margin-bottom-5" id="txtCurrentBalance" style="font-size: 24px;"> No data </label>
                            </div>
                            <div class="margin-bottom-20">
                                <label class="font-grey-salsa" id="txtAvailableDesc"> ----------- </label>
                            </div>
                            <div class="col-sm-12 col-md-6 margin-bottom-10">
                                <label >Account type</label><br>
                                <label class="bold">CURRENCY</label>
                            </div>
                            <div class="col-sm-12 col-md-6 margin-bottom-10">
                                <label id="txtAccountType"> ----- </label><br>
                                <label class="bold" id="txtCurrencyType">-----</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="profile-content">
                <div class="form-group row" style="margin-bottom: 90px;">
                </div>

            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover" id="tbHistoryList">
                    <thead>
                    <tr>
                        <th> Date </th>
                        <th> ID </th>
                        <th> Description </th>
                        <th> Debit/Credit </th>
                        <th> Current </th>
                        <th> Available </th>
                        <th> Status </th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</form>