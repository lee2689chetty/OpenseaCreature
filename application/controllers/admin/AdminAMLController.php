<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminAMLController extends CI_Controller
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
        return $dataToBeDisplayed;
    }

    public function restrict_countries() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_AML_COUNTRIES);
        $countryList = $this->UtilInfo_model->GetCountryList();
        $restrictCountry = $this->AML_model->getRestrictCountry();
        $dataToBeDisplayed['countries'] = $countryList;
        $dataToBeDisplayed['restrictCountries'] = $restrictCountry;
        $this->load->view('admin/pages/aml/view_country_list', $dataToBeDisplayed);
    }

    public function add_restrict_countries() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('countryItem', ' Country ', 'required');

        if($this->form_validation->run() == TRUE) {
            $countryAddItem = $this->input->post('countryItem');
            if($this->AML_model->isCountryExist($countryAddItem) == false) {
                $countryValue = $this->UtilInfo_model->GetBasisUtilInfoList(MY_Model::TABLE_COUNTRY_INFO, array('ID' => $countryAddItem));
                if(count($countryValue) > 0) {
                    $this->AML_model->InsertNewRestrictCountry(array('COUNTRY_ID' => $countryAddItem, 'COUNTRY_DESC' => $countryValue[0]['DESCRIPTION'], 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
                }
            }
        }
        redirect(base_url()."admin/aml/restrict_countries");
    }

    public function remove_restrict_countries($restrictId) {
        if($restrictId > 0)
        {
            $this->AML_model->removeRestrictCountry($restrictId);
        }
        redirect(base_url()."admin/aml/restrict_countries");
    }


    public function view_threshold() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_AML_THRESHOLD);
        $thresholdList = $this->AML_model->getThresholdByArray();
        $dataToBeDisplayed['thresholdList'] = $thresholdList;

        $this->load->view('admin/pages/aml/view_threshold_list', $dataToBeDisplayed);
    }

    public function edit_threshold($thresId) {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_AML_THRESHOLD);
        if($thresId < 0)
        {
            show_404();
            return;
        }

        $thresholdList = $this->AML_model->getThresholdByArray(array('ID' => $thresId));
        $dataToBeDisplayed['thresholdList'] = $thresholdList;
        $dataToBeDisplayed['thresholdId']  = $thresId;

        $this->load->view('admin/pages/aml/edit_threshold_item', $dataToBeDisplayed);
    }

    public function save_threshold() {
        $thresholdValue = $this->input->post('txtThreshold');
        $thresholdId = $this->input->post('thresholdId');
        $this->AML_model->updateThresholdObject(array('THRESHOLD_AMOUNT'=>$thresholdValue, 'UPDATED_AT'=>time()), array('ID' => $thresholdId));
        redirect(base_url()."admin/aml/view_threshold");
    }

    public function view_trans_list() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_AML_TRANS);
        $amlList = $this->AML_model->getAMLTransactionByArray(array('STATUS' => '0'));
        for($idx = 0 ; $idx < count($amlList) ; $idx ++) {
            $retVal = $this->getTransactionHistoryInformation($amlList[$idx]['TRANSACTION_ID']);
            $relatedTrans = $this->AML_model->getAMLRelatedTransactionByArray(array('PARENT_ID' => $amlList[$idx]['ID']));
            $amlList[$idx]['countOfRelation'] = count($relatedTrans);
            $amlList[$idx]['detailItem'] = $retVal['insArr'];
            $amlList[$idx]['transAmount'] = $retVal['transAmount'];
        }

        //get warning items
        $warnList = $this->TransferHistory_model->getWarningTransItems();
        for($i = 0 ; $i < count($warnList) ; $i++) {
            $userItem = $this->User_model->FindUserByArray(array('ID' => $warnList[$i]['TO_USER_ID']));
            if(count($userItem) >0) {
                $warnList[$i]['userName'] = $userItem[0]['NAME'];
            }
            else {
                $warnList[$i]['userName'] = "Bank";
            }
        }

        $dataToBeDisplayed['amlList']  = $amlList;
        $dataToBeDisplayed['warningList'] = $warnList;

        $this->load->view('admin/pages/aml/view_trans_list', $dataToBeDisplayed);
    }


    private function getTransactionHistoryInformation($transactionItemId) {
        $retVal = array();
        $transactionItem = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $transactionItemId));
        $fromUser = $this->User_model->FindUserByArray(array('ID' => $transactionItem[0]['USER_ID']));
        $toUser = $this->User_model->FindUserByArray(array('ID' => $transactionItem[0]['TO_USER_ID']));
        $insArr = array();

        if(intval($fromUser[0]['PROFILE_ID']) == 0) {
            $insArr['fromUserName'] = "Bank";
            $insArr['fromUserProfileId'] = "0";
        }
        else if(intval($fromUser[0]['PROFILE_ID']) == 1) {
            $insArr['fromUserName'] = "Administrator";
            $insArr['fromUserProfileId'] = "0";
        }
        else {
            $insArr['fromUserName'] = $fromUser[0]['FULL_NAME'];
            $insArr['fromUserProfileId'] = $fromUser[0]['PROFILE_ID'];
        }

        if(count($toUser) == 0) {
            $insArr['toUserName'] = "Bank";
            $insArr['toUserProfileId'] = "0";
        }
        else {
            if (intval($toUser[0]['PROFILE_ID']) == 0) {
                $insArr['toUserName'] = "Bank";
                $insArr['toUserProfileId'] = "0";
            } else if (intval($toUser[0]['PROFILE_ID']) == 1) {
                $insArr['toUserName'] = "Administrator";
                $insArr['toUserProfileId'] = "0";
            } else {
                $insArr['toUserName'] = $toUser[0]['FULL_NAME'];
                $insArr['toUserProfileId'] = $toUser[0]['PROFILE_ID'];
            }
        }
        $retVal['transAmount'] = $transactionItem[0]['AMOUNT'];
        $retVal['insArr'] = $insArr;
        return $retVal;
