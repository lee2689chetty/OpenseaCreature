<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminReportController extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect(base_url().'admin/auth/login');
        }
        else if($this->session->userdata['me']['LEVEL']  == '4')
        {
            redirect(base_url().'auth/login');
        }
    }

    public function view($whichView)
    {
        $header_layout = $this->load->view('admin/template/header_layout', '', TRUE);
        $adminDataName = array('adminName' => $this->session->userdata['me']['NAME']);
        $dataToBeDisplayed['header'] = $header_layout;
        $topbar_layout = $this->load->view('admin/template/topbar_layout', $adminDataName, TRUE);
        $dataToBeDisplayed['topbar']  = $topbar_layout;
        $footer_layout = $this->load->view('admin/template/footer_layout', '', TRUE);
        $dataToBeDisplayed['footer'] = $footer_layout;

        $dataToBeDisplayed['accountList'] = $this->Account_model->FindAccountByArray();
        $dataToBeDisplayed['currencyList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $dataToBeDisplayed['feeTypeList'] = $this->Account_model->GetAccountTypeListByArray();
        $dataToBeDisplayed['userList'] = $this->User_model->FindUserByArray(array('LEVEL' => '4'));
        $dataToBeDisplayed['cardUserList'] = $this->Card_model->GetUserCardDetailInformation();
        $dataToBeDisplayed['notifyVerifyDocs'] = 5;

        $selectedMenu = array();
        $renderView = "";
        switch($whichView)
        {
            case 'specific_account':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_SPECIFIC_ACCOUNT);
                $renderView = 'admin/pages/report/view_specific_account';
                break;
            case 'specific_all_transaction':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_SPECIFIC_ALLTRANS);
                $renderView = 'admin/pages/report/view_specific_all_transactions';
                break;
            case 'specific_balance_report':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_SPECIFIC_BALANCE);
                $renderView = 'admin/pages/report/view_specific_balance';
                break;
            case 'system_alltrans':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_ALL);
                $renderView = 'admin/pages/report/view_system_all';
                break;
            case 'system_balance':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_BALANCES);
                $renderView = 'admin/pages/report/view_system_balance';
                break;
            case 'system_outgoing':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_OUTGOING);
                $renderView = 'admin/pages/report/view_system_outgoing';
                break;
            case 'system_cards':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_ALLCARDS);
                $renderView = 'admin/pages/report/view_system_cards';
                break;
            case 'system_manual':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_MANUALTRANS);
                $renderView = 'admin/pages/report/view_system_manual';
                break;
            case 'system_revenue':

                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_REVENUE);
                $renderView = 'admin/pages/report/view_system_revenue';
                break;
            case 'system_access':
                $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_ACCESSLOG);
                $renderView = 'admin/pages/report/view_system_access';
                break;
        }
        $sidebar_layout = $this->load->view('admin/template/sidebar_layout', $selectedMenu, TRUE);
        $dataToBeDisplayed['sidebar'] = $sidebar_layout;
        $this->load->view($renderView, $dataToBeDisplayed);
    }

    public function system_overview() {

        $header_layout = $this->load->view('admin/template/header_layout', '', TRUE);
        $adminDataName = array('adminName' => $this->session->userdata['me']['NAME']);
        $dataToBeDisplayed['header'] = $header_layout;
        $topbar_layout = $this->load->view('admin/template/topbar_layout', $adminDataName, TRUE);
        $dataToBeDisplayed['topbar']  = $topbar_layout;
        $footer_layout = $this->load->view('admin/template/footer_layout', '', TRUE);
        $dataToBeDisplayed['footer'] = $footer_layout;
        $selectedMenu = array('selectedMenu'=>MENU_REPORT_GENERAL_OVERVIEW);
        $renderView = 'admin/pages/report/view_system_overview';
        //profile overview
        $activeProfile = $this->ProfileInfo_model->GetProfileInfoByArray();
        $dataToBeDisplayed['ovActiveProfile'] = count($activeProfile);


        $startDate = $this->input->post('fromAllDate');
        $endDate = $this->input->post('toAllDate');
        $dataToBeDisplayed['startDate'] = $startDate;
        $dataToBeDisplayed['endDate'] = $endDate;

        $this->load->library('Stringutils');
        $startTimeStamp = $this->stringutils->GetUnixTimeStampFromString($startDate, FALSE);
        $endTimeStamp = $this->stringutils->GetUnixTimeStampFromString($endDate, TRUE);

        // deposits
        $ovCurrencyDeposit = $this->Account_model->GetCurrencyKind();
        $dataToBeDisplayed['ovCurrencyDeposit'] = $ovCurrencyDeposit;

        $feeTypes = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_FEE_INFO);
        for($i = 0 ; $i < count($feeTypes); $i++){
            //deposit array regarding to fee info and currency
            for($j = 0 ;$j < count($ovCurrencyDeposit); $j++){
                 $totalValue =  $this->Account_model->GetTotalBalanceByArray(array('CURRENCY_TYPE' => $ovCurrencyDeposit[$j]['CURRENCY_TYPE'],
                                                                                         'FEE_TYPE' => $feeTypes[$i]['ID']));
                 if(!isset($totalValue[0]['TOTAL_BALANCE'])) $totalValue[0]['TOTAL_BALANCE'] = '0.0000';
                $feeTypes[$i][$ovCurrencyDeposit[$j]['CURRENCY_TYPE']] = $totalValue;
            }
        }
        $dataToBeDisplayed['ovDepositContent'] = $feeTypes;//json_encode($feeTypes);
        //review account overview
        $ovCurrencyRevenue = $this->RevenueInfo_model->GetRevenueAccount();
        $dataToBeDisplayed['ovCurrencyRevenue'] = $ovCurrencyRevenue;


        //currency overview
        $totalBalance = array();
        $totalPending = array();
        $futureBalance = array();

        for($j = 0 ;$j < count($ovCurrencyDeposit); $j++) {
            $totalCurrentValue =  $this->Account_model->GetTotalBalanceByArray(array('CURRENCY_TYPE' => $ovCurrencyDeposit[$j]['CURRENCY_TYPE']));
            $totalAvailableValue = $this->Account_model->GetTotalAvailableByArray(array('CURRENCY_TYPE' => $ovCurrencyDeposit[$j]['CURRENCY_TYPE']));

            if(!isset($totalCurrentValue[0]['TOTAL_BALANCE'])) $totalCurrentValue[0]['TOTAL_BALANCE'] = '0.0000';
            if(!isset($totalAvailableValue[0]['TOTAL_BALANCE'])) $totalAvailableValue[0]['TOTAL_BALANCE'] = '0.0000';
            $totalPendingValue[0]['TOTAL_BALANCE'] = $totalCurrentValue[0]['TOTAL_BALANCE'] - $totalAvailableValue[0]['TOTAL_BALANCE'];

            $totalBalance[$ovCurrencyDeposit[$j]['CURRENCY_TYPE']] = $totalCurrentValue;
            $totalPending[$ovCurrencyDeposit[$j]['CURRENCY_TYPE']] = $totalPendingValue;
            // get future value
            // get transaction that is less than complete and get total amount of value + current value
            // available value + sum(transaction.target = me) = FUTURE VALUE
            $accountPerCurrency = $this->Account_model->GetAccountArrayByArray(array('CURRENCY_TYPE' => $ovCurrencyDeposit[$j]['CURRENCY_TYPE']));
            $futureIncomePerCurrency = $this->TransferHistory_model->GetTotalInComeAmount($accountPerCurrency);
            $futureBalance[$ovCurrencyDeposit[$j]['CURRENCY_TYPE']] = floatval($totalAvailableValue[0]['TOTAL_BALANCE']) + floatval($futureIncomePerCurrency);
        }

        $dataToBeDisplayed['covTotalBalance'] = $totalBalance;
        $dataToBeDisplayed['covTotalPending'] = $totalPending;
        $dataToBeDisplayed['covTotalFuture'] =  $futureBalance;

        $sidebar_layout = $this->load->view('admin/template/sidebar_layout', $selectedMenu, TRUE);
        $dataToBeDisplayed['sidebar'] = $sidebar_layout;
        $this->load->view($renderView, $dataToBeDisplayed);
    }

    public function SpecifiedAccountReport() {
        $accountId = $this->input->post('accountNumber');
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $resultAccountId = (!isset($accountId) || $accountId == "");
        if($resultAccountId == false)
        {
            $this->load->library('Stringutils');
            $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);
            $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);
            $historyTransaction = $this->TransferHistoryDetail_model->GetReportTransferDetailInformationByAccountId($accountId, $fromTimestamp, $toTimestamp);
            $dataToBeDisplayed['dataList'] = $historyTransaction;
            $accountData = $this->Account_model->FindAccountByArray(array('a.ID' => $accountId));
            $dataToBeDisplayed['accountData'] = $accountData;
        }
        else
        {
            $dataToBeDisplayed['dataList'] = array();
        }
        echo (json_encode($dataToBeDisplayed));
    }

    public function SpecifiedAllReport() {
        $userId = $this->input->post('userId');
        $fromDate = $this->input->post('fromDate');
        $filter = $this->input->post('allUserFilter');
        //0: all, 1: completed, 2: pending, 3: cancelled

        $toDate = $this->input->post('toDate');
        $this->load->library('Stringutils');
        $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);
        $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);

        $historyTransaction = $this->TransferHistoryDetail_model->GetReportTransferDetailInformationByUserId($userId, $fromTimestamp, $toTimestamp, $filter);
        for($i = 0 ; $i < count($historyTransaction); $i++)
        {
            $historyTransaction[$i]['TRANS_DESC'] = self::getStringFromTransferKind($historyTransaction[$i]['TRANSACTION_TYPE']);
        }
        $dataToBeDisplayed['dataList'] = $historyTransaction;
        echo (json_encode($dataToBeDisplayed));
    }

    public function SpecifiedBalanceReport()
    {
        $userId = $this->input->post('userId');
        $resultUserId = (!isset($userId) || $userId == "");
        if($resultUserId == false)
        {
            $userData = $this->User_model->FindUserByArray(array('ID' => $userId));
            $accountList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $userId));
            $dataToBeDisplayed['userData'] = $userData;
            $dataToBeDisplayed['accountList'] = $accountList;
        }
        else
        {
            $dataToBeDisplayed['userData'] = array();
        }
        echo (json_encode($dataToBeDisplayed));
    }

    public function SystemAllTrans() {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $this->load->library('Stringutils');
        $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);//strtotime($fromDate);
        $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);//strtotime($toDate);
        $filterArray  = array();
        if($fromTimestamp != "") $filterArray['a.CREATED_AT >='] = $fromTimestamp;
        if($toTimestamp != "") $filterArray['a.CREATED_AT <='] = $toTimestamp;
        $historyTransaction = $this->TransferHistory_model->GetTransferHistoryArray($filterArray);
        for($i = 0 ; $i < count($historyTransaction); $i++)
        {
            $historyTransaction[$i]['TRANS_DESC'] = self::getStringFromTransferKind($historyTransaction[$i]['TRANSACTION_TYPE']);
        }
        $dataToBeDisplayed['dataList'] = $historyTransaction;
        echo (json_encode($dataToBeDisplayed));
    }

    public function SystemBalance() {
        $fromDate = $this->input->post('fromDate');
        $this->load->library('Stringutils');

        if( $this->stringutils->IsNullEmpty($fromDate) == false) {
            $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);//strtotime($fromDateTime);
             $accountList = $this->Account_model->FindAccountByArray(
                array('a.CREATED_AT <=' => $fromTimestamp));
            $dataToBeDisplayed['dataList'] = $accountList;
        }
        else {
            $dataToBeDisplayed['dataList'] = array();
        }
        echo (json_encode($dataToBeDisplayed));
    }

    public function SystemOutgoing() {
        $fromDate = $this->input->post('fromDate');
        $currency = $this->input->post('currency');
        $toDate = $this->input->post('toDate');
        $this->load->library('Stringutils');
        $dataToBeDisplayed['TOTAL_DEBIT'] = 0;
        $dataToBeDisplayed['TOTAL_CREDIT'] = 0;
        $dataToBeDisplayed['dataList'] = array();
        if($currency == null ) $currency = "";
        $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);//strtotime($fromDate);
        $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);//strtotime($toDate);

        $historyTransaction = $this->TransferHistoryDetail_model->GetOutgoingTransferDetailInformationByDate($currency, $fromTimestamp, $toTimestamp);
        for($i = 0 ; $i < count($historyTransaction) ; $i++){
            $historyTransaction[$i]['CREATED_AT'] = date('Y-m-d H:m:s', $historyTransaction[$i]['CREATED_AT']);
        }
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($historyTransaction as $item) {
            $totalDebit += $item['AMOUNT'];
        }
        $dataToBeDisplayed['TOTAL_DEBIT'] = $totalDebit;
        $dataToBeDisplayed['TOTAL_CREDIT'] = $totalCredit;
        $dataToBeDisplayed['CURRENCY_TITLE'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND, array('ID' => $currency));
        $dataToBeDisplayed['dataList'] = $historyTransaction;

        echo (json_encode($dataToBeDisplayed));
    }

    public function SystemRevenue() {
        $fromDate = $this->input->post('fromDate');
        $currency = $this->input->post('currency');
        $toDate = $this->input->post('toDate');
        $transferType = $this->input->post('transType');//0: all, 1: system, 2: manual

        $this->load->library('Stringutils');
        $fromTimestamp = 0;
        $toTimestamp = 0;
        if( $this->stringutils->IsNullEmpty($fromDate) == FALSE){// && $this->stringutils->IsNullEmpty($toDate) == FALSE && $this->stringutils->IsNullEmpty($currency) == FALSE) {
            $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);
        }

        if( $this->stringutils->IsNullEmpty($toDate) == FALSE ) {
            $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);
        }
        $revenueModel = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $currency));
        $transferHistory = $this->TransferHistoryDetail_model->GetTransferDetailForRevenueReport($revenueModel[0]['ID'], $transferType, $fromTimestamp, $toTimestamp);
