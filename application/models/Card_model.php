<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class Card_model extends MY_Model
{
    public function InsertCardRecord($insertArray)
    {
        if($this->db->insert(self::TABLE_CARD_INFO, $insertArray))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function FindCardListByArray($array = array())
    {
        return $this->db->select('a.ACCOUNT_ID, a.CARD_NUMBER, a.CARD_HOLDER_NAME, a.CARD_EXP_YEAR, a.CARD_EXP_MONTH')->from(self::TABLE_CARD_INFO.' a')
            ->join(self::TABLE_USER_INFO. ' b', 'b.ID = a.USER_ID')
            ->where($array)
            ->get()
            ->result_array();
    }

    public function GetUserCardDetailInformation($array = array())
    {
        return $this->db->select('a.USER_ID, a.ACCOUNT_ID, a.CARD_NUMBER, a.CARD_EXP_YEAR, a.CARD_EXP_MONTH, 
        a.CARD_HOLDER_NAME, a.CARD_CVC, a.UPDATED_AT, a.CREATED_AT, b.CURRENT_AMOUNT, b.AVAILABLE_AMOUNT, c.TITLE as CURRENCY_TITLE, e.NAME, e.FULL_NAME, d.ACCOUNT_TYPE, f.DESCRIPTION')
            ->from(self::TABLE_CARD_INFO.' a')
            ->join(self::TABLE_ACCOUNT_INFO.' b', 'b.ID = a.ACCOUNT_ID')
            ->join(self::TABLE_USER_INFO.' e', 'e.ID = a.USER_ID')
            ->join(self::TABLE_ACCOUNT_FEE_INFO.' d', 'd.ID = b.FEE_TYPE')
            ->join(self::TABLE_CURRENCY_KIND.' c', 'c.ID = b.CURRENCY_TYPE')
            ->join(self::TABLE_USER_STATUS_KIND.' f', 'f.ID = b.STATUS')
            ->where($array)
            ->get()
            ->result_array();
    }
}