<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class FileController extends CI_Controller
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

    public function new_upload($param) {
        //if($param == "new") insert tarnsaction id with transId
        $dataToBeDisplayed = $this->MakeComponentsViews(6);
        $dataToBeDisplayed['userList'] = $this->User_model->FindUserByArray(array('LEVEL' => 4));
        $dataToBeDisplayed['uploadError'] = false;
        $dataToBeDisplayed['uploadSuccess'] = false;
        if($param == "new") {
            $dataToBeDisplayed['transId'] = "";
        }
        else {
            $dataToBeDisplayed['transId'] = $param;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('transId', 'Transaction Id' , 'required');
        if($this->form_validation->run() == TRUE)
        {
            $userId = $this->input->post('accountOwner');
            $transId = $this->input->post('transId');

            $uploadResult = "";
            if (!empty($_FILES['fileToUpload']['name'])) {
                $attachdirname  = './upload_file';
                if (!is_dir(''.$attachdirname)) {
                    mkdir(''.$attachdirname, 0777, TRUE);
                }
                $uploadResult = $this->fileUpload($attachdirname, 'upload_file_'.time(), 'fileToUpload');
            }

            if($uploadResult['result'] == false) {
                $dataToBeDisplayed['uploadError'] = true;
            }
            else {
                $transactionHistoryItem = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $transId));
                if(count($transactionHistoryItem) == 0){
                    show_404();
                    return;
                }

                $insertedId = $this->File_model->InsertNewFile(array( 'USER_NAME' => $this->session->userdata['me']['NAME'],
                                                        'USER_FULL_NAME' => $this->session->userdata['me']['FULL_NAME'],
                                                        'USER_ID' => $this->session->userdata['me']['ID'],
                                                        'FILE_NAME' => $uploadResult['file_name'],
                                                        'FILE_PATH' => $uploadResult['path'],
                                                        'UPLOADER_ID' => $this->session->userdata['me']['ID'],
                                                        'UPLOADER_USER_NAME' => $this->session->userdata['me']['NAME'],
                                                        'TRANS_ID' => $transId,
                                                        'FILE_EXTENSION' => '',
                                                        'UPDATED_AT' => time(),
                                                        'CREATED_AT' => time()));

                $dataToBeDisplayed['uploadSuccess'] = true;
                $dataToBeDisplayed['transId'] = "";
            }
        }
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/file/new_upload', $dataToBeDisplayed);
    }

    protected function fileUpload($pathToUpload, $nameToUpload, $filePostFiled){
        $config['upload_path']   = $pathToUpload."/";
        $config['allowed_types'] = '*';
        $config['max_size']      = 1024*9;//6 MB Maximum
        $config['file_name'] = $nameToUpload;
        $this->load->library('upload', $config);


        $this->upload->initialize($config);
        $upload_result = $this->upload->do_upload($filePostFiled);

        $uploadFilePath = array();
        $uploadFilePath['result'] = $upload_result;

        if($upload_result == TRUE){
            $uploadFilePath['path'] = $pathToUpload."/".$this->upload->data('file_name');
            $uploadFilePath['file_name'] = $this->upload->data('file_name');

        }
        else{
//            $uploadFilePath = $this->upload->display_errors();
            $uploadFilePath['path'] = "";
            $uploadFilePath['file_name'] = "";
        }
        return $uploadFilePath;
    }

    public function view() {
        $dataToBeDisplayed = $this->MakeComponentsViews(6);
        $fileList = $this->File_model->GetUploadFileInformation(array('USER_ID' => $this->session->userdata['me']['ID']));
        $dataToBeDisplayed['fileList'] = $fileList;
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/file/view_file_list', $dataToBeDisplayed);
    }

    public function download_file($fileId) {
        $fileData = $this->File_model->GetUploadFileInformation(array('ID' => $fileId));
        if(count($fileData) == 0) {
            show_404();
            return;
        }

        $this->load->helper('download');
        $url = $fileData[0]['FILE_PATH'];
        if($url == "") {
            show_404();
            return;
        }
        force_download($url, NULL);
    }

    public function remove_file($fileId) {
        $this->File_model->RemoveFile($fileId);
        redirect(base_url()."file/view");
    }
}