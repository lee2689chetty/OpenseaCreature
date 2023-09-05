<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeeController extends CI_Controller {
	public function getFee($index)
    {
        $feeList = $this->UtilInfo_model->GetOutGoingFee($index);
        $array = $feeList[0]['OUTGOING_FEE'];
        echo($array);
    }
}
