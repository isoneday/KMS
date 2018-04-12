<?php
error_reporting('E_ALL & ~E_NOTICE');
// 
$application['application_id'] = 1;

// do not edit this config
$application['gtfw_base'] = GTFW_BASE_DIR;
$application['docroot'] = GTFW_APP_DIR;

$application['basedir'] = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']); // with trailling slash
$application['baseaddress'] = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://" . $_SERVER['HTTP_HOST']; // without trailling slash
$application['domain'] = NULL; // name of domain

//============database============================

// connection number 0
$application['db_conn'][0]['db_driv'] = 'pdo';
$application['db_conn'][0]['db_type'] = 'mysqlt';
$application['db_conn'][0]['db_host'] = 'localhost';
$application['db_conn'][0]['db_user'] = 'root';
$application['db_conn'][0]['db_pass'] = '';
$application['db_conn'][0]['db_name'] = 'kms1';
$application['db_conn'][0]['db_result_cache_lifetime'] = '';
$application['db_conn'][0]['db_result_cache_path'] = '';
$application['db_conn'][0]['db_debug_enabled'] = '';
$application['db_conn'][0]['db_port'] = '3306';

/*
=================================================
sample Connection for Oracle database
=================================================
$application['db_conn'][0]['db_driv'] = 'adodb';
$application['db_conn'][0]['db_type'] = 'oci8';
$application['db_conn'][0]['db_host'] = 'localhost';
$application['db_conn'][0]['db_user'] = 'GTFW';
$application['db_conn'][0]['db_pass'] = 'GTFWENTERPRISE';
$application['db_conn'][0]['db_name'] = 'ORCL';
*/

//============session============================
$application['use_session'] = TRUE;
$application['session_name'] = 'GTFW35SessID';
$application['session_db_connection']=0;
$application['session_save_handler']=NULL; //to wriste session into files, set as NULL; to write session into db, set as "database"
$application['session_save_path'] = NULL;//TODO: should not be here!!!, and pelase, support NULL value to fallback to PHP INI's session save path
$application['session_expire'] = 60; // in minutes
$application['session_cookie_params']['lifetime'] = 60 * $application['session_expire']; // in seconds
$application['session_cookie_params']['path'] = $application['basedir'];
$application['session_cookie_params']['domain'] = $application['domain'];
$application['session_cookie_params']['secure'] = FALSE; // needs secure connection?

//============default page============================
$application['default_page']['mod'] = 'core.home';
$application['default_page']['sub'] = 'landingPage';
$application['default_page']['act'] = 'view';
$application['default_page']['typ'] = 'html';

//============login page============================
$application['login_page']['mod'] = 'core.login';
$application['login_page']['sub'] = 'login';
$application['login_page']['act'] = 'view';
$application['login_page']['typ'] = 'html';

//============security===========================
$application['enable_security'] = true;
$application['default_user'] = 'nobody';
$application['enable_url_obfuscator'] = FALSE;
$application['url_obfuscator_exception'] = array('soap'); // list of exeption request/response type
$application['url_type'] = 'Long'; // type: Long or Short
$application['login_method'] = 'default';

//============development============================
$application['debug_mode'] = TRUE;

//=========== Single Sign On ========================
$application['system_id'] = 'com.gamatechno.gtfw';
$application['sso_group'] = 'com_gamatechno_academica'; //FIXME: what if this system is associated with more than one sso group

//=========== Single Sign On Server ========================
$application['sso_ldap_connection'] = 3; // connection number available for ldap access, see db_conn above

//============== syslog =============================
$application['syslog_enabled'] = FALSE;
$application['syslog_category'] = array(); // what category permitted to be printed out, array() equals all category
$application['syslog_io_engine'] = 'std'; //tcp, file, std
$application['syslog_log_path'] = '/tmp';
$application['syslog_tcp_host'] = 'localhost';
$application['syslog_tcp_port'] = 9777;

//================ soapgateway ========================
$application['wsdl_use_cache'] = false; // use cached wsdl if available
$application['wsdl_cache_path'] = '/path/to/soap/'; // use cached wsdl if available
$application['wsdl_cache_lifetime'] = 60 * 60 * 24 /* one day!*/; // invalidate wsdl cache every x seconds

//================ additional config =====================
$application['company_name'] ="Gamatechno";
$application['application_name'] ="gtEnterprise App Base";
$application['company_address'] ="Jl. Kaliurang Km.5, no.53, Depok, Sleman";
//================Gaji=====================

//================Upload Dir ==============
$application['upload_dir_path'] = "upload_file/";
$application['icon_save_path'] = "files/icons/";
$application['icon_condition_save_path'] = "assets/images/icons/";
$application['employee_save_path'] = "";
$application['transfer_save_path'] = "files/transfer/history/";
$application['identity_history_save_path'] = "files/history/identity/";
$application['education_history_save_path'] = "files/history/history/";
$application['medical_history_save_path'] = "files/history/medical/";
$application['transaction_history_save_path'] = "files/history/transaction/";
$application['master_save_path'] = "files/master/";
$application['account_logo_save_path'] = "files/crm/";
$application['contact_logo_save_path'] = "files/crm/contact/";
$application['vendor_save_path'] = "files/purchasing/master/";
$application['company_save_path'] = "files/reference/company/";
$application['fxa_master_save_path'] = "files/fxa/";
$application['ga_master_save_path'] = "files/ga/";
$application['crm_save_path'] = "files/crm/";
$application['icon_path'] = "assets/images/icons/";
$application['family_save_path'] = "files/family/";
$application['cms_save_path'] = "files/cms/";
$application['aplikan_aktifitas'] = "files/applicant/activity/";
$application['aplikan_akademik'] = "files/applicant/academic/";
$application['aplikan_lampiran'] = "files/applicant/lampiran/";
$application['aplikan_registulang'] = "files/applicant/registulang/";
$application['aplikan_photo'] = "files/employee/";
//$application['aplikan_filedata2'] = move_uploaded_file($_FILES['lam_filedata']['tmp_name'], 'C:/xampp/htdocs/gtfw36cop/files/applicant/registulang/fileupload/filetxt/'.$_FILES['lam_filedata']['name']);

$application['aplikan_filedata'] = "files/applicant/registulang/fileupload/filetxt/";
$application['aplikan_filecari'] = "files/applicant/registulang/fileupload/filetxt/";
$application['aplikan_filetxt'] = "files/applicant/registulang/fileupload/filetxt/";

$application['aplikan_fileaja'] = "C:\\xampp\\htdocs\\gtkms\\bo\\files\\applicant\\registulang\\fileupload\\filetxt\\";


//================Language=====================
$application['language'] = 'id';

$application['send_email'] = true;
$application['asset_usage_send_email'] = true;
$application['asset_usage_send_notification'] = false;

$application['email_sender'] = 'noreply@pertaminafoundation.org';
$application['smtp_host'] = 'mail.pertaminafoundation.org';
$application['smtp_port'] = '2525';
$application['smtp_auth'] = true;
$application['smtp_username'] = 'noreply@pertaminafoundation.org';
$application['smtp_password'] = 'info2015#';

//=================date ref==================
$application['date_time_zone']='Asia/Jakarta'; // see http://php.net/manual/en/timezones.php
date_default_timezone_set($application['date_time_zone']);

$application['autoload_notif'] = false;
?>
