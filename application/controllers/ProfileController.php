<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/30/17
 * Time: 3:28 PM
 */
class ProfileController extends CI_Controller
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
    }

    public function makeComponentViews($menuNum)
    {
        $this->Notification_model->UpdateReadStatus(array('USER_ID' => $this->session->userdata['me']['ID'], 'REASON_TYPE' => NOTIFY_VERIFY_REQUESTED));
        $header_layout = $this->load->view('client/template/header_layout', '', TRUE);
        $selectedMenu = array('selectedMenu'=>$menuNum);
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
    public function me()
    {
        $dataToBeDisplayed = $this->makeComponentViews(0);
        $myProfileData = $this->ProfileInfo_model->GetUserDetailInformation(array('b.ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['myProfileData'] = $myProfileData[0];
        $loginHistory = $this->LoginHistory_model->GetLoginHistory(array('USER_ID' => $this->session->userdata['me']['ID']));
        if(count($loginHistory) > 0)
            $dataToBeDisplayed['loginHistory'] = $loginHistory[count($loginHistory) - 1];

        $dataToBeDisplayed['profileList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PROFILE_KIND);
        $dataToBeDisplayed['countryList'] = $this->UtilInfo_model->GetCountryList();

        $this->load->library('form_validation');
        //form validation here.
        $this->form_validation->set_rules('profileType', ' Profile Type ' , 'required');
        $this->form_validation->set_rules('userInfoFirstName', ' First Name ' , 'required');
        $this->form_validation->set_rules('userInfoLastName', ' Last Name ' , 'required');
        $this->form_validation->set_rules('userInfoEmail', 'Email Address' , 'required|valid_email');
        $this->form_validation->set_rules('userInfoConfirmEmail', 'Confirm Email' , 'required|matches[userInfoEmail]');

        if($this->form_validation->run() == TRUE)
        {
            /**
             * Begin User Information Part
             */
            $profileType = $this->input->post('profileType');
            $firstName = $this->input->post('userInfoFirstName');
            $lastName = $this->input->post('userInfoLastName');
//            $currentPassword = $this->input->post('userInfoCurrentPassword');
            $userInfoEmail = $this->input->post('userInfoEmail');
            $userInfoConfirmEmail = $this->input->post('userInfoConfirmEmail');
//            $userInfoNewPassword = $this->input->post('userInfoNewPassword');
            $userInfoDOB = $this->input->post('userInfoDOB');
            $userInfoPassport = $this->input->post('userInfoPassport');
            $userInfoCountryList = $this->input->post('userInfoCountryList');
            $userInfoCityList = $this->input->post('userInfoCityList');
            $userInfoPhoneNumber = $this->input->post('userInfoPhoneNumber');
            $userInfoHomePhone = $this->input->post('userInfoHomePhone');
            $userInfoOfficePhone = $this->input->post('userInfoOfficePhone');
            $userInfoFax = $this->input->post('userInfoFax');

            /**
             * Benifical Owner
             */
            $benefitFullName = $this->input->post('benificalFullName');
            $benefitDOB = $this->input->post('benificalDOB');
            $benefitRelation = $this->input->post('benificalRelationShip');
            $benefitAddress = $this->input->post('benificalAddress');
            $benefitPhone = $this->input->post('benificalPhone');

            /**
             * Mailing Address
             */
            $mailingAddress = $this->input->post('mailingAddress');
            $mailing2ndAddress = $this->input->post('mailingAddress_2');
            $mailingCity = $this->input->post('mailingCity');
            $mailingProvince = $this->input->post('mailingState');
            $mailingZipPostal = $this->input->post('mailingZip');
            $mailingCountry = $this->input->post('mailingCountryList');
            $mailingPhone = $this->input->post('mailingPhoneNumber');

            /**
             * Physical Address
             */
            $physicalAddress = $this->input->post('physicalAddress');
            $physical2ndAddress = $this->input->post('physicalAddress_2');
            $physicalCity = $this->input->post('physicalCity');
            $physicalState = $this->input->post('physicalState');
            $physicalZipPostal = $this->input->post('physicalZip');
            $physicalCountry = $this->input->post('physicalCountryList');
            $physicalPhone = $this->input->post('physicalPhone');

            /**
             * check current password
             */
            $whereArray = array('ID' => $myProfileData[0]['ID']);
            $updateArray = array(
                'PROFILE_KIND' => $profileType,
                'FIRST_NAME' => $firstName,
                'LAST_NAME' => $lastName,
                'DOB' => $userInfoDOB,
                'PASSPORT_NUMBER' => $userInfoPassport,
                'COUNTRY_INDEX' => $userInfoCountryList,
                'CITY_INDEX' => $userInfoCityList,
                'PHONE' => $userInfoPhoneNumber,
                'OFFICE_PHONE' => $userInfoOfficePhone,
                'HOME_PHONE' => $userInfoHomePhone,
                'FAX' => $userInfoFax,

                'BENEFICAL_FULL_NAME' => $benefitFullName,
                'BENIFICAL_DOB' => $benefitDOB,
                'BENIFICAL_RELATION' => $benefitRelation,
                'BENIFICAL_ADDR' => $benefitAddress,
                'BENIFICAL_PHONE' => $benefitPhone,

                'MAILING_ADDR' => $mailingAddress,
                'MAILING_ADDR2' => $mailing2ndAddress,
                'MAILING_CITY' => $mailingCity,
                'MAILING_STATE' => $mailingProvince,
                'MAILING_ZIP' => $mailingZipPostal,
                'MAILING_COUNTRY' => $mailingCountry,
                'MAILING_PHONE' => $mailingPhone,

                'PHYSICAL_ADDR' => $physicalAddress,
                'PHYSICAL_ADDR2' => $physical2ndAddress,
                'PHYSICAL_CITY' => $physicalCity,
                'PHYSICAL_STATE' => $physicalState,
                'PHYSICAL_ZIP' => $physicalZipPostal,
                'PHYSICAL_COUNTRY' => $physicalCountry,
                'PHYSICAL_PHONE' => $physicalPhone,
                'UPDATED_AT' => time());
            $this->ProfileInfo_model->UpdateProfileInformation($updateArray, $whereArray);
            $whereUserArray = array('ID' => $this->session->userdata['me']['ID']);
            $setArray = array(
                'EMAIL' => $userInfoEmail,
                'UPDATED_AT' => time()
            );
            $this->User_model->UpdateUserObject($setArray, $whereUserArray);

            $userObjectArray  = $this->User_model->FindUserByArray($whereUserArray);
            $session_value = array(
                'logged_in' => true,
                'me' => $userObjectArray[0]
            );
            $this->session->set_userdata($session_value);
            $dataToBeDisplayed['success'] = true;
            $dataToBeDisplayed['password'] = false;

        }
        else
        {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['password'] = false;
        }
        $currentProfileData = $this->ProfileInfo_model->GetProfileInformation(array('a.ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['currentProfileData'] = $currentProfileData;
        $cityList = array();
        if($currentProfileData[0]['COUNTRY_INDEX'] != '0') {
            $cityList = $this->UtilInfo_model->GetCityList(array('COUNTRY_INDEX' => $currentProfileData[0]['COUNTRY_INDEX']));
        }

        $dataToBeDisplayed['cityList'] = $cityList;
        $dataToBeDisplayed['kycData'] = 'none';

        if($myProfileData[0]['VERIFY_STATUS'] == '1') {
            $kycData = $this->Kyc_model->GetVerificationInformation(array('USER_ID' => $this->session->userdata['me']['ID']));
            if(count($kycData) > 0) {
                $dataToBeDisplayed['kycData'] = $kycData[0];
            }
        }
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/profile/view', $dataToBeDisplayed);
    }

    public function updatepass(){

        $userInfoCurrentPassword = $this->input->post('userInfoCurrentPassword');
        $userInfoNewPassword = $this->input->post('userInfoNewPassword');
        $userInfoConfirmNewPassword = $this->input->post('userInfoConfirmNewPassword');
//        $retVal = array('current' => md5($userInfoCurrentPassword), 'new' => $userInfoNewPassword, 'confirm' => $userInfoConfirmNewPassword, 'my' => $this->session->userdata['me']['PASSWORD']);
        $retVal = array();
        if($userInfoNewPassword == $userInfoConfirmNewPassword){
            $userInfoCurrentPassword = md5($userInfoCurrentPassword);
            $userInfoNewPassword = md5($userInfoNewPassword);
            if($this->session->userdata['me']['PASSWORD'] == $userInfoCurrentPassword) {
                $whereUserArray = array('ID' => $this->session->userdata['me']['ID']);
                $setArray = array(
                    'PASSWORD' => $userInfoNewPassword,
                    'UPDATED_AT' => time()
                );
                $this->User_model->UpdateUserObject($setArray, $whereUserArray);

                $userObjectArray = $this->User_model->FindUserByArray($whereUserArray);
                $session_value = array(
                    'logged_in' => true,
                    'me' => $userObjectArray[0]
                );
                $this->session->set_userdata($session_value);
                $retVal = array('result' => 'success');
            }
            else{
                //current password is wrong
                $retVal = array('result' => 'wrong');
            }
        }
        else{
            //new password doesn't match
            $retVal = array('result' => 'match');
        }
        echo json_encode($retVal);
    }

    public function update_profile()
    {
        $chkNotifyPendingExecuted = $this->input->post("chkNotifyPendingExecuted") == 'on' ? 1 : 0;
        $chkNotifyFundReceive = $this->input->post("chkNotifyFundReceive") == 'on' ? 1 : 0;
        $chkNotifyInternalMsg = $this->input->post("chkNotifyInternalMsg") == 'on' ? 1 : 0;
        $chkNotifyLoginAttempt = $this->input->post("chkNotifyLoginAttempt") == 'on' ? 1 : 0;
        $chkNotifyFundAdd = $this->input->post("chkNotifyFundAdd") == 'on' ? 1 : 0;
        $selectSecurity = $this->input->post("selectSecurity");
        $txtSecurityAnswer = $this->input->post("txtSecurityAnswer");

        $whereArray = array('ID' => $this->session->userdata['me']['ID']);
        $this->User_model->UpdateUserObject(array(
            'NOTIFY_PENDING_EXECUTED' => $chkNotifyPendingExecuted,
            'NOTIFY_FUND_RECEIVE' => $chkNotifyFundReceive,
            'NOTIFY_INTERNAL_MESSAGE' => $chkNotifyInternalMsg,
            'NOTIFY_LOGIN_FAILS' => $chkNotifyLoginAttempt,
            'NOTIFY_FUND_ADD' => $chkNotifyFundAdd,
            'SECURY_QUESTION_ID' => $selectSecurity,
            'SECURITY_ANSWER' => $txtSecurityAnswer
        ), $whereArray);
        redirect(base_url().'profile/setting');
    }

    public function setting() {
        $dataToBeDisplayed = $this->makeComponentViews(0);
        $userDetail = $this->User_model->FindUserByArray(array('ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['userDetail'] = $userDetail[0];
        $dataToBeDisplayed['securityQuestions'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_SECURITY_INFO);
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/profile/setting', $dataToBeDisplayed);
    }

    public function getCitiesFromCountry() {
        $countryIndex = $this->input->post('COUNTRY');
        $citiesList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CITY_INFO, array('COUNTRY_INDEX' => $countryIndex));
        $resultSend = json_encode($citiesList);
        echo ($resultSend);
    }

}