<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/30/17
 * Time: 12:06 PM
 */
class TransferController extends CI_Controller
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
        $dataToBeDisplayed = $this->makeComponentViews(3);
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/transfer/view', $dataToBeDisplayed);
    }

    public function accounts(){
        $dataToBeDisplayed = $this->makeComponentViews(3);

        $senderAccountList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID'], 'a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET));
        $dataToBeDisplayed['senderAccounts'] = $senderAccountList;

        $receiverAccountList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID'], 'a.ACCOUNT_TYPE <' => ACCOUNT_TYPE_CARD));
        $dataToBeDisplayed['receiverAccounts'] = $receiverAccountList;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['result'] = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['available_amount'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromAccount', ' Debit From Account ' ,'required');
        $this->form_validation->set_rules('toAccount', ' Credit To Account ' , 'required');
        $this->form_validation->set_rules('amount', ' Amount ' , 'required');

        if($this->form_validation->run() == TRUE) {
            $fromAccount = $this->input->post('fromAccount');
            $toAccount = $this->input->post('toAccount');
            $amount = $this->input->post('amount');
            $amount = floatval(str_replace(",","",$amount));

            $description = $this->input->post('description');
            if($fromAccount == $toAccount) {
                $dataToBeDisplayed['show_alert'] = true;
                $dataToBeDisplayed['result'] = false;
            }
            else if(($toAccount == '0') || ($fromAccount == '0')) {
                $dataToBeDisplayed['show_alert'] = true;
                $dataToBeDisplayed['result'] = false;
            }
            else {
                $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));
                $toAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $toAccount));
                $availableValue = floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']);
                if($availableValue < $amount) {
                    $dataToBeDisplayed['result'] = false;
                    $dataToBeDisplayed['available_amount'] = true;
                }
                else {
                    $this->load->library('TransferUtils');

                    if ($fromAccountModel[0]['ACCOUNT_TYPE'] == $toAccountModel[0]['ACCOUNT_TYPE']) {
                        //from eWallet to eWallet
                        $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $toAccountModel, $amount, $description);
                        $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                        if ($retValFromEngine['result'] == true) {
                            self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                $this->input->ip_address(),
                                Transfer_Between_Accounts);
                        }
                    } else {
                        //from eWallet to eWallet first
                        //from eWallet to vIBAN second
                        // find eWallet with same currency of toAccountModel
                        if ($fromAccountModel[0]['CURRENCY_TYPE'] == $toAccountModel[0]['CURRENCY_TYPE']) {
                            //same currency from eWallet to vIBAN
                            $retValFromEngine = $this->transferutils->TransferFromEWalletToVIBANEngine($fromAccountModel, $toAccountModel, $amount, $description);
                            $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                            if ($retValFromEngine['result'] == true) {
                                self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                    $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                    $this->input->ip_address(),
                                    Transfer_Between_Accounts);
                            }
                        } else {
                            //differnt currency from eWallet to vIBAN
                            $eWalletForToAccount = $this->Account_model->FindAccountByArray(array('a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET, 'a.CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE'], 'a.USER_ID' => $toAccountModel[0]['USER_ID']));
                            if ($eWalletForToAccount == NULL || count($eWalletForToAccount) == 0) {
                                //show error message to create with same ewallet first
                                $dataToBeDisplayed['target_wallet'] = true;
                            }
                            else {
                                $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $eWalletForToAccount, $amount, $description);
                                $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);

                                if ($retValFromEngine['result'] == true) {
                                    $retValFromEngine = $this->transferutils->TransferFromEWalletToVIBANEngine($eWalletForToAccount, $toAccountModel, $amount * $retValFromEngine['calcConversionRate'], $description);
                                    $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                                    self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                        $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                        $this->input->ip_address(),
                                        Transfer_Between_Accounts);
                                }
                            }
                        }
                    }
                }
            }
        }
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/transfer/accounts', $dataToBeDisplayed);
    }

    public function outgoing()
    {
        $dataToBeDisplayed = $this->makeComponentViews(3);
        //user list
        $accountList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID'], 'a.ACCOUNT_TYPE < ' => ACCOUNT_TYPE_CARD));
        $countryList = $this->UtilInfo_model->GetCountryList();
        $currencyList = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $dataToBeDisplayed['countries'] = $countryList;
        $dataToBeDisplayed['accounts'] = $accountList;
        $dataToBeDisplayed['currencies'] = $currencyList;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['result'] = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['available_amount'] = false;
        $dataToBeDisplayed['aml'] = false;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromAccount', ' Debit From Account ' ,'required');
        $this->form_validation->set_rules('swiftbic', ' Swift/BIC ' , 'required');
        $this->form_validation->set_rules('bankname', ' Bank Name ' , 'required');
        $this->form_validation->set_rules('bankaddress', ' Address of Bank ' , 'required');
        $this->form_validation->set_rules('banklocation', ' Location of Bank ' , 'required');
        $this->form_validation->set_rules('bankcountry', ' Country of Bank ' , 'required');
        $this->form_validation->set_rules('customername', ' Customer name ' , 'required');
        $this->form_validation->set_rules('customeraddress', ' Customer address ' , 'required');
        $this->form_validation->set_rules('customeriban', ' Iban of Customer ' , 'required');
        $this->form_validation->set_rules('additionname', ' Additional Information Name ' , 'required');
        $this->form_validation->set_rules('transferAmount', ' Amount ' , 'required');
        $this->form_validation->set_rules('transferCurrency', ' Currency Type ' , 'required');
        $this->form_validation->set_rules('fee', ' Fee ' , 'required');

        if($this->form_validation->run() == TRUE) {
            $fromAccount = $this->input->post('fromAccount');
            $swiftbic = $this->input->post('swiftbic');
            $bankaddress = $this->input->post('bankaddress');
            $bankname = $this->input->post('bankname');
            $banklocation = $this->input->post('banklocation');
            $bankcountry = $this->input->post('bankcountry');
            $abartn = $this->input->post('abartn');
            $customername = $this->input->post('customername');
            $customeraddress = $this->input->post('customeraddress');
            $customeriban = $this->input->post('customeriban');
            $additionaddr = $this->input->post('additionname');
            $transferAmount = $this->input->post('transferAmount');
            $transferAmount = floatval((str_replace(",","", $transferAmount)));
            $transferCurrency = $this->input->post('transferCurrency');
            $intermediatrybank = $this->input->post('intermediatrybank');
            $interSwift = $this->input->post('interSwift');
            $interName = $this->input->post('interName');
            $interAddress = $this->input->post('interAddress');
            $interLocation = $this->input->post('interLocation');
            $interCountry = $this->input->post('interCountry');
            $interABA = $this->input->post('interABA');
            $interACC = $this->input->post('interACC');

            $description = $this->input->post('description');
            $fee = $this->input->post('fee');
            $fee = floatval((str_replace(",","", $fee)));

            $intermediatrybankInt = $intermediatrybank == 'on'?1:0;
            $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));

            $currencyConversionRate = $this->input->post('currencyConversionRate');
            $vpayRate = $this->input->post('vpayRate');


            $this->load->library('TransferUtils');

            $calcedFee = $this->transferutils->MakeFeeValueByMinMax($fee, $fromAccountModel[0]['MIN_TRANS_FEE'], $fromAccountModel[0]['MAX_TRANS_FEE']);
            $fee = $calcedFee;

            $availableValue = floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']);
            if($availableValue < ($transferAmount + $fee)) {
                $dataToBeDisplayed['available_amount'] = true;
            }
            else {
                    //transfer from this account to outgoing bank
                $bankOutgingHistoryId = $this->transferutils->MakeOutgoingBankHistory($swiftbic,
                    $bankname,
                    $bankaddress,
                    $banklocation,
                    $bankcountry,
                    $abartn,
                    $customername,
                    $customeraddress,
                    $customeriban,
                    $additionaddr,
                    $intermediatrybankInt,
                    $interSwift,
                    $interName,
                    $interAddress,
                    $interLocation,
                    $interCountry,
                    $interABA,
                    $interACC,
                    $transferCurrency);
                $dataToBeDisplayed['show_alert'] = $bankOutgingHistoryId > 0;
                if ($bankOutgingHistoryId > 0) {
                    $retValFromEngine = $this->transferutils->MakeOutgoingWithFixedValue($bankOutgingHistoryId, $fromAccountModel, $transferAmount, $transferCurrency, $vpayRate, $currencyConversionRate, $description, $fee, $fee, "");
                    $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                    if ($retValFromEngine['result'] == true) {
                        self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                            'Bank (' . $bankname . ')',
                            $this->input->ip_address(),
                            Outgoing_Wire_Transfer);
                    }
                }
            }
        }

        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/transfer/outgoing', $dataToBeDisplayed);
    }

    public function cards() {
        $dataToBeDisplayed = $this->makeComponentViews(3);
        $accountList = $this->Account_model->FindAccountByArray(array('USER_ID' => $this->session->userdata['me']['ID'], 'a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET));
        $dataToBeDisplayed['accounts'] = $accountList;
        $cardList = $this->Card_model->GetUserCardDetailInformation(array('a.USER_ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['cards'] = $cardList;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['result'] = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['currency'] = false;
        $dataToBeDisplayed['available_amount'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromAccount', ' Debit From Account ' ,'required');
        $this->form_validation->set_rules('toCard', ' Credit To Card ' , 'required');
        $this->form_validation->set_rules('amount', ' Amount ' , 'required');
        $this->form_validation->set_rules('fee', ' Fee amount ', 'required');
        if($this->form_validation->run() == TRUE) {
            $fromAccount = $this->input->post('fromAccount');
            $toAccount = $this->input->post('toCard');
            $amount = $this->input->post('amount');
            $amount = floatval(str_replace(",","",$amount));
            $fee = $this->input->post('fee');
            $fee = floatval((str_replace(",","", $fee)));
            $description = $this->input->post('description');
            if (intval($fromAccount) == 0 || intval($toAccount) == 0) {
                $dataToBeDisplayed['currency'] = true;
            }
            else {
                $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));
                $toAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $toAccount));
                $this->load->library('TransferUtils');

                $calcedFee = $this->transferutils->MakeFeeValueByMinMax($fee, $fromAccountModel[0]['MIN_TRANS_FEE'], $fromAccountModel[0]['MAX_TRANS_FEE']);
                $fee = $calcedFee;
                $availableValue = floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']);
                if($availableValue < ($amount + $fee)) {
                    $dataToBeDisplayed['available_amount'] = true;
                }
                else {
                    if ($fromAccountModel[0]['CURRENCY_TYPE'] == $toAccountModel[0]['CURRENCY_TYPE']) {
                        $toRevenueModel = $this->RevenueInfo_model->GetRevenueAccount(array('CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE']));
                        if (count($toRevenueModel) == 0) {
                            $dataToBeDisplayed['create_revenue'] = true;
                        } else {
                            $retValFromEngine = $this->transferutils->transferToCard($amount, $description, $fee, $fromAccountModel, $toAccountModel, $toRevenueModel);
                            $dataToBeDisplayed['result'] = $retValFromEngine['result'];
                            $dataToBeDisplayed['show_alert'] = $retValFromEngine['show_alert'];
                            if ($retValFromEngine['result'] == true) {
                                //send notification email to admin
                                self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                    $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                    $this->input->ip_address(),
                                    Card_Funding_Transfer);
                            }
                        }
                    }
                    else {
                        $dataToBeDisplayed['currency'] = true;
                    }
                }
            }
        }
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/transfer/cards', $dataToBeDisplayed);
    }

    public function users()
    {
        $dataToBeDisplayed = $this->makeComponentViews(3);
        //get whole accounts
        $accountList = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $this->session->userdata['me']['ID'], 'a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET));
        $dataToBeDisplayed['accounts'] = $accountList;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['result'] = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['aml'] = false;

        $userList = $this->User_model->FindUserByArray(array('ID !=' => $this->session->userdata['me']['ID'], 'STATUS' => USER_STATUS_ACTIVE, 'LEVEL' => '4'));
        $dataToBeDisplayed['users'] = $userList;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromAccount', ' Debit From Account ', 'required');
        $this->form_validation->set_rules('toAccount', ' Credit To Account ', 'required');
        $this->form_validation->set_rules('amount', ' Amount ', 'required');

        if ($this->form_validation->run() == TRUE) {
            $fromAccount = $this->input->post('fromAccount');
            $toUser = $this->input->post('toAccount');
            $amount = $this->input->post('amount');
            $amount = floatval(str_replace(",","",$amount));

            $description = $this->input->post('description');

            $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));
            $toAccountModel = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $toUser, 'a.CURRENCY_TYPE' => $fromAccountModel[0]['CURRENCY_TYPE'], 'a.STATUS' => USER_STATUS_ACTIVE, 'a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET));
            $this->load->library('TransferUtils');
            if (count($toAccountModel) == 0) {
                $toAccountModel = $this->Account_model->FindAccountByArray(array('USER_ID' => $toUser, 'a.STATUS' => USER_STATUS_ACTIVE, 'a.ACCOUNT_TYPE' => ACCOUNT_TYPE_VIBAN));
                if (count($toAccountModel) == 0) {
                    $dataToBeDisplayed['show_alert'] = true;
                    $dataToBeDisplayed['result'] = false;
                    $this->load->view('client/pages/transfer/users', $dataToBeDisplayed);
                    return;
                }
            }

            $availableValue = floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']);
            if($availableValue < ($amount)) {
                $dataToBeDisplayed['available_amount'] = true;
            }
            else {
                if ($fromAccountModel[0]['ACCOUNT_TYPE'] == $toAccountModel[0]['ACCOUNT_TYPE']) {
                    //from eWallet to eWallet
                    $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $toAccountModel, $amount, $description, Transfer_Between_Users);
                    $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);

                    if ($retValFromEngine['result'] == true && $retValFromEngine['aml'] == false) {
                        $emailResult = self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                            $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                            $this->input->ip_address(),
                            Transfer_Between_Users);
                    }
                }
                else {
                    //from eWallet to vIBAN
                    //so eWallet - eWallet - vIBAN
                    //  - find eWallet of same currecy with vIBAN in toAccountUser
                    if ($fromAccountModel[0]['CURRENCY_TYPE'] == $toAccountModel[0]['CURRENCY_TYPE']) {
                        $retValFromEngine = $this->transferutils->TransferFromEWalletToVIBANEngine($fromAccountModel, $toAccountModel, $amount, $description, Transfer_Between_Users);
                        $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                        if ($retValFromEngine['result'] == true) {
                            $emailResult = self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                $this->input->ip_address(),
                                Transfer_Between_Users);
                        }
                    } else {
                        $toEWalletAccount = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $toAccountModel[0]['USER_ID'], 'a.CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE'], 'a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET));
                        if ($toEWalletAccount === NULL || count($toEWalletAccount) == 0) {
                            $dataToBeDisplayed['target_wallet'] = true;
                        } else {
                            $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $toEWalletAccount, $amount, $description, Transfer_Between_Users);
                            $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                            $isAML = $dataToBeDisplayed['aml'];
                            if ($retValFromEngine['result'] == true) {
                                $retValFromWallet = $this->transferutils->TransferFromEWalletToVIBANEngine($toEWalletAccount, $toAccountModel, $amount * $retValFromEngine['calcConversionRate'], $description, Transfer_Between_Users);
                                $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromWallet);
                                $dataToBeDisplayed['aml'] = $isAML;
                                $emailResult = self::SendNotificationEmail($fromAccountModel[0]['USER_FULLNAME'] . '(' . $fromAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                    $toAccountModel[0]['USER_FULLNAME'] . '(' . $toAccountModel[0]['ACCOUNT_NUMBER'] . ')',
                                    $this->input->ip_address(),
                                    Transfer_Between_Users);
                            }
                        }
                    }
                }
            }
        }

        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/transfer/users', $dataToBeDisplayed);
    }

    public function getFeeValue()
    {
        $accountId = $this->input->post('accountId');
        $accountArray = $this->Account_model->FindAccountByArray(array('a.ID' => $accountId));
        $feeArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_FEE_INFO, array('ID' => $accountArray[0]['FEE_TYPE_INDEX']));
        echo json_encode($feeArray);
    }

    private function SendNotificationEmail($fromAccountName, $toAccountName, $ip, $transferType)
    {
        $adminData = $this->User_model->FindUserByArray(array('LEVEL' => 1));

        $content = "";
        if($transferType == Transfer_Between_Accounts)
        {
            $content = "Hi, <strong> There's new Transfer Between Accounts request.</strong><br>".$fromAccountName." want to transfer to ".$toAccountName."."
                ."<br>IP Location: ".$ip;

        }
        else if($transferType == Transfer_Between_Users)
        {
            $content = "Hi, <strong> There's new Transfer Between Users request.</strong><br>".$fromAccountName." want to transfer to ".$toAccountName."."
                ."<br>IP Location: ".$ip;

        }
        else if($transferType == Outgoing_Wire_Transfer)
        {
            $content = "Hi, <strong> There's new Outgoing Wire Transfer request.</strong><br>".$fromAccountName." want to transfer to ".$toAccountName."."
                ."<br>IP Location: ".$ip;
        }
        else if($transferType == Card_Funding_Transfer)
        {
            $content = "Hi, <strong> There's new Card Funding Transfer request.</strong><br>".$fromAccountName." want to transfer to ".$toAccountName."."
                ."<br>IP Location: ".$ip;
        }

        $this->email->initialize($this->config->item('EMAIL'));
        $this->email->from($this->config->item('EMAIL_DISP'), $this->config->item('EMAIL_DISP'));
        $this->email->to($adminData[0]['EMAIL']);

        $this->email->subject('New Request Occurred');
        $this->email->message($content);
        $result = $this->email->send();
        return $result;
    }

    public function GetCurrencyConversionRate(){
        $accountId = $this->input->post('accountId');
        $targetCurrency = $this->input->post('targetCurrency');

        $this->load->library('TransferUtils');

        $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $accountId));
        $valorPayRate = $this->transferutils->GetValorPayRate($fromAccountModel[0]['CURRENCY_TYPE'], $targetCurrency);

        echo json_encode(array('vpayRate' => $valorPayRate));
    }

}