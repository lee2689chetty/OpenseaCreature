<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminRequestController extends CI_Controller
{

//    var $ARRAY_DESCRIPTION = array("AFT Fee", "UFT Fee", "OWT Fee", "CFT Fee", "IWT Fee", "ADT Fee", "ACT Fee");
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

    public function makeComponentViews($menuNum)
    {
        $header_layout = $this->load->view('admin/template/header_layout', '', TRUE);
        $adminDataName = array('adminName' => $this->session->userdata['me']['NAME']);
        $topbar_layout = $this->load->view('admin/template/topbar_layout', $adminDataName, TRUE);
        $selectedMenu = array('selectedMenu'=>$menuNum);
        $sidebar_layout = $this->load->view('admin/template/sidebar_layout', $selectedMenu, TRUE);
        $footer_layout = $this->load->view('admin/template/footer_layout', '', TRUE);
        $dataToBeDisplayed['header'] = $header_layout;
        $dataToBeDisplayed['topbar']  = $topbar_layout;
        $dataToBeDisplayed['sidebar'] = $sidebar_layout;
        $dataToBeDisplayed['footer'] = $footer_layout;
        $dataToBeDisplayed['notifyVerifyDocs'] = 5;
        return $dataToBeDisplayed;
    }

    public function transfer_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_REQUEST_TRANSFER);
        $transferKind = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND);
        $transferStatus = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS);
        $postRequestId = $this->input->post('requestId');
        $postFromVirtualAccountDate = $this->input->post('fromVirtualAccountDate');
        $postToVirtualAccountDate = $this->input->post('toVirtualAccountDate');
        $postTransferKind = $this->input->post('transferKind');
        $postTransferStatus = $this->input->post('transferStatus');

        $this->load->library('Stringutils');
        $postFromVirtualAccountDate = $this->stringutils->GetUnixTimeStampFromString($postFromVirtualAccountDate, FALSE);
        $postToVirtualAccountDate = $this->stringutils->GetUnixTimeStampFromString($postToVirtualAccountDate, TRUE);

        $whereArray = array();
        if(isset($postRequestId) && $postRequestId != "")
        {
            $whereArray['a.ID'] = $postRequestId;
        }



        if(isset($postFromVirtualAccountDate) && $postFromVirtualAccountDate != "") {
            $whereArray['a.CREATED_AT >='] = $postFromVirtualAccountDate;
        }
        if(isset($postToVirtualAccountDate) && $postToVirtualAccountDate != "") {
            $whereArray['a.CREATED_AT <='] = $postToVirtualAccountDate;
        }
        if(isset($postTransferKind) && $postTransferKind != '0') {
            if($postTransferKind == 1) {
                // client transfer
                $whereArray['a.IS_MANUAL_TRANS'] = 0;
            }
            else {
                $whereArray['a.TRANSACTION_TYPE'] = $postTransferKind;
            }
        }
        else {
            $whereArray['a.IS_MANUAL_TRANS'] = 0;
        }
        if(isset($postTransferStatus) && $postTransferStatus != '0') {
            $whereArray['a.STATUS'] = $postTransferStatus;
        }

        $transferHistoryList = $this->TransferHistory_model->GetTransferTotalHistory($whereArray);
        for($i = 0 ; $i < count($transferHistoryList) ; $i++) {
            $transferDetail = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND, array('ID'=>$transferHistoryList[$i]['TRANSACTION_TYPE']));
            $statusDetail = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS, array('ID' => $transferHistoryList[$i]['STATUS']));
            $transferHistoryList[$i]['SUBJECT'] = $transferDetail[0]['DESCRIPTION'];
            $transferHistoryList[$i]['STATUS_TITLE'] = $statusDetail[0]['DESCRIPTION'];
        }
        $dataToBeDisplayed['transferKind'] = $transferKind;
        $dataToBeDisplayed['transferStatus'] = $transferStatus;
        $dataToBeDisplayed['transferHistory'] = $transferHistoryList;
        $dataToBeDisplayed['whereArray'] = $whereArray;
        $this->load->view('admin/pages/request/transfer_view', $dataToBeDisplayed);
    }

    public function register_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_REQUEST_REGISTER);