//        echo json_encode($transferHistory);

        $retArray = array();

        for($i = 0 ; $i < count($transferHistory) ; $i++){
            $targetUserId = 0;
            $targetAccountId = 0;
            $amount = 0;
            $currentAmount = 0;

            $amount += $transferHistory[$i]['AMOUNT'];
            $amount = $transferHistory[$i]['DETAIL_TYPE'] == 0 ? 1*$amount : -1*$amount;

            if($transferHistory[$i]['TRANSACTION_TYPE'] < Account_Debit_Transfer){
                //transfer between users, accounts
                $targetUserId = $transferHistory[$i]['USER_ID'];
                $targetAccountId = $transferHistory[$i]['FROM_ACCOUNT'];
                $currentAmount = $transferHistory[$i]['FROM_CURRENT_BALANCE'];
            }
            else if($transferHistory[$i]['TRANSACTION_TYPE'] == Account_Debit_Transfer){
                $targetUserId = $transferHistory[$i]['USER_ID'];
                $targetAccountId = $transferHistory[$i]['FROM_ACCOUNT'];
                $currentAmount = $transferHistory[$i]['FROM_CURRENT_BALANCE'];
//                if($targetUserId == 1) $amount = -1 * $amount;
            }
            else {//($transferHistory[$i]['TRANSACTION_TYPE'] == Account_Credit_Transfer){
                $targetUserId = $transferHistory[$i]['TO_USER_ID'];
                $targetAccountId = $transferHistory[$i]['TO_ACCOUNT'];
                $currentAmount = $transferHistory[$i]['TO_CURRENT_BALANCE'];
            }

            if($targetUserId > 0){
                if($amount != 0) {
                    $tmp = array();
                    $tmp['transaction_id'] = $transferHistory[$i]['REQUEST_ID'];
                    $tmp['transaction_type'] = self::getStringFromTransferKind($transferHistory[$i]['TRANSACTION_TYPE']);
                    $tmp['description'] = $transferHistory[$i]['DESCRIPTION'];
                    $tmp['created_at']  = $transferHistory[$i]['CREATED_AT'];
                    if($targetUserId > 1){
                        //user account
                        $targetAccountInfo = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $targetUserId, 'a.ID' => $targetAccountId));
                        $tmp['username'] = $targetAccountInfo[0]['NAME'];
                        $tmp['fullname'] = $targetAccountInfo[0]['USER_FULLNAME'];
                        $tmp['account_number'] = $targetAccountInfo[0]['ACCOUNT_NUMBER'];
                        $tmp['account_id'] = $targetAccountInfo[0]['ID'];
                        $tmp['account_type'] = $targetAccountInfo[0]['FEE_TYPE'];
                    }
                    else{
                        $targetAccountInfo = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $targetAccountId));
                        $tmp['username'] = 'Administrator';
                        $tmp['fullname'] = $targetAccountInfo[0]['REVENUE_NAME'];
                        $tmp['account_number'] = $targetAccountInfo[0]['REVENUE_NAME'];
                        $tmp['account_id'] = $targetAccountInfo[0]['ID'];
                        $tmp['account_type'] = '';
                    }

                    $tmp['current'] = $currentAmount;
                    $tmp['amount'] = $amount;
                    array_push($retArray, $tmp);
                }
            }
            else{
                //in this case, it is bank.
                if($amount != 0) {
                    $tmp = array();
                    $tmp['transaction_id'] = $transferHistory[$i]['REQUEST_ID'];
                    $tmp['transaction_type'] = self::getStringFromTransferKind($transferHistory[$i]['TRANSACTION_TYPE']);
                    $tmp['description'] = $transferHistory[$i]['DESCRIPTION'];
                    $tmp['created_at'] = $transferHistory[$i]['CREATED_AT'];
                    $tmp['username'] = "Bank";
                    $tmp['fullname'] = "Bank";
                    $tmp['account_number'] = "";
                    $tmp['account_type'] = "";
                    $tmp['account_id'] = "";
                    $tmp['current'] = "";
                    $tmp['amount'] = $amount;
                    array_push($retArray, $tmp);
                }
            }
        }
        echo (json_encode(array('transList' => $retArray)));

    }

    private function getStringFromTransferKind($transferKind){
        switch ($transferKind){
            case Transfer_Between_Accounts:
                return "Transfer Between Accounts";
            case Transfer_Between_Users:
                return "Transfer Between Users";
            case Outgoing_Wire_Transfer:
                return "Outgoing Wire Transfer";
            case Card_Funding_Transfer:
                return "Card Funding Transfer";
            case Incoming_Wire_Transfer:
                return "Incoming Wire Transfer";
            case Account_Debit_Transfer:
                return "Manual Debit";
            case Account_Credit_Transfer:
                return "Manual Credit";
        }
    }

    public function SystemManualTrans() {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');

        $this->load->library('Stringutils');
        $fromTimestamp = 0;
        $toTimestamp = 0;

        if( $this->stringutils->IsNullEmpty($fromDate) == FALSE)
        {
            $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);
        }

        if( $this->stringutils->IsNullEmpty($toDate) == FALSE)
        {
            $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);
        }


        $historyManualTransfer = $this->TransferHistory_model->GetManualTransferHistoryByDate($fromTimestamp, $toTimestamp);
