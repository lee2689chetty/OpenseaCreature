<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 7:20 PM
 */
class TransferHistoryDetail_model extends MY_Model{

    public function InsertRecordByArray($array){
        if($this->db->insert(self::TABLE_TRANSFER_DETAIL_INFO, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function UpdateTransferHistoryDetailObject($setArray, $whereArray)
    {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_TRANSFER_DETAIL_INFO, $setArray);
    }

    public function InsertManualRequestHistory($requestId, $fromUserId, $fromAccountId, $toUserId, $toAccountId, $revenueAccountId, $amount, $transactionFee = 0)
    {
        $this->InsertRecordByArray(array('REQUEST_ID' => $requestId,
            'USER_ID' => $fromUserId,
            'ACCOUNT_ID' => $fromAccountId,
            'AMOUNT' => $amount,
            'DETAIL_TYPE' => DETAIL_DEBIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $requestId,
            'USER_ID' => $toUserId,
            'ACCOUNT_ID' => $toAccountId,
            'AMOUNT' => $amount,
            'DETAIL_TYPE' => DETAIL_CREDIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $requestId,
            'USER_ID' => $fromUserId,
            'ACCOUNT_ID' => $fromAccountId,
            'AMOUNT' => $transactionFee,
            'DETAIL_TYPE' => DETAIL_DEBIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $requestId,
            'USER_ID' => '1',
            'ACCOUNT_ID' => $revenueAccountId,
            'AMOUNT' => $transactionFee,
            'DETAIL_TYPE' => DETAIL_CREDIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));
    }

    public function InsertRequestHistoryByStatus($resultInsert, $fromAccountModel, $toAccountModel, $toRevenueModelForFee, $toRevenueModelForCCR, $amount, $calcConversionRate, $feeAmount, $hiddenFeeValue = 0)
    {
        $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
            'USER_ID' => $fromAccountModel[0]['USER_ID'],
            'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
            'AMOUNT' => $amount,
            'DETAIL_TYPE' => DETAIL_DEBIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
            'USER_ID' => $toAccountModel[0]['USER_ID'],
            'ACCOUNT_ID' => $toAccountModel[0]['ID'],
            'AMOUNT' => ($amount * $calcConversionRate),
            'DETAIL_TYPE' => DETAIL_CREDIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        if(floatval($feeAmount) > 0) {
            $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
                'USER_ID' => $fromAccountModel[0]['USER_ID'],
                'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
                'AMOUNT' => $feeAmount,
                'DETAIL_TYPE' => DETAIL_DEBIT,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()));
        }

        if(floatval($feeAmount) > 0) {
            $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
                'USER_ID' => '1',
                'ACCOUNT_ID' => $toRevenueModelForFee[0]['ID'],
                'AMOUNT' => ($feeAmount),
                'DETAIL_TYPE' => DETAIL_CREDIT,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()));
        }

        if(floatval($hiddenFeeValue) > 0)
        {
            $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
                'USER_ID' => '1',
                'ACCOUNT_ID' => $toRevenueModelForCCR[0]['ID'],
                'AMOUNT' => ($hiddenFeeValue),
                'DETAIL_TYPE' => DETAIL_CREDIT,
                'UPDATED_AT' => time(),
                'CREATED_AT' => time()));
        }
    }

    public function InsertOutgoingHistoryByStatus($resultInsert, $fromAccountModel, $toRevenueModel, $amount, $calcConversionRate, $feeAmount)
    {
        $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
            'USER_ID' => $fromAccountModel[0]['USER_ID'],
            'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
            'AMOUNT' => $amount,
            'DETAIL_TYPE' => DETAIL_DEBIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
            'USER_ID' => 0,
            'ACCOUNT_ID' => 0,
            'AMOUNT' => ($amount * $calcConversionRate),
            'DETAIL_TYPE' => DETAIL_CREDIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
            'USER_ID' => $fromAccountModel[0]['USER_ID'],
            'ACCOUNT_ID' => $fromAccountModel[0]['ID'],
            'AMOUNT' => $feeAmount,
            'DETAIL_TYPE' => DETAIL_DEBIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));

        $this->InsertRecordByArray(array('REQUEST_ID' => $resultInsert,
            'USER_ID' => '1',
            'ACCOUNT_ID' => $toRevenueModel[0]['ID'],
            'AMOUNT' => $feeAmount,
            'DETAIL_TYPE' => DETAIL_CREDIT,
            'UPDATED_AT' => time(),
            'CREATED_AT' => time()));
    }

    public function GetHistoryDetailItems($array = array()){
        return $this->db->select('a.ID, a.REQUEST_ID, a.ACCOUNT_ID, a.AMOUNT, a.DETAIL_TYPE, b.FROM_AVAILABLE_BALANCE, 
        b.TO_AVAILABLE_BALANCE, b.DESCRIPTION, a.UPDATED_AT, f.TITLE, d.ACCOUNT_NUMBER, a.USER_ID,  d.ACCOUNT_NUMBER, f.TITLE as CURRENCY_TITLE')
            ->from(self::TABLE_TRANSFER_DETAIL_INFO.' a')
            ->join(self::TABLE_HISTORY_TRANSACTION.' b', 'b.ID = a.REQUEST_ID')
            ->join(self::TABLE_ACCOUNT_INFO.' d', 'd.ID = a.ACCOUNT_ID')
            ->join(self::TABLE_ACCOUNT_FEE_INFO. ' e', 'e.ID = d.FEE_TYPE')
            ->join(self::TABLE_CURRENCY_KIND.' f', 'f.ID = d.CURRENCY_TYPE')
            ->where($array)
            ->get()
            ->result_array();
    }


    public function GetTransferDetailForRevenueReport($revenueId, $transferType, $fromTimeStamp, $toTimeStamp){
        $sql = "SELECT a.ID, a.REQUEST_ID, a.ACCOUNT_ID, a.AMOUNT, a.DETAIL_TYPE, b.USER_ID, b.FROM_ACCOUNT, b.TO_USER_ID, b.TO_ACCOUNT, 
                b.TRANSACTION_TYPE, b.DESCRIPTION, b.FROM_AVAILABLE_BALANCE, b.FROM_CURRENT_BALANCE, b.TO_AVAILABLE_BALANCE, b.TO_CURRENT_BALANCE, b.TRANSACTION_FEE,
                b.UPDATED_AT, b.CREATED_AT FROM ".self::TABLE_TRANSFER_DETAIL_INFO." a JOIN ".self::TABLE_HISTORY_TRANSACTION." b ON b.ID = a.REQUEST_ID
                WHERE a.AMOUNT > 0 AND (a.USER_ID = 1 AND a.ACCOUNT_ID = ".$revenueId.") AND b.STATUS > ".TRANSFER_APPROVED;
        //0: all, 1: system, 2: manual
        if(intval($transferType) == 1){
            $sql = $sql." AND b.IS_MANUAL_TRANS = 0";
        }
        else if(intval($transferType) == 2){
            $sql = $sql." AND b.IS_MANUAL_TRANS = 1";
        }

        if($fromTimeStamp > 0){
            $sql = $sql." AND b.UPDATED_AT > ".$fromTimeStamp;
        }

        if($toTimeStamp > 0){
            $sql = $sql." AND b.UPDATED_AT < ".$toTimeStamp;
        }
//        return $sql;
        return $this->db->query($sql)->result_array();
    }

    public function GetHistoryDetail($array=array()){
        return $this->db->select('*')->from(self::TABLE_TRANSFER_DETAIL_INFO)->where($array)->get()->result_array();
    }

    public function GetReportTransferDetailInformationByUserId($userId, $fromDate, $toDate, $status = 0)
    {
        //0: all, 1: completed, 2: pending
        $query = "SELECT  `a`.`ID`, `a`.`USER_ID`, `b`.`ACCOUNT_NUMBER`, `a`.`TRANSACTION_TYPE`, `detail`.`ID` as `TRANS_ID`, 
                          `detail`.DETAIL_TYPE, `detail`.`AMOUNT`, `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, 
                          `a`.`DESCRIPTION`, `a`.`STATUS`, `a`.`FROM_AVAILABLE_BALANCE`, `a`.`TRANSACTION_FEE`, `a`.`TO_AVAILABLE_BALANCE`, 
                          `a`.`UPDATED_AT`, `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `d`.`TITLE`, `e`.`DESCRIPTION` as `STATUS_DESCRIPTION`
                  FROM  `history_transaction_detail` `detail` 
                  JOIN `history_transaction` `a` ON `a`.`ID` = `detail`.REQUEST_ID 
                  JOIN `account_info` `b` ON `b`.`ID` = `detail`.`ACCOUNT_ID` 
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE` 
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `b`.`CURRENCY_TYPE` 
                  JOIN  `basis_transfer_status` `e` ON `e`.`ID` = `a`.`STATUS`
                  WHERE `detail`.AMOUNT > 0 ";
        if(intval($status) == 1) {
            $query .= " AND (`a`.`STATUS` = ".TRANSFER_COMPLETE.")";
        }
        else if(intval($status == 2)) {
            $query .= " AND (`a`.`STATUS` = ".TRANSFER_AWAITING_APPROVAL.")";
        }
        else if(intval($status) == 3) {
            $query .= " AND (`a`.`STATUS` = ".TRANSFER_CANCELLED.")";
        }
        if($userId != "") $query .= " AND (`detail`.`USER_ID` = '".$userId."')";
        if($fromDate != "") $query = $query." AND (`a`.`CREATED_AT` BETWEEN ".$fromDate." AND ".$toDate.") ";

        $query = $query." ORDER BY `detail`.`CREATED_AT` DESC";
        return $this->db->query($query)->result_array();
    }

    public function GetReportTransferDetailInformationByDate($fromDate, $toDate)
    {
        $query = "SELECT  `a`.`ID`, `a`.`USER_ID`, `b`.`ACCOUNT_NUMBER`, `a`.`TRANSACTION_TYPE`, `detail`.`ACCOUNT_ID` as SOURCE_ACCOUNT_ID,
                          `detail`.DETAIL_TYPE, `detail`.`AMOUNT`, `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, 
                          `a`.`DESCRIPTION`, `a`.`STATUS`, `a`.`FROM_AVAILABLE_BALANCE`, `a`.`FROM_CURRENT_BALANCE`, `a`.`TRANSACTION_FEE`, 
                          `a`.`TO_AVAILABLE_BALANCE`, `a`.`TO_CURRENT_BALANCE`,
                          `a`.`UPDATED_AT`, `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `c`.`ACCOUNT_TYPE`, `d`.`TITLE`, `e`.`NAME` as USER_NAME, 
                          `e`.`FULL_NAME` as USER_FULL_NAME, 
                          `e`.`CREATED_AT` as USER_CREATED_AT, `b`.`CREATED_AT` as ACCOUNT_CREATED_AT
                  FROM  `history_transaction_detail` `detail` 
                  JOIN `history_transaction` `a` ON `a`.`ID` = `detail`.`REQUEST_ID` 
                  JOIN `account_info` `b` ON `b`.`ID` = `detail`.`ACCOUNT_ID` 
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE` 
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `b`.`CURRENCY_TYPE`
                  JOIN `user_info` `e` ON `e`.`ID` = `a`.`USER_ID`
                  WHERE `detail`.AMOUNT > 0 AND `a`.`CREATED_AT` BETWEEN ".$fromDate." AND ".$toDate;
        return $this->db->query($query)->result_array();
    }

    public function GetOutgoingTransferDetailInformation($outgoingIndex)
    {
        $query = "SELECT  `a`.`ID`, `a`.`USER_ID`, `b`.`ACCOUNT_NUMBER`, `a`.`TRANSACTION_TYPE`, 
                          `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, `a`.`AMOUNT`, 
                          `a`.`DESCRIPTION`, `a`.`STATUS`, `a`.`FROM_AVAILABLE_BALANCE`, `a`.`FROM_CURRENT_BALANCE`, `a`.`TRANSACTION_FEE`, 
                          `a`.`TO_AVAILABLE_BALANCE`, `a`.`TO_CURRENT_BALANCE`,
                          `a`.`UPDATED_AT`, `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `c`.`ACCOUNT_TYPE`, `d`.`TITLE` as CURRENCY_TITLE, `e`.`NAME` as USER_NAME, 
                          `e`.`FULL_NAME` as USER_FULL_NAME, 
                          `e`.`CREATED_AT` as USER_CREATED_AT, `b`.`CREATED_AT` as ACCOUNT_CREATED_AT
                  FROM `outgoing_wire_history` `outgoing`
                  JOIN `history_transaction` `a` ON `a`.`OUTGOING_WIRE_INDEX` = `outgoing`.`ID`
                  JOIN `account_info` `b` ON (`b`.`ID` = `a`.`FROM_ACCOUNT` AND `b`.`USER_ID` = `detail`.`USER_ID`) 
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE` 
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `outgoing`.`CURRENCY_TYPE`
                  JOIN `user_info` `e` ON `e`.`ID` = `a`.`USER_ID`
                  WHERE `outgoing`.`ID` = ".$outgoingIndex;
        return $this->db->query($query)->result_array();
    }

    public function GetOutgoingTransferDetailInformationByDate($currencyType, $fromDate, $toDate)
    {
        $query = "SELECT  `a`.`ID`, `a`.`USER_ID`, `b`.`ACCOUNT_NUMBER`, `a`.`TRANSACTION_TYPE`, 
                          `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, `a`.`AMOUNT`, 
                          `a`.`DESCRIPTION`, `a`.`STATUS`, `a`.`FROM_AVAILABLE_BALANCE`, `a`.`FROM_CURRENT_BALANCE`, `a`.`TRANSACTION_FEE`, 
                          `a`.`TO_AVAILABLE_BALANCE`, `a`.`TO_CURRENT_BALANCE`,
                          `a`.`UPDATED_AT`, `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `c`.`ACCOUNT_TYPE`, `d`.`TITLE`, `e`.`NAME` as USER_NAME, 
                          `e`.`FULL_NAME` as USER_FULL_NAME, 
                          `e`.`CREATED_AT` as USER_CREATED_AT, `b`.`CREATED_AT` as ACCOUNT_CREATED_AT
                  FROM `outgoing_wire_history` `outgoing`
                  JOIN `history_transaction` `a` ON `a`.`OUTGOING_WIRE_INDEX` = `outgoing`.`ID`
                  JOIN `account_info` `b` ON `b`.`ID` = `a`.`FROM_ACCOUNT` 
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE` 
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `outgoing`.`CURRENCY_TYPE`
                  JOIN `user_info` `e` ON `e`.`ID` = `a`.`USER_ID`
                  WHERE 1=1";
        if($currencyType != "") $query .= " AND `outgoing`.`CURRENCY_TYPE` = ".$currencyType;
        if($fromDate != "") $query .= " AND `outgoing`.`CREATED_AT` >= ".$fromDate;
        if($toDate != "") $query .= " AND `outgoing`.`CREATED_AT` <=".$toDate;

        return $this->db->query($query)->result_array();
    }

    public function GetReportTransferDetailInformationByAccountId($accountId, $fromDate, $toDate)
    {
        $query = "SELECT `a`.`ID`, `a`.`USER_ID`, `a`.`TRANSACTION_TYPE`, `detail`.DETAIL_TYPE, `detail`.`AMOUNT`, `detail`.`ID` as `TRANS_ID`, 
                         `a`.`FROM_ACCOUNT`, `a`.`TO_ACCOUNT`, `a`.`OUTGOING_WIRE_INDEX`, `a`.`DESCRIPTION`, `a`.`STATUS`, 
                         `a`.`FROM_AVAILABLE_BALANCE`, `a`.`FROM_CURRENT_BALANCE`, `a`.`TRANSACTION_FEE`, `a`.`TO_AVAILABLE_BALANCE`, `a`.`TO_CURRENT_BALANCE`, `a`.`UPDATED_AT`, 
                         `a`.`CREATED_AT`, `b`.`CURRENCY_TYPE`, `d`.`TITLE`, `e`.`DESCRIPTION` as `STATUS_DESCRIPTION`
                  FROM  `history_transaction_detail` `detail` 
                  JOIN `history_transaction` `a` ON `a`.`ID` = `detail`.REQUEST_ID 
                  JOIN `account_info` `b` ON (`b`.`ID` = `detail`.`ACCOUNT_ID` AND `b`.`USER_ID` = `detail`.`USER_ID`)
                  JOIN `basis_account_fee_info` `c` ON `c`.`ID` = `b`.`FEE_TYPE`
                  JOIN `basis_currency_kind` `d` ON `d`.`ID` = `b`.`CURRENCY_TYPE`
                  JOIN  `basis_transfer_status` `e` ON `e`.`ID` = `a`.`STATUS`
                  WHERE (`detail`.`ACCOUNT_ID` = '".$accountId."') AND (`detail`.`AMOUNT` > 0) AND `a`.`STATUS` > '2'";
        if($fromDate != "") $query = $query." AND `detail`.`CREATED_AT` >= ".$fromDate;
        if($toDate != "") $query = $query." AND `detail`.`CREATED_AT` <=".$toDate;
        else
            $query = $query." LIMIT 20";
        return $this->db->query($query)->result_array();
    }

}