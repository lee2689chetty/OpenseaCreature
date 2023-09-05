<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 3/26/18
 * Time: 12:27 AM
 */
class AdminCurrencyRateController extends CI_Controller
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

    public function currencypair_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_CURRENCY_PAIR);
        $dataToBeDisplayed['currency'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_PAIR);
        $this->load->view('admin/pages/currency/currency_pair_view', $dataToBeDisplayed);
    }

    public function remove_pair($pairId)
    {
        $this->UtilInfo_model->DeleteUtilInformation(MY_Model::TABLE_CURRENCY_PAIR, array('ID' => $pairId));
    }

    public function addpair_view(){
        $dataToBeDisplayed = $this->makeComponentViews(MENU_CURRENCY_PAIR);
        $dataToBeDisplayed['currency'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('baseCurrency', 'Base Currency' , 'required');
        $this->form_validation->set_rules('secondaryCurrency', 'Secondary Currency' , 'required');
        $this->form_validation->set_rules('interbankRate', 'InterBank Rate' , 'required');
        $this->form_validation->set_rules('valorPayRate', 'ValorPay Rate' , 'required');

        if($this->form_validation->run() == TRUE)
        {
            $baseCurrency = $this->input->post('baseCurrency');
            $secondaryCurrency = $this->input->post('secondaryCurrency');
            $interbankRate = $this->input->post('interbankRate');
            $valorPayRate = $this->input->post('valorPayRate');
            if($baseCurrency == $secondaryCurrency)
            {
                $dataToBeDisplayed['error'] = true;
                $dataToBeDisplayed['success'] = false;
            }
            else
            {
                $baseCurrencyTitle = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND, array('ID' => $baseCurrency));
                $secondaryCurrencyTitle = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND, array('ID' => $secondaryCurrency));


                $this->UtilInfo_model->InsertUtilInformation(MY_Model::TABLE_CURRENCY_PAIR, array(
                    'BASE_CURRENCY_ID' => $baseCurrency,
                    'BASE_CURRENCY_TITLE' => $baseCurrencyTitle[0]['TITLE'],
                    'SECONDARY_CURRENCY_ID' => $secondaryCurrency,
                    'SECONDARY_CURRENCY_TITLE' => $secondaryCurrencyTitle[0]['TITLE'],
                    'INTER_BANK_RATE' => $interbankRate,
                    'VALOR_PAY_RATE' => $valorPayRate,
                    'UPDATED_AT' =>now(),
                    'CREATED_AT' =>now()
                ));
                $dataToBeDisplayed['error'] = false;
                $dataToBeDisplayed['success'] = true;
            }
        }
        else
        {
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed['success'] = false;
        }
        $this->load->view('admin/pages/currency/add_pair_view', $dataToBeDisplayed);
    }

    public function editpair_view($pairId){
        $dataToBeDisplayed = $this->makeComponentViews(MENU_CURRENCY_PAIR);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('interbankRate', 'InterBank Rate' , 'required');
        $this->form_validation->set_rules('valorPayRate', 'ValorPay Rate' , 'required');

        if($this->form_validation->run() == TRUE)
        {
            $interbankRate = $this->input->post('interbankRate');
            $valorPayRate = $this->input->post('valorPayRate');
            $this->UtilInfo_model->UpdateUtilInformation(MY_Model::TABLE_CURRENCY_PAIR, array(
                    'INTER_BANK_RATE' => $interbankRate,
                    'VALOR_PAY_RATE' => $valorPayRate,
                    'UPDATED_AT' =>now()
                ),
                array('ID' => $pairId));
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed['success'] = true;
        }
        else
        {
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed['success'] = false;
        }
        $dataToBeDisplayed['pair'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_PAIR, array('ID' => $pairId));
        $this->load->view('admin/pages/currency/edit_pair_view', $dataToBeDisplayed);
    }

    public function transfer_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_CURRENCY_PAIR);
        $dataToBeDisplayed['currency'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
//        $dataToBeDisplayed['cards'] = $this->Card_model->GetUserCardDetailInformation();
//
//        $accountTypes = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_TYPE);
//        $accountStatuses = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
//
//        $accountId = $this->input->post('accountId');
//        $postFromVirtualAccountDate = $this->input->post('fromVirtualAccountDate');
//        $postToVirtualAccountDate = $this->input->post('toVirtualAccountDate');
//        $accountType = $this->input->post('accountTypes');
//        $accountStatus = $this->input->post('accountStatus');
//
//        $whereArray = array();
//        if(isset($accountId) && $accountId != "")
//        {
//            $whereArray['a.ACCOUNT_NUMBER'] = $accountId;
//        }
//        if(isset($postFromVirtualAccountDate) && $postFromVirtualAccountDate != "")
//        {
//            $whereArray['a.CREATED_AT >='] = strtotime($postFromVirtualAccountDate);
//        }
//        if(isset($postToVirtualAccountDate) && $postToVirtualAccountDate != "")
//        {
//            $whereArray['a.CREATED_AT <='] = strtotime($postToVirtualAccountDate);
//        }
//        if(isset($accountType) && $accountType != '0')
//        {
//            $whereArray['a.ACCOUNT_TYPE'] = $accountType;
//        }
//        if(isset($accountStatus) && $accountStatus != '0')
//        {
//            $whereArray['a.STATUS'] = $accountStatus;
//        }
//
//        $dataToBeDisplayed['accountList'] = $this->Account_model->FindAccountByArray($whereArray);
//        $dataToBeDisplayed['whereArray'] = $whereArray;
//        $dataToBeDisplayed['accountKind'] = $accountTypes;
//        $dataToBeDisplayed['accountStatus'] = $accountStatuses;

        $this->load->view('admin/pages/currency/transfer_view', $dataToBeDisplayed);
    }

    public function exchange_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_CURRENCY_PAIR);
        $dataToBeDisplayed['currency'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
//        $dataToBeDisplayed['cards'] = $this->Card_model->GetUserCardDetailInformation();
//
//        $accountTypes = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_TYPE);
//        $accountStatuses = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
//
//        $accountId = $this->input->post('accountId');
//        $postFromVirtualAccountDate = $this->input->post('fromVirtualAccountDate');
//        $postToVirtualAccountDate = $this->input->post('toVirtualAccountDate');
//        $accountType = $this->input->post('accountTypes');
//        $accountStatus = $this->input->post('accountStatus');
//
//        $whereArray = array();
//        if(isset($accountId) && $accountId != "")
//        {
//            $whereArray['a.ACCOUNT_NUMBER'] = $accountId;
//        }
//        if(isset($postFromVirtualAccountDate) && $postFromVirtualAccountDate != "")
//        {
//            $whereArray['a.CREATED_AT >='] = strtotime($postFromVirtualAccountDate);
//        }
//        if(isset($postToVirtualAccountDate) && $postToVirtualAccountDate != "")
//        {
//            $whereArray['a.CREATED_AT <='] = strtotime($postToVirtualAccountDate);
//        }
//        if(isset($accountType) && $accountType != '0')
//        {
//            $whereArray['a.ACCOUNT_TYPE'] = $accountType;
//        }
//        if(isset($accountStatus) && $accountStatus != '0')
//        {
//            $whereArray['a.STATUS'] = $accountStatus;
//        }
//
//        $dataToBeDisplayed['accountList'] = $this->Account_model->FindAccountByArray($whereArray);
//        $dataToBeDisplayed['whereArray'] = $whereArray;
//        $dataToBeDisplayed['accountKind'] = $accountTypes;
//        $dataToBeDisplayed['accountStatus'] = $accountStatuses;

        $this->load->view('admin/pages/currency/exchange_view', $dataToBeDisplayed);
    }
}