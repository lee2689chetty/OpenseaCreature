<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 3/13/18
 * Time: 3:16 PM
 */
class MessageController extends CI_Controller
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
        $this->Notification_model->UpdateReadStatus(array('USER_ID' => $this->session->userdata['me']['ID'], 'REASON_TYPE' => NOTIFY_NEW_MESSAGE_RECEIVED));
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
        $dataToBeDisplayed = $this->makeComponentViews(5);
        $myId = $this->session->userdata['me']['ID'];
        $contactArrayList = $this->Message_model->GetContactList($myId);
        $dispThreadArrayList = array();
        foreach ($contactArrayList as $contactItem)
        {
            $dispThreadItem = array();
            $dispThreadItem['thread_id'] = $contactItem['ID'];
            $dispThreadItem['thread_title'] = $contactItem['SUBJECT'];
            $partnerId = $contactItem['USER_ID_1'] == $myId ? $contactItem['USER_ID_2'] : $contactItem['USER_ID_1'];
            $partnerArray = $this->User_model->FindUserByArray(array('ID' => $partnerId));
            $dispThreadItem['partner_name'] = $partnerArray[0]['FULL_NAME'];
            $dispThreadItem['partner_id'] = $partnerId;
            $messageUnreadArray = $this->Message_model->GetUnreadMessageInThread($contactItem['ID'], $myId);
            $dispThreadItem['unread_count'] = count($messageUnreadArray);
            $lastMsg = $this->Message_model->GetLastMessageDescriptionInThread($contactItem['ID']);
            $dispThreadItem['last_desc'] = $lastMsg->MSG_CONTENT;
            array_push($dispThreadArrayList, $dispThreadItem);
        }
        $dataToBeDisplayed['contacts'] = $dispThreadArrayList;
        $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
        $this->load->view('client/pages/message/view', $dataToBeDisplayed);
    }

    public function new_message()
    {
        $dataToBeDisplayed = $this->makeComponentViews(5);
        $dataToBeDisplayed['users'] = $this->User_model->FindUserByArray(array('ID !=' => $this->session->userdata['me']['ID'], 'STATUS' => USER_STATUS_ACTIVE, 'LEVEL<' => '4'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('toUser', ' Send To ', 'required');
        $this->form_validation->set_rules('msgContent', ' Message Content ', 'required');
        $this->form_validation->set_rules('subject', ' Subject ', 'required');

        if ($this->form_validation->run() == TRUE) {
            $toUser = $this->input->post('toUser');
            $content = $this->input->post('msgContent');
            $subject = $this->input->post('subject');

            if(intval($toUser) == 0)
            {
                $dataToBeDisplayed['error'] = true;
                $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
                $this->load->view('client/pages/message/new_message', $dataToBeDisplayed);
            }
            else {
                //create new contact & thread & subject
                $now = now();
                $insertNewThread = array('USER_ID_1' => $this->session->userdata['me']['ID'], 'USER_ID_2' => $toUser, 'SUBJECT' => $subject, 'CREATED_AT' => $now, 'UPDATED_AT' => $now);
                $insertedThreadId = $this->Message_model->InsertNewThread($insertNewThread);

                //insert new chat history with thread id
                $insertNewHistory = array('THREAD_ID' => $insertedThreadId, 'SENDER_ID' => $this->session->userdata['me']['ID'], 'RECEIVER_ID' => $toUser, 'MSG_CONTENT' => $content,
                    'READ_STATUS' => 0, 'UPDATED_AT' => $now, 'CREATED_AT' => $now);
                $this->Message_model->InsertNewHistory($insertNewHistory);
                $partnerUser = $this->User_model->FindUserByArray(array('ID' => $toUser));

//                $this->Notification_model->InsertNewNotification(array('USER_ID' => $toUser,
//                    'REASON_TYPE' => NOTIFY_NEW_MESSAGE_RECEIVED,
//                    'LINK_ID' => $insertedThreadId,
//                    'CONTENT' => '',
//                    'USER_CHECK' => 0,
//                    'UPDATED_AT' => time(),
//                    'CREATED_AT' => time()));

//                if($partnerUser[0]['NOTIFY_INTERNAL_MESSAGE'] == 1)
//                {
                $this->SendNewMessageNotificationEmail($partnerUser[0]['EMAIL'], $this->session->userdata['me']['FULL_NAME'], $partnerUser[0]['FULL_NAME']);
//                }
                redirect(base_url() . 'message/view');
            }
        }
        else
        {
            $dataToBeDisplayed['error'] = false;
            $dataToBeDisplayed = $this->makeTopBarComponentViews($dataToBeDisplayed);
            $this->load->view('client/pages/message/new_message', $dataToBeDisplayed);
        }
    }

    public function getHistory()
    {
        $threadId = $this->input->post('threadId');
        //set as read
        $this->Message_model->UpdateAllMessageDetail(array('THREAD_ID' => $threadId, 'READ_STATUS' => '0', 'RECEIVER_ID' => $this->session->userdata['me']['ID']));

        $msgHistoryArray = $this->Message_model->FindMessageDetailInfo(array('THREAD_ID' => $threadId));
        $contactUserArray = $this->Message_model->GetMessageThread($threadId);
        $partnerId = $contactUserArray[0]['USER_ID_1'] == $this->session->userdata['me']['ID'] ? $contactUserArray[0]['USER_ID_2'] : $contactUserArray[0]['USER_ID_1'];
        $partnerArray = $this->User_model->FindUserByArray(array('ID' => $partnerId));
        $partnerName = $partnerArray[0]['FULL_NAME'];
        $retVal = array();
        foreach ($msgHistoryArray as $historyItem) {
            if($historyItem['SENDER_ID'] == $this->session->userdata['me']['ID'])
            {
                //out
                $item = "<li class=\"out\">
                                        <img class=\"avatar\" alt=\"\" src=\"".base_url() . "assets/layouts/img/avatar.png"."\"/>
                                        <div class=\"message\">
                                            <span class=\"arrow\"> </span>
                                            <a href=\"javascript:;\" class=\"name\"> You </a>
                                            <span class=\"datetime\"> at ".date('Y-m-d H:m:s', $historyItem['CREATED_AT'])." </span>
                                            <span class=\"body\">".$historyItem['MSG_CONTENT']."</span>
                                        </div>
                                    </li>";
            }
            else
            {
                //in
                $item = "<li class=\"in\">
                                        <img class=\"avatar\" alt=\"\" src=\"".base_url()."assets/layouts/img/placeholder.png\" />
                                        <div class=\"message\">
                                            <span class=\"arrow\"> </span>
                                            <a href=\"javascript:;\" class=\"name\"> ".$partnerName." </a>
                                            <span class=\"datetime\"> at ".date('Y-m-d H:m:s', $historyItem['CREATED_AT'])."</span>
                                            <span class=\"body\"> ".$historyItem['MSG_CONTENT']."</span>
                                        </div>
                                    </li>";
            }
            array_push($retVal, $item);
        }
        echo (json_encode($retVal));
    }

    public function appendMessage()
    {
        $threadId = $this->input->post('threadId');
        $msgContent = $this->input->post('msgContent');
        $ThreadInfo = $this->Message_model->GetMessageThread($threadId);
        if(!isset($ThreadInfo) || count($ThreadInfo) == 0)
        {
            echo "";
            return;
        }
        $partnerId = $ThreadInfo[0]['USER_ID_1'] == $this->session->userdata['me']['ID'] ? $ThreadInfo[0]['USER_ID_2'] : $ThreadInfo[0]['USER_ID_1'];
        //set as read
        $now = now();
        $insertedResult = $this->Message_model->InsertNewHistory(
            array('THREAD_ID' => $threadId, 'SENDER_ID'=>$this->session->userdata['me']['ID'],
                'RECEIVER_ID' => $partnerId, 'MSG_CONTENT' => $msgContent,
            'READ_STATUS' =>0, 'UPDATED_AT' => $now, 'CREATED_AT' => $now));


        $insertedMessageHistoryItem = $this->Message_model->FindMessageDetailInfo(array('ID' => $insertedResult));
                //out
        $item = "<li class=\"out\">
                                <img class=\"avatar\" alt=\"\" src=\"".base_url() . "assets/layouts/img/avatar.png"."\"/>
                                <div class=\"message\">
                                    <span class=\"arrow\"> </span>
                                    <a href=\"javascript:;\" class=\"name\"> You </a>
                                    <span class=\"datetime\"> at ".date('Y-m-d H:m:s', $insertedMessageHistoryItem[0]['UPDATED_AT'])." </span>
                                    <span class=\"body\">".$insertedMessageHistoryItem[0]['MSG_CONTENT']."</span>
                                </div>
                            </li>";

        $partnerUser = $this->User_model->FindUserByArray(array('ID' => $partnerId));

        $this->Notification_model->InsertNewNotification(array( 'USER_ID' => $partnerId,
            'REASON_TYPE' => NOTIFY_NEW_MESSAGE_RECEIVED,
            'LINK_ID' => $threadId ,
            'CONTENT' => '',
            'USER_CHECK' => 0,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->SendNewMessageNotificationEmail($partnerUser[0]['EMAIL'], $this->session->userdata['me']['FULL_NAME'], $partnerUser[0]['FULL_NAME']);

        $retVal['result'] = $item;
        echo (json_encode($retVal));
    }

    private function SendNewMessageNotificationEmail($targetEmail, $fromUserName, $toUserName)
    {
        $this->email->initialize($this->config->item('EMAIL'));
        $this->email->from($this->config->item('EMAIL_DISP'), $this->config->item('EMAIL_DISP'));
        $this->email->to($targetEmail);
        $this->email->subject('Valor Pay Support team');
        $content = "Hi, <strong> ".$toUserName."</strong> <br> ".$fromUserName." sent you new message.";
        $this->email->message($content);
        $this->email->send();
    }
}