//        $relatedTrans = $this->AML_model->getAMLRelatedTransactionByArray(array('PARENT_ID' => $amlList[$idx]['ID']));
//        $amlList[$idx]['countOfRelation'] = count($relatedTrans);
//        $amlList[$idx]['detailItem'] = $insArr;
//        $amlList[$idx]['transAmount'] = $transactionItem[0]['AMOUNT'];
    }

    public function view_related_trans($mainTransId) {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_AML_TRANS);
        $retValMain = $this->AML_model->getAMLTransactionByArray(array('ID' => $mainTransId));
        $retValMainDetail = $this->getTransactionHistoryInformation($retValMain[0]['TRANSACTION_ID']);
        $retValMain['transAmount'] = $retValMainDetail['transAmount'];
        $retValMain['detailItem'] = $retValMainDetail['insArr'];

        $relatedTrans = $this->AML_model->getAMLRelatedTransactionByArray(array('PARENT_ID' => $mainTransId));
        for($i = 0 ; $i < count($relatedTrans); $i++) {
            $retValTmp = $this->getTransactionHistoryInformation($relatedTrans[$i]['TRANS_ID']);
            array_push($relatedTrans[$i], $retValTmp);
        }

        $dataToBeDisplayed['mainTrans'] = $retValMain;
        $dataToBeDisplayed['relatedTrans'] = $relatedTrans;
        $this->load->view('admin/pages/aml/view_related_trans_list', $dataToBeDisplayed);
    }


    public function approve_one($amlTransId) {
        $this->AML_model->updateAMLTransaction(array('UPDATED_AT' => now(), 'STATUS' => '1'), array('ID' => $amlTransId));
        $amlTransHistory = $this->AML_model->getAMLTransactionByArray(array('ID' => $amlTransId));
        $lastStatus  = $this->TransferHistoryDetailStatus_model->getLastStatusExceptForSuspend($amlTransHistory[0]['TRANSACTION_ID']);
        $this->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => $lastStatus[0]['STATUS_ID'], 'UPDATED_AT' => now(), 'IS_AML_PASSED' => '1'), array('ID' => $amlTransHistory[0]['TRANSACTION_ID']));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $amlTransHistory[0]['TRANSACTION_ID'], 'STATUS_ID' => $lastStatus[0]['STATUS_ID'], 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        redirect(base_url().'admin/aml/view_trans_list');
    }

    public function approve_all($amlTransId) {
        $this->AML_model->updateAMLTransaction(array('UPDATED_AT' => now(), 'STATUS' => '1'), array('ID' => $amlTransId));
        $amlMainTransHistory = $this->AML_model->getAMLTransactionByArray(array('ID' => $amlTransId));
        $lastStatus  = $this->TransferHistoryDetailStatus_model->getLastStatusExceptForSuspend($amlMainTransHistory[0]['TRANSACTION_ID']);

        $this->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => $lastStatus[0]['STATUS_ID'], 'UPDATED_AT' => now(), 'IS_AML_PASSED' => '1'), array('ID' => $amlMainTransHistory[0]['TRANSACTION_ID']));
        $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $amlMainTransHistory[0]['TRANSACTION_ID'], 'STATUS_ID' => $lastStatus[0]['STATUS_ID'], 'UPDATED_AT' => now(), 'CREATED_AT' => now()));

        $amlRelatedTransHistory = $this->AML_model->getAMLRelatedTransactionByArray(array('PARENT_ID'=>$amlTransId));
        for($i = 0 ; $i < count($amlRelatedTransHistory) ; $i++) {
            $this->AML_model->updateAMLRelatedTransaction(array('STATUS' => '1', 'UPDATED_AT' => now()), array('ID' => $amlRelatedTransHistory[$i]['ID']));
            $lastStatus  = $this->TransferHistoryDetailStatus_model->getLastStatusExceptForSuspend($amlRelatedTransHistory[0]['TRANS_ID']);

            $this->TransferHistory_model->UpdateTransferHistoryObject(array('STATUS' => $lastStatus[0]['STATUS_ID'], 'UPDATED_AT' => now(), 'IS_AML_PASSED' => '1'), array('ID' => $amlRelatedTransHistory[$i]['TRANS_ID']));
            $this->TransferHistoryDetailStatus_model->InsertRecordByArray(array('REQUEST_ID' => $amlRelatedTransHistory[$i]['TRANS_ID'], 'STATUS_ID' => $lastStatus[0]['STATUS_ID'], 'UPDATED_AT' => now(), 'CREATED_AT' => now()));
        }

        redirect(base_url().'admin/aml/view_trans_list');
    }


    public function view_warnings() {
        $dataToBeDisplayed = $this->makeComponentViews(MENU_AML_TRANS);

        $touser = $this->input->get('to_user');
        $amount = $this->input->get('amount');
        $warningRelationRecords = $this->TransferHistory_model->getLast30Records($touser, $amount);
        for($i = 0 ; $i < count($warningRelationRecords) ; $i++) {
            $retValMainDetail = $this->getTransactionHistoryInformation($warningRelationRecords[$i]['ID']);
            $warningRelationRecords[$i]['userInfo'] = $retValMainDetail['insArr'];
        }
        $dataToBeDisplayed['transfer_history'] = $warningRelationRecords;
        $this->load->view('admin/pages/aml/view_warning_trans_list', $dataToBeDisplayed);
    }
}