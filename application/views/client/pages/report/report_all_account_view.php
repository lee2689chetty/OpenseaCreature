<div class="row" id="reportAllAccountContainer">
    <div class="col-md-12">
        <div class="form-horizontal bg-grey">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12 col-md-4 form-group" style="margin-left: 0px;">
                        <label class="col-sm-12 control-label" style="text-align: left;"> Duration </label>
                        <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="fromAllDate" id="fromAllDate">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control" name="toAllDate" id="toAllDate">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 form-actions">
                        <button class="btn yellow-gold margin-bottom-10" style="margin-top: 25px;" id="btAllReportSubmit"> Generate </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 90px;">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover" id="tbAllAccountTransactionList">
                    <thead>
                        <tr>
                            <th class="font-yellow-gold"> Date </th>
                            <th class="font-yellow-gold"> Account Number </th>
                            <th class="font-yellow-gold"> Parent ID </th>
                            <th class="font-yellow-gold"> ID </th>
                            <th class="font-yellow-gold"> Description </th>
                            <th class="font-yellow-gold"> Debit/Credit </th>
                            <th class="font-yellow-gold"> Current Balance </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>