//        echo json_encode($historyManualTransfer);
        $result = array();

        for($i = 0 ; $i < count($historyManualTransfer) ; $i++){
            $arrayTmp = array();
            $arrayTmp['REQUEST_ID'] = $historyManualTransfer[$i]['ID'];
            $arrayTmp['TRANSFER_TYPE_STRING'] = $this->getStringFromTransferKind($historyManualTransfer[$i]['TRANSACTION_TYPE']);
            $arrayTmp['DATE'] = $historyManualTransfer[$i]['UPDATED_AT'];
            $arrayTmp['TRANS_DESCRIPTION'] = $historyManualTransfer[$i]['DESCRIPTION'];

            if($historyManualTransfer[$i]['TRANSACTION_TYPE'] <= Account_Debit_Transfer){
                //use from account then
                if($historyManualTransfer[$i]['USER_ID'] == 1){
                    //use revenue
                    $revenue = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $historyManualTransfer[$i]['FROM_ACCOUNT']));
                    $arrayTmp = self::makeManualReadableDataFromRevenue($arrayTmp, $revenue, $historyManualTransfer[$i]['AMOUNT'], true);
                }
                else{
                    //use user account
                    $account = $this->Account_model->FindAccountByArray(array('a.ID' => $historyManualTransfer[$i]['FROM_ACCOUNT']));
                    $arrayTmp = self::makeManualReadableDataFromAccount($arrayTmp, $account, $historyManualTransfer[$i]['AMOUNT'], true);
                }
            }
            else{
                //use to account then
                if($historyManualTransfer[$i]['TO_USER_ID'] == 1){
                    //use revenue
                    $revenue = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $historyManualTransfer[$i]['TO_ACCOUNT']));
                    $arrayTmp = self::makeManualReadableDataFromRevenue($arrayTmp, $revenue, $historyManualTransfer[$i]['AMOUNT'], true);
                }
                else{
                    //use user account
                    $account = $this->Account_model->FindAccountByArray(array('a.ID' => $historyManualTransfer[$i]['TO_ACCOUNT']));
                    $arrayTmp = self::makeManualReadableDataFromAccount($arrayTmp, $account, $historyManualTransfer[$i]['AMOUNT'], false);
                }
            }

