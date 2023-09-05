<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
 * User status constants
 */

defined('USER_STATUS_PENDING')          OR define('USER_STATUS_PENDING', 1);
defined('USER_STATUS_ACTIVE')           OR define('USER_STATUS_ACTIVE', 2);
defined('USER_STATUS_INACTIVE')         OR define('USER_STATUS_INACTIVE', 3);
defined('USER_STATUS_DORMANT')          OR define('USER_STATUS_DORMANT', 4);

/**
 * Account type constants
 */
defined('ACCOUNT_TYPE_EWALLET')         OR define('ACCOUNT_TYPE_EWALLET', 1);
defined('ACCOUNT_TYPE_VIBAN')           OR define('ACCOUNT_TYPE_VIBAN', 2);
defined('ACCOUNT_TYPE_CARD')            OR define('ACCOUNT_TYPE_CARD', 3);

/**
 * Transfer Status constants
 */
defined('TRANSFER_REQUESTED')               OR define('TRANSFER_REQUESTED', 1);
defined('TRANSFER_AWAITING_APPROVAL')       OR define('TRANSFER_AWAITING_APPROVAL', 2);
defined('TRANSFER_APPROVED')                OR define('TRANSFER_APPROVED', 3);
defined('TRANSFER_COMPLETE')                OR define('TRANSFER_COMPLETE', 4);
defined('TRANSFER_CANCELLED')               OR define('TRANSFER_CANCELLED', 5);
defined('TRANSFER_SUSPENDED')               OR define('TRANSFER_SUSPENDED', 6);

/**
 * Menu constants
 */

defined('MENU_HOME')                            OR define('MENU_HOME', 1);
defined('MENU_REQUEST_TRANSFER')                OR define('MENU_REQUEST_TRANSFER', 2);
defined('MENU_REQUEST_REGISTER')                OR define('MENU_REQUEST_REGISTER', 3);
defined('MENU_ACCOUNT_VIRTUAL')                 OR define('MENU_ACCOUNT_VIRTUAL', 4);
defined('MENU_ACCOUNT_CARD')                    OR define('MENU_ACCOUNT_CARD', 5);
defined('MENU_ACCOUNT_REVENUE')                 OR define('MENU_ACCOUNT_REVENUE', 6);
defined('MENU_PROFILE_USER')                    OR define('MENU_PROFILE_USER', 7);
defined('MENU_PROFILE_FEE')                     OR define('MENU_PROFILE_FEE', 8);
defined('MENU_TRANSFER')                        OR define('MENU_TRANSFER', 9);
defined('MENU_MESSAGES')                        OR define('MENU_MESSAGES', 10);
defined('MENU_CURRENCY_PAIR')                   OR define('MENU_CURRENCY_PAIR', 11);
defined('MENU_REPORT_SPECIFIC_ACCOUNT')         OR define('MENU_REPORT_SPECIFIC_ACCOUNT', 12);
defined('MENU_REPORT_SPECIFIC_ALLTRANS')        OR define('MENU_REPORT_SPECIFIC_ALLTRANS', 13);
defined('MENU_REPORT_SPECIFIC_BALANCE')         OR define('MENU_REPORT_SPECIFIC_BALANCE', 14);
defined('MENU_REPORT_GENERAL_ALL')              OR define('MENU_REPORT_GENERAL_ALL', 15);
defined('MENU_REPORT_GENERAL_BALANCES')         OR define('MENU_REPORT_GENERAL_BALANCES', 16);
defined('MENU_REPORT_GENERAL_OUTGOING')         OR define('MENU_REPORT_GENERAL_OUTGOING', 17);
defined('MENU_REPORT_GENERAL_ALLCARDS')         OR define('MENU_REPORT_GENERAL_ALLCARDS', 18);
defined('MENU_REPORT_GENERAL_MANUALTRANS')      OR define('MENU_REPORT_GENERAL_MANUALTRANS', 19);
defined('MENU_REPORT_GENERAL_REVENUE')          OR define('MENU_REPORT_GENERAL_REVENUE', 20);
defined('MENU_REPORT_GENERAL_ACCESSLOG')        OR define('MENU_REPORT_GENERAL_ACCESSLOG', 21);
defined('MENU_REPORT_GENERAL_OVERVIEW')         OR define('MENU_REPORT_GENERAL_OVERVIEW', 22);
defined('MENU_ADMIN_MANAGE')                    OR define('MENU_ADMIN_MANAGE', 23);
defined('MENU_KYC_MANAGE')                      OR define('MENU_KYC_MANAGE', 24);
defined('MENU_FILE_MANAGE')                      OR define('MENU_FILE_MANAGE', 25);
defined('MENU_AML_COUNTRIES')                      OR define('MENU_AML_COUNTRIES', 26);
defined('MENU_AML_THRESHOLD')                      OR define('MENU_AML_THRESHOLD', 27);
defined('MENU_AML_TRANS')                      OR define('MENU_AML_TRANS', 28);

/*
 * Credit, Debit constants
 */
defined('DETAIL_CREDIT')      OR define('DETAIL_CREDIT', 0);
defined('DETAIL_DEBIT')       OR define('DETAIL_DEBIT', 1);

/**
 * Transfer Kind constants
 */
defined('All_Client_Transfer')            OR define('All_Client_Transfer', 1);
defined('Transfer_Between_Accounts')      OR define('Transfer_Between_Accounts', 2);
defined('Transfer_Between_Users')         OR define('Transfer_Between_Users', 3);
defined('Outgoing_Wire_Transfer')         OR define('Outgoing_Wire_Transfer', 4);
defined('Card_Funding_Transfer')          OR define('Card_Funding_Transfer', 5);
defined('Incoming_Wire_Transfer')         OR define('Incoming_Wire_Transfer', 6);
defined('Account_Debit_Transfer')         OR define('Account_Debit_Transfer', 7);
defined('Account_Credit_Transfer')        OR define('Account_Credit_Transfer', 8);


/**
 * Notification type contstants
 */
defined('NOTIFY_NEW_ACCOUNT_CREATE')      OR define('NOTIFY_NEW_ACCOUNT_CREATE', 0);
defined('NOTIFY_NEW_MESSAGE_RECEIVED')    OR define('NOTIFY_NEW_MESSAGE_RECEIVED', 1);
defined('NOTIFY_NEW_TRANS_CREATE')        OR define('NOTIFY_NEW_TRANS_CREATE', 2);
defined('NOTIFY_VERIFY_REQUESTED')        OR define('NOTIFY_VERIFY_REQUESTED', 3);