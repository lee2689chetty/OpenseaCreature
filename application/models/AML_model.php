<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 3/20/18
 * Time: 2:13 AM
 */
class AML_model extends MY_Model
{
    public function InsertNewRestrictCountry($array) {
        if($this->db->insert(self::TABLE_AML_COUNTRY, $array))  {
            return $this->db->insert_id();
        }
        else {
            return -1;
        }
    }

    public function InsertNewAMLRecord($array) {
        if($this->db->insert(self::TABLE_AML_TRANSACTION, $array))  {
            return $this->db->insert_id();
        }
        else {
            return -1;
        }
    }

    public function InsertNewRelatedAMLRecord($array) {
        if($this->db->insert(self::TABLE_AML_RELATED_TRANSACTION, $array))  {
            return $this->db->insert_id();
        }
        else {
            return -1;
        }
    }

    public function isCountryExist($countryId) {
        $resultArr =  $this->db->select('*')
                            ->from(self::TABLE_AML_COUNTRY)
                            ->where(array('COUNTRY_ID'=> $countryId))
                            ->get()
                            ->result_array();
        return count($resultArr) > 0;
    }

    public function getRestrictCountry($arrWhere = array()) {
        return $this->db->select('*')
            ->from(self::TABLE_AML_COUNTRY)
            ->where($arrWhere)
            ->get()
            ->result_array();
    }

    public function removeRestrictCountry($id) {
        $this->db->delete(self::TABLE_AML_COUNTRY, array('ID' => $id));
    }

    public function getThresholdByArray($arrWhere = array()) {
        return $this->db->select('*')
            ->from(self::TABLE_AML_THRESHOLD)
            ->where($arrWhere)
            ->get()
            ->result_array();
    }

    public function updateThresholdObject($setArray, $whereArray) {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_AML_THRESHOLD, $setArray);
    }

    public function getAMLTransactionByArray($arrWhere  = array()) {
        return $this->db->select('*')
            ->from(self::TABLE_AML_TRANSACTION)
            ->where($arrWhere)
            ->get()
            ->result_array();
    }

    public function updateAMLTransaction($setArray, $whereArray) {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_AML_TRANSACTION, $setArray);
    }

    public function updateAMLRelatedTransaction($setArray, $whereArray) {
        $this->db->where($whereArray);
        $this->db->update(self::TABLE_AML_RELATED_TRANSACTION, $setArray);
    }

    public function getAMLRelatedTransactionByArray($arrWhere  = array()) {
        return $this->db->select('*')
            ->from(self::TABLE_AML_RELATED_TRANSACTION)
            ->where($arrWhere)
            ->get()
            ->result_array();
    }


}