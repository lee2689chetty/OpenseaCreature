<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminProfileController extends CI_Controller
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
        $dataToBeDisplayed['notifyVerifyDocs'] = 5;
        return $dataToBeDisplayed;
    }

    public function user_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_USER);

        $userId = $this->input->post('userId');
        $email = $this->input->post('email');
        $status = $this->input->post('status');
        $from = $this->input->post('from');
        $to = $this->input->post('to');

        $whereArray = array();
        if(isset($userId) && $userId != "0")
        {
            $whereArray['b.ID'] = $userId;
        }
        if(isset($from) && $from != "")
        {
            $whereArray['a.CREATED_AT >='] = strtotime($from);
        }
        if(isset($to) && $to != "")
        {
            $whereArray['a.CREATED_AT <='] = strtotime($to);
        }
        if(isset($email) && $email != "0")
        {
            $whereArray['b.EMAIL'] = $email;
        }
        if(isset($status) && $status != '0')
        {
            $whereArray['b.STATUS'] = $status;
        }

        $userDetailInfoArray = $this->ProfileInfo_model->GetUserDetailInformation();
        $userDispListArray = $this->ProfileInfo_model->GetUserDetailInformation($whereArray);
        $statusArray  = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);

        $dataToBeDisplayed['userList'] = $userDetailInfoArray;
        $dataToBeDisplayed['userDispArray'] = $userDispListArray;
        $dataToBeDisplayed['statusList'] = $statusArray;
        $dataToBeDisplayed['whereArray'] = $whereArray;

        $this->load->view('admin/pages/profile/view_user_profile', $dataToBeDisplayed);
    }

    public function fee_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_FEE);
        $dataToBeDisplayed['feeProfileList'] = $this->UtilInfo_model->GetFeeProfileInformation();
        $this->load->view('admin/pages/profile/view_fee_profile', $dataToBeDisplayed);
    }

    public function user_create()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_USER);

        $profileType = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PROFILE_KIND);
        $countryList = $this->UtilInfo_model->GetCountryList();
        $statusList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);

        $dataToBeDisplayed['profileList'] = $profileType;
        $dataToBeDisplayed['countryList'] = $countryList;
        $dataToBeDisplayed['statusList'] = $statusList;
        $dataToBeDisplayed['duplicate_email'] = false;
        $dataToBeDisplayed['duplicate_name'] = false;
        $dataToBeDisplayed['error'] = false;
        $dataToBeDisplayed['success'] = false;
        $this->load->library('form_validation');
        //form validation here.
        $this->form_validation->set_rules('profileType', 'Profile Type' , 'required');
        $this->form_validation->set_rules('firstName', 'First Name' , 'required');
        $this->form_validation->set_rules('lastName', 'Last Name' , 'required');

        $this->form_validation->set_rules('userName', 'User Name' , 'required');
        $this->form_validation->set_rules('emailAddress', 'Email Address' , 'required|valid_email');
        $this->form_validation->set_rules('confirmEmail', 'Confirm Email' , 'required|matches[emailAddress]');
        $this->form_validation->set_rules('passwordInput', 'Password Input' , 'required|min_length[6]');
        $this->form_validation->set_rules('confirmPassword', 'confirmPassword' , 'required|matches[passwordInput]');
        $this->form_validation->set_rules('statusList', 'statusList' , 'required');

        if($this->form_validation->run() == TRUE)
        {
            /**
             * Begin User Information Part
             */
            $profileType = $this->input->post('profileType');
            $firstName = $this->input->post('firstName');
            $lastName = $this->input->post('lastName');
            $companyName = $this->input->post('companyName');

            /// Begin of user info table data.....
            $userName = $this->input->post('userName');
            $emailAddress = $this->input->post('emailAddress');
            $passwordInput = $this->input->post('passwordInput');
            $statusList = $this->input->post('statusList');
            /// End of user info table data.....


            $birthday = $this->input->post('birthday');
            $passport = $this->input->post('passport');
            $countryList = $this->input->post('countryList');
            if($countryList == NULL) $countryList = 0;
            $cityList = $this->input->post('cityList');
            if($cityList == NULL) $cityList = 0;
            $phone = $this->input->post('phone');
            $homePhone = $this->input->post('homePhone');
            $officePhone = $this->input->post('officePhone');
            $fax = $this->input->post('fax');

            /**
             * Benifical Owner
             */
            $benefitFullName = $this->input->post('benefitFullName');
            $benefitDOB = $this->input->post('benefitDOB');
            $benefitRelation = $this->input->post('benefitRelation');
            $benefitAddress = $this->input->post('benefitAddress');
            $benefitPhone = $this->input->post('benefitPhone');

            /**
             * Mailing Address
             */
            $mailingAddress = $this->input->post('mailingAddress');
            $mailing2ndAddress = $this->input->post('mailing2ndAddress');
            $mailingCity = $this->input->post('mailingCity');
            $mailingProvince = $this->input->post('mailingProvince');
            $mailingZipPostal = $this->input->post('mailingZipPostal');
            $mailingCountry = $this->input->post('mailingCountry');
            $mailingPhone = $this->input->post('mailingPhone');

            /**
             * Physical Address
             */
            $physicalAddress = $this->input->post('physicalAddress');
            $physical2ndAddress = $this->input->post('physical2ndAddress');
            $physicalCity = $this->input->post('physicalCity');
            $physicalState = $this->input->post('physicalState');
            $physicalZipPostal = $this->input->post('physicalZipPostal');
            $physicalCountry = $this->input->post('physicalCountry');
            $physicalPhone = $this->input->post('physicalPhone');

            /***
             * Internal Message
             */
            $internalMessage = $this->input->post('txtInternalNote');

            /**
             * Don't forget to make new message entry point in message box: "About create account"
             * Also, send email notification to user
             */

            $isExistUserName = $this->User_model->FindUserByArray(array('NAME' => $userName));
            $isExistEmail = $this->User_model->FindUserByArray(array('EMAIL' => $emailAddress));

            if(count($isExistEmail) > 0) {
                $dataToBeDisplayed['duplicate_email'] = true;
                $dataToBeDisplayed['error'] = true;
            }
            else {
                if (count($isExistUserName) > 0) {
                    $dataToBeDisplayed['duplicate_name'] = true;
                    $dataToBeDisplayed['error'] = true;
                } else {
                    $userIdCard = "";
                    if (!empty($_FILES['identification']['name'])) {
                        $attachdirname  = './usr_identification';
                        if (!is_dir(''.$attachdirname)) {
                            mkdir(''.$attachdirname, 0777, TRUE);
                        }
                        $userIdCard = $this->fileUpload($attachdirname, 'user_id_'.time(), 'identification');
                    }


                    $now = time();

                    $insertArray = array(
                        'PROFILE_KIND' => $profileType,
                        'COMPANY_NAME' => $companyName,
                        'FIRST_NAME' => $firstName,
                        'LAST_NAME' => $lastName,
                        'USER_NAME' => $userName,
                        'DOB' => $birthday,
                        'ID_CARD' => $userIdCard,
                        'PASSPORT_NUMBER' => $passport,
                        'COUNTRY_INDEX' => $countryList,
                        'CITY_INDEX' => $cityList,
                        'PHONE' => $phone,
                        'OFFICE_PHONE' => $officePhone,
                        'HOME_PHONE' => $homePhone,
                        'FAX' => $fax,

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
                        'INTERNAL_MESSAGE' => $internalMessage,
                        'UPDATED_AT' => $now,
                        'CREATED_AT' => $now
                    );

                    $insertResult = $this->ProfileInfo_model->InsertProfileInformation($insertArray);
                    if ($insertResult != -1) {
                        $now = time();
                        $userInsertArray = array(
                            'LEVEL' => '4',
                            'NAME' => $userName,
                            'FULL_NAME' => $firstName . ' ' . $lastName,
                            'EMAIL' => $emailAddress,
                            'PASSWORD' => md5($passwordInput),
                            'STATUS' => $statusList,
                            'PROFILE_ID' => $insertResult,
                            'UPDATED_AT' => $now,
                            'CREATED_AT' => $now
                        );

                        $userInsertResult = $this->User_model->InsertUserInformation($userInsertArray);
                        if ($userInsertResult != -1) {
                            $dataToBeDisplayed['error'] = false;
                            $dataToBeDisplayed['success'] = true;
                        }
                    }

                }
            }
        }
        $this->load->view('admin/pages/profile/create_user', $dataToBeDisplayed);
    }

    public function getCitiesFromCountry()
    {
        $countryIndex = $this->input->post('COUNTRY');
        $citiesList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CITY_INFO, array('COUNTRY_INDEX' => $countryIndex));
        $resultSend = json_encode($citiesList);
        echo ($resultSend);
    }

    public function detail($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_USER);
        $userDetail = $this->User_model->FindUserByArray(array('PROFILE_ID' => $id));
        $dataToBeDisplayed['userDetail'] = $userDetail[0];
        $dataToBeDisplayed['securityQuestions'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_SECURITY_INFO);
        $this->load->view('admin/pages/profile/setting', $dataToBeDisplayed);
    }

    public function edit($id){
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_USER);
        $profileType = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PROFILE_KIND);
        $countryList = $this->UtilInfo_model->GetCountryList();
        $statusList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);

        $dataToBeDisplayed['profileList'] = $profileType;
        $dataToBeDisplayed['countryList'] = $countryList;
        $dataToBeDisplayed['statusList'] = $statusList;

