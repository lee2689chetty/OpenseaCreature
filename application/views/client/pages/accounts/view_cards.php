<div class="row">
    <div class="col-md-12">
        <?php foreach ($cards as $cardItem){?>
            <div class="panel col-md-3 md-shadow-z-3" style="border-radius: 5px; border-width:1px; border-color: #f1ecec; margin: 10px;">
                <div class="panel-body">
                    <h3 class="font-yellow-gold text-center margin-bottom-20 bold" style="font-size: 28px;"> <?php
                        $cardItem['CARD_NUMBER'] = str_replace(' ', '',$cardItem['CARD_NUMBER']);
                        $cardItem['CARD_NUMBER'] = str_replace('-', '',$cardItem['CARD_NUMBER']);
                        $arr_card_num = str_split($cardItem['CARD_NUMBER'], 4);
                        $prtVal = "";
                        foreach ( $arr_card_num as $item){
                            $prtVal .= ($item."-");
                        }
                        $prtVal = substr($prtVal, 0, -1);
                        echo $prtVal;
                        ?> </h3>
                    <div class="row">

                        <div class="col-sm-12 col-md-6">
                            <p class="margin-bottom-10 font-grey-salsa"> Valid Date</p>
                            <p class="font-lg"> <?php echo ($cardItem['CARD_EXP_YEAR'].'-'.str_pad($cardItem['CARD_EXP_MONTH'], 2, "0", STR_PAD_LEFT));?> </p>

                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="pull-left">
                                <p class="margin-bottom-10 font-grey-salsa"> Currency </p>
                                <p class="font-lg"> <?php echo $cardItem['CURRENCY_TITLE'];?> </p>
                            </div>
                            <div class="pull-right">
                                <i class="icon font-lg icon-credit-card"></i>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="margin-bottom-10 font-grey-salsa"> Card Holder</p>
                            <p class="font-lg"> <?php echo $cardItem['CARD_HOLDER_NAME'];?> </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="margin-bottom-10 font-grey-salsa"> Amount </p>
                            <p class="font-lg"> <?php echo number_format($cardItem['CURRENT_AMOUNT'], 2, ".", ",");?> </p>
                        </div>
                    </div>
                </div>

            </div>
        <?php }?>
    </div>
</div>