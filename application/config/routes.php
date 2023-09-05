<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['admin/aml/(:any)/(:any)'] = 'admin/AdminAMLController/$1/$2';
$route['admin/aml/(:any)'] = 'admin/AdminAMLController/$1';

$route['admin/file/(:any)/(:any)'] = 'admin/AdminFileController/$1/$2';
$route['admin/file/(:any)'] = 'admin/AdminFileController/$1';

$route['admin/kyc/(:any)/(:any)'] = 'admin/AdminKYCController/$1/$2';
$route['admin/kyc/(:any)'] = 'admin/AdminKYCController/$1';

$route['admin/supers/(:any)'] = 'admin/AdminSuperbController/$1';
$route['admin/supers/(:any)/(:num)'] = 'admin/AdminSuperbController/$1/$2';

$route['admin/currency/(:any)'] = 'admin/AdminCurrencyRateController/$1';
$route['admin/currency/(:any)/(:num)'] = 'admin/AdminCurrencyRateController/$1/$2';

$route['admin/report/view/(:any)'] = 'admin/AdminReportController/view/$1';
$route['admin/report/(:any)'] = 'admin/AdminReportController/$1';

$route['admin/profile/(:any)'] = 'admin/AdminProfileController/$1';
$route['admin/profile/(:any)/(:num)'] = 'admin/AdminProfileController/$1/$2';
$route['admin/messages/(:any)'] = 'admin/AdminMessagesController/$1';
$route['admin/transfer/(:any)'] = 'admin/AdminTransferController/$1';
$route['admin/account/(:any)/(:any)'] = 'admin/AdminAccountController/$1/$2';
$route['admin/account/(:any)'] = 'admin/AdminAccountController/$1';
$route['admin/request/(:any)/(:any)'] = 'admin/AdminRequestController/$1/$2';
$route['admin/request/(:any)'] = 'admin/AdminRequestController/$1';
$route['admin/dash/recent/(:any)'] = 'admin/AdminDashController/recent/$1';
$route['admin/dash/(:any)'] = 'admin/AdminDashController/$1';
$route['admin/auth/(:any)'] = 'admin/AdminAuthController/$1';

$route['file/(:any)'] = 'FileController/$1';
$route['file/(:any)/(:any)'] = 'FileController/$1/$2';
$route['kyc/(:any)'] = 'KycController/$1';
$route['kyc/(:any)/(:any)'] = 'KycController/$1/$2';
$route['request/(:any)/(:any)'] = 'RequestController/$1/$2';
$route['message/(:any)'] = 'MessageController/$1';
$route['fee/(:any)/(:num)'] = 'FeeController/$1/$2';
$route['report/(:any)'] = 'ReportController/$1';
$route['profile/(:any)'] = 'ProfileController/$1';
$route['transfer/(:any)'] = 'TransferController/$1';
$route['account/(:any)'] = 'AccountController/$1';
$route['dash/recent/(:any)'] = 'DashController/recent/$1';
$route['dash/(:any)'] = 'DashController/$1';
$route['auth/(:any)'] = 'AuthController/$1';
$route['default_controller'] = 'AuthController/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
