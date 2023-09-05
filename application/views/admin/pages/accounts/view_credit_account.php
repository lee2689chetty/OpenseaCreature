<?php echo $header;?>
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">


<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Card Accounts
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php foreach ($cards as $cardItem){?>
                                            <div class="panel col-md-4 md-shadow-z-3" style="border-radius: 5px; border-width:1px; border-color: #f1ecec; margin: 10px;">
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
                                                            <p class="margin-bottom-10 font-grey"> Valid Date</p>
                                                            <p class="font-lg"> <?php echo ($cardItem['CARD_EXP_YEAR'].'-'.$cardItem['CARD_EXP_MONTH']);?> </p>

                                                        </div>

                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="pull-left">
                                                                <p class="margin-bottom-10 font-grey"> Currency </p>
                                                                <p class="font-lg"> <?php echo $cardItem['CURRENCY_TITLE'];?> </p>
                                                            </div>
                                                            <div class="pull-right">
                                                                <i class="icon font-lg icon-credit-card"></i>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <p class="margin-bottom-10 font-grey"> Card Holder</p>
                                                            <p class="font-lg"> <?php echo $cardItem['CARD_HOLDER_NAME'];?> </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <p class="margin-bottom-10 font-grey"> Amount </p>
                                                            <p class="font-lg"> <?php echo number_format($cardItem['CURRENT_AMOUNT'], 2, '.', ',');?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer;?>
</body>

</html>