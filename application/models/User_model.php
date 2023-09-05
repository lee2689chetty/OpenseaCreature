<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class User_model extends MY_Model
{
    public function InsertUserInformation($arrayInformation)
    {
        if($this->db->insert(self::TABLE_USER_INFO, $arrayInformation))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }


    public function FindUserByArray($array = array(), $or_array = array())
    {
        return $this->db->select('*')->from(self::TABLE_USER_INFO)
                                    ->where($array)
                                    ->get()
                                    ->result_array();
    }

    public function GetUserRecordByArray($array = array())
    {
        return $this->db->select('*')->from(self::TABLE_USER_INFO)
            ->where($array)
            ->get()
            ->row();
    }

    public function UpdateUserObject($setArray, $whereArray)
    {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_USER_INFO, $setArray);
    }

    public function UpdateUserLoginAttempt($id)
    {
        $this->db->set('LOGIN_ATTEMPT', 'LOGIN_ATTEMPT+1', FALSE);
        $this->db->where('ID', $id);
        $this->db->update(self::TABLE_USER_INFO);
    }


}