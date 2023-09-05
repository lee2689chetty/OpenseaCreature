<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class Message_model extends MY_Model
{
    public function InsertNewThread($array)
    {
        if($this->db->insert(self::TABLE_MESSAGE_THREAD, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function InsertNewHistory($array)
    {
        if($this->db->insert(self::TABLE_MESSAGE_DETAIL, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function GetMessageThread($threadId)
    {
        return $this->db->select('*')->from(self::TABLE_MESSAGE_THREAD)->where('ID', $threadId)->get()->result_array();
    }

    public function CountOfNewMessage($userId)
    {
        return $this->db->select('COUNT(*) as TOTAL')
            ->from(self::TABLE_MESSAGE_DETAIL.' a')
            ->join(self::TABLE_MESSAGE_THREAD.' b', 'b.ID = a.THREAD_ID')
            ->where(array('a.READ_STATUS' => '0', 'a.RECEIVER_ID'=>$userId))
            ->get()
            ->result_array();
    }

    public function FindMessageDetailInfo($array = array())
    {
        return $this->db->select('*')
                        ->from(self::TABLE_MESSAGE_DETAIL)
                        ->where($array)
                        ->get()
                        ->result_array();
    }

    public function GetContactList($userId)
    {
        return $this->db->select('*')
            ->from(self::TABLE_MESSAGE_THREAD)
            ->where('USER_ID_1', $userId)
            ->or_where('USER_ID_2', $userId)
            ->get()
            ->result_array();
    }

    public function GetUnreadMessageInThread($threadId, $receiverId)
    {
        return $this->db->select('*')
            ->from(self::TABLE_MESSAGE_DETAIL)
            ->where(array('THREAD_ID' => $threadId, 'RECEIVER_ID' => $receiverId, 'READ_STATUS' => '0'))
            ->get()
            ->result_array();
    }

    public function GetLastMessageDescriptionInThread($threadId)
    {
        return $this->db->select('*')->from(self::TABLE_MESSAGE_DETAIL)->where(array('THREAD_ID' => $threadId))->order_by('ID', 'desc')->limit(1, 0)->get()->row();
    }

    public function UpdateAllMessageDetail($array = array())
    {
        $this->db->set('READ_STATUS', '1', FALSE);
        $this->db->set('UPDATED_AT', now(), FALSE);
        $this->db->where($array);
        $this->db->update(self::TABLE_MESSAGE_DETAIL);
    }

    public function GetMessageHistoryForAdminDashBoard()
    {
        return $this->db->select('*')
                ->from(self::TABLE_MESSAGE_DETAIL)
                ->order_by('ID', 'desc')
                ->limit(5)
                ->get()
                ->result_array();
    }

    public function GetMessageHistoryForDashBoard($userId)
    {
        return $this->db->select('*')
            ->from(self::TABLE_MESSAGE_DETAIL)
            ->where('SENDER_ID', $userId)
            ->or_where('RECEIVER_ID', $userId)
            ->order_by('ID', 'desc')
            ->limit(5)
            ->get()
            ->result_array();
    }
}