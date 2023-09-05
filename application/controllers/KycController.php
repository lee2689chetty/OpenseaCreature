<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class KycController extends CI_Controller
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
    }

    public function MakeComponentsViews($menuNum)
    {
        $this->Notification_model->UpdateReadStatus(array('USER_ID' => $this->session->userdata['me']['ID'], 'REASON_TYPE' => NOTIFY_VERIFY_REQUESTED));
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
    public function view($ticketNumber)
    {
        $dataToBeDisplayed = $this->MakeComponentsViews(0);
        $kycData =  $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $ticketNumber));
        if(count($kycData) == 0) {
            show_404();
            return;
        }
        $dataToBeDisplayed['kycData'] = $kycData[0];
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/kyc/view', $dataToBeDisplayed);
    }

    public function upload($ticketNumber) {
        $kycData =  $this->Kyc_model->GetVerificationInformation(array('TICKET_NUMBER' => $ticketNumber));
        if(count($kycData) == 0) {
            show_404();
            return;
        }
        $userFName = $this->input->post('userFName');
        $userLName = $this->input->post('userLName');
        $dob = $this->input->post('dob');
        $userIdNumber = $this->input->post('userIdNumber');
        $userAddress = $this->input->post('userAddress');
        $addressProofType = $this->input->post('addressProofType');

        $passImg = "";
        if($kycData[0]['IDENTIFY_APPROVE'] == '0') {
            if (!empty($_FILES['passimg']['name'])) {
                $attachdirname  = './kyc_upload_data';
                if (!is_dir(''.$attachdirname)) {
                    mkdir(''.$attachdirname, 0777, TRUE);
                }
                $passImg = $this->fileUpload($attachdirname, 'pass_kyc_'.time(), 'passimg');
            }
        }
        else {
            $passImg = $kycData[0]['USER_ID_APPROVE_PATH'];
            $userIdNumber = $kycData[0]['USER_ID_NUMBER'];
            $dob = $kycData[0]['USER_DOB'];
            $userFName = $kycData[0]['USER_FNAME'];
            $userLName = $kycData[0]['USER_LNAME'];
        }

        $billImg = "";
        if($kycData[0]['ADDRESS_APPROVE'] == '0') {
            if (!empty($_FILES['billimg']['name'])) {
                $attachdirname  = './kyc_upload_data';
                if (!is_dir(''.$attachdirname)) {
                    mkdir(''.$attachdirname, 0777, TRUE);
                }
                $billImg = $this->fileUpload($attachdirname, 'bill_kyc_'.time(), 'billimg');
            }
        }
        else {
            $billImg = $kycData[0]['ADDR_APPROVE_DOC'];
            $userAddress = $kycData[0]['USER_ADDR'];
            $addressProofType = $kycData[0]['ADDR_DOC_KIND'];
        }

        $this->Kyc_model->UpdateKycObject(array('UPDATED_AT' => time(), 'USER_FNAME' => $userFName, 'USER_LNAME' => $userLName,
                                                'USER_DOB' => $dob, 'USER_ID_NUMBER' => $userIdNumber, 'USER_ID_APPROVE_PATH' => $passImg,
                                                'USER_ADDR' => $userAddress, 'ADDR_DOC_KIND' => $addressProofType, 'ADDR_APPROVE_DOC' => $billImg),
                                        array('TICKET_NUMBER' => $ticketNumber));
        redirect(base_url().'kyc/view/'.$ticketNumber);
    }

    protected function fileUpload($pathToUpload, $nameToUpload, $filePostFiled){
        $config['upload_path']   = $pathToUpload."/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 1024*9;//6 MB Maximum
        $config['max_width']     = 8000;
        $config['max_height']    = 8000;
        $config['file_name'] = $nameToUpload;
        $this->load->library('upload', $config);

        $this->upload->initialize($config);
        $upload_result = $this->upload->do_upload($filePostFiled);
        $uploadFilePath = "";
        if($upload_result == TRUE){
            $uploadFilePath = $pathToUpload."/".$this->upload->data('file_name');
        }
        else{
//            $uploadFilePath = $this->upload->display_errors();

            $uploadFilePath = "";
        }
        return $uploadFilePath;
    }

}