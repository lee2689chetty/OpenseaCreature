<div class="row">
    <div class="col-md-12">

        <div class="col-sm-12 col-md-4">
            <div class="row panel panel-default">
                <div class="panel-body">
                    <?php foreach ($accountAnalysisList as $item){?>
                        <h3 class="lead col-sm-12 font-yellow-lemon"> <?php echo $item['CURRENCY_TITLE'];?> </h3>
                        <div class="col-sm-12">
                            <div class="col-sm-12 col-md-5">
                                <label class="font-grey-salsa uppercase">TOTAL BALANCE:</label>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <label class="uppercase"><?php echo number_format($item['CURRENCY_ANALYSIS']['TOTAL_CURRENT_BALANCE'], 2, ".", ",");?></label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-12 col-md-5">
                                <label class="font-grey-salsa uppercase">TOTAL PENDING TRANSACTIONS:</label>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <label class="uppercase"><?php echo number_format($item['CURRENCY_ANALYSIS']['TOTAL_PENDING_AMOUNT'], 2, ".", ",");?></label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-12 col-md-5">
                                <label class="font-grey-salsa uppercase">FUTURE BALANCE:</label>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <label class="uppercase"><?php echo number_format($item['CURRENCY_ANALYSIS']['FUTURE_AMOUNT'], 2, ".", ",");?></label>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-8">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="font-yellow-gold"> Account Type </th>
                        <th class="font-yellow-gold"> Number of Account </th>
                        <th class="font-yellow-gold"> Currency </th>
                        <th class="font-yellow-gold"> Available Balance </th>
                        <th class="font-yellow-gold"> Current Balance </th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($accountFeeValueList as $feeItem){?>
                         <tr class="input-large">
                             <td style="padding-top: 25px; padding-bottom: 25px;"> <?php echo $feeItem['ACCOUNT_TYPE_DESC'];?> </td>
                             <td style="padding-top: 25px; padding-bottom: 25px;"> <?php echo $feeItem['ACCOUNT_NUMBER'];?> </td>
                             <td style="padding-top: 25px; padding-bottom: 25px;"> <?php echo $feeItem['CURRENCY_TITLE'];?> </td>
                             <td style="padding-top: 25px; padding-bottom: 25px;"> <?php echo number_format($feeItem['AVAILABLE_AMOUNT'], 2, ".", ",");?> </td>
                             <td style="padding-top: 25px; padding-bottom: 25px;"> <?php echo number_format($feeItem['CURRENT_AMOUNT'], 2, ".", ",");?> </td>
                         </tr>
                     <?php }?>
                </tbody>
            </table>

        </div>

    </div>
</div>