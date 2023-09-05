<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class RevenueInfo_model extends MY_Model
{
    public function InsertRevenueInfo($arrayInformation)
    {
        if($this->db->insert(self::TABLE_REVENUE_INFO, $arrayInformation))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function GetRevenueAccount($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_REVENUE_INFO)->where($where)->get()->result_array();
    }

    public function GetCurrencyForNewAccount()
    {
        $wholeCurrency = $this->db->select('*')->from(self::TABLE_CURRENCY_KIND)->get()->result_array();
        $usedCurrency = $this->db->select('*')->from(self::TABLE_REVENUE_INFO)->get()->result_array();
        $retVal = array();
        foreach ($wholeCurrency as $currencyItem)
        {
            $new = FALSE;
            foreach ($usedCurrency as $usedItem)
            {
                if($usedItem['CURRENCY_TYPE'] == $currencyItem['ID'])
                {
                    $new = TRUE;
                    break;
                }
            }
            if($new == FALSE)
            {
                array_push($retVal, $currencyItem);
            }
        }
        return $retVal;
    }

    public function UpdateRevenueBalance($id, $amount = 0, $isCredit = false)
    {
        $userObject = $this->db->select('AVAILABLE_AMOUNT, CURRENT_AMOUNT')->from(self::TABLE_REVENUE_INFO)->where('ID', $id)->get()->row();
        if($isCredit == true)
        {
            $this->db->set('AVAILABLE_AMOUNT', $userObject ->AVAILABLE_AMOUNT+$amount, FALSE);
            $this->db->set('CURRENT_AMOUNT', $userObject -> CURRENT_AMOUNT + $amount, FALSE);
            $this->db->set('UPDATED_AT', now());
        }
        else
        {
            $this->db->set('AVAILABLE_AMOUNT', $userObject ->AVAILABLE_AMOUNT - $amount, FALSE);
            $this->db->set('CURRENT_AMOUNT', $userObject -> CURRENT_AMOUNT - $amount, FALSE);
            $this->db->set('UPDATED_AT', now());
        }
        $this->db->where('ID', $id);
        $this->db->update(self::TABLE_REVENUE_INFO);
    }
}