<?php

/**
 * Created by PhpStorm.
 * User: zeus
 * Date: 5/15/18
 * Time: 12:55 AM
 */
class CurrencyCalcUtils
{
    public function Calculation_CurrencyRate($transferAmount, $currencyConversionRate, $valorPayRate)
    {
        $retVal = (($transferAmount-(($currencyConversionRate/100)*$transferAmount))*$valorPayRate)/$transferAmount;
        return $retVal;
    }
}