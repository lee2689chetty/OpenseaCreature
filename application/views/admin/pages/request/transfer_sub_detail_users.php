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
                                <td style="border-bottom: 0px !important;">
                                    <p class="font-grey-salsa"> Exchange Rate </p>
                                </td>
                                <td style="border-bottom: 0px !important;">
                                    <p class="font-dark"> 1 <?php echo ($fromUserData['CURRENCY_TITLE']);?> = <?php echo $requestDetail['CURRENCY_CALCED_RATE'];?> <?php echo $toUserData['CURRENCY_TITLE']; ?> </p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <p class="col-sm-12 uppercase font-yellow-gold"> Debit from account </p>
                            <p class="col-md-4 uppercase font-grey-salsa"> account number </p>
                            <p class="col-sm-6 "> <?php echo $fromUserData['ACCOUNT_NUMBER'];?> </p>

                            <p class="col-sm-12 uppercase font-yellow-gold"> Credit to user </p>
                            <p class="col-md-4 uppercase font-grey-salsa"> User Name </p>
                            <p class="col-sm-6"> <?php echo $toUserData['USER_NAME'];?>  </p>
                            <p class="col-md-4 uppercase font-grey-salsa"> Account Number </p>
                            <p class="col-sm-6"> <?php echo $toUserData['ACCOUNT_NUMBER'];?> </p>
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