<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 3/20/18
 * Time: 2:13 AM
 */
class Kyc_model extends MY_Model
{
    public function InsertNewHistory($array) {
        if($this->db->insert(self::TABLE_KYC_PROGRESS, $array))  {
            return $this->db->insert_id();
        }
        else {
            return -1;
        }
    }

    public function GetVerificationInformation($where = array()) {
        return $this->db->select('*')
                        ->from(self::TABLE_KYC_PROGRESS)
                        ->where($where)
                        ->get()
                        ->result_array();
    }

    public function UpdateKycObject($setArray, $whereArray) {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_KYC_PROGRESS, $setArray);
    }
}