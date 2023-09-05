<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class DashController extends CI_Controller
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

    public function MakeComponentsViews($menuNum)
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

    public function home()
    {
        $dataToBeDisplayed = $this->MakeComponentsViews(1);
        $accountArray = $this->Account_model->FindAccountByArray(array('USER_ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['countTotalAccount'] = count($accountArray);
        $countRecentMessages = $this->Message_model->CountOfNewMessage($this->session->userdata['me']['ID']);
        $dataToBeDisplayed['countRecentMessages'] = $countRecentMessages[0]['TOTAL'];
        $countPendingTrans = $this->TransferHistory_model->GetTransactionsArrayList(array('USER_ID' => $this->session->userdata['me']['ID'], 'STATUS<' => USER_STATUS_INACTIVE));
        $dataToBeDisplayed['countPendingTrans'] = count($countPendingTrans);
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/dashboard/dashboard', $dataToBeDisplayed);
    }

    public function recent($timenow)
    {
        $this->load->library('Stringutils');
        $dispResultArrayList = array();

        $recentTransferArrayList = $this->TransferHistory_model->GetRecentTransactionsArrayList($this->session->userdata['me']['ID']);
        foreach ($recentTransferArrayList as $transItem)
        {
            $pushData = array();
            $toAccountNumber = "";
            $toUserName  = "";
            $currencyTitle = "";
            $fromAccountNumber  = "";
            $fromUserName = "";

            if($transItem['TO_USER_ID'] > 0)
            {
                $toUserArray = $this->User_model->FindUserByArray(array('ID' => $transItem['TO_USER_ID']));
                $toUserName = $toUserArray[0]['FULL_NAME'];
                if($transItem['TO_USER_ID'] == 1)
                {
                    //admin
                    $toAccountObject = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $transItem['TO_ACCOUNT']));
                    $toAccountNumber = $toAccountObject[0]['REVENUE_NAME'];
//                    $currencyTitle = $toAccountObject[0]['CURRENCY_TITLE'];
                }
                else
                {
                    //normal user
                    $toAccountObject = $this->Account_model->GetAccountArrayByArray(array('ID' => $transItem['TO_ACCOUNT']));
                    if(count($toAccountObject) > 0)
                    {
                        $toAccountNumber = $toAccountObject[0]['ACCOUNT_NUMBER'];
                    }
                    else
                    {
                        $toAccountNumber = "Bank";
                        $toUserName = "Bank";
                    }
                }
            }
            else
            {
                //bank
                $toUserName = "Bank";
                $toAccountNumber = "Bank";
            }

            $fromUserArray = $this->User_model->FindUserByArray(array('ID' => $transItem['USER_ID']));
            $pushData['DispType'] = 'transfer';//transfer, received, account, message
            $transferTypeArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_TRANSFER_KIND, array('ID' => $transItem['TRANSACTION_TYPE']));
            $pushData['Title'] = $transferTypeArray[0]['DESCRIPTION'];//

            if($transItem['USER_ID'] <= 0)
            {
                $toAccountObject = $this->Account_model->FindAccountByArray(array('a.ID' => $transItem['TO_ACCOUNT']));
                $currencyTitle = $toAccountObject[0]['CURRENCY_TITLE'];
                $pushData['Content'] = "VPay<strong>(Bank)</strong> transferred ".$transItem['AMOUNT']." (".$currencyTitle.") "." to "
                    .$toAccountNumber."(<strong> ".$toUserName."</strong>)";
            }
            else
            {
                if($transItem['USER_ID'] == 1)
                {
                    $fromAccountObject = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $transItem['FROM_ACCOUNT']));
                    //admin
                    $pushData['Content'] = $fromAccountObject[0]['REVENUE_NAME']."<strong>(".$fromUserArray[0]['FULL_NAME'].")</strong> transferred ".$transItem['AMOUNT']." (".$fromAccountObject[0]['CURRENCY_TITLE'].") "." to "
                        .$toAccountNumber."(<strong>".$toUserName."</strong>)";
                }
                else
                {
                    $fromAccountObject = $this->Account_model->FindAccountByArray(array('a.ID' => $transItem['FROM_ACCOUNT']));
                    //user
                    $pushData['Content'] = $fromAccountObject[0]['ACCOUNT_NUMBER']."<strong> (".$fromUserArray[0]['FULL_NAME'].") </strong> transferred ".$transItem['AMOUNT']." (".$fromAccountObject[0]['CURRENCY_TITLE'].") "." to "
                        .$toAccountNumber."(<strong>".$toUserName."</strong>)";
                }
            }
            $pushData['DateOccur'] = $transItem['CREATED_AT'];
            array_push($dispResultArrayList, $pushData);
        }

        $recentAccountArrayList = $this->Account_model->GetRecentAccountActivity(array('a.USER_ID' => $this->session->userdata['me']['ID']));
        foreach ($recentAccountArrayList as $accountItem)
        {
            $pushData = array();

            $pushData['DispType'] = 'account';//transfer, received, account, message
            $pushData['Title'] = 'New Account Created';
            $pushData['Content'] = $accountItem['ACCOUNT_NUMBER']."(".$accountItem['CURRENCY_TITLE'].")"." created.<br> Status of account is ".$accountItem['STATUS_DESCRIPTION'];
            $pushData['DateOccur'] = $accountItem['CREATED_AT'];
            array_push($dispResultArrayList, $pushData);
        }

        $recentMessageArrayList = $this->Message_model->GetMessageHistoryForDashBoard($this->session->userdata['me']['ID']);
        foreach ($recentMessageArrayList as $msgItem)
        {
            $pushData = array();
            $toUserArray = $this->User_model->FindUserByArray(array('ID' => $msgItem['SENDER_ID']));
            $fromUserArray = $this->User_model->FindUserByArray(array('ID' => $msgItem['RECEIVER_ID']));

            $pushData['DispType'] = 'message';//transfer, received, account, message
            if($msgItem['SENDER_ID'] == $this->session->userdata['me']['ID'])
            {
                $pushData['Title'] = 'New Message Sent';
            }
            else
            {
                $pushData['Title'] = 'New Message Received';
            }
            $pushData['Content'] = $toUserArray[0]['FULL_NAME']." sent message to ".$fromUserArray[0]['FULL_NAME'];
            $pushData['DateOccur'] = $msgItem['UPDATED_AT'];
            array_push($dispResultArrayList, $pushData);
        }

        $dispData['dispArray'] = $this->stringutils->array_sort($dispResultArrayList, 'DateOccur', SORT_DESC);
        $this->load->view('client/pages/dashboard/dashboard_recent_activity', $dispData);
    }
}