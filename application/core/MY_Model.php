<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 23/7/2017
 * Time: 12:49 AM
 */
class MY_Model extends CI_Model
{
    const DB_RESULT_SUCCESS = 1;
    const DB_RESULT_FAILED = 0;
    const DB_REPLY_RESULT_FIELD = 'result';
    const DB_REPLY_MESSAGE_FIELD = 'msg';
    const TABLE_USER_INFO = "user_info";
    const TABLE_ACCOUNT_INFO = "account_info";
    const TABLE_REVENUE_TRANSACTION = "history_revenue_transaction";
    const TABLE_HISTORY_TRANSACTION = "history_transaction";
    const TABLE_TRANSFER_DETAIL_INFO = "history_transaction_detail";
    const TABLE_TRANSFER_DETAIL_STATUS = "history_transaction_status";
    const TABLE_OUTGOING_WIRE = "outgoing_wire_history";
    const TABLE_PROFILE_INFO = "profile_info";
    const TABLE_CARD_INFO = "card_info";
    const TABLE_REVENUE_INFO = "revenue_info";
    const TABLE_MESSAGE_THREAD = "history_message_thread";
    const TABLE_MESSAGE_DETAIL = "history_message_transaction";
    const TABLE_LOGIN_HISTORY = "history_login";
    const TABLE_PROFILE_KIND = "basis_profile_type";
    const TABLE_USER_STATUS_KIND = "basis_user_status";
    const TABLE_ACCOUNT_FEE_INFO = "basis_account_fee_info";
    const TABLE_CURRENCY_KIND = "basis_currency_kind";
    const TABLE_CURRENCY_PAIR = "basis_currency_pair";
    const TABLE_CURRENCY_EXCHANGE_RATE = "basis_currency_exchange_rate";
    const TABLE_CHARGE_PERIOD = "basis_charge_period";
    const TABLE_CHARGE_DAY = "basis_charge_day";
    const TABLE_LOC_METHOD = "basis_loc_method";
    const TABLE_PAYOUT_DAY = "basis_payout_day";
    const TABLE_PAYMENT_OPTOION = "basis_payment_option";
    const TABLE_CITY_INFO = "basis_city_info";
    const TABLE_ACCOUNT_TYPE = "basis_account_type";
    const TABLE_TRANSFER_KIND = "basis_transfer_kind";
    const TABLE_TRANSFER_STATUS = "basis_transfer_status";
    const TABLE_COUNTRY_INFO = "basis_country_info";
    const TABLE_SECURITY_INFO = "basis_security_questions";
    const TABLE_BASIS_USER_LEVEL = "basis_user_level";
    const TABLE_KYC_PROGRESS = "kyc_info";

    const TABLE_AML_COUNTRY = "basis_restrict_area";
    const TABLE_AML_TRANSACTION = "aml_transaction";
    const TABLE_AML_RELATED_TRANSACTION = "aml_releated_transaction";
    const TABLE_AML_THRESHOLD = "aml_threshold";

    const TABLE_NOTIFY_HISTORY = "history_notification";
    const TABLE_UPLOAD_FILES = "upload_file_info";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

}