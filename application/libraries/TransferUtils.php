<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: zeus
 * Date: 6/24/2018
 * Time: 9:42 PM
 */
class TransferUtils
{
    protected $CI;
    const AML_AMOUNT_DURATION_VALUE = 60 * 60 * 24 * 7;
    function __construct()
    {
        $this->CI =& get_instance();
    }

    public function transferToCard($amount, $description, $fee, $fromAccountModel, $toAccountModel, $toRevenueModel)
    {
        $retVal = array();
        $retVal['result'] = false;
        $retVal['show_alert'] = false;

        $fromAccountModel = $this->CI->Account_model->FindAccountByArray(array('a.ID' => $fromAccountModel[0]['ID']));
        $insertArray = array(
            'USER_ID' => $fromAccountModel[0]['USER_ID'],
            'TO_USER_ID' => $toAccountModel[0]['USER_ID'],
            'TRANSACTION_TYPE' => Card_Funding_Transfer,
            'AMOUNT' => $amount,
            'FROM_ACCOUNT' => $fromAccountModel[0]['ID'],
            'TO_ACCOUNT' => $toAccountModel[0]['ID'],
            'OUTGOING_WIRE_INDEX' => '0',
            'HIDDEN_FEE_IN_RATE' => '0',
            'DESCRIPTION' => $description,
            'TRANSACTION_FEE' => $fee,
            'CURRENCY_CALCED_RATE' => 1,
            'STATUS' => TRANSFER_AWAITING_APPROVAL,
            'FROM_AVAILABLE_BALANCE' => $fromAccountModel[0]['AVAILABLE_AMOUNT'] - ($amount + $fee),
            'TO_AVAILABLE_BALANCE' => $toAccountModel[0]['AVAILABLE_AMOUNT'],
            'FROM_CURRENT_BALANCE' => $fromAccountModel[0]['CURRENT_AMOUNT'],
            'TO_CURRENT_BALANCE' => $toAccountModel[0]['CURRENT_AMOUNT'],
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()
        );
        $resultInsert = $this->CI->TransferHistory_model->InsertTransferHistory($insertArray);
        if($resultInsert > 0)
        {
            $this->CI->Account_model->UpdateAvailableBalance(false, $fromAccountModel[0]['ID'], $amount + $fee);
            $this->CI->TransferHistoryDetail_model->InsertRequestHistoryByStatus($resultInsert, $fromAccountModel, $toAccountModel, $toRevenueModel, $toRevenueModel, $amount, 1, $fee);
            $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultInsert, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
            $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultInsert, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));

            $this->CI->Notification_model->InsertNewNotification(array( 'USER_ID' => $fromAccountModel[0]['USER_ID'],
                'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE,
                'LINK_ID' => $resultInsert,
                'CONTENT' => ''.Card_Funding_Transfer,
                'USER_CHECK' => 0,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()));