//        $transferKind = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND);
//        $transferStatus = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS);
//
//        $postRequestId = $this->input->post('requestId');
//        $postFromVirtualAccountDate = $this->input->post('fromVirtualAccountDate');
//        $postToVirtualAccountDate = $this->input->post('toVirtualAccountDate');
//        $postTransferKind = $this->input->post('transferKind');
//        $postTransferStatus = $this->input->post('transferStatus');
//
//        $whereArray = array();
//        if(isset($postRequestId) && $postRequestId != "")
//        {
//            $whereArray['a.ID'] = $postRequestId;
//        }
//        if(isset($postFromVirtualAccountDate) && $postFromVirtualAccountDate != "")
//        {
//            $whereArray['a.CREATED_AT >='] = strtotime($postFromVirtualAccountDate);
//        }
//        if(isset($postToVirtualAccountDate) && $postToVirtualAccountDate != "")
//        {
//            $whereArray['a.CREATED_AT <='] = strtotime($postToVirtualAccountDate);
//        }
//        if(isset($postTransferKind) && $postTransferKind != '0')
//        {
//            $whereArray['a.TRANSACTION_TYPE'] = $postTransferKind;
//        }
//        if(isset($postTransferStatus) && $postTransferStatus != '0')
//        {
//            $whereArray['a.STATUS'] = $postTransferStatus;
//        }
//
//        $transferHistoryList = $this->TransferHistory_model->GetTransferTotalHistory($whereArray);
//        for($i = 0 ; $i < count($transferHistoryList) ; $i++)
//        {
//            $transferDetail = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND, array('ID'=>$transferHistoryList[$i]['TRANSACTION_TYPE']));
//            $statusDetail = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS, array('ID' => $transferHistoryList[$i]['STATUS']));
//            $transferHistoryList[$i]['SUBJECT'] = $transferDetail[0]['DESCRIPTION'];
//            $transferHistoryList[$i]['STATUS_TITLE'] = $statusDetail[0]['DESCRIPTION'];
//        }
//
//        $dataToBeDisplayed['transferKind'] = $transferKind;
//        $dataToBeDisplayed['transferStatus'] = $transferStatus;
//        $dataToBeDisplayed['transferHistory'] = $transferHistoryList;
//        $dataToBeDisplayed['whereArray'] = $whereArray;

        /**
         * make form values
         */

        $this->load->view('admin/pages/request/register_view', $dataToBeDisplayed);
    }

    public function transfer($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_REQUEST_TRANSFER);
        $requestHistory = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $id));
        $statusArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS);
        $transactionDetails = $this->TransferHistoryDetail_model->GetHistoryDetail(array('REQUEST_ID' => $id));
        $this->load->library('TransferUtils');
        for ($i = 0 ; $i < count($transactionDetails) ; $i++)
        {
            $transactionDetails[$i]['DESCRIPTION'] = $requestHistory[0]['DESCRIPTION'];
            if($transactionDetails[$i]['USER_ID'] == 1)
            {
                //revenue
                $revenueAccount = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $transactionDetails[$i]['ACCOUNT_ID']));
                $transactionDetails[$i]['ACCOUNT_NUMBER'] = count($revenueAccount) > 0?$revenueAccount[0]['REVENUE_NAME']:"";
                $transactionDetails[$i]['CURRENCY_TITLE'] = count($revenueAccount) > 0?$revenueAccount[0]['CURRENCY_TITLE']:"";
            }
            else if($transactionDetails[$i]['USER_ID'] == 0)
            {
                $outGoingItem = $this->TransferHistory_model->GetOutgingHistory(array('ID' => $requestHistory[0]['OUTGOING_WIRE_INDEX']));
                $outGoingCurrency = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND, array('ID' => $outGoingItem[0]['CURRENCY_TYPE']));
                $transactionDetails[$i]['ACCOUNT_NUMBER'] = $outGoingItem[0]['BANK_NAME'];
                $transactionDetails[$i]['CURRENCY_TITLE'] = $outGoingCurrency[0]['TITLE'];
            }
            else
            {
                $accountData = $this->Account_model->FindAccountByArray(array('a.ID' => $transactionDetails[$i]['ACCOUNT_ID']));
                $transactionDetails[$i]['ACCOUNT_NUMBER'] = count($accountData) > 0?$accountData[0]['ACCOUNT_NUMBER']:"";
                $transactionDetails[$i]['CURRENCY_TITLE'] = count($accountData) > 0?$accountData[0]['CURRENCY_TITLE']:"";
            }
        }

        if(count($requestHistory) == 0) {
            $requestHistory = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $id));
        }
        $requestHistory[0]['STATUS_DESCRIPTION'] = $statusArray[$requestHistory[0]['STATUS'] - 1]['DESCRIPTION'];


        $transactionType = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND, array('ID' => $requestHistory[0]['TRANSACTION_TYPE']));
        $dataToBeDisplayed['requestDetail'] = $requestHistory[0];
        $dataToBeDisplayed['historyDetail'] = $transactionDetails;
        $dataToBeDisplayed['outgoingDetail'] = $this->TransferHistory_model->GetOutgingHistory(array('ID' => $requestHistory[0]['OUTGOING_WIRE_INDEX']));
        if(count($dataToBeDisplayed['outgoingDetail']) > 0)
            $dataToBeDisplayed['outgoingDetail'][0]['currency'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND, array('ID' => $dataToBeDisplayed['outgoingDetail'][0]['CURRENCY_TYPE']));
        $fromUserData = $this->transferutils->GetAccountDetailInformationFromTransferHistory($requestHistory[0]['USER_ID'], $requestHistory[0]['FROM_ACCOUNT'], $requestHistory[0]['OUTGOING_WIRE_INDEX']);
        $toUserData = $this->transferutils->GetAccountDetailInformationFromTransferHistory($requestHistory[0]['TO_USER_ID'], $requestHistory[0]['TO_ACCOUNT'], $requestHistory[0]['OUTGOING_WIRE_INDEX']);
        $dataToBeDisplayed['fromUserData'] = $fromUserData;
        $dataToBeDisplayed['toUserData'] = $toUserData;
        $dataToBeDisplayed['transactionType'] = $transactionType[0];
        $dataToBeDisplayed['statusArray'] = $statusArray;
        $dataToBeDisplayed['countryList'] = $this->UtilInfo_model->GetCountryList();
        $this->load->view('admin/pages/request/transfer', $dataToBeDisplayed);
    }

    public function status($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_REQUEST_TRANSFER);

        $requestHistory = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $id));
        if(count($requestHistory) == 0 ) {
            show_404();
            return;
        }

        $statusArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS);
        $this->load->library('TransferUtils');
        $fromUserData = $this->transferutils->GetAccountDetailInformationFromTransferHistory($requestHistory[0]['USER_ID'], $requestHistory[0]['FROM_ACCOUNT'], $requestHistory[0]['OUTGOING_WIRE_INDEX']);
        $toUserData = $this->transferutils->GetAccountDetailInformationFromTransferHistory($requestHistory[0]['TO_USER_ID'], $requestHistory[0]['TO_ACCOUNT'], $requestHistory[0]['OUTGOING_WIRE_INDEX']);
        $transactionType = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND, array('ID' => $requestHistory[0]['TRANSACTION_TYPE']));
        $dataToBeDisplayed['requestDetail'] = $requestHistory[0];
        $dataToBeDisplayed['transactionType'] = $transactionType[0];
        $dataToBeDisplayed['statusArray'] = $statusArray;
        $transferStatusHistory = $this->TransferHistoryDetailStatus_model->GetTransferStatusHistoryArray(array('REQUEST_ID' => $id));


        $dataToBeDisplayed['TransferHistory'] = $transferStatusHistory;
        $dataToBeDisplayed['FromUserData'] = $fromUserData;
        $dataToBeDisplayed['toUserData'] = $toUserData;
        $dataToBeDisplayed['adminDisp'] = true;

        $dataToBeDisplayed['uploadFiles'] = $this->File_model->GetUploadFileInformation(array('TRANS_ID' => $id));
        $this->load->view('admin/pages/request/transfer_status_view', $dataToBeDisplayed);

    }

    public function remove_file($fileId) {
        $transData = $this->File_model->GetUploadFileInformation(array('ID' => $fileId));
        if(count($transData) == 0) {show_404(); return;}
        $this->File_model->RemoveFile($fileId);
        redirect(base_url()."admin/request/status/".$transData[0]['TRANS_ID']);
    }

    public function execute($id){
        $this->TransferHistory_model->UpdateTransferHistoryObject(array('UPDATED_AT' => now()), array('ID' => $id));
        $this->TransferHistoryDetail_model->UpdateTransferHistoryDetailObject(array('UPDATED_AT' => now()), array('REQUEST_ID' => $id));

        $HistoryItemArray = $this->TransferHistory_model->GetTransferHistoryObject(array('ID' => $id));
        if(count($HistoryItemArray) == 0) {
            show_404();
            return;
        }

        $HistoryItem = $HistoryItemArray[0];
        $this->Account_model->UpdateCurrentBalance(false, $HistoryItem->FROM_ACCOUNT, doubleval($HistoryItem->AMOUNT) + doubleval($HistoryItem -> TRANSACTION_FEE) + doubleval($HistoryItem -> ADDITIONAL_FEE));

        $detailHistoryItemForRevenue = $this->TransferHistoryDetail_model->GetHistoryDetail(array('REQUEST_ID' => $id, 'USER_ID' => '1'));
//        if(count($detailHistoryItemForRevenue) == 0) {
//            show_error("No Revenue account");
//            return;
//        }

        for($idx = 0; $idx < count($detailHistoryItemForRevenue) ;$idx ++)
        {
            $this->RevenueInfo_model->UpdateRevenueBalance($detailHistoryItemForRevenue[$idx]['ACCOUNT_ID'], $detailHistoryItemForRevenue[$idx]['AMOUNT'], true);
        }

        if(intval($HistoryItem -> TO_ACCOUNT) > 0) {
            $amountToBeSent = ($HistoryItem->AMOUNT) * $HistoryItem->CURRENCY_CALCED_RATE;
            $this->Account_model->UpdateCurrentBalance(true, $HistoryItem->TO_ACCOUNT, $amountToBeSent);
            $this->Account_model->UpdateAvailableBalance(true, $HistoryItem->TO_ACCOUNT, $amountToBeSent);
            $fromAccount = $this->Account_model->FindAccountByArray(array('a.ID' => $HistoryItem->FROM_ACCOUNT));
            $toAccount = $this->Account_model->FindAccountByArray(array('a.ID' => $HistoryItem->TO_ACCOUNT));
            $this->TransferHistory_model->UpdateTransferHistoryObject(
                                            array('STATUS' => TRANSFER_COMPLETE,
                                                'FROM_CURRENT_BALANCE' => $fromAccount[0]['CURRENT_AMOUNT'],
                                                'TO_CURRENT_BALANCE' => $toAccount[0]['CURRENT_AMOUNT'],
                                                'FROM_AVAILABLE_BALANCE' => $fromAccount[0]['AVAILABLE_AMOUNT'],
                                                 'TO_AVAILABLE_BALANCE' => $toAccount[0]['AVAILABLE_AMOUNT'],
                                                'UPDATED_AT' => now()),
                                            array('ID' => $id));

            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $id, 'STATUS_ID' => TRANSFER_APPROVED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $id, 'STATUS_ID' => TRANSFER_COMPLETE, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
            //send email notification
            $toUser = $this->User_model->FindUserByArray(array('ID' => $toAccount[0]['USER_ID']));
            if(intval($toUser[0]['NOTIFY_FUND_ADD']) == 1)
            {
                $fromUser = $this->User_model->FindUserByArray(array('ID' => $fromAccount[0]['USER_ID']));
                $mailContent = "Hi, <strong>".$toUser[0]['FULL_NAME']."</strong><br> New Fund is added to Account: ".$toAccount[0]['ACCOUNT_NUMBER']
                    ."<br>IP Location: ".$this->input->ip_address()
                    ."<br>From: ".$fromUser[0]['FULL_NAME']." ( ".$fromAccount[0]['ACCOUNT_NUMBER']." ) ";
                $this->SendFundNotificationEmail($toUser[0]['EMAIL'], $mailContent);
            }
        }
        else {
            $fromAccount = $this->Account_model->FindAccountByArray(array('a.ID' => $HistoryItem->FROM_ACCOUNT));
            $this->TransferHistory_model->UpdateTransferHistoryObject(
                                            array('STATUS' => TRANSFER_COMPLETE,
                                                'FROM_AVAILABLE_BALANCE' => $fromAccount[0]['AVAILABLE_AMOUNT'],
                                                'FROM_CURRENT_BALANCE' => $fromAccount[0]['CURRENT_AMOUNT'],
                                                'TO_AVAILABLE_BALANCE' => 0,
                                                'TO_CURRENT_BALANCE' => 0,
                                                'UPDATED_AT' => now()),
                                            array('ID' => $id));
            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $id, 'STATUS_ID' => TRANSFER_APPROVED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $id, 'STATUS_ID' => TRANSFER_COMPLETE, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        }
//        print_r($fromAccount);
        redirect(base_url().'admin/request/transfer/'.$id);
    }

    public function cancel($id)
    {
        $cancelMessage =  $this->input->post('txtCancelContent');

        $HistoryItemArray = $this->TransferHistory_model->GetTransferHistoryObject(array('ID' => $id));
        $HistoryItem = $HistoryItemArray[0];

        if($HistoryItem->STATUS == TRANSFER_COMPLETE){
            $this->Account_model->UpdateAvailableBalance(true, $HistoryItem->FROM_ACCOUNT, $HistoryItem->AMOUNT + $HistoryItem->TRANSACTION_FEE + $HistoryItem -> ADDITIONAL_FEE + $HistoryItem -> HIDDEN_FEE_IN_RATE );
            $this->Account_model->UpdateCurrentBalance(true, $HistoryItem->FROM_ACCOUNT, $HistoryItem->AMOUNT + $HistoryItem->TRANSACTION_FEE + $HistoryItem->ADDITIONAL_FEE + $HistoryItem -> HIDDEN_FEE_IN_RATE);

            if($HistoryItem -> TO_ACCOUNT != '0') {
                $toAccount = $this->Account_model->FindAccountByArray(array('a.ID' => $HistoryItem->TO_ACCOUNT));
                $toRevenue = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $toAccount[0]['CURRENCY_TYPE']));
                $this->RevenueInfo_model->UpdateRevenueBalance($toRevenue[0]['ID'], $HistoryItem->TRANSACTION_FEE + $HistoryItem->ADDITIONAL_FEE + $HistoryItem->HIDDEN_FEE_IN_RATE);

                print_r('transfer complete not outgoing case');
                print_r($toAccount);
                print_r($toRevenue);

            }
            else {
                $outgoingHistoryItem = $this->TransferHistory_model->GetOutgingHistory(array('ID' => $HistoryItem->OUTGOING_WIRE_INDEX));
                $toRevenue = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $outgoingHistoryItem[0]['CURRENCY_TYPE']));
                $this->RevenueInfo_model->UpdateRevenueBalance($toRevenue[0]['ID'], $HistoryItem->TRANSACTION_FEE + $HistoryItem->ADDITIONAL_FEE + $HistoryItem->HIDDEN_FEE_IN_RATE);

                print_r('transfer complete outgoing case');
                print_r($toRevenue);

            }
            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $id, 'STATUS_ID' => TRANSFER_CANCELLED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
            if($HistoryItem->TO_ACCOUNT != '0') {
                $amountToBeSent = $HistoryItem->AMOUNT * $HistoryItem->CURRENCY_CALCED_RATE;
                $this->Account_model->UpdateAvailableBalance(false, $HistoryItem->TO_ACCOUNT, $amountToBeSent);
                $this->Account_model->UpdateCurrentBalance(false, $HistoryItem->TO_ACCOUNT, $amountToBeSent);
            }

        }
        else{
            $this->Account_model->UpdateAvailableBalance(true, $HistoryItem->FROM_ACCOUNT, $HistoryItem->AMOUNT + $HistoryItem->TRANSACTION_FEE + $HistoryItem->HIDDEN_FEE_IN_RATE);
            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $id, 'STATUS_ID' => TRANSFER_CANCELLED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        }

        $this->TransferHistory_model->UpdateTransferHistoryObject(
            array('STATUS' => TRANSFER_CANCELLED, 'CANCEL_MSG' => $cancelMessage, 'UPDATED_AT'=>now()),
            array('ID' => $id));
        $this->TransferHistoryDetail_model->UpdateTransferHistoryDetailObject(array('UPDATED_AT' => now()), array('REQUEST_ID' => $id));


       redirect(base_url().'admin/request/transfer/'.$id);
    }

    private function SendFundNotificationEmail($targetEmail, $content)
    {
        $this->email->initialize($this->config->item('EMAIL'));
        $this->email->from($this->config->item('EMAIL_DISP'), $this->config->item('EMAIL_DISP'));
        $this->email->to($targetEmail);
        $this->email->subject('Valor Pay Support team');
        $this->email->message($content);
        $result = $this->email->send();
//        echo($result);
    }
}