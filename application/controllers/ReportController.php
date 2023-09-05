<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/3/18
 * Time: 5:11 AM
 */
class ReportController extends CI_Controller
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
    public function view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(4);
        $dataToBeDisplayed['accountList'] = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID']));
        $currencyList = $this->Account_model->GetCurrencyGroupByAccount($this->session->userdata['me']['ID']);
        $accountAnalysisList = array();
        foreach($currencyList as $currencyListItem)
        {
            $listDisp = array();
            $listDisp['CURRENCY_TITLE'] = $currencyListItem['TITLE'];
            $currencyBaseData = $this->Account_model->GetAnalysisDataByAccount($this->session->userdata['me']['ID'], $currencyListItem['CURRENCY_TYPE']);
            $listDisp['CURRENCY_ANALYSIS'] = $currencyBaseData;
            array_push($accountAnalysisList, $listDisp);
        }
        $dataToBeDisplayed['accountAnalysisList'] = $accountAnalysisList;
        //// account analytics based on account type
        $accountFeeValueList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['accountFeeValueList'] = $accountFeeValueList;
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/report/view', $dataToBeDisplayed);
    }

    public function SpecificAccountData()
    {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $accountId = $this->input->post('accountNumber');
        $resultAccountId = (!isset($accountId) || $accountId == "");

        if($resultAccountId == false)
        {
            $this->load->library('Stringutils');
            $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);
            $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);
            $historyTransaction = $this->TransferHistoryDetail_model->GetReportTransferDetailInformationByAccountId($accountId, $fromTimestamp, $toTimestamp);
            $dataToBeDisplayed['dataList'] = $historyTransaction;
            $dataToBeDisplayed['accountData'] = $this->Account_model->FindAccountByArray(array('a.ID' => $accountId));
        }
        else
        {
            $dataToBeDisplayed['dataList'] = array();
        }
        echo (json_encode($dataToBeDisplayed));
    }

    public function AllAccountData()
    {
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $this->load->library('Stringutils');
        $fromTimestamp = $this->stringutils->GetUnixTimeStampFromString($fromDate, FALSE);
        $toTimestamp = $this->stringutils->GetUnixTimeStampFromString($toDate, TRUE);

        $historyTransaction = $this->TransferHistoryDetail_model->GetReportTransferDetailInformationByUserId($this->session->userdata['me']['ID'],  $fromTimestamp, $toTimestamp);
        $dataToBeDisplayed['dataList'] = $historyTransaction;

        echo (json_encode($dataToBeDisplayed));
    }


}