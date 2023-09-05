<?php

/**
 * Created by PhpStorm.
 * User: zeus
 * Date: 7/3/2018
 * Time: 4:58 PM
 */
class RequestController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect(base_url().'auth/login');
        }
        else if($this->session->userdata['me']['LEVEL'] != '4')
        {
            redirect(base_url().'admin/auth/login');
        }


        $userData = $this->User_model->FindUserByArray(array('ID' => $this->session->userdata['me']['ID']));
        if(count($userData) == 0) {
            show_404();
            return;
        }

        if($userData[0]['VERIFY_STATUS'] == '1') {
            redirect(base_url().'profile/me');
        }
    }

    public function makeComponentViews($menuNum)
    {
        $header_layout = $this->load->view('client/template/header_layout', '', TRUE);
        $selectedMenu = array('selectedMenu' => $menuNum);
        $sidebar_layout = $this->load->view('client/template/sidebar_layout', $selectedMenu, TRUE);
        $footer_layout = $this->load->view('client/template/footer_layout', '', TRUE);
        $dataToBeDisplayed['header'] = $header_layout;
        $dataToBeDisplayed['sidebar'] = $sidebar_layout;
        $dataToBeDisplayed['footer'] = $footer_layout;
        return $dataToBeDisplayed;
    }

    public function makeTopBarComponentViews($dataToBeDisplayed)
    {
        $topBarData = $this->Notification_model->getClientTopBarData($this->session->userdata['me']['ID']);
        $dataTopBar = array('adminDataName' =>  $this->session->userdata['me']['NAME'], 'topBarData' => $topBarData);
        $topbar_layout = $this->load->view('client/template/topbar_layout', $dataTopBar, TRUE);
        $dataToBeDisplayed['topbar'] = $topbar_layout;
        return $dataToBeDisplayed;
    }

    public function status($id)
    {
        $this->Notification_model->UpdateReadStatus(array('USER_ID' => $this->session->userdata['me']['ID'], 'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE, 'LINK_ID' => $id.''));
        $this->load->library('TransferUtils');
        $dataToBeDisplayed = $this->makeComponentViews(4);
        $requestHistory = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $id));
        $statusArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS);
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
        $dataToBeDisplayed['adminDisp'] = false;
        $dataToBeDisplayed['uploadFiles'] = $this->File_model->GetUploadFileInformation(array('TRANS_ID' => $id));
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('admin/pages/request/transfer_status_view', $dataToBeDisplayed);
    }
}