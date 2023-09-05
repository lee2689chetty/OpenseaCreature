<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminTransferController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect(base_url().'admin/auth/login');
        }
        else if($this->session->userdata['me']['LEVEL']  == '4') {
            redirect(base_url().'auth/login');
        }
    }

    public function makeComponentViews($menuNum)
    {
        $header_layout = $this->load->view('admin/template/header_layout', '', TRUE);
        $adminDataName = array('adminName' => $this->session->userdata['me']['NAME']);
        $topbar_layout = $this->load->view('admin/template/topbar_layout', $adminDataName, TRUE);
        $selectedMenu = array('selectedMenu'=>$menuNum );
        $sidebar_layout = $this->load->view('admin/template/sidebar_layout', $selectedMenu, TRUE);
        $footer_layout = $this->load->view('admin/template/footer_layout', '', TRUE);
        $dataToBeDisplayed['header'] = $header_layout;
        $dataToBeDisplayed['topbar']  = $topbar_layout;
        $dataToBeDisplayed['sidebar'] = $sidebar_layout;
        $dataToBeDisplayed['footer'] = $footer_layout;
        $dataToBeDisplayed['notifyVerifyDocs'] = 5;
        return $dataToBeDisplayed;
    }

    public function view()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_TRANSFER);
        $this->load->view('admin/pages/transfer/view', $dataToBeDisplayed);
    }

    /**
     * Begin of Transfer Between Account
     */
    public function baccounts()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_TRANSFER);
        $dataToBeDisplayed['userList'] = $this->User_model->FindUserByArray(array('LEVEL' => '4'));
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['result'] = false;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['available_amount'] = false;
        $dataToBeDisplayed['aml'] = false;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('baUserList', ' User ', 'required');
        $this->form_validation->set_rules('baAccountFrom', ' Debit From Account ', 'required');
        $this->form_validation->set_rules('baAccountTo', ' Credit To Account ', 'required');
        $this->form_validation->set_rules('baAmount', ' Amount ', 'required');
        $this->form_validation->set_rules('baDescription', ' Description ', 'required');

        if ($this->form_validation->run() == TRUE) {
            $userId = $this->input->post('baUserList');
            $fromAccount = $this->input->post('baAccountFrom');
            $toAccount = $this->input->post('baAccountTo');
            $amount = $this->input->post('baAmount');
            $amount = floatval((str_replace(",","", $amount)));
            $description = $this->input->post('baDescription');
            if ($fromAccount == $toAccount) {
                $dataToBeDisplayed['show_alert'] = true;
                $dataToBeDisplayed['result'] = false;
            }
            else {
                $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));
                $toAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $toAccount));
                if(floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']) < $amount) {
                    $dataToBeDisplayed['available_amount'] = true;
                }
                else {
                    $this->load->library('TransferUtils');

                    if ($fromAccountModel[0]['ACCOUNT_TYPE'] == $toAccountModel[0]['ACCOUNT_TYPE']) {
                        $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $toAccountModel, $amount, $description);
                        $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                    }
                    else {
                        if ($fromAccountModel[0]['CURRENCY_TYPE'] == $toAccountModel[0]['CURRENCY_TYPE']) {
                            //same currency from eWallet to vIBAN
                            $retValFromEngine = $this->transferutils->TransferFromEWalletToVIBANEngine($dataToBeDisplayed, $fromAccountModel, $toAccountModel, $amount, $description);
                            $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                        }
                        else {
                            // find eWallet with same currency of toAccountModel
                            $eWalletForToAccount = $this->Account_model->FindAccountByArray(array('a.ACCOUNT_TYPE' => ACCOUNT_TYPE_EWALLET, 'a.CURRENCY_TYPE' => $toAccountModel[0]['CURRENCY_TYPE'], 'a.USER_ID' => $toAccountModel[0]['USER_ID']));
                            if ($eWalletForToAccount === NULL || count($eWalletForToAccount) == 0) {
                                //show error message to create with same ewallet first
                                $dataToBeDisplayed['target_wallet'] = true;
                            }
                            else {
                                // transfer money between eWallet with currency conversion first
                                // transfer money from eWalletForToAccount to toAccountModel without any fee
                                $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $eWalletForToAccount, $amount, $description);
                                $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);


                                if ($retValFromEngine['result'] == true) {
                                    $retValFromEngine = $this->transferutils->TransferFromEWalletToVIBANEngine($eWalletForToAccount, $toAccountModel, $amount * $retValFromEngine['calcConversionRate'], $description);
                                    $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->load->view('admin/pages/transfer/betweenaccounts', $dataToBeDisplayed);
    }

    public function busers()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_TRANSFER);
        $dataToBeDisplayed['userList'] = $this->User_model->FindUserByArray(array('LEVEL' => '4'));
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['available_amount'] = false;
        $dataToBeDisplayed['aml'] = false;
        $dataToBeDisplayed['result'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bUserList1', ' Debit From User ' ,'required');
        $this->form_validation->set_rules('bAccountList1', ' Debit From Account ' ,'required');
        $this->form_validation->set_rules('bUserList2', ' Credit To User ' ,'required');
        $this->form_validation->set_rules('bAccountList2', ' Credit To Account ' ,'required');
        $this->form_validation->set_rules('bAmount', ' Amount ' , 'required');
        $this->form_validation->set_rules('bDescription', ' Description ' , 'required');

        if($this->form_validation->run() == TRUE) {
            $fromUser = $this->input->post('bUserList1');
            $toUser = $this->input->post('bUserList2');
            $fromAccount = $this->input->post('bAccountList1');
            $toAccount = $this->input->post('bAccountList2');
            $amount = $this->input->post('bAmount');
            $amount = floatval((str_replace(",","", $amount)));

            $description = $this->input->post('bDescription');
            if($fromUser == $toUser) {
                //if same user transfer, then it should be failed.
                $dataToBeDisplayed['show_alert'] = true;
            }
            else {
                $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));
                $toAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $toAccount));

                if(floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']) < $amount) {
                    $dataToBeDisplayed['available_amount'] = true;
                }
                else {
                    $this->load->library('TransferUtils');
                    // engine starts here.
                    //don't forget to check revenue account existance in every step
                    if ($fromAccountModel[0]['ACCOUNT_TYPE'] == $toAccountModel[0]['ACCOUNT_TYPE']) {
                        //from eWallet to eWallet
                        $retValFromEngine = $this->transferutils->TransferFromEWalletToEWalletEngine($fromAccountModel, $toAccountModel, $amount, $description, Transfer_Between_Users);
                        $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);

                    } else {
                        //from eWallet to vIBAN
                        //so eWallet - eWallet - vIBAN
                        //  - find eWallet of same currecy with vIBAN in toAccountUser
                        if ($fromAccountModel[0]['CURRENCY_TYPE'] == $toAccountModel[0]['CURRENCY_TYPE']) {
                            $retValFromEngine = $this->transferutils->TransferFromEWalletToVIBANEngine($fromAccountModel, $toAccountModel, $amount, $description, Transfer_Between_Users);
                            $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                        }
                        else {
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
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->load->view('admin/pages/transfer/betweenuser', $dataToBeDisplayed);
    }

    public function outgoing()
    {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_TRANSFER);

        $dataToBeDisplayed['userList'] = $this->User_model->FindUserByArray(array('LEVEL' => '4'));
        $dataToBeDisplayed['countries'] = $this->UtilInfo_model->GetCountryList();
        $dataToBeDisplayed['currencies'] = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_CURRENCY_KIND);
        $dataToBeDisplayed['create_revenue'] = false;
        $dataToBeDisplayed['target_wallet']  = false;
        $dataToBeDisplayed['show_alert'] = false;
        $dataToBeDisplayed['currencypair'] = false;
        $dataToBeDisplayed['available_amount'] = false;
        $dataToBeDisplayed['result'] = false;
        $dataToBeDisplayed['aml'] = false;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('userList', ' Debit From User ' ,'required');
        $this->form_validation->set_rules('accountList', ' Debit From Account ' ,'required');
        $this->form_validation->set_rules('bankSwift', ' Swift/BIC ' , 'required');
        $this->form_validation->set_rules('bankName', ' Bank Name ' , 'required');
        $this->form_validation->set_rules('bankAddress', ' Address of Bank ' , 'required');
        $this->form_validation->set_rules('bankLocation', ' Location of Bank ' , 'required');
        $this->form_validation->set_rules('bankCountry', ' Country of Bank ' , 'required');
        $this->form_validation->set_rules('beneficaryName', ' Customer name ' , 'required');
        $this->form_validation->set_rules('beneficaryAddr', ' Customer address ' , 'required');
        $this->form_validation->set_rules('beneficaryAcc', ' Iban of Customer ' , 'required');
        $this->form_validation->set_rules('addionAddress', ' Additional Information Name ' , 'required');
        $this->form_validation->set_rules('transferAmount', ' Amount ' , 'required');
        $this->form_validation->set_rules('transferCurrency', ' Currency Type ' , 'required');
        $this->form_validation->set_rules('fee', ' Fee ' , 'required');

        if($this->form_validation->run() == TRUE) {
            $userList = $this->input->post('userList');
            $fromAccount = $this->input->post('accountList');
            $swiftbic = $this->input->post('bankSwift');
            $bankaddress = $this->input->post('bankAddress');
            $bankname = $this->input->post('bankName');
            $banklocation = $this->input->post('bankLocation');
            $bankcountry = $this->input->post('bankCountry');
            $abartn = $this->input->post('bankABA');
            $customername = $this->input->post('beneficaryName');
            $customeraddress = $this->input->post('beneficaryAddr');
            $customeriban = $this->input->post('beneficaryAcc');
            $additionaddr = $this->input->post('addionAddress');
            $transferAmount = $this->input->post('transferAmount');
            $transferAmount = floatval((str_replace(",","", $transferAmount)));

            $transferCurrency = $this->input->post('transferCurrency');
            $intermediatrybank = $this->input->post('chkIntermediaryBank');
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

            $vpayRate = $this->input->post('vpayRate');

            $currencyConversionRate = $this->input->post('currencyConversionRate');
            $currencyConversionRate = floatval(str_replace(",", "", $currencyConversionRate));

            //totally Fee
            $resultFee = $this->input->post('resultFee');
            $resultFee = floatval(str_replace(",", "", $resultFee));

            $additionFee = $this->input->post('additionalFeeTotal');

            $intermediatrybankInt = $intermediatrybank == 'on'?1:0;

            $fromAccountModel = $this->Account_model->FindAccountByArray(array('a.ID' => $fromAccount));
            if(floatval($fromAccountModel[0]['AVAILABLE_AMOUNT']) < ($resultFee + $transferAmount)) {
                $dataToBeDisplayed['available_amount'] = true;
            }
            else {
                $this->load->library('TransferUtils');
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
                    $retValFromEngine = $this->transferutils->MakeOutgoingWithFixedValue($bankOutgingHistoryId, $fromAccountModel, $transferAmount, $transferCurrency, $vpayRate, $currencyConversionRate, $description, $fee, $resultFee, $additionFee);
                    $dataToBeDisplayed = ConvertResultToDataToBeDisplayed($dataToBeDisplayed, $retValFromEngine);
                }
            }
        }
        $this->load->view('admin/pages/transfer/outgoing', $dataToBeDisplayed);
    }

    public function AccountFromUser()
    {
        $userId = $this->input->post('userId');
        $accountType = $this->input->post('accountType');
        $findArray['a.USER_ID'] = $userId;
        if($accountType == "wallet")
        {
            $findArray['a.ACCOUNT_TYPE'] = ACCOUNT_TYPE_EWALLET;
        }
        else if($accountType == "iban")
        {
            $findArray['a.ACCOUNT_TYPE <='] = ACCOUNT_TYPE_VIBAN;
        }
        $accountListArray = $this->Account_model->FindAccountByArray($findArray);
        echo json_encode($accountListArray);
    }

    public function GetAccountForOutGoing()
    {
        $userId = $this->input->post('userId');
        $accountListArray = $this->Account_model->FindAccountByArray(array('a.USER_ID' => $userId, 'a.ACCOUNT_TYPE < '=>ACCOUNT_TYPE_CARD));
        echo json_encode($accountListArray);
    }

    public function GetFeeValueFromAccount()
    {
        $accountId = $this->input->post('accountId');
        $accountArray = $this->Account_model->FindAccountByArray(array('a.ID' => $accountId));
        $feeArray = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_ACCOUNT_FEE_INFO, array('ID' => $accountArray[0]['FEE_TYPE_INDEX']));
        echo json_encode($feeArray);
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