//
//
//            $historyManualTransferDetail = $this->TransferHistoryDetail_model->GetHistoryDetail(array('REQUEST_ID' => $historyManualTransfer[$i]['ID'], 'AMOUNT>' => 0, 'USER_ID >' => 0));
//            for($j = 0 ; $j < count($historyManualTransferDetail) ; $j++) {
//
//                if ($historyManualTransferDetail[$j]['USER_ID'] == 1) {
//                    //revenue account
//                    $userInfo = $this->User_model->GetUserRecordByArray(array('ID' => $historyManualTransferDetail[$j]['USER_ID']));
//                    $accountInfo = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $historyManualTransferDetail[$j]['ACCOUNT_ID']));
//                    $arrayAccount = array(
//                        'USERNAME' => $userInfo->NAME,
//                        'FULLNAME' => $userInfo->FULL_NAME,
//                        'ACCOUNT_NUMBER' => $accountInfo[0]['REVENUE_NAME'],
//                        'CURRENCY_TITLE' => $accountInfo[0]['CURRENCY_TITLE'],
//                        'REVENUE' => 'Revenue',
//                        'ACCOUNT_TYPE' => 'Revenue'
//                    );
//                    $historyManualTransferDetail[$j]['USERINFO'] = $arrayAccount;
//                    $historyManualTransferDetail[$j]['TRANS_DESC'] = $historyManualTransfer[$i]['DESCRIPTION'];
//                } else {
//                    //user account
//                    $accountInfo = $this->Account_model->FindAccountByArray(array('a.ID' => $historyManualTransferDetail[$j]['ACCOUNT_ID']));
//                    $arrayAccount = array(
//                        'USERNAME' => $accountInfo[0]['NAME'],
//                        'FULLNAME' => $accountInfo[0]['USER_FULLNAME'],
//                        'ACCOUNT_NUMBER' => $accountInfo[0]['ACCOUNT_NUMBER'],
//                        'CURRENCY_TITLE' => $accountInfo[0]['CURRENCY_TITLE'],
//                        'REVENUE' => '',
//                        'ACCOUNT_TYPE' => $accountInfo[0]['ACCOUNT_TYPE_DESC']
//                    );
//                    $historyManualTransferDetail[$j]['USERINFO'] = $arrayAccount;
//                    $historyManualTransferDetail[$j]['TRANS_DESC'] = $historyManualTransfer[$i]['DESCRIPTION'];
//                }
//                array_push($result, $historyManualTransferDetail[$j]);
//            }
            array_push($result, $arrayTmp);//$result
        }
        echo (json_encode( array('dataList' => $result)));
    }

    private function makeManualReadableDataFromRevenue($arrayTmp, $revenueInfo, $amount, $isDebit){
        $arrayTmp['USER_NAME'] = $revenueInfo[0]['REVENUE_NAME'];
        $arrayTmp['FULL_NAME'] = "Administrator";
        $arrayTmp['ACCOUNT_NUMBER'] = $revenueInfo[0]['REVENUE_NAME'];
        $arrayTmp['ACCOUNT_TYPE'] = "";
        $arrayTmp['CURRENCY'] = $revenueInfo[0]['CURRENCY_TITLE'];
        $arrayTmp['AMOUNT'] = $isDebit == true ? $amount * -1 : $amount;
        $arrayTmp['REVENUE'] = "Revenue";
        return $arrayTmp;
    }

    public function makeManualReadableDataFromAccount($arrayTmp, $accountInfo, $amount, $isDebt){
        $arrayTmp['USER_NAME'] = $accountInfo[0]['NAME'];
        $arrayTmp['FULL_NAME'] = $accountInfo[0]['USER_FULLNAME'];
        $arrayTmp['ACCOUNT_NUMBER'] = $accountInfo[0]['ACCOUNT_NUMBER'];
        $arrayTmp['ACCOUNT_TYPE'] = $accountInfo[0]['ACCOUNT_TYPE_DESC'];
        $arrayTmp['CURRENCY'] = $accountInfo[0]['CURRENCY_TITLE'];
        $arrayTmp['AMOUNT'] = $isDebt == true ? $amount * -1 : $amount;
        $arrayTmp['REVENUE'] = "";
        return $arrayTmp;
    }

    public function SystemCreditCards() {

    }


}

