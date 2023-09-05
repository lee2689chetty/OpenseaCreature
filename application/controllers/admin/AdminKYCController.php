<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminKYCController extends CI_Controller
{
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
        return $dataToBeDisplayed;
    }

    public function view() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_KYC_MANAGE);
        $userList = $this->User_model->FindUserByArray(array('VERIFY_STATUS>' => '0', 'VERIFY_STATUS<' => '3'));
        for($i = 0 ; $i < count($userList); $i++) {
            $loginHistory = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_LOGIN_HISTORY, array('USER_ID' => $userList[$i]['ID']));
            $loginTime = "Never Login";
            if(count($loginHistory) > 0)
                $loginTime = $loginHistory[count($loginHistory) - 1]['UPDATED_AT'];
            $userList[$i]['last_login_time'] = date('Y-m-d H:m:s', $loginTime);

            $verifyRequest = $this->Kyc_model->GetVerificationInformation(array('USER_ID' => $userList[$i]['ID']));
            $userList[$i]['REQUESTED_TIME'] = date('Y-m-d H:m:s', $verifyRequest[0]['CREATED_AT']);
        }

        $statusList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
        $dataToBeDisplayed['userList'] = $userList;
        $dataToBeDisplayed['statusList'] = $statusList;

        $this->load->view('admin/pages/kyc/view_verify_users', $dataToBeDisplayed);
    }

    public function add($userId) {
        //add verify
        $this->User_model->UpdateUserObject(array('VERIFY_STATUS' => '1'), array('ID' => $userId));
        $hashUserId = md5($userId);
        $insertedVerifyId = $this->Kyc_model->InsertNewHistory(array(
                                                'TICKET_NUMBER' => $hashUserId,
                                                'USER_ID' => $userId,
                                                'VERIFY_REQUEST_DATE' => time(),
                                                'VERIFY_UPDATE_DATE' => 0,
                                                'USER_FNAME' => '',
                                                'USER_LNAME' => '',
                                                'USER_DOB' => '',
                                                'USER_ID_NUMBER' => '',
                                                'USER_ID_APPROVE_PATH' => '',
                                                'USER_ADDR' => '',
                                                'ADDR_DOC_KIND' => '',
                                                'ADDR_APPROVE_DOC' => '',
                                                'IDENTIFY_APPROVE' => 0,
                                                'ADDRESS_APPROVE' => 0,
                                                'APPROVE_ADMIN_ID' => $this->session->userdata['me']['ID'],
                                                'UPDATED_AT' => time(),
                                                'CREATED_AT' => time()));
        $this->Notification_model->InsertNewNotification(array( 'USER_ID' => $userId,
                                                                'REASON_TYPE' => NOTIFY_VERIFY_REQUESTED,
                                                                'LINK_ID' => $insertedVerifyId,
                                                                'CONTENT' => '',
                                                                'USER_CHECK' => 0,
                                                                'UPDATED_AT' => time(),
                                                                'CREATED_AT' => time()));
        redirect(base_url().'admin/kyc/history/'.$userId);
    }

    public function history($userId) {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_KYC_MANAGE);
        $userData = $this->User_model->FindUserByArray(array('ID' => $userId));
        if(count($userData) == 0)
        {
            show_404();
            return;
        }

        $dataToBeDisplayed['userData'] = $userData[0];
        $histories = $this->Kyc_model->GetVerificationInformation(array('USER_ID' => $userId));
        for($i = 0 ; $i < count($histories) ; $i++) {
            $histories[$i]['admin'] = $this->User_model->FindUserByArray(array('ID' => $histories[$i]['APPROVE_ADMIN_ID']))[0];
        }

        $dataToBeDisplayed['history']  = $histories;
        $this->load->view('admin/pages/kyc/view_verify_histories', $dataToBeDisplayed);
    }

    public function verify_edit($kycId) {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_KYC_MANAGE);
        $kycData = $this->Kyc_model->GetVerificationInformation(array('ID' => $kycId));
        if(count($kycData) == 0) {
            show_404();
            return;
        }
        $userData = $this->User_model->FindUserByArray(array('ID' => $kycData[0]['USER_ID']));
        if(count($userData) == 0 ) {
            show_404();
            return;
        }
        $kycData[0]['USER_DATA'] = $userData[0];
        $dataToBeDisplayed['kycData'] = $kycData[0];
        $this->load->view('admin/pages/kyc/verify_edit', $dataToBeDisplayed);
    }

    public function identify_approve($tickeNumber) {
        $kycData = $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $tickeNumber));
        if(count($kycData) == 0) {
            show_404();
            return;
        }

        $this->Kyc_model->UpdateKycObject(array('IDENTIFY_APPROVE' => 1, 'UPDATED_AT' => time()), array('TICKET_NUMBER' => $tickeNumber));
        //update identify information here
        $this->User_model->UpdateUserObject(array('FULL_NAME' => $kycData[0]['USER_FNAME'].' '.$kycData[0]['USER_LNAME']), array('ID' => $kycData[0]['USER_ID']));
        $userData = $this->User_model->FindUserByArray(array('ID' => $kycData[0]['USER_ID']));

        $this->ProfileInfo_model->UpdateProfileInformation(array('FIRST_NAME' => $kycData[0]['USER_FNAME'], 'LAST_NAME' => $kycData[0]['USER_LNAME'], 'DOB' => $kycData[0]['USER_DOB'],
                                                                'PASSPORT_NUMBER' => $kycData[0]['USER_ID_NUMBER']),
                                                            array('ID' => $userData[0]['PROFILE_ID']));

        if($kycData[0]['ADDRESS_APPROVE'] == '1') {
            $this->Kyc_model->UpdateKycObject(array('VERIFY_UPDATE_DATE' => time()), array('TICKET_NUMBER' => $tickeNumber));
            $this->User_model->UpdateUserObject(array('VERIFY_STATUS' => 2), array('ID' => $kycData[0]['USER_ID']));
        }
        redirect(base_url().'admin/kyc/verify_edit/'.$kycData[0]['ID']);
    }

    public function identify_deny($tickeNumber) {
        $kycData = $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $tickeNumber));
        if(count($kycData) == 0) {
            show_404();
            return;
        }

        $this->Kyc_model->UpdateKycObject(array('IDENTIFY_APPROVE' => 0, 'UPDATED_AT' => time()), array('TICKET_NUMBER' => $tickeNumber));
        redirect(base_url().'admin/kyc/verify_edit/'.$kycData[0]['ID']);
    }

    public function address_approve($tickeNumber) {
        $kycData = $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $tickeNumber));
        if(count($kycData) == 0) {
            show_404();
            return;
        }
        $this->Kyc_model->UpdateKycObject(array('ADDRESS_APPROVE' => 1, 'UPDATED_AT' => time()), array('TICKET_NUMBER' => $tickeNumber));

        if($kycData[0]['IDENTIFY_APPROVE'] == '1') {
            $this->Kyc_model->UpdateKycObject(array('VERIFY_UPDATE_DATE' => time()), array('TICKET_NUMBER' => $tickeNumber));
            $this->User_model->UpdateUserObject(array('VERIFY_STATUS' => 2), array('ID' => $kycData[0]['USER_ID']));
        }

        redirect(base_url().'admin/kyc/verify_edit/'.$kycData[0]['ID']);
    }

    public function address_deny($tickeNumber) {
        $kycData = $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $tickeNumber));
        if(count($kycData) == 0) {
            show_404();
            return;
        }
        $this->Kyc_model->UpdateKycObject(array('ADDRESS_APPROVE' => 0, 'UPDATED_AT' => time()), array('TICKET_NUMBER' => $tickeNumber));
        redirect(base_url().'admin/kyc/verify_edit/'.$kycData[0]['ID']);
    }

    public function download_file() {
        $ticketNumber = $this->input->get('TICKET_NUMBER');
        $kind = $this->input->get('KIND');

        $kycData = $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $ticketNumber));
        if(count($kycData) == 0) {
            show_error('No KYC Data');
            return;
        }

        $this->load->helper('download');
        $url = "";
        if(intval($kind) == 0) {
            $url = $kycData[0]['USER_ID_APPROVE_PATH'];
        }
        else {
            $url = $kycData[0]['ADDR_APPROVE_DOC'];
        }
        if($url == "") {
            show_404();
            return;
        }

        force_download($url, NULL);
    }
}