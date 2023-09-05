<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: rock
 * Date: 7/11/2017
 * Time: 12:58 AM
 */
class Stringutils
{
    public function IsNullEmpty($stringValue)
    {
        return (!isset($stringValue) || trim($stringValue)==='');
    }

    public function array_sort($array, $on, $order=SORT_ASC){

        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                }
                else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function check_dateformat($stringVal){
        if(preg_match("/^[0-9]{4}\\-[0-9]{2}\\/[0-9]{2}$/", $stringVal)) {
            return TRUE;
        }else {
            return FALSE;
        }
    }

    public function GetUnixTimeStampFromString($fromDate, $isToEndOfDate)
    {
        if (preg_match('/^(?P<year>\d+)[-\/](?P<month>\d+)[-\/](?P<day>\d+)$/', $fromDate, $matches)) {
            if($isToEndOfDate == TRUE)
            {
//                $fromTimestamp_tmp = $fromDate." 23:59:59";
//                $fromTimestamp = strtotime($fromTimestamp_tmp);
                $fromTimestamp = mktime(23, 59, 59, ($matches['month']), $matches['day'], $matches['year']);
            }
            else
            {
//                $fromTimestamp_tmp = $fromDate." 00:00:00";
//                $fromTimestamp = strtotime($fromTimestamp_tmp);
                $fromTimestamp = mktime(0, 0, 0, ($matches['month']), $matches['day'], $matches['year']);
            }
        } else {
            $fromTimestamp = "";
        }
        return $fromTimestamp;
    }

}