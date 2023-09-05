<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class ProfileInfo_model extends MY_Model
{
    public function InsertProfileInformation($arrayInformation)
    {
        if($this->db->insert(self::TABLE_PROFILE_INFO, $arrayInformation))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function GetProfileInfoByArray($whereArray = array()){
        return $this->db->select('*')->from(self::TABLE_PROFILE_INFO)->where($whereArray)->get()->result_array();
    }

    public function UpdateProfileInformation($updateArray = array(), $whereArray = array())
    {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_PROFILE_INFO, $updateArray);
    }

    public function GetProfileInformation($whereArray = array())
    {
        return $this->db->select('b.ID,  b.PROFILE_KIND, b.COMPANY_NAME,  a.ID as USER_ID, b.ID_CARD, a.VERIFY_STATUS, a.FULL_NAME, a.STATUS, a.EMAIL, b.PROFILE_KIND, b.FIRST_NAME, b.LAST_NAME, b.USER_NAME, b.DOB, b.PASSPORT_NUMBER, 
        b.COUNTRY_INDEX, b.CITY_INDEX, b.PHONE, b.OFFICE_PHONE, b.HOME_PHONE, b.FAX, b.BENEFICAL_FULL_NAME, b.BENIFICAL_DOB, b.BENIFICAL_RELATION, b.BENIFICAL_ADDR, b.BENIFICAL_PHONE,
        b.MAILING_ADDR, b.MAILING_ADDR2, b.MAILING_CITY, b.MAILING_STATE, b.MAILING_ZIP, b.MAILING_COUNTRY, b.MAILING_PHONE, b.PHYSICAL_ADDR, b.PHYSICAL_ADDR2, b.PHYSICAL_CITY, b.PHYSICAL_STATE,
        b.PHYSICAL_ZIP, b.PHYSICAL_COUNTRY, b.PHYSICAL_PHONE, b.INTERNAL_MESSAGE, b.UPDATED_AT, b.CREATED_AT')
                        ->from(self::TABLE_USER_INFO.' a')
                        ->join(self::TABLE_PROFILE_INFO.' b', 'b.ID = a.PROFILE_ID')
                        ->where($whereArray)
                        ->get()
                        ->result_array();
    }

    public function GetUserDetailInformation($whereArray = array())
    {
        return $this->db->select('a.ID, a.PROFILE_KIND, a.COMPANY_NAME, b.VERIFY_STATUS,  b.ID as USER_ID, b.NAME, b.EMAIL, a.FIRST_NAME, a.LAST_NAME, a.DOB, b.FULL_NAME, 
        a.CREATED_AT, b.STATUS, c.DESCRIPTION as STATUS_DESCRIPTION, d.DESCRIPTION as PROFILE_DESC, a.ID_CARD')
            ->from(self::TABLE_PROFILE_INFO.' a')
            ->join(self::TABLE_USER_INFO.' b', 'b.PROFILE_ID = a.ID','left')
            ->join(self::TABLE_USER_STATUS_KIND.' c', 'b.STATUS = c.ID')
            ->join(self::TABLE_PROFILE_KIND.' d', 'd.ID = a.PROFILE_KIND')
            ->where($whereArray)
            ->get()
            ->result_array();
    }
}