<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminAccountController extends CI_Controller
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

    public function city_populate($countryIndex) {
        $this->load->helper('file');
        $array = json_decode(read_file('https://simplemaps.com/static/data/country-cities/mx/mx.json'));

        $insertArray = array();
        for($i = 0 ; $i < count($array) ; $i++ ) {
            $tmpArray = array('COUNTRY_INDEX' => $countryIndex,
                                'DESCRIPTION' => $array[$i]->city,
                                'UPDATED_AT' => now(), 'CREATED_AT' => now());
            array_push($insertArray, $tmpArray);
        }
        $this->db->insert_batch(MY_Model::TABLE_CITY_INFO, $insertArray);
        print_r($insertArray);
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

    public function edit($accountId)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_VIRTUAL);

        $dataToBeDisplayed['accountUserList'] = $this->User_model->FindUserByArray(array('LEVEL > ' => '1'));
        $dataToBeDisplayed['feeTypeList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_FEE_INFO);
        $dataToBeDisplayed['statusList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
        $dataToBeDisplayed['payoutList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PAYOUT_DAY);
        $dataToBeDisplayed['currencyList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $dataToBeDisplayed['accountTypeList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_TYPE, array('ID<>' => ACCOUNT_TYPE_CARD));
        $dataToBeDisplayed['error'] = true;
        $dataToBeDisplayed['success'] = false;
        $dataToBeDisplayed['duplicate_number'] = false;
        $this->load->library('form_validation');

        $this->form_validation->set_rules('accountNumber', 'Account Number' , 'required');
        $this->form_validation->set_rules('userName', 'User Name' , 'required');
        $this->form_validation->set_rules('accountType', 'Account Type' , 'required');
        $this->form_validation->set_rules('feeType', 'Fee Type' , 'required');
        $this->form_validation->set_rules('userStatus', 'Status' , 'required');
        $this->form_validation->set_rules('initialBalance', 'Initial Balance' , 'required');
        $this->form_validation->set_rules('radioPayoutOptions', 'Payout Option' , 'numeric');
        $this->form_validation->set_rules('payoutDay', 'Payout Day' , 'numeric');

        if($this->form_validation->run() == TRUE)
        {
            $accountNumber = $this->input->post('accountNumber');
            $userId = $this->input->post('userName');
            $description = $this->input->post('description');
            $accountType = $this->input->post('accountType');
            $currencyType = $this->input->post('userCurrency');
            $feeType = $this->input->post('feeType');
            $accountStatus = $this->input->post('userStatus');
            $initialBalance = $this->input->post('initialBalance');
            $initialBalance = floatval((str_replace(",","", $initialBalance)));
            $availableBalance = $this->input->post('availableBalance');
            $availableBalance = floatval((str_replace(",","", $availableBalance)));

            $allowWithdrawTmp = $this->input->post('allowWithdraw');
            $allowWithdraw = $allowWithdrawTmp == NULL?0:1;
            $allowDepositTmp = $this->input->post('allowDeposit');
            $allowDeposit = $allowDepositTmp == NULL?0:1;
            $radioPayoutOptions = $this->input->post('radioPayoutOptions');
            $payoutDay = $this->input->post('payoutDay');

            /** check duplicated account number */
            $duplicateAccountNumber = $this->Account_model->GetAccountArrayByArray(array('ACCOUNT_NUMBER' => $accountNumber));
            if(count($duplicateAccountNumber) > 0){
                $dataToBeDisplayed['duplicate_number'] = true;
            }
            else{
                if($accountType == ACCOUNT_TYPE_EWALLET)
                {
                    $accountNumber = 'W - '.$accountNumber;
                }
                else if($accountType == ACCOUNT_TYPE_CARD)
                {
                    $accountNumber = 'C - '.$accountNumber;
                }
                else if($accountType == ACCOUNT_TYPE_VIBAN)
                {
                    $accountNumber = 'I - '.$accountNumber;
                }

                $updateAccountArray = array(
                    'ACCOUNT_NUMBER' => $accountNumber,
                    'USER_ID' => $userId,
                    'ACCOUNT_TYPE' => $accountType,
                    'FEE_TYPE' => $feeType,
                    'CURRENCY_TYPE' => $currencyType,
                    'DESCRIPTION' => $description,
                    'STATUS' => $accountStatus,
                    'CURRENT_AMOUNT' => $initialBalance,
                    'AVAILABLE_AMOUNT' => $availableBalance,
                    'ALLOW_WITHDRAW' => $allowWithdraw,
                    'ALLOW_DEPOSIT' => $allowDeposit,
                    'PAYMENT_OPTIONS' => $radioPayoutOptions,
                    'PAYOUT_DAY' => $payoutDay,
                    'UPDATED_AT' => now(),
                    'CREATED_AT' => now()
                );
                $insertResult = $this->Account_model->updateAccount($updateAccountArray, array('ID' => $accountId));
                if($insertResult == -1)
                {
                    $dataToBeDisplayed['error'] = true;
                    $dataToBeDisplayed['success'] = false;
                }
                else
                {
                    $dataToBeDisplayed['error'] = false;
                    $dataToBeDisplayed['success'] = true;
                }
            }
        }
        else
        {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['error'] = false;
        }

        $accountData = $this->Account_model->GetAccountArrayByArray(array('ID' => $accountId));
        if(count($accountData) == 0) {
            show_404();
            return;
        }
        $dataToBeDisplayed['accountData'] = $accountData[0];
        $this->load->view('admin/pages/accounts/account_edit', $dataToBeDisplayed);
    }

    public function bank_view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_VIRTUAL);

        $accountOwners = $this->User_model->FindUserByArray(array('LEVEL' => 4));
        $accountTypes = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_TYPE, array('ID<>' => ACCOUNT_TYPE_CARD));
        $accountStatuses = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
        $accountOwnerId = $this->input->post('accountOwner');
        $accountId = $this->input->post('accountId');
        $postFromVirtualAccountDate = $this->input->post('fromVirtualAccountDate');
        $postToVirtualAccountDate = $this->input->post('toVirtualAccountDate');
        $accountType = $this->input->post('accountTypes');
        $accountStatus = $this->input->post('accountStatus');

        $dataToBeDisplayed['accountNumberList'] = array();//$this->Account_model->GetAccountArrayByArray();

        $whereArray = array();
        if(isset($accountOwnerId) && $accountOwnerId != "0")
        {
            $whereArray['a.USER_ID'] = $accountOwnerId;
            $dataToBeDisplayed['accountNumberList'] = $this->Account_model->GetAccountArrayByArray(array('USER_ID' => $accountOwnerId));
        }

        if(isset($accountId) && $accountId != "0")
        {
            $whereArray['a.ID'] = $accountId;
        }
        if(isset($postFromVirtualAccountDate) && $postFromVirtualAccountDate != "")
        {
            $whereArray['a.CREATED_AT >='] = strtotime($postFromVirtualAccountDate);
        }
        if(isset($postToVirtualAccountDate) && $postToVirtualAccountDate != "")
        {
            $whereArray['a.CREATED_AT <='] = strtotime($postToVirtualAccountDate);
        }
        if(isset($accountType) && $accountType != '0')
        {
            $whereArray['a.ACCOUNT_TYPE'] = $accountType;
        }
        if(isset($accountStatus) && $accountStatus != '0')
        {
            $whereArray['a.STATUS'] = $accountStatus;
        }

        $whereArray['a.ACCOUNT_TYPE<>'] = ACCOUNT_TYPE_CARD;

        $dataToBeDisplayed['accountList'] = $this->Account_model->FindAccountByArray($whereArray);

        $dataToBeDisplayed['whereArray'] = $whereArray;
        $dataToBeDisplayed['accountKind'] = $accountTypes;
        $dataToBeDisplayed['accountStatus'] = $accountStatuses;
        $dataToBeDisplayed['accountOwners'] = $accountOwners;
        $this->load->view('admin/pages/accounts/view_virtualbank_account', $dataToBeDisplayed);
    }

    public function GetAccounts()
    {
        $userId = $this->input->post('userId');
        $retAccountArray = $this->Account_model->GetAccountArrayByArray(array('USER_ID' => $userId));
        echo (json_encode($retAccountArray));
    }

    public function card_view()
    {
        $header_layout = $this->load->view('admin/template/header_layout', '', TRUE);
        $adminDataName = array('adminName' => $this->session->userdata['me']['NAME']);
        $topbar_layout = $this->load->view('admin/template/topbar_layout', $adminDataName, TRUE);
        $selectedMenu = array('selectedMenu'=>MENU_ACCOUNT_CARD);
        $sidebar_layout = $this->load->view('admin/template/sidebar_layout', $selectedMenu, TRUE);
        $footer_layout = $this->load->view('admin/template/footer_layout', '', TRUE);
        $dataToBeDisplayed['header'] = $header_layout;
        $dataToBeDisplayed['topbar']  = $topbar_layout;
        $dataToBeDisplayed['sidebar'] = $sidebar_layout;
        $dataToBeDisplayed['footer'] = $footer_layout;
        $dataToBeDisplayed['cards'] = $this->Card_model->GetUserCardDetailInformation();
        $this->load->view('admin/pages/accounts/view_credit_account', $dataToBeDisplayed);
    }

    public function new_account()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_VIRTUAL);

        $dataToBeDisplayed['accountUserList'] = $this->User_model->FindUserByArray(array('LEVEL > ' => '1'));
        $dataToBeDisplayed['feeTypeList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_FEE_INFO);
        $dataToBeDisplayed['statusList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND);
        $dataToBeDisplayed['payoutList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PAYOUT_DAY);
        $dataToBeDisplayed['currencyList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $dataToBeDisplayed['accountTypeList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_TYPE);
//        $dataToBeDisplayed['paymentOptionList'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PAYMENT_OPTOION);
        $dataToBeDisplayed['error'] = true;
        $dataToBeDisplayed['success'] = false;
        $dataToBeDisplayed['duplicate_number'] = false;
        $this->load->library('form_validation');

        $this->form_validation->set_rules('accountNumber', 'Account Number' , 'required');
        $this->form_validation->set_rules('userName', 'User Name' , 'required');

        $this->form_validation->set_rules('accountType', 'Account Type' , 'required');
        $this->form_validation->set_rules('feeType', 'Fee Type' , 'required');
        $this->form_validation->set_rules('userStatus', 'Status' , 'required');
        $this->form_validation->set_rules('initialBalance', 'Initial Balance' , 'required');
        $this->form_validation->set_rules('radioPayoutOptions', 'Payout Option' , 'numeric');
        $this->form_validation->set_rules('payoutDay', 'Payout Day' , 'numeric');

        if($this->form_validation->run() == TRUE)
        {
            $accountNumber = $this->input->post('accountNumber');
            $userId = $this->input->post('userName');
            $description = $this->input->post('description');
            $accountType = $this->input->post('accountType');
            $currencyType = $this->input->post('userCurrency');
            /** @var  $feeType  Indicates the index of basis_account_fee_info */
            $feeType = $this->input->post('feeType');
            $accountStatus = $this->input->post('userStatus');
            $initialBalance = $this->input->post('initialBalance');
            $initialBalance = floatval((str_replace(",","", $initialBalance)));
            $allowWithdrawTmp = $this->input->post('allowWithdraw');
            $allowWithdraw = $allowWithdrawTmp == NULL?0:1;
            $allowDepositTmp = $this->input->post('allowDeposit');
            $allowDeposit = $allowDepositTmp == NULL?0:1;
            $radioPayoutOptions = $this->input->post('radioPayoutOptions');
            $payoutDay = $this->input->post('payoutDay');
            $cardCVC = $this->input->post('cardCVC');
            $cardValYear = $this->input->post('cardValYear');
            $cardValMonth = $this->input->post('cardValMonth');
            $cardHolder = $this->input->post('cardHolder');

            /** check duplicated account number */
            $duplicateAccountNumber = $this->Account_model->GetAccountArrayByArray(array('ACCOUNT_NUMBER' => $accountNumber));
            if(count($duplicateAccountNumber) > 0){
                 $dataToBeDisplayed['duplicate_number'] = true;
            }
            else {
                $insertAccountArray = array(
                    'ACCOUNT_NUMBER' => $accountNumber,
                    'USER_ID' => $userId,
                    'ACCOUNT_TYPE' => $accountType,
                    'FEE_TYPE' => $feeType,
                    'CURRENCY_TYPE' => $currencyType,
                    'DESCRIPTION' => $description,
                    'STATUS' => $accountStatus,
                    'CURRENT_AMOUNT' => $initialBalance,
                    'AVAILABLE_AMOUNT' => $initialBalance,
                    'ALLOW_WITHDRAW' => $allowWithdraw,
                    'ALLOW_DEPOSIT' => $allowDeposit,
                    'PAYMENT_OPTIONS' => $radioPayoutOptions,
                    'PAYOUT_DAY' => $payoutDay,
                    'UPDATED_AT' => now(),
                    'CREATED_AT' => now()
                );
                $insertResult = $this->Account_model->InsertNewAccount($insertAccountArray);
                if($insertResult == -1)
                {
                    $dataToBeDisplayed['error'] = true;
                    $dataToBeDisplayed['success'] = false;
                }
                else
                {
                    if($accountType == ACCOUNT_TYPE_CARD)
                    {
                        //$InsertResult = last inserted id
                        $cardInsertArray = array(
                            'USER_ID' => $userId,
                            'ACCOUNT_ID' => $insertResult,
                            'CARD_NUMBER' => $accountNumber,
                            'CARD_EXP_YEAR' => $cardValYear,
                            'CARD_HOLDER_NAME' => $cardHolder,
                            'CARD_EXP_MONTH' => $cardValMonth,
                            'CARD_CVC' => $cardCVC,
                            'UPDATED_AT' => now(),
                            'CREATED_AT' => now()
                        );
                        $this->Card_model->InsertCardRecord($cardInsertArray);
                    }

                    $this->Notification_model->InsertNewNotification(array( 'USER_ID' => $userId,
                                                                            'REASON_TYPE' => NOTIFY_NEW_ACCOUNT_CREATE,
                                                                            'LINK_ID' => $insertResult,
                                                                            'CONTENT' => '',
                                                                            'USER_CHECK' => 0,
                                                                            'UPDATED_AT' => time(),
                                                                            'CREATED_AT' => time()));

                    $dataToBeDisplayed['error'] = false;
                    $dataToBeDisplayed['success'] = true;
                }
            }
        }
        else
        {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['error'] = false;
        }

        $this->load->view('admin/pages/accounts/account_new_create', $dataToBeDisplayed);
    }

    public function detail($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_VIRTUAL);
        $accountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $id));
        if(count($accountModel) == 0) {
            show_404();
            return;
        }
        $dataToBeDisplayed['accountData'] = $accountModel[0];
        $statusModel = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_USER_STATUS_KIND, array('ID'=>$accountModel[0]['STATUS']));
        $dataToBeDisplayed['statusData'] = $statusModel[0];
        $paymentOptionModel = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_PAYMENT_OPTOION, array('ID'=>$accountModel[0]['PAYMENT_OPTIONS']));
        $dataToBeDisplayed['paymentOption'] = $paymentOptionModel[0];
        $dataToBeDisplayed['currencyType'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND, array('ID' => $accountModel[0]['CURRENCY_TYPE']));
        $this->load->view('admin/pages/accounts/detail', $dataToBeDisplayed);
    }

    public function debit($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_VIRTUAL);
        $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $id));
        $dataToBeDisplayed['accountName'] = $fromAccountModel[0]['ACCOUNT_NUMBER'];
        $dataToBeDisplayed['userName'] = $fromAccountModel[0]['USER_FULLNAME'];
        $dataToBeDisplayed['accountId'] = $id;
        $dataToBeDisplayed['currentBalance'] = $fromAccountModel[0]['CURRENT_AMOUNT'];
        $dataToBeDisplayed['availableBalance'] = $fromAccountModel[0]['AVAILABLE_AMOUNT'];
        $dataToBeDisplayed['currencyType'] = $fromAccountModel[0]['CURRENCY_TITLE'];
        $dataToBeDisplayed['success'] = false;
        $dataToBeDisplayed['failed'] = false;
        $dataToBeDisplayed['revenue'] = false;
        $dataToBeDisplayed['available_amount'] = false;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('debitAmount', 'Debit Amount' , 'required');
        $this->form_validation->set_rules('debitDescription', 'Debit Description' , 'required');
        if($this->form_validation->run() == TRUE)
        {
            $debitAmount = $this->input->post('debitAmount');
            $debitDescription = $this->input->post('debitDescription');
            $chkRevenue = $this->input->post('debitRevenue');
            $debitAmount = floatval((str_replace(",","", $debitAmount)));
            $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $id));
            if(floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']) < $debitAmount) {
                $dataToBeDisplayed['available_amount'] = true;
            }
            else {
                $this->Account_model->UpdateAvailableBalance(false, $id, $debitAmount);
                $this->Account_model->UpdateCurrentBalance(false, $id, $debitAmount);

                $insertHistoryArray = array(
                    'USER_ID' => $fromAccountModel[0]['USER_ID'],
                    'TRANSACTION_TYPE' => Account_Debit_Transfer,
                    'AMOUNT' => $debitAmount,
                    'FROM_ACCOUNT' => $id,
                    'OUTGOING_WIRE_INDEX' => '0',
                    'DESCRIPTION' => $debitDescription,
                    'TRANSACTION_FEE' => 0,
                    'CURRENCY_CALCED_RATE' => 1,
                    'STATUS' => TRANSFER_COMPLETE,
                    'FROM_AVAILABLE_BALANCE' => $fromAccountModel[0]['AVAILABLE_AMOUNT'],
                    'FROM_CURRENT_BALANCE' => $fromAccountModel[0]['CURRENT_AMOUNT'],
                    'IS_MANUAL_TRANS' => '1',
                    'UPDATED_AT' => now(),
                    'CREATED_AT' => now()
                );

                $revenueAccountModel = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE']));
                if (count($revenueAccountModel) > 0) {
                    if ($chkRevenue == 'on') {
                        //credit to revenue account
                        //transfer from account to revenue
                        $this->RevenueInfo_model->UpdateRevenueBalance($revenueAccountModel[0]['ID'], $debitAmount, true);
                        $revenueAccountModel = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE']));
                        $insertHistoryArray['TO_USER_ID'] = 1;
                        $insertHistoryArray['TO_ACCOUNT'] = $revenueAccountModel[0]['ID'];
                        $insertHistoryArray['TO_AVAILABLE_BALANCE'] = $revenueAccountModel[0]['AVAILABLE_AMOUNT'];
                        $insertHistoryArray['TO_CURRENT_BALANCE'] = $revenueAccountModel[0]['CURRENT_AMOUNT'];

                    } else {
                        //just debit from account
                        $insertHistoryArray['TO_USER_ID'] = -1;
                        $insertHistoryArray['TO_ACCOUNT'] = -1;
                        $insertHistoryArray['TO_AVAILABLE_BALANCE'] = 0;
                        $insertHistoryArray['TO_CURRENT_BALANCE'] = 0;
                    }
                    $insertResult = self::makeDebitTransactionHistory($insertHistoryArray, $fromAccountModel, $revenueAccountModel, $debitAmount);

                    $this->Notification_model->InsertNewNotification(array('USER_ID' => $fromAccountModel[0]['USER_ID'],
                        'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE,
                        'LINK_ID' => $insertResult,
                        'CONTENT' => '',
                        'USER_CHECK' => 0,
                        'UPDATED_AT' => time(),
                        'CREATED_AT' => time()));

                    $dataToBeDisplayed['success'] = true;
                } else {
                    $dataToBeDisplayed['revenue'] = true;
                }
            }
        }
        $this->load->view('admin/pages/accounts/debit', $dataToBeDisplayed);
    }

    private function makeDebitTransactionHistory($insertHistoryArray, $fromAccountModel, $revenueAccountModel, $debitAmount)
    {
        $resultHistoryInsert = $this->TransferHistory_model->InsertTransferHistory($insertHistoryArray);
        $this->TransferHistoryDetail_model->InsertManualRequestHistory($resultHistoryInsert, $fromAccountModel[0]['USER_ID'], $fromAccountModel[0]['ID'], $insertHistoryArray['TO_USER_ID'], $insertHistoryArray['TO_ACCOUNT'], $revenueAccountModel[0]['ID'], $debitAmount);
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_APPROVED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_COMPLETE, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        return $resultHistoryInsert;
    }

    public function credit($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_VIRTUAL);
        $toAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $id));

        $dataToBeDisplayed['accountName'] = $toAccountModel[0]['ACCOUNT_NUMBER'];
        $dataToBeDisplayed['userName'] = $toAccountModel[0]['USER_FULLNAME'];
        $dataToBeDisplayed['accountId'] = $id;
        $dataToBeDisplayed['currentBalance'] = $toAccountModel[0]['CURRENT_AMOUNT'];
        $dataToBeDisplayed['availableBalance'] = $toAccountModel[0]['AVAILABLE_AMOUNT'];
        $dataToBeDisplayed['currencyType'] = $toAccountModel[0]['CURRENCY_TITLE'];
        $dataToBeDisplayed['success'] = false;
        $dataToBeDisplayed['failed'] = false;
        $dataToBeDisplayed['revenue'] = false;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('creditAmount', 'Credit Amount' , 'required');
        $this->form_validation->set_rules('creditDescription', 'Credit Description' , 'required');
        if($this->form_validation->run() == TRUE)
        {
            $creditAmount  = $this->input->post('creditAmount');
            $creditAmount = floatval((str_replace(",","", $creditAmount)));

            $creditDescription  = $this->input->post('creditDescription');
            $creditRevenue  = $this->input->post('creditRevenue');
            $iwtFee  = $this->input->post('iwtFee');

            $insertArray['OUTGOING_WIRE_INDEX'] = '0';
            $insertArray['DESCRIPTION'] = $creditDescription;
            $insertArray['STATUS'] = TRANSFER_COMPLETE;
            $insertArray['UPDATED_AT'] = now();
            $insertArray['CREATED_AT'] = now();
            $insertArray['TRANSACTION_TYPE'] = Account_Credit_Transfer;
            $insertArray['TO_USER_ID'] = $toAccountModel[0]['USER_ID'];
            $insertArray['TO_ACCOUNT'] = $toAccountModel[0]['ID'];
            $insertArray['IS_MANUAL_TRANS'] = '1';
            $insertArray['CURRENCY_CALCED_RATE'] = 1;

            $creditAmount = floatval((str_replace(",","", $creditAmount)));

            $revenueAccountModel = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE']));
            if(count($revenueAccountModel) > 0) {
                $transferFee = 0;
                if ($iwtFee == 'on') {
                    $transferFee = $toAccountModel[0]['IWT_TYPE'] == '#' ? $toAccountModel[0]['IWT_AMOUNT'] : $creditAmount * $toAccountModel[0]['IWT_AMOUNT'] / 100;
                    $this->load->library('TransferUtils');

                    $calcedFeeValue = $this->transferutils->MakeFeeValueByMinMax($transferFee, $toAccountModel[0]['MIN_TRANS_FEE'], $toAccountModel[0]['MAX_TRANS_FEE']);
                    $transferFee = $calcedFeeValue;
                }

                $creditAmount = $creditAmount - $transferFee;
                $insertArray['AMOUNT'] = $creditAmount;
                $insertArray['TRANSACTION_FEE'] = $transferFee;
                $this->Account_model->UpdateAvailableBalance(true, $id, $creditAmount);
                $this->Account_model->UpdateCurrentBalance(true, $id, $creditAmount);
                $this->RevenueInfo_model->UpdateRevenueBalance($revenueAccountModel[0]['ID'], $transferFee, true);

                $toAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $id));
                $revenueAccountModel = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $revenueAccountModel[0]['ID']));

                $insertArray['TO_AVAILABLE_BALANCE'] = $toAccountModel[0]['AVAILABLE_AMOUNT'];
                $insertArray['TO_CURRENT_BALANCE'] = $toAccountModel[0]['CURRENT_AMOUNT'];

                if ($creditRevenue == 'on') {
                    $insertArray['USER_ID'] = 1;
                    $insertArray['FROM_ACCOUNT'] = $revenueAccountModel[0]['ID'];
                    $insertArray['FROM_AVAILABLE_BALANCE'] = $revenueAccountModel[0]['AVAILABLE_AMOUNT'];
                    $insertArray['FROM_CURRENT_BALANCE'] = $revenueAccountModel[0]['CURRENT_AMOUNT'];
                    $this->RevenueInfo_model->UpdateRevenueBalance($revenueAccountModel[0]['ID'], $transferFee + $creditAmount, false);

                } else {
                    $insertArray['USER_ID'] = -1;
                    $insertArray['FROM_ACCOUNT'] = -1;
                    $insertArray['FROM_AVAILABLE_BALANCE'] = 0;
                    $insertArray['FROM_CURRENT_BALANCE'] = 0;
                }

                $insertResult = self::makeCreditTransactionHistory($insertArray, $toAccountModel, $revenueAccountModel, $creditAmount);

                $this->Notification_model->InsertNewNotification(array( 'USER_ID' => $toAccountModel[0]['USER_ID'],
                                                                        'REASON_TYPE' => NOTIFY_NEW_TRANS_CREATE,
                                                                        'LINK_ID' => $insertResult,
                                                                        'CONTENT' => '',
                                                                        'USER_CHECK' => 0,
                                                                        'UPDATED_AT' => time(),
                                                                        'CREATED_AT' => time()));
                //send email notification
                $toUser = $this->User_model->FindUserByArray(array('ID' => $toAccountModel[0]['USER_ID']));
                if (intval($toUser[0]['NOTIFY_FUND_ADD']) == 1) {
                    $mailContent = "Hi, <strong>" . $toUser[0]['FULL_NAME'] . "</strong><br> New Fund is added to Account: " . $toAccountModel[0]['ACCOUNT_NUMBER']
                        . "<br>IP Location: " . $this->input->ip_address() . "";
                    $this->SendFundNotificationEmail($toUser[0]['EMAIL'], $mailContent);
                }
                $dataToBeDisplayed['success'] = true;
            }
            else {
                $dataToBeDisplayed['revenue'] = true;
            }
        }
        else
        {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['failed'] = false;
        }
        $this->load->view('admin/pages/accounts/credit', $dataToBeDisplayed);
    }

    private function makeCreditTransactionHistory($insertHistoryArray, $toAccountModel, $revenueAccountModel, $creditAmount) {
        $resultHistoryInsert = $this->TransferHistory_model->InsertTransferHistory($insertHistoryArray);
        $this->TransferHistoryDetail_model->InsertManualRequestHistory($resultHistoryInsert, $insertHistoryArray['USER_ID'], $insertHistoryArray['FROM_ACCOUNT'], $toAccountModel[0]['USER_ID'], $toAccountModel[0]['ID'], $revenueAccountModel[0]['ID'], $creditAmount, $insertHistoryArray['TRANSACTION_FEE']);
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_APPROVED, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $resultHistoryInsert, 'STATUS_ID' => TRANSFER_COMPLETE, 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        return $resultHistoryInsert;
    }

    private function SendFundNotificationEmail($targetEmail, $content)
    {
        $this->email->initialize($this->config->item('EMAIL'));
        $this->email->from($this->config->item('EMAIL_DISP'), $this->config->item('EMAIL_DISP'));
        $this->email->to($targetEmail);
        $this->email->subject('Valor Pay Support team');
        $this->email->message($content);
        $result = $this->email->send();
        echo($result);
    }

    public function revenue_view() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_REVENUE);
        $dataToBeDisplayed['accountList'] = $this->RevenueInfo_model->GetRevenueAccount();
        $this->load->view('admin/pages/accounts/view_revenue_account', $dataToBeDisplayed);
    }

    public function revenue_history($id) {
        $revenueModel = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $id));
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_REVENUE);
        $dataToBeDisplayed['ACCOUNT_ID'] = $revenueModel[0]['CURRENCY_TYPE'];
        $this->load->view('admin/pages/accounts/history_revenue', $dataToBeDisplayed);
    }

    public function new_revenue() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_REVENUE);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('revenueAmount', 'Initial amount' , 'required');
        $this->form_validation->set_rules('revenueName', 'Account name' , 'required');
        if($this->form_validation->run() == TRUE)
        {
            $currencyType = $this->input->post('currencyType');
            $revenueName = $this->input->post('revenueName');
            $revenueAmount = $this->input->post('revenueAmount');
            $revenueAmount = floatval((str_replace(",","", $revenueAmount)));
            if($currencyType < 1) {
                $dataToBeDisplayed['success'] = false;
                $dataToBeDisplayed['failed'] = true;
            }
            else {
                $dataToBeDisplayed['success'] = true;
                $dataToBeDisplayed['failed'] = false;
                $currencyItem = $this->UtilInfo_model->GetCurrencyList(array('ID' => $currencyType));
                $insertArray = array('REVENUE_NAME' => $revenueName,
                    'CURRENCY_TITLE'=>$currencyItem[0]['TITLE'],
                    'CURRENCY_TYPE'=>$currencyType,
                    'AVAILABLE_AMOUNT' => $revenueAmount,
                    'CURRENT_AMOUNT' => $revenueAmount,
                    'UPDATED_AT' => now(),
                    'CREATED_AT' => now());
                $this->RevenueInfo_model->InsertRevenueInfo($insertArray);
            }
        }
        else {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['failed'] = false;
        }
        $dataToBeDisplayed['currencyList'] = $this->RevenueInfo_model->GetCurrencyForNewAccount();
        $this->load->view('admin/pages/accounts/revenue_new_create', $dataToBeDisplayed);
    }

    public function revenue_credit($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_REVENUE);
        $accountItem = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $id));
        $dataToBeDisplayed['accountName'] = $accountItem[0]['REVENUE_NAME'];
        $dataToBeDisplayed['accountId'] = $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('creditAmount', 'Credit Amount' , 'required');
        $this->form_validation->set_rules('creditDescription', 'Credit Description' , 'required');
        if($this->form_validation->run() == TRUE)
        {
            $creditAmount = $this->input->post('creditAmount');
            $creditAmount = floatval((str_replace(",","", $creditAmount)));
            $creditDescription = $this->input->post('creditDescription');

            $this->RevenueInfo_model->UpdateRevenueBalance($id, $creditAmount, true);
            $accountItem = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $id));

            $insertArray = array(
                'USER_ID' => '-1',
                'TO_USER_ID' => '1',
                'TRANSACTION_TYPE' => Account_Credit_Transfer,
                'AMOUNT' => $creditAmount,
                'FROM_ACCOUNT' => '-1',
                'TO_ACCOUNT' => $id,
                'OUTGOING_WIRE_INDEX' => '0',
                'DESCRIPTION' => $creditDescription,
                'TRANSACTION_FEE' => '0',
                'CURRENCY_CALCED_RATE' => '1',
                'STATUS' => TRANSFER_COMPLETE,
                'FROM_AVAILABLE_BALANCE' => '0',
                'TO_AVAILABLE_BALANCE' => $accountItem[0]['AVAILABLE_AMOUNT'],
                'FROM_CURRENT_BALANCE' => '0',
                'TO_CURRENT_BALANCE' => $accountItem[0]['CURRENT_AMOUNT'],
                'IS_MANUAL_TRANS' => '1',
                'UPDATED_AT' => now(),
                'CREATED_AT' => now()
            );

            $insertTransferId = $this->TransferHistory_model->InsertTransferHistory($insertArray);
            $this->TransferHistoryDetail_model->InsertManualRequestHistory($insertTransferId, -1, -1, 1, $id, $id, $creditAmount);
            $this->TransferHistoryDetailStatus_model->InsertRecordsByOnce($insertTransferId);
            $dataToBeDisplayed['success'] = true;
            $dataToBeDisplayed['failed'] = false;
        }
        else
        {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['failed'] = false;
        }
        $this->load->view('admin/pages/accounts/credit_revenue', $dataToBeDisplayed);
    }

    public function revenue_debit($id)
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_ACCOUNT_REVENUE);
        $accountItem = $this->RevenueInfo_model->GetRevenueAccount(array('ID' => $id));
        $dataToBeDisplayed['accountName'] = $accountItem[0]['REVENUE_NAME'];
        $dataToBeDisplayed['accountId'] = $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('debitAmount', 'Debit Amount' , 'required');
        $this->form_validation->set_rules('debitDescription', 'Debit Description' , 'required');
        if($this->form_validation->run() == TRUE) {
            $debitAmount = $this->input->post('debitAmount');
            $debitAmount = floatval((str_replace(",","", $debitAmount)));
            $debitDescription = $this->input->post('debitDescription');

            $this->RevenueInfo_model->UpdateRevenueBalance($id, $debitAmount, false);

            $insertArray = array(
                'USER_ID' => '1',
                'TO_USER_ID' => '-1',
                'TRANSACTION_TYPE' => Account_Debit_Transfer,
                'AMOUNT' => $debitAmount,
                'FROM_ACCOUNT' => $id,
                'TO_ACCOUNT' => '-1',
                'OUTGOING_WIRE_INDEX' => '0',
                'DESCRIPTION' => $debitDescription,
                'TRANSACTION_FEE' => '0',
                'CURRENCY_CALCED_RATE' => '1',
                'STATUS' => TRANSFER_COMPLETE,
                'FROM_AVAILABLE_BALANCE' => $accountItem[0]['AVAILABLE_AMOUNT'],
                'TO_AVAILABLE_BALANCE' => '0',
                'FROM_CURRENT_BALANCE' => $accountItem[0]['CURRENT_AMOUNT'],
                'TO_CURRENT_BALANCE' => '0',
                'IS_MANUAL_TRANS' => '1',
                'UPDATED_AT' => now(),
                'CREATED_AT' => now()
            );
            $insertTransferId = $this->TransferHistory_model->InsertTransferHistory($insertArray);
            $this->TransferHistoryDetail_model->InsertManualRequestHistory($insertTransferId, 1, $id, -1, -1, $id, $debitAmount);
            $this->TransferHistoryDetailStatus_model->InsertRecordsByOnce($insertTransferId);
            $dataToBeDisplayed['success'] = true;
            $dataToBeDisplayed['failed'] = false;
        }
        else {
            $dataToBeDisplayed['success'] = false;
            $dataToBeDisplayed['failed'] = false;
        }
        $this->load->view('admin/pages/accounts/debit_revenue', $dataToBeDisplayed);
    }
}