            $retVal['result'] = true;
        }
        else
        {
            $retVal['show_alert'] = true;
        }
        return $retVal;
    }

    public function MakeOutgoingWithFixedValue($bankHistoryId, $fromAccountModel, $transferAmount, $transferCurrencyType, $vpayRate, $calcedRate, $description, $fee, $totalFee, $additionJsonString) {
        $retVal = array();
        $retVal['currencypair'] = false;
        $retVal['create_revenue'] = false;
        $retVal['result'] = false;
        $retVal['show_alert'] = false;
        $retVal['aml'] = false;

        $revenueForCCR = $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $transferCurrencyType));
        $revenueForFee = $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE']));
        if(count($revenueForFee) == 0 || count($revenueForCCR) == 0)
        {
            $retVal['create_revenue'] = true;
        }
        else {
            // check if transfer is aml or not
            // check transfer location is restricted area
            $outGoingHistory = $this->CI->TransferHistory_model->GetOutgingHistory(array('ID' => $bankHistoryId));

            $toBankCountryExist = $this->CI->AML_model->isCountryExist($outGoingHistory[0]['BANK_COUNTRY']);
            $fromUserInRestrictArea = $this->isUserInRestrictCountry($fromAccountModel[0]['PROFILE_ID']);

            $isAML_Location = $toBankCountryExist && $fromUserInRestrictArea;

            $oneWeekTransList = $this->CI->TransferHistory_model->GetTransactionsArrayList(
                array(
                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'IS_AML_PASSED' => '0',
                    'TRANSACTION_TYPE>'=>Transfer_Between_Accounts,
                    'TRANSACTION_TYPE<' => Card_Funding_Transfer,
//                    'TRANSACTION_TYPE' => Outgoing_Wire_Transfer,
                    'STATUS<>' => TRANSFER_CANCELLED,
                    'CREATED_AT>' =>(time() - $this::AML_AMOUNT_DURATION_VALUE)));//1 week ago
            $isAML_Amount = $this->isExceedTransferAmount($oneWeekTransList, $transferAmount, $outGoingHistory[0]['BANK_COUNTRY']);

            $feeInRate = ($vpayRate - $calcedRate) * $transferAmount;

            $insertArray = array(
                'USER_ID' => $fromAccountModel[0]['USER_ID'],
                'TO_USER_ID' => '0',
                'TRANSACTION_TYPE' => Outgoing_Wire_Transfer,
                'AMOUNT' => $transferAmount,
                'FROM_ACCOUNT' => $fromAccountModel[0]['ID'],
                'TO_ACCOUNT' => '0',
                'OUTGOING_WIRE_INDEX' => $bankHistoryId,
                'DESCRIPTION' => $description,
                'HIDDEN_FEE_IN_RATE' => $feeInRate,
                'TRANSACTION_FEE' => $fee,
                'CURRENCY_CALCED_RATE' => $calcedRate,
                'FROM_AVAILABLE_BALANCE' => $fromAccountModel[0]['AVAILABLE_AMOUNT'] - ($transferAmount + $totalFee),
                'TO_AVAILABLE_BALANCE' => '0',
                'FROM_CURRENT_BALANCE' => $fromAccountModel[0]['CURRENT_AMOUNT'],
                'TO_CURRENT_BALANCE' => '0',
                'STATUS' => $isAML_Amount||$isAML_Location ? TRANSFER_SUSPENDED : TRANSFER_AWAITING_APPROVAL,
                'ADDITIONAL_FEE' => $totalFee - $fee,
                'ADDITIONAL_FEE_JSON' => $additionJsonString,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()
            );
            
            $resultHistoryInsert = $this->CI->TransferHistory_model->InsertTransferHistory($insertArray);
            if ($resultHistoryInsert > 0) {

                if($isAML_Amount) {
                    $insertedAMLRecord = $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $resultHistoryInsert, 
                        'REASON' => '0',
                        'STATUS' => '0', 
                        'UPDATED_AT' => time(), 
                        'CREATED_AT' => time()));
                    for ($idx = 0; $idx < count($oneWeekTransList); $idx++) {
                        $this->CI->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => TRANSFER_SUSPENDED, 'UPDATED_AT' => time()), array('ID' => $oneWeekTransList[$idx]['ID']));
                        $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $oneWeekTransList[$idx]['ID'], 'STATUS_ID' => TRANSFER_SUSPENDED, 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                        $this->CI->AML_model->InsertNewRelatedAMLRecord(array('TRANS_ID' => $oneWeekTransList[$idx]['ID'], 'PARENT_ID' => $insertedAMLRecord, 'STATUS' => '0', 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                    }
                }
                else if($isAML_Location) {
                    $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $resultHistoryInsert,
                        'REASON' => '1',
                        'STATUS' => '0',
                        'UPDATED_AT' => time(),
                        'CREATED_AT' => time()));
                }

                $this->CI->Account_model->UpdateAvailableBalance(false, $fromAccountModel[0]['ID'], $transferAmount + $totalFee);

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
                    'AMOUNT' => $transferAmount,
                    'DETAIL_TYPE' => DETAIL_DEBIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => 0,
                    'ACCOUNT_ID' => 0,
                    'AMOUNT' => $transferAmount * $calcedRate,
                    'DETAIL_TYPE' => DETAIL_CREDIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
                    'AMOUNT' => ($fee),
                    'DETAIL_TYPE' => DETAIL_DEBIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => '1',
                    'ACCOUNT_ID' => $revenueForFee[0]['ID'],
                    'AMOUNT' => ($fee),
                    'DETAIL_TYPE' => DETAIL_CREDIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                if($feeInRate > 0)
                {
                    $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                        'USER_ID' => '1',
                        'ACCOUNT_ID' => $revenueForCCR[0]['ID'],
                        'AMOUNT' => ($feeInRate),
                        'DETAIL_TYPE' => DETAIL_CREDIT,
                        'UPDATED_AT' => time(),
                        'CREATED_AT' => time()));
                }

                if($additionJsonString != "") {
                    $jsonAdditionFee = json_decode($additionJsonString);
                    for($idx = 0 ; $idx < count($jsonAdditionFee) ; $idx ++) {
                        $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                            'USER_ID' => $fromAccountModel[0]['USER_ID'],
                            'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
                            'AMOUNT' => $jsonAdditionFee[$idx] -> fee,
                            'DETAIL_TYPE' => DETAIL_DEBIT,
                            'UPDATED_AT' => time(),
                            'CREATED_AT' => time()));

                        $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                            'USER_ID' => '1',
                            'ACCOUNT_ID' => $revenueForFee[0]['ID'],
                            'AMOUNT' => $jsonAdditionFee[$idx] -> fee,
                            'DETAIL_TYPE' => DETAIL_CREDIT,
                            'UPDATED_AT' => time(),
                            'CREATED_AT' => time()));
                    }
                }

                $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));

                if($isAML_Location || $isAML_Amount) {
                    $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_SUSPENDED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                }
                
                $this->CI->Notification_model->InsertNewNotification(array( 'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE,
                    'LINK_ID' => $resultHistoryInsert,
                    'CONTENT' => ''.Outgoing_Wire_Transfer,
                    'USER_CHECK' => 0,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $retVal['result'] = true;
                $retVal['aml'] = $isAML_Location || $isAML_Amount;
            }
            else {
                $retVal['show_alert'] = true;
            }
        }

        return $retVal;
    }

    public function MakeOutgoingTransfer($bankHistoryId, $fromAccountModel, $transferAmount, $description, $fee){
        $retVal = array();
        $retVal['currencypair'] = false;
        $retVal['create_revenue'] = false;
        $retVal['result'] = false;
        $retVal['show_alert'] = false;
        $toRevenueModel = $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE']));
        if($toRevenueModel == NULL || count($toRevenueModel) == 0)
        {
            $retVal['create_revenue'] = true;
        }
        else {
            //insert outgoing transfer history
            //add outgoing detail, status history
            $fromAccountModel = $this->CI->Account_model->FindAccountByArray(array('a.ID' => $fromAccountModel[0]['ID']));

            $insertArray = array(
                'USER_ID' => $fromAccountModel[0]['USER_ID'],
                'TO_USER_ID' => '0',
                'TRANSACTION_TYPE' => Outgoing_Wire_Transfer,
                'AMOUNT' => $transferAmount,
                'FROM_ACCOUNT' => $fromAccountModel[0]['ID'],
                'TO_ACCOUNT' => '0',
                'OUTGOING_WIRE_INDEX' => $bankHistoryId,
                'DESCRIPTION' => $description,
                'TRANSACTION_FEE' => $fee,
                'CURRENCY_CALCED_RATE' => 1,
                'FROM_AVAILABLE_BALANCE' => $fromAccountModel[0]['AVAILABLE_AMOUNT'] - ($transferAmount + $fee),
                'TO_AVAILABLE_BALANCE' => '0',
                'FROM_CURRENT_BALANCE' => $fromAccountModel[0]['CURRENT_AMOUNT'],
                'TO_CURRENT_BALANCE' => '0',
                'STATUS' => TRANSFER_AWAITING_APPROVAL,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()
            );
            $resultHistoryInsert = $this->CI->TransferHistory_model->InsertTransferHistory($insertArray);
            if ($resultHistoryInsert > 0) {
                $this->CI->Account_model->UpdateAvailableBalance(false, $fromAccountModel[0]['ID'], $transferAmount + $fee);
                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
                    'AMOUNT' => $transferAmount,
                    'DETAIL_TYPE' => DETAIL_DEBIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => 0,
                    'ACCOUNT_ID' => 0,
                    'AMOUNT' => $transferAmount,
                    'DETAIL_TYPE' => DETAIL_CREDIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
                    'AMOUNT' => $fee,
                    'DETAIL_TYPE' => DETAIL_DEBIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetail_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert,
                    'USER_ID' => '1',
                    'ACCOUNT_ID' => $toRevenueModel[0]['ID'],
                    'AMOUNT' => $fee,
                    'DETAIL_TYPE' => DETAIL_CREDIT,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->Notification_model->InsertNewNotification(array( 'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE,
                    'LINK_ID' => $resultHistoryInsert,
                    'CONTENT' => ''.Outgoing_Wire_Transfer,
                    'USER_CHECK' => 0,
                    'UPDATED_AT' => time(),
                    'CREATED_AT' => time()));

                $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                $retVal['result'] = true;
            }
            else
            {
                $retVal['show_alert'] = true;
            }
        }
        return $retVal;
    }

    public function MakeTransferHistory($fromAccountModel, $toAccountModel, $toRevenueModelForFee, $toRevenueModelForCCR, $transferAmount, $transferDesc, $hiddenFeeValue, $feeAmount, $calcConversionRate, $transferType = Transfer_Between_Accounts, $isAML = false)
    {
        $insertArray = array(
            'USER_ID' => $fromAccountModel[0]['USER_ID'],
            'TO_USER_ID' => $toAccountModel[0]['USER_ID'],
            'TRANSACTION_TYPE' => $transferType,
            'AMOUNT' => $transferAmount,
            'FROM_ACCOUNT' => $fromAccountModel[0]['ID'],
            'TO_ACCOUNT' => $toAccountModel[0]['ID'],
            'OUTGOING_WIRE_INDEX' => '0',
            'DESCRIPTION' => $transferDesc,
            'HIDDEN_FEE_IN_RATE' => $hiddenFeeValue,
            'TRANSACTION_FEE' => $feeAmount,
            'CURRENCY_CALCED_RATE' => $calcConversionRate,
            'STATUS' => $isAML ? TRANSFER_SUSPENDED : TRANSFER_AWAITING_APPROVAL,
            'FROM_AVAILABLE_BALANCE' => $fromAccountModel[0]['AVAILABLE_AMOUNT']- ($transferAmount + $feeAmount),
            'TO_AVAILABLE_BALANCE' => $toAccountModel[0]['AVAILABLE_AMOUNT'] ,
            'FROM_CURRENT_BALANCE' => $fromAccountModel[0]['CURRENT_AMOUNT'],
            'TO_CURRENT_BALANCE' => $toAccountModel[0]['CURRENT_AMOUNT'],
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()
        );

        $resultInsert = $this->CI->TransferHistory_model->InsertTransferHistory($insertArray);
        if ($resultInsert > 0) {
            $this->CI->Account_model->UpdateAvailableBalance(false, $fromAccountModel[0]['ID'], $transferAmount + $feeAmount);
            $this->CI->TransferHistoryDetail_model->InsertRequestHistoryByStatus($resultInsert, $fromAccountModel, $toAccountModel, $toRevenueModelForFee, $toRevenueModelForCCR, $transferAmount, $calcConversionRate, $feeAmount, $hiddenFeeValue);
            $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultInsert, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
            $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultInsert, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
            if($isAML)
            {
                $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultInsert, 'STATUS_ID' => TRANSFER_SUSPENDED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
            }

            $this->CI->Notification_model->InsertNewNotification(array( 'USER_ID' => $fromAccountModel[0]['USER_ID'],
                'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE,
                'LINK_ID' => $resultInsert,
                'CONTENT' => ''.$transferType,
                'USER_CHECK' => 0,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()));
        }
        return $resultInsert;
    }

    public function GetValorPayRate($fromAccountCurrency, $toAccountCurrency) {
        if(intval($fromAccountCurrency) != intval($toAccountCurrency)) {
            $feeInfoArray = $this->CI->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_PAIR, array('BASE_CURRENCY_ID' => $fromAccountCurrency, 'SECONDARY_CURRENCY_ID' => $toAccountCurrency));
            if(count($feeInfoArray) == 0)
                return -1;
            return $feeInfoArray[0]['VALOR_PAY_RATE'];
        }
        else {
            return 1;
        }
    }

    public function MakeOutgoingBankHistory($swiftbic, $bankname, $bankaddress, $banklocation, $bankcountry, $abartn, $customername, $customeraddress, $customeriban,$additionaddr, $intermediatrybankInt, $interSwift,
                                            $interName, $interAddress, $interLocation, $interCountry, $interABA, $interACC,$transferCurrency ){
        $insertArrayOutgoing = array("BANK_SWIFT_BIC"=>$swiftbic,
            "BANK_NAME" => $bankname,
            "BANK_ADDRESS" => $bankaddress,
            "BANK_LOCATION" => $banklocation,
            "BANK_COUNTRY" => $bankcountry,
            "BANK_ABA" => $abartn,
            "CUSTOMER_NAME" => $customername,
            "CUSTOMER_ADDRESS" => $customeraddress,
            "CUSTOMER_IBAN" => $customeriban,
            "REF_MESSAGE" => $additionaddr,
            "SPCIFY_INTERMEDIARY_BANK" => $intermediatrybankInt,
            "INTER_SWIFT" => $interSwift,
            "INTER_NAME" => $interName,
            "INTER_ADDR" => $interAddress,
            "INTER_LOCATION" => $interLocation,
            "INTER_COUNTRY" => $interCountry,
            "INTER_ABA_RTN" => $interABA,
            "INTER_IBAN" => $interACC,
            "CURRENCY_TYPE" => $transferCurrency,
            "UPDATED_AT" => time(),
            "CREATED_AT" => time()
        );
        $insertResult = $this->CI->TransferHistory_model->transferOutgoingWire($insertArrayOutgoing);
        return $insertResult;
    }

    public function TransferFromEWalletToVIBANEngine( $fromAccountModel, $toAccountModel, $amount, $description, $transType = Transfer_Between_Accounts)
    {
        $retVal = array();
        $retVal['calcConversionRate'] = 1;
        $retVal['feeAmount'] = 0;
        $retVal['create_revenue'] = false;
        $retVal['show_alert'] = false;
        $retVal['result'] = false;
        $retVal['currencypair'] = false;
        $retVal['aml'] = false;
        $revenueForCCR = $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE']));
        $revenueForFee= $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE']));
        if(count($revenueForCCR) == 0 || count($revenueForFee) == 0) {
            $retVal['create_revenue'] = true;
        }
        else {
            $retVal['calcConversionRate'] = 1;
            $retVal['feeAmount'] = 0;
            if($transType == Transfer_Between_Users) {
                if($this->isUserInRestrictCountry($toAccountModel[0]['PROFILE_ID']) || $this->isUserInRestrictCountry($fromAccountModel[0]['PROFILE_ID'])) {
                    $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], 0, $retVal['calcConversionRate'], $transType, true);
                    $retVal['show_alert'] = !($insertResult > 0);
                    $retVal['result'] = ($insertResult > 0);
                    $retVal['aml'] = true;

                    //here is aml transaction for restrict area
                    $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $insertResult, 'REASON' => '1', 'STATUS' => '0', 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                    return $retVal;
                }

                $oneWeekTransList = $this->CI->TransferHistory_model->GetTransactionsArrayList(
                                                                                                array(
                                                                                                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                                                                                                    'IS_AML_PASSED' => '0',
                                                                                                    'STATUS<>' => TRANSFER_CANCELLED,
                                                                                                    'TRANSACTION_TYPE>'=>Transfer_Between_Accounts,
                                                                                                    'TRANSACTION_TYPE<' => Card_Funding_Transfer,
                                                                                                    'CREATED_AT>' =>(time() - $this::AML_AMOUNT_DURATION_VALUE)));//1 week ago
                $toCountryId = $this->getCountryIdFromAccountModel($toAccountModel);

                if ($this->isExceedTransferAmount($oneWeekTransList, $amount, $toCountryId)) {
                    $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], 0, $retVal['calcConversionRate'], $transType, true);
                    $retVal['show_alert'] = !($insertResult > 0);
                    $retVal['result'] = ($insertResult > 0);
                    $retVal['aml'] = true;
                    $insertedAMLRecord = $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $insertResult, 'REASON' => '0', 'STATUS' => '0', 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                    for ($idx = 0; $idx < count($oneWeekTransList); $idx++) {
                        $this->CI->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => TRANSFER_SUSPENDED, 'UPDATED_AT' => time()), array('ID' => $oneWeekTransList[$idx]['ID']));
                        $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $oneWeekTransList[$idx]['ID'], 'STATUS_ID' => TRANSFER_SUSPENDED, 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                        $this->CI->AML_model->InsertNewRelatedAMLRecord(array('TRANS_ID' => $oneWeekTransList[$idx]['ID'], 'PARENT_ID' => $insertedAMLRecord, 'STATUS' => '0', 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                    }
                    return $retVal;
                }
            }

            $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], 0, $retVal['calcConversionRate'], $transType);

            $retVal['show_alert'] = !($insertResult > 0);
            $retVal['result'] = ($insertResult > 0);
        }
        return $retVal;
    }

    private function getCountryIdFromAccountModel($accountModel) {
        $fromUserProfile = $this->CI->ProfileInfo_model->GetProfileInfoByArray(array('ID' => $accountModel[0]['PROFILE_ID']));
        if(count($fromUserProfile) > 0) {
            return intval($fromUserProfile[0]['COUNTRY_INDEX']);
        }
        return 0;
    }

    public function isExceedTransferAmount($oneWeekTransList, /*$fromAccountModel,*/ $amount, $toCountryId) {

//        $fromUserProfile = $this->CI->ProfileInfo_model->GetProfileInfoByArray(array('ID' => $fromAccountModel[0]['PROFILE_ID']));
//        if(count($fromUserProfile) > 0) {
//            if(intval($fromUserProfile[0]['COUNTRY_INDEX']) > 0) {
                $defaultTransferLimitValue = 15000;
                $limitTransferArray = $this->CI->AML_model->getThresholdByArray(array('COUNTRY_ID' => $toCountryId));/*$fromUserProfile[0]['COUNTRY_INDEX']));*/
                if(count($limitTransferArray) > 0) {
                    if($limitTransferArray[0]['THRESHOLD_AMOUNT'] != 0)
                        $defaultTransferLimitValue = $limitTransferArray[0]['THRESHOLD_AMOUNT'];
                }

                $sumTotalForOneWeek = 0;
                for($idx = 0 ; $idx < count($oneWeekTransList) ; $idx++) {
                    $sumTotalForOneWeek += $oneWeekTransList[$idx]['AMOUNT'];
                }

                if(/*$limitTransferArray[0]['THRESHOLD_AMOUNT'] != 0 && doubleval($limitTransferArray[0]['THRESHOLD_AMOUNT'])*/$defaultTransferLimitValue < (doubleval($sumTotalForOneWeek) + doubleval($amount))) {
                    return true;
                }
//            }
//        }
        return false;
    }

    public function isUserInRestrictCountry($userProfileId) {
        $toUserProfile = $this->CI->ProfileInfo_model->GetProfileInfoByArray(array('ID' => $userProfileId));
        if(count($toUserProfile) > 0) {
            if($this->CI->AML_model->isCountryExist($toUserProfile[0]['COUNTRY_INDEX'])) {
                return true;
            }
        }
        return false;
    }

    function MakeFeeValueByMinMax($amount, $min, $max){
        if($min > 0 && $amount < $min) return $min;
        if($max > 0 && $amount > $max) return $max;
        return $amount;
    }

    public function TransferFromEWalletToEWalletEngine($fromAccountModel,$toAccountModel, $amount, $description, $transType = Transfer_Between_Accounts, $transFee = 0)
    {
        $retVal = array();
        $retVal['calcConversionRate'] = 0;
        $retVal['feeAmount'] = 0;
        $retVal['currencypair'] = false;
        $retVal['create_revenue'] = false;
        $retVal['show_alert'] = false;
        $retVal['result'] = false;
        $retVal['aml'] = false;
        $revenueForCCR = $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE']));
        $revenueForFee = $this->CI->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE']));
        if(count($revenueForFee) == 0 || count($revenueForCCR) == 0){
            $retVal['create_revenue'] = true;
            $retVal['calcConversionRate'] = 0;
        }
        else {
            if($fromAccountModel[0]['CURRENCY_TYPE'] != $toAccountModel[0]['CURRENCY_TYPE']){
                $this->CI->load->library('CurrencyCalcUtils');
                $valorPayRate = $this->GetValorPayRate($fromAccountModel[0]['CURRENCY_TYPE'], $toAccountModel[0]['CURRENCY_TYPE']);
                if($valorPayRate < 0) {
                    $retVal['currencypair'] = true;
                }
                else {
                    $currencyConversionRate = $fromAccountModel[0]['CURRENCY_CONVERSION_RATE'];
                    $retVal['calcConversionRate'] = $this->CI->currencycalcutils->Calculation_CurrencyRate($amount, $currencyConversionRate, $valorPayRate);
                    $calcFee = ($valorPayRate - $retVal['calcConversionRate']) * $amount;//self::MakeFeeValueByMinMax($currencyConversionRate * $amount / 100, );
                    $retVal['feeAmount'] = $calcFee;// it is ccr fee
                    if ($transType == Transfer_Between_Users) {
                        if ($this->isUserInRestrictCountry($toAccountModel[0]['PROFILE_ID'])) {
                            $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], $transFee, $retVal['calcConversionRate'], $transType, true);
                            $retVal['show_alert'] = !($insertResult > 0);
                            $retVal['result'] = ($insertResult > 0);
                            $retVal['aml'] = true;

                            $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $insertResult, 'REASON' => '1', 'STATUS' => '0', 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                            return $retVal;
                        }

                        $oneWeekTransList = $this->CI->TransferHistory_model->GetTransactionsArrayList(array(
                                                                                                        'USER_ID' => $fromAccountModel[0]['USER_ID'],
                                                                                                        'IS_AML_PASSED' => '0',
                                                                                                        'STATUS<>' => TRANSFER_CANCELLED,
                                                                                                        'TRANSACTION_TYPE>'=>Transfer_Between_Accounts,
                                                                                                        'TRANSACTION_TYPE<' => Card_Funding_Transfer,
                                                                                                        'CREATED_AT>' =>(time() - $this::AML_AMOUNT_DURATION_VALUE)));//1 week ago
                        $toCountryId = $this->getCountryIdFromAccountModel($toAccountModel);
                        if ($this->isExceedTransferAmount($oneWeekTransList, $amount, $toCountryId)) {
                            $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], 0, $retVal['calcConversionRate'], $transType, true);
                            $retVal['show_alert'] = !($insertResult > 0);
                            $retVal['result'] = ($insertResult > 0);
                            $retVal['aml'] = true;
                            $insertedAMLRecord = $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $insertResult, 'REASON' => '0', 'STATUS' => '0', 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                            for ($idx = 0; $idx < count($oneWeekTransList); $idx++) {
                                $this->CI->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => TRANSFER_SUSPENDED, 'UPDATED_AT' => time()), array('ID' => $oneWeekTransList[$idx]['ID']));
                                $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $oneWeekTransList[$idx]['ID'], 'STATUS_ID' => TRANSFER_SUSPENDED, 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                                $this->CI->AML_model->InsertNewRelatedAMLRecord(array('TRANS_ID' => $oneWeekTransList[$idx]['ID'], 'PARENT_ID' => $insertedAMLRecord, 'STATUS' => '0', 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                            }
                            return $retVal;
                        }
                    }
                    $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], $transFee, $retVal['calcConversionRate'], $transType, false);
                    $retVal['aml'] = false;
                    $retVal['show_alert'] = !($insertResult > 0);
                    $retVal['result'] = ($insertResult > 0);
                }
            }
            else {
                $retVal['calcConversionRate'] = 1;
                $retVal['feeAmount'] = 0;
                if($transType == Transfer_Between_Users)
                {
                    if($this->isUserInRestrictCountry($toAccountModel[0]['PROFILE_ID'])) {
                        $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], $transFee, $retVal['calcConversionRate'], $transType, true);
                        $retVal['aml'] = true;
                        $retVal['show_alert'] = !($insertResult > 0);
                        $retVal['result'] = ($insertResult > 0);
                        $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $insertResult, 'REASON' => '1', 'STATUS' => '0', 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                        return $retVal;
                    }


                    $oneWeekTransList = $this->CI->TransferHistory_model->GetTransactionsArrayList(array(
                                                                                                        'USER_ID' => $fromAccountModel[0]['USER_ID'],
                                                                                                        'IS_AML_PASSED' => '0',
                                                                                                        'STATUS<>' => TRANSFER_CANCELLED,
                                                                                                        'TRANSACTION_TYPE>'=>Transfer_Between_Accounts,
                                                                                                        'TRANSACTION_TYPE<' => Card_Funding_Transfer,
                                                                                                        'CREATED_AT>' =>(time() - $this::AML_AMOUNT_DURATION_VALUE)));//1 week ago
                    $toCountryId = $this->getCountryIdFromAccountModel($toAccountModel);
                    if ($this->isExceedTransferAmount($oneWeekTransList, $amount, $toCountryId)) {
                        $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], 0, $retVal['calcConversionRate'], $transType, true);
                        $retVal['show_alert'] = !($insertResult > 0);
                        $retVal['result'] = ($insertResult > 0);
                        $retVal['aml'] = true;
                        $insertedAMLRecord = $this->CI->AML_model->InsertNewAMLRecord(array('TRANSACTION_ID' => $insertResult, 'REASON' => '0', 'STATUS' => '0', 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
                        for ($idx = 0; $idx < count($oneWeekTransList); $idx++) {
                            $this->CI->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => TRANSFER_SUSPENDED, 'UPDATED_AT' => time()), array('ID' => $oneWeekTransList[$idx]['ID']));
                            $this->CI->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $oneWeekTransList[$idx]['ID'], 'STATUS_ID' => TRANSFER_SUSPENDED, 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                            $this->CI->AML_model->InsertNewRelatedAMLRecord(array('TRANS_ID' => $oneWeekTransList[$idx]['ID'], 'PARENT_ID' => $insertedAMLRecord, 'STATUS' => '0', 'CREATED_AT' => time(), 'UPDATED_AT' => time()));
                        }
                        return $retVal;
                    }
                }

                $insertResult = $this->MakeTransferHistory($fromAccountModel, $toAccountModel, $revenueForFee, $revenueForCCR, $amount, $description, $retVal['feeAmount'], $transFee, $retVal['calcConversionRate'], $transType, false);
                $retVal['aml'] = false;
                $retVal['show_alert'] = !($insertResult > 0);
                $retVal['result'] = ($insertResult > 0);
            }
        }
        return $retVal;
    }

    public function GetAccountDetailInformationFromTransferHistory($userId, $accountId, $requestHistory_OutgoingId)
    {
        $userName = "";
        $accountNumber = "";
        $accountCurrency = "";
        if($userId == 0)
        {
            //outgoing bank
            $outGoingItem = $this->CI->TransferHistory_model->GetOutgingHistory(array('ID' => $requestHistory_OutgoingId));
            $userName = $outGoingItem[0]['BANK_SWIFT_BIC'];
            $accountNumber = $outGoingItem[0]['BANK_NAME'];
            $accountCurrency = "";
        }
        else if($userId < 0)
        {
            $userName = "Manual";
            $accountNumber = "Manual Transaction";
            $accountCurrency = "";
        }
        else if($userId == 1)
        {
            //it is revenue
            $revenueAccount = $this->CI->RevenueInfo_model->GetRevenueAccount(array('ID' => $accountId));
            $userName = "Administrator";
            $accountNumber = $revenueAccount[0]['REVENUE_NAME'];
            $accountCurrency = $revenueAccount[0]['CURRENCY_TITLE'];
        }
        else if($userId > 1)
        {
            //it is user account
            $accountInfo = $this->CI->Account_model->FindAccountByArray(array('a.ID' => $accountId));
            $userName = $accountInfo[0]['USER_FULLNAME'];
            $accountNumber = $accountInfo[0]['ACCOUNT_NUMBER'];
            $accountCurrency= $accountInfo[0]['CURRENCY_TITLE'];
        }
        $retVal = array('USER_NAME' => $userName, 'ACCOUNT_NUMBER' => $accountNumber, 'CURRENCY_TITLE' => $accountCurrency);
        return $retVal;
    }
}