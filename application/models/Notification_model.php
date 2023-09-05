<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class Notification_model extends MY_Model
{
    public function InsertNewNotification($array) {
        if($this->db->insert(self::TABLE_NOTIFY_HISTORY, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function getClientTopBarData($userId) {
        return $this->db->select('*')->from(self::TABLE_NOTIFY_HISTORY)
            ->where(array('USER_ID' => $userId, 'USER_CHECK' => 0))
            ->order_by('CREATED_AT', 'DESC')
            ->get()
            ->result_array();
    }

    public function getDashBoardData($where = array()) {

    }

    public function UpdateReadStatus($whereArray)
    {
        $setArray = array('USER_CHECK' => '1', 'UPDATED_AT' => time());
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_NOTIFY_HISTORY, $setArray);
    }
}