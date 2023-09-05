<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 3/20/18
 * Time: 2:13 AM
 */
class File_model extends MY_Model
{
    public function InsertNewFile($array) {
        if($this->db->insert(self::TABLE_UPLOAD_FILES, $array))  {
            return $this->db->insert_id();
        }
        else {
            return -1;
        }
    }

    public function GetUploadFileInformation($where = array()) {
        return $this->db->select('*')
                        ->from(self::TABLE_UPLOAD_FILES)
                        ->where($where)
                        ->get()
                        ->result_array();
    }

    public function RemoveFile($id) {
        $this->db->delete(self::TABLE_UPLOAD_FILES, array('ID' => $id));
    }
}