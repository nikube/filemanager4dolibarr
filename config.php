<?php
//Default Configuration
// Language is auto-detected from Dolibarr — DO NOT hardcode here, TFM will overwrite line 3 but the real lang comes from the block below
//
// Filemanager4Dolibarr — Auto-detect language from Dolibarr
// This block runs when config.php is included by TinyFileManager, after $langs is set by the index file
if (isset($langs) && is_object($langs) && !empty($langs->defaultlang)) {
	$_dolibarr_to_tfm = array(
		'fr_FR' => 'fr', 'es_ES' => 'es', 'de_DE' => 'de', 'it_IT' => 'it',
		'pt_PT' => 'pt_PT', 'pt_BR' => 'pt_BR', 'nl_NL' => 'nl', 'pl_PL' => 'pl',
		'ro_RO' => 'ro', 'ru_RU' => 'ru', 'cs_CZ' => 'cz', 'sk_SK' => 'sk',
		'sl_SI' => 'sl', 'hu_HU' => 'hu', 'el_GR' => 'gr', 'tr_TR' => 'tr',
		'da_DK' => 'da', 'nb_NO' => 'no', 'fi_FI' => 'fi', 'sv_SE' => 'no',
		'ja_JP' => 'ja', 'ko_KR' => 'ko', 'zh_CN' => 'zh-CN', 'zh_TW' => 'zh-TW',
		'th_TH' => 'th', 'vi_VN' => 'vi', 'id_ID' => 'id', 'ar_SA' => 'Ar',
		'fa_IR' => 'Fa', 'he_IL' => 'he', 'bn_BD' => 'bn', 'ca_ES' => 'ca',
		'gl_ES' => 'gl', 'mn_MN' => 'mn_MN',
	);
	$_tfm_lang = $_dolibarr_to_tfm[$langs->defaultlang] ?? 'en';
	// Override $CONFIG with correct Dolibarr language
	$CONFIG = json_encode(array(
		'lang' => $_tfm_lang,
		'error_reporting' => false,
		'show_hidden' => true,
		'hide_Cols' => false,
		'theme' => 'light'
	));
	unset($_dolibarr_to_tfm, $_tfm_lang);
}
//
// === Additional settings (uncomment to use) ===
//
// === USER-SPECIFIC DIRECTORIES ===
// $directories_users = array(
//     'admin' => '/var/www/documents',
//     'john' => '/var/www/documents/users/john',
// );

// === READONLY USERS ===
// $readonly_users = array('guest', 'viewer');

// === FILE EXTENSION RESTRICTIONS ===
// $allowed_file_extensions = 'txt,html,css,js,php,json,xml,md';
// $allowed_upload_extensions = 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip';

// === DATE/TIME SETTINGS ===
// $datetime_format = 'd/m/Y H:i:s';
// $default_timezone = 'Europe/Paris';

// === DISPLAY SETTINGS ===
// $path_display_mode = 'full';
// $highlightjs_style = 'vs';

// === SECURITY SETTINGS ===
// $ip_ruleset = 'OFF';
// $ip_whitelist = array('127.0.0.1', '::1');
// $ip_blacklist = array('0.0.0.0', '::');

// === ADVANCED SETTINGS ===
// $upload_chunk_size_bytes = 2 * 1024 * 1024;
// $online_viewer = 'google';
// $sticky_navbar = true;