//        $userDetail = $this->User_model->FindUserByArray(array('PROFILE_ID' => $id));
        $profileDetail = $this->ProfileInfo_model->GetProfileInformation(array('a.PROFILE_ID' => $id));

        $city = $this->UtilInfo_model->GetCityList(array('ID' => $profileDetail[0]['CITY_INDEX']));
        $cityList = $this->UtilInfo_model->GetCityList(array('COUNTRY_INDEX' => $profileDetail[0]['COUNTRY_INDEX']));
        if(count($city) == 0){
            $profileDetail[0]['CITY_TITLE'] = "--NONE--";
        }
        else{
            $profileDetail[0]['CITY_TITLE'] = $city[0]['DESCRIPTION'];
        }
        $dataToBeDisplayed['cityList'] = $cityList;
        $dataToBeDisplayed['userDetail'] = $profileDetail[0];
        $this->load->view('admin/pages/profile/detail_user_info', $dataToBeDisplayed);
    }

    public function update_detail_name($profileId){
        $userId = $this->input->post('userId');
        $profileType = $this->input->post('profileType');
        $firstName = $this->input->post('firstName');
        $lastName = $this->input->post('lastName');
        $userName = $this->input->post('userName');
        $statusList = $this->input->post('statusList');
        $companyName = $this->input->post('companyName');

        $isExistUserName = $this->User_model->FindUserByArray(array('NAME' => $userName));
        $this->session->set_flashdata('nameDuplicate', count($isExistUserName) > 0);
        if(count($isExistUserName == 0)) {
            $profileUpdateArray = array('PROFILE_KIND' => $profileType, 'COMPANY_NAME' => $companyName, 'FIRST_NAME' => $firstName, 'LAST_NAME' => $lastName, 'USER_NAME' => $userName, 'UPDATED_AT' => time());
            $this->ProfileInfo_model->UpdateProfileInformation($profileUpdateArray, array('ID' => $profileId));

            $userUpdateArray = array('NAME' => $userName, 'FULL_NAME' => ($firstName . " " . $lastName), 'STATUS' => $statusList, 'UPDATED_AT' => time());
            $this->User_model->UpdateUserObject($userUpdateArray, array('ID' => $userId));
        }


        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_detail_email($profileId){
        $userId = $this->input->post('userId');
        $emailAddress = $this->input->post('emailAddress');
        $isExistEmail = $this->User_model->FindUserByArray(array('EMAIL' => $emailAddress));
        $this->session->set_flashdata('emailDuplicate', count($isExistEmail));
        if(count($isExistEmail) == 0) {
            $userUpdateArray = array('EMAIL' => $emailAddress, 'UPDATED_AT' => time());
            $this->User_model->UpdateUserObject($userUpdateArray, array('ID' => $userId));
        }
        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_detail_pass($profileId){
        $userId = $this->input->post('userId');
        $passwordInput = $this->input->post('passwordInput');
        $passwordInput = md5($passwordInput);
        $userUpdateArray = array('PASSWORD' => $passwordInput, 'UPDATED_AT' => time());
        $this->User_model->UpdateUserObject($userUpdateArray, array('ID' => $userId));
        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_detail_identification($profileId){
        $userId = $this->input->post('userId');
        $birthday = $this->input->post('birthday');
        $passport = $this->input->post('passport');
        $countryList = $this->input->post('countryList');
        $cityList = $this->input->post('cityList');
        $phone = $this->input->post('phone');
        $homePhone = $this->input->post('homePhone');
        $officePhone = $this->input->post('officePhone');
        $fax = $this->input->post('fax');

        $userIdCard = "";
        if (!empty($_FILES['identification']['name'])) {
            $attachdirname  = './usr_identification';
            if (!is_dir(''.$attachdirname)) {
                mkdir(''.$attachdirname, 0777, TRUE);
            }
            $userIdCard = $this->fileUpload($attachdirname, 'user_id_'.time(), 'identification');
        }
        $profileUpdateArray = array('DOB' => $birthday,
                                    'PASSPORT_NUMBER' => $passport,
                                    'COUNTRY_INDEX' => $countryList,
                                    'CITY_INDEX' => $cityList,
                                    'PHONE' => $phone,
                                    'OFFICE_PHONE' => $officePhone,
                                    'HOME_PHONE' => $homePhone,
                                    'FAX' => $fax,
                                    'UPDATED_AT' => time());
        if($userIdCard != ""){
            $profileUpdateArray['ID_CARD'] = $userIdCard;
        }
        $this->ProfileInfo_model->UpdateProfileInformation($profileUpdateArray, array('ID' => $profileId));
        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_detail_benefical($profileId){
        $benefitFullName = $this->input->post('benefitFullName');
        $benefitDOB = $this->input->post('benefitDOB');
        $benefitRelation = $this->input->post('benefitRelation');
        $benefitAddress = $this->input->post('benefitAddress');
        $benefitPhone = $this->input->post('benefitPhone');

        $profileUpdateArray = array('BENEFICAL_FULL_NAME' => $benefitFullName,
                                    'BENIFICAL_DOB' => $benefitDOB,
                                    'BENIFICAL_RELATION' => $benefitRelation,
                                    'BENIFICAL_ADDR' => $benefitAddress,
                                    'BENIFICAL_PHONE' => $benefitPhone,
                                    'UPDATED_AT' => time());
        $this->ProfileInfo_model->UpdateProfileinformation($profileUpdateArray, array('ID' => $profileId));
        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_detail_address($profileId){
        $physicalAddress = $this->input->post('physicalAddress');
        $physical2ndAddress = $this->input->post('physical2ndAddress');
        $physicalCity = $this->input->post('physicalCity');
        $physicalState = $this->input->post('physicalState');
        $physicalZipPostal = $this->input->post('physicalZipPostal');
        $physicalCountry = $this->input->post('physicalCountry');
        $physicalPhone = $this->input->post('physicalPhone');
        $mailingAddress = $this->input->post('mailingAddress');
        $mailing2ndAddress = $this->input->post('mailing2ndAddress');
        $mailingCity = $this->input->post('mailingCity');
        $mailingProvince = $this->input->post('mailingProvince');
        $mailingZipPostal = $this->input->post('mailingZipPostal');
        $mailingCountry = $this->input->post('mailingCountry');
        $mailingPhone = $this->input->post('mailingPhone');

        $profileUpdateArray = array('MAILING_ADDR' => $mailingAddress,
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
        $this->ProfileInfo_model->UpdateProfileinformation($profileUpdateArray, array('ID' => $profileId));
        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_detail_internal($profileId){
        $txtInternalNote = $this->input->post('txtInternalNote');
        $profileUpdateArray = array('INTERNAL_MESSAGE' => $txtInternalNote,
                                    'UPDATED_AT' => time());
        $this->ProfileInfo_model->UpdateProfileinformation($profileUpdateArray, array('ID' => $profileId));
        redirect(base_url()."admin/profile/edit/".$profileId);
    }

    public function update_profile($userId)
    {
        $chkNotifyPendingExecuted = $this->input->post("chkNotifyPendingExecuted") == 'on' ? 1 : 0;
        $chkNotifyFundReceive = $this->input->post("chkNotifyFundReceive") == 'on' ? 1 : 0;
        $chkNotifyInternalMsg = $this->input->post("chkNotifyInternalMsg") == 'on' ? 1 : 0;
        $chkNotifyLoginAttempt = $this->input->post("chkNotifyLoginAttempt") == 'on' ? 1 : 0;
        $chkNotifyFundAdd = $this->input->post("chkNotifyFundAdd") == 'on' ? 1 : 0;
        $selectSecurity = $this->input->post("selectSecurity");
        $txtSecurityAnswer = $this->input->post("txtSecurityAnswer");


        $this->User_model->UpdateUserObject(array(
            'NOTIFY_PENDING_EXECUTED' => $chkNotifyPendingExecuted,
            'NOTIFY_FUND_RECEIVE' => $chkNotifyFundReceive,
            'NOTIFY_INTERNAL_MESSAGE' => $chkNotifyInternalMsg,
            'NOTIFY_LOGIN_FAILS' => $chkNotifyLoginAttempt,
            'NOTIFY_FUND_ADD' => $chkNotifyFundAdd,
            'SECURY_QUESTION_ID' => $selectSecurity,
            'SECURITY_ANSWER' => $txtSecurityAnswer
        ), array('ID' => $userId));

        $userDetail = $this->User_model->FindUserByArray(array('ID' => $userId));
        redirect(base_url().'admin/profile/detail/'.$userDetail[0]['PROFILE_ID']);
    }

    public function new_feeprofile()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_FEE);
        $dataToBeDisplayed['isUpdate'] = false;

        $dataToBeDisplayed['currencyList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $dataToBeDisplayed['locChargePeriod'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CHARGE_PERIOD);
        $dataToBeDisplayed['mbChargeDay'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CHARGE_DAY);
        $dataToBeDisplayed['locMethod'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_LOC_METHOD);
        $dataToBeDisplayed['payoutDay'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PAYOUT_DAY);

        $dataToBeDisplayed['error'] = true;
        $dataToBeDisplayed['success'] = false;

        $this->load->library('form_validation');

        $this->form_validation->set_rules('accountType', 'Account Type' , 'required');
        $this->form_validation->set_rules('monthlyFeeAmount', 'Fee Amount' , 'required');
        $this->form_validation->set_rules('mbLimitAccount', 'Limit Account' , 'required');
        $this->form_validation->set_rules('mbFeeAmount', 'Fee Amount' , 'required');
        $this->form_validation->set_rules('locLimitAmount', 'Limit Account' , 'required');
        $this->form_validation->set_rules('locAnnualInterest', 'Annual Interest Rate' , 'required');

        if($this->form_validation->run() == TRUE)
        {

            $accountType = $this->input->post("accountType");
            $iwtAmount = $this->input->post("iwtAmount");
            $iwtAmount = floatval((str_replace(",","", $iwtAmount)));
            $iwtType = $this->input->post("iwtType");

            $owtAmount = $this->input->post("owtAmount");
            $owtAmount = floatval((str_replace(",","", $owtAmount)));
            $owtType = $this->input->post("owtType");

            $cftAmount = $this->input->post("cftAmount");
            $cftAmount = floatval((str_replace(",","", $cftAmount)));
            $cftType = $this->input->post("cftType");

            $currencyRate = $this->input->post("currencyRate");
            $currencyRate = floatval((str_replace(",","", $currencyRate)));

            $minFeeValue = $this->input->post("minTransFeeAmount");
            $minFeeValue = floatval((str_replace(",","", $minFeeValue)));

            $maxFeeValue = $this->input->post("maxTransFeeAmount");
            $maxFeeValue = floatval((str_replace(",","", $maxFeeValue)));


            $chkMonthlymaintenance = is_null($this->input->post("chkMonthlymaintenance"))?0:1;
            $monthlyFeeAmount = $this->input->post("monthlyFeeAmount");
            $monthlyFeeAmount = floatval((str_replace(",","", $monthlyFeeAmount)));

            $chkMinibalance = is_null($this->input->post("chkMinibalance")) ?0:1;
            $mbLimitAccount = $this->input->post("mbLimitAccount");
            $mbLimitAccount = floatval((str_replace(",","", $mbLimitAccount)));

            $mbFeeAmount = $this->input->post("mbFeeAmount");
            $mbFeeAmount = floatval((str_replace(",","", $mbFeeAmount)));

            $mbChargeDay = $this->input->post("mbChargeDay");
            $chkLoc = is_null($this->input->post("chkLoc")) ? 0 : 1;
            $locLimitAmount = $this->input->post("locLimitAmount");
            $locLimitAmount = floatval((str_replace(",","", $locLimitAmount)));

            $locAnnualInterest = $this->input->post("locAnnualInterest");
            $locAnnualInterest = floatval((str_replace(",","", $locAnnualInterest)));

            $locMethod = $this->input->post("locMethod");
            $locChargePeriod = $this->input->post("locChargePeriod");

            $chkInterestingGenerate = is_null($this->input->post("chkInterestingGenerate")) ? 0 : 1;
            $txtAnnualInterest = $this->input->post("txtAnnualInterest");
            $txtAnnualInterest = floatval((str_replace(",","", $txtAnnualInterest)));

            $annualMethod = $this->input->post("annualMethod");
            $annualPayout = $this->input->post("annualPayout");
            $annualPayoutDay = $this->input->post("annualPayoutDay");

            $now = time();
            $insertArray = array(
                'ACCOUNT_TYPE' => $accountType,
                'IWT_AMOUNT' => $iwtAmount,
                'IWT_TYPE' => $iwtType,
                'OWT_AMOUNT' => $owtAmount,
                'OWT_TYPE' => $owtType,
                'CFT_AMOUNT' => $cftAmount,
                'CFT_TYPE' => $cftType,
                'CURRENCY_CONVERSION_RATE' => $currencyRate,
                'MIN_TRANS_FEE' => $minFeeValue,
                'MAX_TRANS_FEE' => $maxFeeValue,
                'IS_MONTHLY_MAINTENANCE' => $chkMonthlymaintenance,
                'MONTHLY_FEE_AMOUNT' => $monthlyFeeAmount,
                'IS_MINIMUM_BALANCE' => $chkMinibalance,
                'MINIMUM_LIMIT_AMOUNT' => $mbLimitAccount,
                'MINIMUM_LIMIT_FEE_AMOUNT' => $mbFeeAmount,
                'MINIMUM_CHARGE_DAY' => $mbChargeDay,
                'IS_LOC' => $chkLoc,
                'LOC_LIMIT_AMOUNT' => $locLimitAmount,
                'LOC_ANNUAL_RATE' => $locAnnualInterest,
                'LOC_METHOD' => $locMethod,
                'LOC_CHARGE_PERIOD' => $locChargePeriod,
                'IS_INTEREST' => $chkInterestingGenerate,
                'INTEREST_ANNUAL_RATE' => $txtAnnualInterest,
                'INTEREST_METHOD' => $annualMethod,
                'INTEREST_PAYOUT_PERIOD' => $annualPayout,
                'INTEREST_PAYOUT_DAY' => $annualPayoutDay,
                'UPDATED_AT' => $now,
                'CREATED_AT' => $now
            );

            $insertResult = $this->UtilInfo_model->InsertUtilInformation(MY_Model::TABLE_ACCOUNT_FEE_INFO, $insertArray);
            if($insertResult != -1)
            {
                $dataToBeDisplayed['error'] = false;
                $dataToBeDisplayed['success'] = true;
            }
        }
        else
        {
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed['success'] = false;
        }
        $this->load->view('admin/pages/profile/account_fee_create', $dataToBeDisplayed);
    }

    public function update_fee($feeId)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_PROFILE_FEE);
        $dataToBeDisplayed['isUpdate'] = true;
        $dataToBeDisplayed['locChargePeriod'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CHARGE_PERIOD);
        $dataToBeDisplayed['mbChargeDay'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CHARGE_DAY);
        $dataToBeDisplayed['locMethod'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_LOC_METHOD);
        $dataToBeDisplayed['payoutDay'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PAYOUT_DAY);

        $dataToBeDisplayed['error'] = true;
        $dataToBeDisplayed['success'] = false;

        $this->load->library('form_validation');

        $this->form_validation->set_rules('accountType', 'Account Type' , 'required');
        $this->form_validation->set_rules('monthlyFeeAmount', 'Fee Amount' , 'required');
        $this->form_validation->set_rules('mbLimitAccount', 'Limit Account' , 'required');
        $this->form_validation->set_rules('mbFeeAmount', 'Fee Amount' , 'required');
        $this->form_validation->set_rules('locLimitAmount', 'Limit Account' , 'required');
        $this->form_validation->set_rules('locAnnualInterest', 'Annual Interest Rate' , 'Required');

        if($this->form_validation->run() == TRUE)
        {

            $accountType = $this->input->post("accountType");
            $iwtAmount = $this->input->post("iwtAmount");
            $iwtAmount = floatval((str_replace(",","", $iwtAmount)));

            $iwtType = $this->input->post("iwtType");
            $owtAmount = $this->input->post("owtAmount");
            $owtAmount = floatval((str_replace(",","", $owtAmount)));

            $owtType = $this->input->post("owtType");
            $cftAmount = $this->input->post("cftAmount");
            $owtAmount = floatval((str_replace(",","", $owtAmount)));

            $cftType = $this->input->post("cftType");
            $currencyRate = $this->input->post("currencyRate");
            $currencyRate = floatval((str_replace(",","", $currencyRate)));

            $minFeeValue = $this->input->post("minTransFeeAmount");
            $minFeeValue = floatval((str_replace(",","", $minFeeValue)));
            $maxFeeValue = $this->input->post("maxTransFeeAmount");
            $maxFeeValue = floatval((str_replace(",","", $maxFeeValue)));

            $chkMonthlymaintenance = is_null($this->input->post("chkMonthlymaintenance"))?0:1;
            $monthlyFeeAmount = $this->input->post("monthlyFeeAmount");
            $monthlyFeeAmount = floatval((str_replace(",","", $monthlyFeeAmount)));

            $chkMinibalance = is_null($this->input->post("chkMinibalance")) ?0:1;
            $mbLimitAccount = $this->input->post("mbLimitAccount");
            $mbLimitAccount = floatval((str_replace(",","", $mbLimitAccount)));
            $mbFeeAmount = $this->input->post("mbFeeAmount");
            $mbFeeAmount = floatval((str_replace(",","", $mbFeeAmount)));
            $mbChargeDay = $this->input->post("mbChargeDay");

            $chkLoc = is_null($this->input->post("chkLoc")) ? 0 : 1;
            $locLimitAmount = $this->input->post("locLimitAmount");
            $locLimitAmount = floatval((str_replace(",","", $locLimitAmount)));
            $locAnnualInterest = $this->input->post("locAnnualInterest");
            $locAnnualInterest = floatval((str_replace(",","", $locAnnualInterest)));
            $locMethod = $this->input->post("locMethod");
            $locChargePeriod = $this->input->post("locChargePeriod");

            $chkInterestingGenerate = is_null($this->input->post("chkInterestingGenerate")) ? 0 : 1;
            $txtAnnualInterest = $this->input->post("txtAnnualInterest");
            $annualMethod = $this->input->post("annualMethod");
            $annualPayout = $this->input->post("annualPayout");
            $annualPayoutDay = $this->input->post("annualPayoutDay");

            $now = time();
            $updateArray = array(
                'ACCOUNT_TYPE' => $accountType,
                'IWT_AMOUNT' => $iwtAmount,
                'IWT_TYPE' => $iwtType,
                'OWT_AMOUNT' => $owtAmount,
                'OWT_TYPE' => $owtType,
                'CFT_AMOUNT' => $cftAmount,
                'CFT_TYPE' => $cftType,
                'CURRENCY_CONVERSION_RATE' => $currencyRate,
                'MIN_TRANS_FEE' => $minFeeValue,
                'MAX_TRANS_FEE' => $maxFeeValue,
                'IS_MONTHLY_MAINTENANCE' => $chkMonthlymaintenance,
                'MONTHLY_FEE_AMOUNT' => $monthlyFeeAmount,
                'IS_MINIMUM_BALANCE' => $chkMinibalance,
                'MINIMUM_LIMIT_AMOUNT' => $mbLimitAccount,
                'MINIMUM_LIMIT_FEE_AMOUNT' => $mbFeeAmount,
                'MINIMUM_CHARGE_DAY' => $mbChargeDay,
                'IS_LOC' => $chkLoc,
                'LOC_LIMIT_AMOUNT' => $locLimitAmount,
                'LOC_ANNUAL_RATE' => $locAnnualInterest,
                'LOC_METHOD' => $locMethod,
                'LOC_CHARGE_PERIOD' => $locChargePeriod,
                'IS_INTEREST' => $chkInterestingGenerate,
                'INTEREST_ANNUAL_RATE' => $txtAnnualInterest,
                'INTEREST_METHOD' => $annualMethod,
                'INTEREST_PAYOUT_PERIOD' => $annualPayout,
                'INTEREST_PAYOUT_DAY' => $annualPayoutDay,
                'UPDATED_AT' => $now,
                'CREATED_AT' => $now
            );

            $this->UtilInfo_model->UpdateUtilInformation(MY_Model::TABLE_ACCOUNT_FEE_INFO, $updateArray, array('ID' => $feeId));
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed['success'] = true;
        }
        else
        {
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed['success'] = false;
        }
        $originAccount = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_FEE_INFO, array('ID' => $feeId));
        $dataToBeDisplayed['originAccount'] = $originAccount[0];
        $this->load->view('admin/pages/profile/account_fee_create', $dataToBeDisplayed);
    }

    protected function fileUpload($pathToUpload, $nameToUpload, $filePostFiled){
        $config['upload_path']   = $pathToUpload."/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 1024*9;//6 MB Maximum
        $config['max_width']     = 8000;
        $config['max_height']    = 8000;
        $config['file_name'] = $nameToUpload;
        $this->load->library('upload', $config);

        $this->upload->initialize($config);
        $upload_result = $this->upload->do_upload($filePostFiled);
        $uploadFilePath = "";
        if($upload_result == TRUE){
            $uploadFilePath = $pathToUpload."/".$this->upload->data('file_name');
        }
        else{
//            $uploadFilePath = $this->upload->display_errors();

            $uploadFilePath = "";
        }
        return $uploadFilePath;
    }

}