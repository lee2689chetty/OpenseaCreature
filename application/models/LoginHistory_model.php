<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 3/20/18
 * Time: 2:13 AM
 */
class LoginHistory_model extends MY_Model
{
    public function InsertNewHistory($array)
    {
        if($this->db->insert(self::TABLE_LOGIN_HISTORY, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function GetLoginHistory($where = array())
    {
        return $this->db->select('*')
                        ->from(self::TABLE_LOGIN_HISTORY)
                        ->where($where)
                        ->get()
                        ->result_array();
    }
}