<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('ConvertResultToDataToBeDisplayed')) {
    function ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $result){
        $dataToBeDisplayed['create_revenue'] = $result['create_revenue'];
        $dataToBeDisplayed['result'] = $result['result'];
        $dataToBeDisplayed['currencypair'] = $result['currencypair'];
        $dataToBeDisplayed['show_alert'] = $result['show_alert'];
        $dataToBeDisplayed['aml'] = $result['aml'];
        return $dataToBeDisplayed;
    }


}
