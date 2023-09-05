<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 8:17 PM
 */
class AccountController extends CI_Controller
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
        $this->Notification_model->UpdateReadStatus(array('USER_ID' => $this->session->userdata['me']['ID'], 'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE));
        $this->Notification_model->UpdateReadStatus(array('USER_ID' => $this->session->userdata['me']['ID'], 'REASON_TYPE' => NOTIFY_NEW_ACCOUNT_CREATE));
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

    public function view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(2);
        $accountList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID'], 'a.ACCOUNT_TYPE <>' => ACCOUNT_TYPE_CARD));
        $dataToBeDisplayed['accounts'] = $accountList;

        $cardList = $this->Card_model->GetUserCardDetailInformation(array('a.USER_ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['cards'] = $cardList;
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/accounts/view', $dataToBeDisplayed);
    }

    public function getBankAccountAjax()
    {
        $id = $this->input->post('accountId');
        $accountList = $this->Account_model->FindAccountByArray(array('a.ID' => $id));
        $transHistory = $this->TransferHistory_model->GetTransferHistory($id);
        for($index = 0 ; $index < count($transHistory); $index++)
        {
            $statusTitle = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_STATUS, array('ID'=>$transHistory[$index]['STATUS']));
            $transHistory[$index]['STATUS_DESCRIPTION'] = $statusTitle[0]['DESCRIPTION'];
        }
        $accountList[0]['transaction'] = $transHistory;
        echo json_encode($accountList);
    }
}