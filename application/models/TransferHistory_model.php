<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 7:20 PM
 */
class TransferHistory_model extends MY_Model
{
    public function InsertTransferHistory($insertArray)
    {
        if($this->db->insert(self::TABLE_HISTORY_TRANSACTION, $insertArray))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function getWarningTransItems() {
        $sql = "SELECT * FROM (SELECT *, COUNT(*) AS counter FROM `history_transaction` WHERE CREATED_AT > ".(strtotime('today') - 2592000)." AND IS_MANUAL_TRANS = '0' AND IS_AML_PASSED = '0' GROUP BY `TO_USER_ID`,`AMOUNT`) as sub_table WHERE counter > 5";
        return $this->db->query($sql)->result_array();
    }

    public function getLast30Records($toUserId, $amount) {
        //today 00:00:00
        $timestamp = strtotime('today');
        $timestamp = $timestamp - 2592000;
        return $this->db->select('*')
            ->from($this::TABLE_HISTORY_TRANSACTION)
            ->where(array('TO_USER_ID' => $toUserId, 'AMOUNT' => $amount, 'CREATED_AT>' => $timestamp))
            ->order_by('ID', 'ASC')
//            ->limit(5)
            ->get()
            ->result_array();
    }
//    public function GetTransferHistoryForRevenueReport($transType = 0, $fromStartDate = 0, $toStartDate=0, $currencyType = 0){
//        $query = "SELECT * FROM `history_transaction` WHERE 1=1 ";
//        switch($transType){
//            case 0:
//                //all
//                //do nothing
//                break;
//            case 1:
//                //system
//                $query .= " AND `TRANSACTION_TYPE` < ".Account_Debit_Transfer;
//                break;
//            case 2:
//                //manual
//                $query .= " AND (`TRANSACTION_TYPE` = ".Account_Debit_Transfer." OR `TRANSACTION_TYPE` = ".Account_Credit_Transfer;
//                break;
//        }
//
//        return $this->db->query($query)->result_array();
//    }

    public function GetTotalInComeAmount($accountIdList){
        $retVal = 0;
        foreach($accountIdList as $accountItem) {
            $historyArray = $this->db->select('*')->from(MY_Model::TABLE_HISTORY_TRANSACTION)->where(array('TO_ACCOUNT' => $accountItem['ID'], 'STATUS' < TRANSFER_APPROVED))->get()->result_array();
            foreach ($historyArray as $item) {
                $retVal += $item['AMOUNT'] * $item['CURRENCY_CALCED_RATE'];
            }
        }
        return $retVal;
    }

    public function transferOutgoingWire($insertArray)
    {
        if($this->db->insert(self::TABLE_OUTGOING_WIRE, $insertArray))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function GetOutgingHistory($whereArray)
    {
        return $this->db->select('*')->from(self::TABLE_OUTGOING_WIRE)
            ->where($whereArray)
            ->get()
            ->result_array();
    }

    public function GetTransferHistory($accountId)
    {
        $this->db->select('*');
        $this->db->where('FROM_ACCOUNT', $accountId);
        $this->db->or_where('TO_ACCOUNT', $accountId);
        $this->db->from(self::TABLE_HISTORY_TRANSACTION);
        return $this->db->get()->result_array();
    }

    public function GetManualTransferHistoryByDate($fromDate, $toDate){
        $query = "SELECT * FROM `history_transaction` WHERE (`IS_MANUAL_TRANS` = 1) AND `STATUS` > ".TRANSFER_APPROVED;

        if($fromDate > 0)
            $query = $query." AND `UPDATED_AT` > ".$fromDate;
        if($toDate > 0)
            $query = $query." AND `UPDATED_AT` < ".$toDate;
        return $this->db->query($query)->result_array();
    }

    public function GetTransferTotalHistory($whereArray = array())
    {
        return $this->db->select('a.ID, a.CREATED_AT, b.FULL_NAME, a.TRANSACTION_TYPE, a.STATUS')
            ->from(self::TABLE_HISTORY_TRANSACTION.' a')
            ->join(self::TABLE_USER_INFO.' b', 'b.ID = a.USER_ID','left')
            ->where($whereArray)
            ->order_by('a.ID', 'desc')
            ->get()
            ->result_array();
    }

    public function GetTransferHistoryArray($array, $manual = false)
    {
        if($manual)
            $array['a.IS_MANUAL_TRANS'] = '1';
        return $this->db->select('a.ID, a.USER_ID, a.TRANSACTION_TYPE, a.AMOUNT, a.FROM_ACCOUNT, a.TO_ACCOUNT,f.FULL_NAME, f.NAME as USER_NAME, b.ACCOUNT_NUMBER, 
        a.OUTGOING_WIRE_INDEX, a.DESCRIPTION, a.STATUS, a.FROM_AVAILABLE_BALANCE,   c.ACCOUNT_TYPE, a.TO_USER_ID, a.CURRENCY_CALCED_RATE,
        a.TRANSACTION_FEE, a.TO_AVAILABLE_BALANCE, a.UPDATED_AT, a.CREATED_AT, b.CURRENCY_TYPE, d.TITLE, e.DESCRIPTION as STATUS_DESCRIPTION')
            ->from(self::TABLE_HISTORY_TRANSACTION." a")
            ->join(self::TABLE_USER_INFO." f", 'f.ID = a.USER_ID')
            ->join(self::TABLE_ACCOUNT_INFO." b", 'b.ID = a.FROM_ACCOUNT')
            ->join(self::TABLE_ACCOUNT_FEE_INFO.' c', 'c.ID = b.FEE_TYPE')
            ->join(self::TABLE_CURRENCY_KIND.' d', 'd.ID = b.CURRENCY_TYPE')
            ->join(self::TABLE_TRANSFER_STATUS.' e', 'e.ID = a.STATUS')
            ->where($array)
            ->get()
            ->result_array();
    }

    public function GetOrTransferHistoryArray($accountId, $fromDate, $toDate, $manual = false)
    {
        $query = "SELECT `a`.`ID`, `a`.`USER_ID`, `a`.`TRANSACTION_TYPE`, `a`.`AMOUNT`, `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, `a`.`DESCRIPTION`, `a`.`STATUS`, `a`.`FROM_AVAILABLE_BALANCE`, `a`.`TRANSACTION_FEE`, `a`.`TO_AVAILABLE_BALANCE`, `a`.`UPDATED_AT`, `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `d`.`TITLE`
                  FROM `history_transaction` `a`
                  JOIN `account_info` `b` ON `b`.`ID` = `a`.`FROM_ACCOUNT`
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE`
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `b`.`CURRENCY_TYPE`
                  WHERE (`a`.`FROM_ACCOUNT` = '".$accountId."' OR `a`.`TO_ACCOUNT` = '".$accountId."') AND (`a`.`CREATED_AT` BETWEEN ".$fromDate." AND ".$toDate.")";

        return $this->db->query($query)->result_array();
    }


    public function GetOrTransferHistoryArrayWithUserId($userId, $fromDate, $toDate, $manual = false)
    {
        $query = "SELECT `a`.`ID`, `a`.`USER_ID`, `a`.`TRANSACTION_TYPE`, `a`.`AMOUNT`, `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, `a`.`DESCRIPTION`, `a`.`STATUS`, `a`.`FROM_AVAILABLE_BALANCE`, `a`.`TRANSACTION_FEE`, `a`.`TO_AVAILABLE_BALANCE`, `a`.`UPDATED_AT`, `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `d`.`TITLE`
                  FROM `history_transaction` `a`
                  JOIN `account_info` `b` ON `b`.`ID` = `a`.`FROM_ACCOUNT`
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE`
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `b`.`CURRENCY_TYPE`
                  WHERE (`a`.`USER_ID` = '".$userId."') AND (`a`.`CREATED_AT` BETWEEN ".$fromDate." AND ".$toDate.")";
        return $this->db->query($query)->result_array();
    }

//
//    public function GetOneWeekTransactionHistoryForAML($userId) {
//        $sql = "SELECT * FROM history_transaction WHERE `IS_AML_PASSED` = 0 AND `USER_ID` = ".$userId." AND (`TRANSACTION_TYPE` =  )";
//
//    }
    public function GetTransactionsArrayList($where = array()) {
//
//                    'TRANSACTION_TYPE<' => Card_Funding_Transfer,
//                    'STATUS<' => TRANSFER_CANCELLED,
//                    'CREATED_AT>' =>(time() - $this::AML_AMOUNT_DURATION_VALUE)));

        return $this->db->select('*')->from(self::TABLE_HISTORY_TRANSACTION)
            ->where($where)
            ->get()
            ->result_array();
    }

    public function GetTransferHistoryObject($array)
    {
        return $this->db->select('*')->from(self::TABLE_HISTORY_TRANSACTION)
            ->where($array)
            ->limit(1,0)
            ->get()
            ->result();
    }

    public function UpdateTransferHistoryObject($setArray, $whereArray)
    {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_HISTORY_TRANSACTION, $setArray);
    }

    /**
     * Recent activity related functions
     */
    public function GetRecentTransactionsArrayList($userId)
    {
        $arrayRecentTransactionList =  $this->db->select('*')
            ->from(self::TABLE_HISTORY_TRANSACTION)
            ->where(array('USER_ID' => $userId))
            ->or_where(array('TO_USER_ID' => $userId))
            ->limit(5)
            ->order_by('ID', 'desc')
            ->get()
            ->result_array();
        return $arrayRecentTransactionList;
    }

    public function GetRecentTransactionsArrayListForAdmin()
    {
        $arrayRecentTransactionList =  $this->db->select('*')
            ->from(self::TABLE_HISTORY_TRANSACTION)
            ->limit(5)
            ->order_by('ID', 'desc')
            ->get()
            ->result_array();
        return $arrayRecentTransactionList;
    }

    public function GetRecentReceivedArrayList($userId)
    {
        $arrayRecentReceivedList =  $this->db->select('*')
            ->from(self::TABLE_HISTORY_TRANSACTION)
            ->where(array('TO_USER_ID' => $userId, 'STATUS' => '4'))
            ->limit(5)
            ->order_by('ID', 'desc')
            ->get()
            ->result_array();
        return $arrayRecentReceivedList;
    }

    public function GetRecentReceivedArrayListForAdmin()
    {

        $arrayRecentReceivedList =  $this->db->select('*')
            ->from(self::TABLE_HISTORY_TRANSACTION)
            ->where(array('STATUS' => '4'))
            ->limit(5)
            ->order_by('ID', 'desc')
            ->get()
            ->result_array();
        return $arrayRecentReceivedList;
    }
}