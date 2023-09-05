<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 4:30 AM
 */
class Account_model extends MY_Model
{
    public function InsertNewAccount($array)
    {
        if($array['ACCOUNT_TYPE'] == ACCOUNT_TYPE_EWALLET)
        {
            $array['ACCOUNT_NUMBER'] = 'W - '.$array['ACCOUNT_NUMBER'];
        }
        else if($array['ACCOUNT_TYPE'] == ACCOUNT_TYPE_CARD)
        {
            $array['ACCOUNT_NUMBER'] = 'C - '.$array['ACCOUNT_NUMBER'];
        }
        else if($array['ACCOUNT_TYPE'] == ACCOUNT_TYPE_VIBAN)
        {
            $array['ACCOUNT_NUMBER'] = 'I - '.$array['ACCOUNT_NUMBER'];
        }
        if($this->db->insert(self::TABLE_ACCOUNT_INFO, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function GetTotalBalanceByArray($where = array()){
        return $this->db->select('SUM(CURRENT_AMOUNT) as TOTAL_BALANCE')->from(self::TABLE_ACCOUNT_INFO)->where($where)->get()->result_array();
    }

    public function GetTotalAvailableByArray($where = array()){
        return $this->db->select('SUM(AVAILABLE_AMOUNT) as TOTAL_BALANCE')->from(self::TABLE_ACCOUNT_INFO)->where($where)->get()->result_array();
    }

    public function FindAccountByArray($array = array())
    {

        return $this->db->select('a.ID,  a.ACCOUNT_NUMBER, b.NAME, b.PROFILE_ID, b.FULL_NAME as USER_FULLNAME, b.VERIFY_STATUS, b.CREATED_AT as USER_CREATED_AT, a.CREATED_AT, a.CURRENT_AMOUNT, a.ACCOUNT_TYPE, 
                                    e.ACCOUNT_TYPE as FEE_TYPE, a.STATUS, e.CURRENCY_CONVERSION_RATE, e.IWT_AMOUNT, e.IWT_TYPE, e.ID as FEE_TYPE_INDEX,
                                   , a.AVAILABLE_AMOUNT, a.ALLOW_WITHDRAW, a.ALLOW_DEPOSIT, a.PAYMENT_OPTIONS, c.DESCRIPTION as ACCOUNT_TYPE_DESC, d.TITLE as CURRENCY_TITLE, 
                                    a.CURRENCY_TYPE, a.USER_ID, f.DESCRIPTION as STATUS_DESCRIPTION, e.MIN_TRANS_FEE, e.MAX_TRANS_FEE')
                                    ->from(self::TABLE_ACCOUNT_INFO.' a')
                                    ->join(self::TABLE_USER_INFO.' b', 'b.ID = a.USER_ID')
                                    ->join(self::TABLE_ACCOUNT_FEE_INFO.' e','e.ID = a.FEE_TYPE')
                                    ->join(self::TABLE_ACCOUNT_TYPE.' c', 'c.ID = a.ACCOUNT_TYPE')
                                    ->join(self::TABLE_CURRENCY_KIND.' d', 'd.ID = a.CURRENCY_TYPE')
                                    ->join(self::TABLE_USER_STATUS_KIND. ' f', 'f.ID = a.STATUS')
                                    ->where($array)
                                    ->get()
                                    ->result_array();
    }

    public function updateAccount($setArray, $whereArray) {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_ACCOUNT_INFO, $setArray);
    }

    public function GetCurrencyKind(){
        return $this->db->select('a.ID,  a.ACCOUNT_NUMBER, a.CREATED_AT, a.CURRENT_AMOUNT, a.ACCOUNT_TYPE, 
                                     a.STATUS, a.AVAILABLE_AMOUNT, a.ALLOW_WITHDRAW, a.ALLOW_DEPOSIT, a.PAYMENT_OPTIONS, d.TITLE as CURRENCY_TITLE, 
                                    a.CURRENCY_TYPE, a.USER_ID')
            ->from(self::TABLE_ACCOUNT_INFO.' a')
            ->join(self::TABLE_CURRENCY_KIND.' d', 'd.ID = a.CURRENCY_TYPE')
            ->group_by('CURRENCY_TYPE')
            ->get()
            ->result_array();
    }

    public function GetRecentAccountActivity($array = array())
    {
        return $this->db->select('a.ID,  a.ACCOUNT_NUMBER, b.NAME, b.FULL_NAME as USER_FULLNAME, b.CREATED_AT as USER_CREATED_AT, a.CREATED_AT, a.CURRENT_AMOUNT, a.ACCOUNT_TYPE, 
                                    e.ACCOUNT_TYPE as FEE_TYPE, a.STATUS, 
                                   , a.AVAILABLE_AMOUNT, a.CURRENT_AMOUNT, a.ALLOW_WITHDRAW, a.ALLOW_DEPOSIT, a.PAYMENT_OPTIONS, c.DESCRIPTION as ACCOUNT_TYPE_DESC, d.TITLE as CURRENCY_TITLE, 
                                    a.CURRENCY_TYPE, a.USER_ID, f.DESCRIPTION as STATUS_DESCRIPTION')
            ->from(self::TABLE_ACCOUNT_INFO.' a')
            ->join(self::TABLE_USER_INFO.' b', 'b.ID = a.USER_ID')
            ->join(self::TABLE_ACCOUNT_FEE_INFO.' e','e.ID = a.FEE_TYPE')
            ->join(self::TABLE_ACCOUNT_TYPE.' c', 'c.ID = a.ACCOUNT_TYPE')
            ->join(self::TABLE_CURRENCY_KIND.' d', 'a.CURRENCY_TYPE = d.ID')
            ->join(self::TABLE_USER_STATUS_KIND. ' f', 'f.ID = a.STATUS')
            ->where($array)
            ->limit(5)
            ->get()
            ->result_array();
    }

    public function GetAccountRecordByArray($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_ACCOUNT_INFO)->where($where)->limit(1, 0)->get()->row();
    }

    public function GetAccountArrayByArray($where = array())
    {
        return $this->db->select('*')->from(self::TABLE_ACCOUNT_INFO)->where($where)->get()->result_array();
    }

    public function GetCurrencyGroupByAccount($userId)
    {
        return $this->db->select('account_info.CURRENCY_TYPE, currency.TITLE')
            ->from(self::TABLE_ACCOUNT_INFO)
            ->join(self::TABLE_ACCOUNT_FEE_INFO.' accountfee', 'accountfee.ID = account_info.FEE_TYPE' )
            ->join(self::TABLE_CURRENCY_KIND.' currency', 'currency.ID = account_info.CURRENCY_TYPE')
            ->where(array('account_info.USER_ID' => $userId))
            ->group_by("CURRENCY_TYPE")
            ->get()
            ->result_array();
    }

    public function GetAnalysisDataByAccount($userId, $currencyType)
    {
        $accountInfoList = $this->FindAccountByArray(array('a.USER_ID' => $userId, 'a.CURRENCY_TYPE' => $currencyType));
        $totalCurrentAmount = 0;
        $totalAvailableAmount = 0;
        $totalFutureAmount = 0;

        foreach ($accountInfoList as $item)
        {
            $totalCurrentAmount += $item['CURRENT_AMOUNT'];
            $totalAvailableAmount += $item['AVAILABLE_AMOUNT'];
            $pendingPayList = $this->db->select('*')->from(self::TABLE_HISTORY_TRANSACTION)
                ->where(array('TO_ACCOUNT' => $item['ID'], 'STATUS <' => TRANSFER_APPROVED))
                ->get()
                ->result_array();
            foreach ($pendingPayList as $pendingItem)
            {
                $totalFutureAmount += $pendingItem['AMOUNT'] * $pendingItem['CURRENCY_CALCED_RATE'];
            }
        }
        $totalPendingAmount = $totalCurrentAmount - $totalAvailableAmount + $totalFutureAmount;
        $totalFutureAmount += $totalCurrentAmount;
        $retArray = array('TOTAL_CURRENT_BALANCE' => $totalAvailableAmount, 'TOTAL_PENDING_AMOUNT' => $totalPendingAmount, 'FUTURE_AMOUNT' => $totalFutureAmount);
        return $retArray;
    }

    public function UpdateCurrentBalance($isAdd, $accountId, $amount)
    {
        $userObject = $this->db->select('CURRENT_AMOUNT')->from(self::TABLE_ACCOUNT_INFO)->where('ID', $accountId)->get()->row();

        if($isAdd == true)
        {
            $this->db->set('CURRENT_AMOUNT', $userObject->CURRENT_AMOUNT + $amount, FALSE);
            $this->db->set('UPDATED_AT', now());
        }
        else
        {
            $this->db->set('CURRENT_AMOUNT', $userObject->CURRENT_AMOUNT - $amount, FALSE);
            $this->db->set('UPDATED_AT', now());
        }

        $this->db->where('ID', $accountId);
        $this->db->update(self::TABLE_ACCOUNT_INFO);
    }

    public function UpdateAvailableBalance($isAdd, $accountId, $amount)
    {
        $userObject = $this->db->select('AVAILABLE_AMOUNT')->from(self::TABLE_ACCOUNT_INFO)->where('ID', $accountId)->get()->row();

        if($isAdd == true)
        {
            $this->db->set('AVAILABLE_AMOUNT', $userObject->AVAILABLE_AMOUNT + $amount, FALSE);
        }
        else
        {
            $this->db->set('AVAILABLE_AMOUNT', $userObject->AVAILABLE_AMOUNT - $amount, FALSE);
        }

        $this->db->where('ID', $accountId);
        $this->db->update(self::TABLE_ACCOUNT_INFO);
    }

    public function GetAccountTypeListByArray($array = array())
    {
        return $this->db->select('accountfee.ID, accountfee.ACCOUNT_TYPE, currency.TITLE')
                        ->from(self::TABLE_ACCOUNT_INFO.' accountfee')
                        ->join(self::TABLE_CURRENCY_KIND.' currency', 'currency.ID = accountfee.CURRENCY_TYPE')
                        ->where($array)
                        ->get()
                        ->result_array();
    }
}