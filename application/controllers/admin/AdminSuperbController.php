<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminSuperbController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect(base_url().'admin/auth/login');
        }
        else if($this->session->userdata['me']['LEVEL'] == '4')
        {
            redirect(base_url().'auth/login');
        }
    }

    public function makeComponentViews($menuNum) {
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

    public function view() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ADMIN_MANAGE);
        $adminArray = $this->User_model->FindUserByArray(array('LEVEL<' => 4));
        $levelArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_BASIS_USER_LEVEL);
        $statusArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);

        for($i = 0 ; $i < count($adminArray); $i++){
            $adminArray[$i]['LEVEL_TITLE'] = $levelArray[$adminArray[$i]['LEVEL'] - 1]['TITLE'];
            $adminArray[$i]['STATUS_TITLE'] = $statusArray[$adminArray[$i]['STATUS'] - 1]['DESCRIPTION'];
        }
        $dataToBeDisplayed['accountList'] = $adminArray;
        $this->load->view('admin/pages/superb/view_admin_account', $dataToBeDisplayed);
    }

    public function edit($userId) {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ADMIN_MANAGE);
        $levelList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_BASIS_USER_LEVEL, array('ID<' => 4));
        $dataToBeDisplayed['levelList'] = $levelList;

        $statusArray  = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
        $dataToBeDisplayed['statusArray'] = $statusArray;

        $dataToBeDisplayed['adminData'] = $this->User_model->FindUserByArray(array('ID' => $userId));
        if(count($dataToBeDisplayed['adminData']) == 0){
            show_404();
            return;
        }

        $this->load->view('admin/pages/superb/edit_admin_account', $dataToBeDisplayed);
    }

    public function update_profile($userId) {
        $userStatus = $this->input->post('userStatus');
        $accountName = $this->input->post('accountName');
        $userInfoEmail = $this->input->post('userInfoEmail');
        $levelType = $this->input->post('levelType');
        $fullName = $this->input->post('fullName');

        //print_r(array(  'STATUS' => $userStatus, 'NAME' => $accountName, 'EMAIL' => $userInfoEmail, 'LEVEL' => $levelType, 'FULL_NAME' => $fullName));
        $this->load->library('Stringutils');
        if($this->stringutils->IsNullEmpty($userStatus) || $this->stringutils->IsNullEmpty($accountName)
            || $this->stringutils->IsNullEmpty($userInfoEmail)|| $this->stringutils->IsNullEmpty($levelType)) {
            redirect(base_url()."admin/supers/edit/".$userId);
            return;
        }

        $this->User_model->UpdateUserObject(array(  'STATUS' => $userStatus,
                                                    'NAME' => $accountName,
                                                    'FULL_NAME' => $fullName,
                                                    'EMAIL' => $userInfoEmail,
                                                    'LEVEL' => $levelType),
            array('ID' => $userId));
        redirect(base_url()."admin/supers/edit/".$userId);
    }

    public function password($userId) {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ADMIN_MANAGE);
        $dataToBeDisplayed['USER_ID'] = $userId;
        $dataToBeDisplayed['PASS_MISMATCH'] = false;
        $dataToBeDisplayed['OLD_MISMATCH'] = false;
        $dataToBeDisplayed['SUCCESS_CHANGE'] = false;
        $oldPassword = $this->input->post('oldPassword');
        $newPassword = $this->input->post('newPassword');
        $confirmPassword = $this->input->post('confirmPassword');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', ' Old Password ', 'required');
        $this->form_validation->set_rules('newPassword', ' New Password', 'required');
        $this->form_validation->set_rules('confirmPassword', ' Confirm New Password ', 'required');

        if ($this->form_validation->run() == TRUE) {
            $oldPassword = md5($oldPassword);
            $newPassword = md5($newPassword);
            $confirmPassword = md5($confirmPassword);

            $userData = $this->User_model->FindUserByArray(array('ID' => $userId));

            if($newPassword == $confirmPassword) {
                if($userData[0]['PASSWORD'] == $oldPassword) {
                    $this->User_model->UpdateUserObject(array('PASSWORD' => $newPassword), array('ID' => $userId));
                    $dataToBeDisplayed['SUCCESS_CHANGE'] = true;
                }
                else {
                    $dataToBeDisplayed['OLD_MISMATCH'] = true;
                }
            }
            else {
                $dataToBeDisplayed['PASS_MATCH'] = true;
            }
        }
        $this->load->view('admin/pages/superb/password_admin_account', $dataToBeDisplayed);
    }

    public function create() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ADMIN_MANAGE);
        $levelList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_BASIS_USER_LEVEL, array('ID<' => 4));
        $dataToBeDisplayed['levelList'] = $levelList;

        $statusArray  = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
        $dataToBeDisplayed['statusArray'] = $statusArray;
        $this->load->view('admin/pages/superb/create_admin_account', $dataToBeDisplayed);
    }

    public function create_admin(){
        $levelType = $this->input->post('levelType');
        $accountName = $this->input->post('accountName');
        $fullName = $this->input->post('fullName');
        $userInfoEmail = $this->input->post('userInfoEmail');
        $newPassword = $this->input->post('newPassword');
        $confirmPassword = $this->input->post('confirmPassword');
        $userStatus = $this->input->post('userStatus');

        $newPassword = md5($newPassword);
        $confirmPassword = md5($confirmPassword);
        if($newPassword == $confirmPassword){
            $existAccounts = $this->User_model->FindUserByArray(array('EMAIL' => $userInfoEmail));
            if(count($existAccounts) == 0) {
                $this->User_model->InsertUserInformation(array('LEVEL' => $levelType,
                    'NAME' => $accountName,
                    'FULL_NAME' => $fullName,
                    'EMAIL' => $userInfoEmail,
                    'PASSWORD' => $newPassword,
                    'LOGIN_ATTEMPT' => 0,
                    'BLOCK_TIME' => 0,
                    'STATUS' => $userStatus,
                    'PROFILE_ID' => 0,
                    'CREATED_AT' => time(),
                    'UPDATED_AT' => time()));
                redirect(base_url().'admin/supers/view');
            }
            else {
                redirect(base_url().'admin/supers/create');
            }
        }
        else{
            redirect(base_url().'admin/supers/create');
        }
    }
}