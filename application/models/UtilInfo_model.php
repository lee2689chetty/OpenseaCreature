<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class UtilInfo_model extends MY_Model
{
    public function GetBasisUtilInfoList($tableName, $where=array())
    {
        return $this->db->select('*')->from($tableName)
            ->where($where)
            ->order_by('ID', 'ASC')
            ->get()
            ->result_array();
    }

    public function InsertUtilInformation($tableName, $arrayInformation)
    {
        if($this->db->insert($tableName, $arrayInformation))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function UpdateUtilInformation($tableName, $arrayInformation = array(), $whereInformation = array())
    {
        $this->db->where($whereInformation);
        $this->db->update($tableName, $arrayInformation);
    }

    public function DeleteUtilInformation($tableName, $arrayInformation = array())
    {
        $this->db->delete($tableName, $arrayInformation);
    }
    public function GetCountryList($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_COUNTRY_INFO)
                                    ->where($where)
                                    ->get()
                                    ->result_array();
    }

    public function GetCityList($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_CITY_INFO)
            ->where($where)
            ->get()
            ->result_array();
    }


    public function GetCurrencyList($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_CURRENCY_KIND)
            ->where($where)
            ->get()
            ->result_array();
    }


//    public function GetFeeList($array)
//    {
//        return $this->db->select('*')->from(self::TABLE_FEE_KIND)
//            ->where($array)
//            ->get()
//            ->result_array();
//    }

    public function GetTransferKind($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_TRANSFER_KIND)
            ->where($where)
            ->get()
            ->result_array();
    }

    public function GetProfileType($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_PROFILE_KIND)
            ->where($where)
            ->get()
            ->result_array();
    }


    public function GetFeeProfileInformation($where = array())
    {
        return $this->db->select('a.ID, a.ACCOUNT_TYPE, a.IWT_AMOUNT, a.IWT_TYPE, a.OWT_AMOUNT, a.OWT_TYPE, 
        a.CFT_AMOUNT, a.CFT_TYPE, a.CURRENCY_CONVERSION_RATE, a.CREATED_AT')
            ->from(self::TABLE_ACCOUNT_FEE_INFO.' a')
//            ->join(self::TABLE_CURRENCY_KIND.' b', 'b.ID = a.CURRENCY_TYPE')
            ->where($where)
            ->get()
            ->result_array();
    }

}