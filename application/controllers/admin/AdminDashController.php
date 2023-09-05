<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminDashController extends CI_Controller
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

    public function home()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_HOME);
        $totalBalance = $this->RevenueInfo_model->GetRevenueAccount();
        $dataToBeDisplayed['totalBalance'] = count($totalBalance);
        $countRecentMessages = $this->Message_model->CountOfNewMessage($this->session->userdata['me']['ID']);
        $dataToBeDisplayed['messages'] = $countRecentMessages[0]['TOTAL'];
        $pendingRequest = $this->TransferHistory_model->GetTransactionsArrayList(array('STATUS<' => TRANSFER_APPROVED));
        $dataToBeDisplayed['pendingRequest'] = count($pendingRequest);

        $this->load->view('admin/pages/dashboard/dashboard', $dataToBeDisplayed);
    }

    public function recent($timenow)
    {

        $this->load->library('Stringutils');
        $dispResultArrayList = array();

        $recentTransferArrayList = $this->TransferHistory_model->GetRecentTransactionsArrayListForAdmin();
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
                if($transItem['TO_USER_ID'] ==  1) {
                    //it is revenue account
                    $toAccountObject = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $transItem['TO_ACCOUNT']));
                    if(count($toAccountObject) > 0) {
                        $currencyTitle = $toAccountObject[0]['CURRENCY_TITLE'];
                    }
                    else{
                        $currencyTitle = "";
                    }
                }
                else {
                    // it is user account
                    $toAccountObject = $this->Account_model->FindAccountByArray(array('a.ID' => $transItem['TO_ACCOUNT']));
                    if(count($toAccountObject) > 0) {
                        $currencyTitle = $toAccountObject[0]['CURRENCY_TITLE'];
                    }
                    else{
                        $currencyTitle = "";
                    }
                }


                $pushData['Content'] = "VPay<strong>(Bank)</strong> transferred ".$transItem['AMOUNT']." ( ".$currencyTitle." ) "." to "
                    .$toAccountNumber."(<strong>".$toUserName."</strong>)";
            }
            else
            {
                if($transItem['USER_ID'] == 1)
                {
                    $fromAccountObject = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $transItem['FROM_ACCOUNT']));
                    //admin
                    $pushData['Content'] = $fromAccountObject[0]['REVENUE_NAME']."<strong>(".$fromUserArray[0]['FULL_NAME'].")</strong> transferred ".$transItem['AMOUNT']."( ".$fromAccountObject[0]['CURRENCY_TITLE']." )"." to "
                        .$toAccountNumber."(<strong>".$toUserName."</strong>)";
                }
                else
                {
                    $fromAccountObject = $this->Account_model->FindAccountByArray(array('a.ID' => $transItem['FROM_ACCOUNT']));
                    //user
                    $pushData['Content'] = $fromAccountObject[0]['ACCOUNT_NUMBER']."<strong> ( ".$fromUserArray[0]['FULL_NAME']." ) </strong> transferred ".$transItem['AMOUNT']."( ".$fromAccountObject[0]['CURRENCY_TITLE']." )"." to "
                        .$toAccountNumber."(<strong>".$toUserName."</strong>)";
                }
            }
            $pushData['DateOccur'] = $transItem['CREATED_AT'];
            array_push($dispResultArrayList, $pushData);
        }

        $recentAccountArrayList = $this->Account_model->GetRecentAccountActivity(array());
        foreach ($recentAccountArrayList as $accountItem)
        {
            $pushData = array();

            $pushData['DispType'] = 'account';//transfer, received, account, message
            $pushData['Title'] = 'New Account Created';
            $pushData['Content'] = $accountItem['ACCOUNT_NUMBER']."<strong>(".$accountItem['CURRENCY_TITLE'].")</strong>"." created.<br> Status of account is ".$accountItem['STATUS_DESCRIPTION'];
            $pushData['DateOccur'] = $accountItem['CREATED_AT'];
            array_push($dispResultArrayList, $pushData);
        }

        $recentMessageArrayList = $this->Message_model->GetMessageHistoryForDashBoard($this->session->userdata['me']['ID']);
        foreach ($recentMessageArrayList as $msgItem)
        {
            $pushData = array();
            $fromUserArray = $this->User_model->FindUserByArray(array('ID' => $msgItem['SENDER_ID']));
            $toUserArray = $this->User_model->FindUserByArray(array('ID' => $msgItem['RECEIVER_ID']));

            $pushData['DispType'] = 'message';//transfer, received, account, message
            if($msgItem['SENDER_ID'] == $this->session->userdata['me']['ID'])
            {
                $pushData['Title'] = 'New Message Sent';
            }
            else
            {
                $pushData['Title'] = 'New Message Received';
            }

            $pushData['Content'] = $fromUserArray[0]['FULL_NAME']." sent message to ".$toUserArray[0]['FULL_NAME'];
            $pushData['DateOccur'] = $msgItem['CREATED_AT'];
            array_push($dispResultArrayList, $pushData);
        }
        
        $dispData['dispArray'] = $this->stringutils->array_sort($dispResultArrayList, 'DateOccur', SORT_DESC);
        $this->load->view('admin/pages/dashboard/dashboard_recent_activity', $dispData);
    }
}