<div class="row">
    <div class="col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-yellow-gold">
                    Transfer Details
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">

                            <table class="table table-responsive table-light table-bordered">
                                <tr>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-grey-salsa"> Subject </p>
                                    </td>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-dark"> <?php echo $transactionType['DESCRIPTION'];?> &nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-grey-salsa"> Amount </p>
                                    </td>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-dark"> <?php echo $fromUserData['CURRENCY_TITLE'].' '.number_format($requestDetail['AMOUNT'], 2, ".", ",");?> &nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-grey-salsa"> Description </p>
                                    </td>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-dark"> <?php echo $requestDetail['DESCRIPTION'];?> &nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-grey-salsa"> Transfer fee </p>
                                    </td>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-dark"> AFT Fee  <?php echo $fromUserData['CURRENCY_TITLE'].'  '.$requestDetail['TRANSACTION_FEE'];?> &nbsp;</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border-bottom: 0px !important; vertical-align: top !important;">
                                        <p class="font-grey-salsa" > Additional fee </p>
                                    </td>
                                    <td style="border-bottom: 0px !important;">
                                        <?php
                                            $additionData = $requestDetail['ADDITIONAL_FEE_JSON'];
                                            if($additionData != "") {
                                                $additionJson = json_decode($additionData);
                                                for ($index = 0; $index < count($additionJson);$index++):?>
                                                    <p class="font-dark" style="margin-bottom: 0px;">  <?php echo $fromUserData['CURRENCY_TITLE'].'  '.$additionJson[$index] ->fee;?> &nbsp;</p>
                                                    <p class="font-dark" > <?php echo $additionJson[$index]->desc;?> </p>
                                        <?php
                                                endfor;
                                            }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-grey-salsa"> Exchange Rate </p>
                                    </td>
                                    <td style="border-bottom: 0px !important;">
                                        <p class="font-dark"> 1 <?php echo ($fromUserData['CURRENCY_TITLE']);?> = <?php echo $requestDetail['CURRENCY_CALCED_RATE'];?> <?php echo $outgoingDetail[0]['currency'][0]['TITLE']; ?> </p>
                                    </td>
                                </tr>
                            </table>

                            <p class="col-sm-12 uppercase font-yellow-gold"> Debit from account </p>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> account number </p>
                                <p class="col-sm-6 "> <?php echo $toUserData['ACCOUNT_NUMBER'];?></p>
                            </div>
                            <p class="col-sm-12 uppercase font-yellow-gold"> Specify Beneficiary bank  </p>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Swift/bic </p>
                                <p class="col-sm-6"> <?php echo $outgoingDetail[0]['BANK_SWIFT_BIC'];?> </p>
                            </div>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Name </p>
                                <p class="col-sm-6"> <?php echo $outgoingDetail[0]['BANK_NAME'];?> </p>
                            </div>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Address </p>
                                <p class="col-sm-6"> <?php echo $outgoingDetail[0]['BANK_ADDRESS'];?> </p>
                            </div>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Location </p>
                                <p class="col-sm-6"> <?php echo "".$outgoingDetail[0]['BANK_LOCATION'];?> </p>
                            </div>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Country </p>
                                <p class="col-sm-6"> <?php
                                    for($i  = 0 ; $i < count($countryList) ; $i++) {
                                        if($countryList[$i]['ID'] == $outgoingDetail[0]['BANK_COUNTRY']) {
                                            echo $countryList[$i]['DESCRIPTION'];
                                            break;
                                        }
                                    }
                                    ?> </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">


                            <p class="col-md-12 uppercase font-yellow-gold"> Specify Beneficiary customer  </p>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Name </p>
                                <p class="col-md-6"> <?php echo $outgoingDetail[0]['CUSTOMER_NAME'];?> </p>
                            </div>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Address </p>
                                <p class="col-md-6"> <?php echo $outgoingDetail[0]['CUSTOMER_ADDRESS'];?> </p>
                            </div>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Acc/Bin </p>
                                <p class="col-md-6"> <?php echo $outgoingDetail[0]['CUSTOMER_IBAN'];?> </p>
                            </div>
                            <p class="col-md-12 uppercase font-yellow-gold"> Additional Information </p>
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Ref.Message </p>
                                <p class="col-md-6"> <?php echo $outgoingDetail[0]['REF_MESSAGE'];?> </p>
                            </div>
                            <p class="col-md-12 uppercase font-yellow-gold"> SPECIFY INTERMEDIARY BANK </p>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> SWIFT / BIC </p>
                                <p class="col-md-6"> <?php echo " ".$outgoingDetail[0]['INTER_SWIFT'];?> </p>
                            </div>

                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Name </p>
                                <p class="col-md-6"> <?php echo " ".$outgoingDetail[0]['INTER_NAME'];?> </p>
                            </div>

                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Address </p>
                                <p class="col-md-6"> <?php echo " ".$outgoingDetail[0]['INTER_ADDR'];?> </p>
                            </div>

                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Location </p>
                                <p class="col-md-6"> <?php echo " ".$outgoingDetail[0]['INTER_LOCATION'];?> </p>
                            </div>

                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> Country </p>
                                <p class="col-md-6"> <?php
                                    if($outgoingDetail[0]['INTER_COUNTRY'] > 0)
                                        for($i  = 0 ; $i < count($countryList) ; $i++) {
                                            if($countryList[$i]['ID'] == $outgoingDetail[0]['INTER_COUNTRY']) {
                                                echo $countryList[$i]['DESCRIPTION'];
                                                break;
                                            }
                                        }

                                    ?> </p>
                            </div>

                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> ABA/RTN </p>
                                <p class="col-md-6"> <?php echo " ".$outgoingDetail[0]['INTER_ABA_RTN'];?> </p>
                            </div>

                            <div class="col-sm-12">
                                <p class="col-md-4 uppercase font-grey-salsa"> ACC#/IBAN </p>
                                <p class="col-md-6"> <?php echo " ".$outgoingDetail[0]['INTER_IBAN'];?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="../transfer_view" class="btn yellow-gold btn-outline"> Back to List </a>
                        <?php if($requestDetail['STATUS'] < 4){?>
                            <a href="../execute/<?php echo $requestDetail['ID'];?>" class="btn yellow-gold "> Execute </a>
                        <?php }?>
                    </div>
                    <div class="col-sm-6">
                        <?php if($requestDetail['STATUS'] < TRANSFER_CANCELLED ){?>
                        <form class="form-inline" role="form" method="post" action="<?php echo base_url();?>admin/request/cancel/<?php echo $requestDetail['ID'];?>">
                                <div class="col-sm-8 form-group">
                                    <label class="sr-only" for="txtCancelContent"> Reason for cancellation </label>
                                    <input type="text" style="width: 100%;" class="col-sm-12 form-control" id="txtCancelContent" name="txtCancelContent" placeholder="Reason for cancellation...">
                                </div>
                                <button  type="submit" class="btn yellow-gold "> Cancel </button>
                        </form>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>