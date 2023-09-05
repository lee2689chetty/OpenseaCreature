<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 1/19/18
 * Time: 7:20 PM
 */
class TransferHistoryDetailStatus_model extends MY_Model
{
    public function InsertRecordByArray($array)
    {
        if($this->db->insert(self::TABLE_TRANSFER_DETAIL_STATUS, $array))
        {
            return $this->db->insert_id();
        }
        else
        {
            return -1;
        }
    }

    public function InsertRecordsByOnce($transferId)
    {
        self::InsertRecordByArray(array('REQUEST_ID' => $transferId, 'STATUS_ID' => TRANSFER_REQUESTED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
        self::InsertRecordByArray(array('REQUEST_ID' => $transferId, 'STATUS_ID' => TRANSFER_AWAITING_APPROVAL, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
        self::InsertRecordByArray(array('REQUEST_ID' => $transferId, 'STATUS_ID' => TRANSFER_APPROVED, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
        self::InsertRecordByArray(array('REQUEST_ID' => $transferId, 'STATUS_ID' => TRANSFER_COMPLETE, 'UPDATED_AT' => time(), 'CREATED_AT' => time()));
    }
    public function GetTransferStatusHistoryArray($arrayWhere = array())
    {
        return $this->db->select('a.UPDATED_AT, a.ID, b.DESCRIPTION, a.STATUS_ID, a.REQUEST_ID')
                    ->from(self::TABLE_TRANSFER_DETAIL_STATUS." a")
                    ->join(self::TABLE_TRANSFER_STATUS." b", "b.ID = a.STATUS_ID")
                    ->where($arrayWhere)
                    ->order_by('a.ID', 'ASC')
                    ->get()
                    ->result_array();
    }

    public function getLastStatusExceptForSuspend($transferId) {
       return  $this->db->select('*')
            ->from(self::TABLE_TRANSFER_DETAIL_STATUS)
            ->where(array('REQUEST_ID' => $transferId, 'STATUS_ID<' => TRANSFER_SUSPENDED))
            ->order_by('ID', 'DESC')
            ->get()
            ->result_array();
    }
}