<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/29/17
 * Time: 11:29 AM
 */
class AdminFileController extends CI_Controller
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

    public function new_upload($param) {
        //if($param == "new") insert tarnsaction id with transId
        $dataToBeDisplayed = $this->makeComponentViews(MENU_FILE_MANAGE);
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
        $this->form_validation->set_rules('accountOwner', 'User' , 'required');
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
                $userRecord = $this->User_model->FindUserByArray(array('ID' => $userId));
                if(count($userRecord) == 0) {
                    show_404();
                    return;
                }

                $transactionHistoryItem = $this->TransferHistory_model->GetTransactionsArrayList(array('ID' => $transId));
                if(count($transactionHistoryItem) == 0){
                    show_404();
                    return;
                }

                $insertedId = $this->File_model->InsertNewFile(array( 'USER_NAME' => $userRecord[0]['NAME'],
                                                        'USER_FULL_NAME' => $userRecord[0]['FULL_NAME'],
                                                        'USER_ID' => $userId,
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
        $this->load->view('admin/pages/file/new_upload', $dataToBeDisplayed);
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
        $dataToBeDisplayed = $this->makeComponentViews(MENU_FILE_MANAGE);
        $fileList = $this->File_model->GetUploadFileInformation();
        $dataToBeDisplayed['fileList'] = $fileList;
        $this->load->view('admin/pages/file/view_file_list', $dataToBeDisplayed);
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
        redirect(base_url()."admin/file/view");
    }
}