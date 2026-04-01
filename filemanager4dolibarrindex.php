<?php
/* Copyright (C) 2025 Anatole Conseil
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       filemanager4dolibarr/filemanager4dolibarrindex.php
 *	\ingroup    filemanager4dolibarr
 *	\brief      TinyFileManager for Dolibarr - Secure wrapper with auto-login
 */

// Disable CSRF check - TinyFileManager sends POST requests without Dolibarr's token.
// Authentication is still enforced via Dolibarr session below.
if (!defined('NOCSRFCHECK')) {
	define('NOCSRFCHECK', '1');
}

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME'];
$tmp2 = realpath(__FILE__);
$i = strlen($tmp) - 1;
$j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

/**
 * @var Conf $conf
 * @var DoliDB $db
 * @var User $user
 */

// Load translation files required by the page
$langs->loadLangs(array("filemanager4dolibarr@filemanager4dolibarr", "admin"));

// Security check - Check if user has permission
// Either user is admin OR non-admin access is enabled via configuration
if (empty($user->admin) && !getDolGlobalInt('FILEMANAGER4DOLIBARR_ALLOW_NON_ADMIN')) {
	accessforbidden('Administrator access required (or enable non-admin access in module configuration)');
}

if (!isModEnabled('filemanager4dolibarr')) {
	accessforbidden('Module not enabled');
}

// Check if tinyfilemanager file exists
$tfm_file = __DIR__ . '/tinyfilemanager.php';
if (!file_exists($tfm_file)) {
	llxHeader("", $langs->trans("Filemanager4DolibarrArea"));
	print '<div class="error">';
	print $langs->trans("FilemanagerFileNotFound") . ': tinyfilemanager.php';
	print '</div>';
	llxFooter();
	exit;
}

/*
 * Configuration for TinyFileManager
 */

// === AUTHENTICATION ===
// Use FM_EMBED mode to disable TFM authentication completely
// This tells TFM we're embedding it in another application (Dolibarr)
// and that authentication is handled externally
define('FM_EMBED', true);

// TFM still requires $use_auth to be set
$use_auth = false;

// Empty auth_users array (not needed when FM_EMBED is true)
$auth_users = array();

// Set TFM session with Dolibarr user's login for user-specific directories
// This allows TFM to map the user to their specific directory
if (!defined('FM_SESSION_ID')) {
	define('FM_SESSION_ID', 'filemanager');
}
if (!isset($_SESSION[FM_SESSION_ID])) {
	$_SESSION[FM_SESSION_ID] = array();
}
// Use Dolibarr user login for directory mapping
$_SESSION[FM_SESSION_ID]['logged'] = $user->login;

// === USER-SPECIFIC DIRECTORIES ===
// Parse user directory mapping from Dolibarr configuration
// Format: username1:/path/to/dir1,username2:/path/to/dir2
$directories_users = array();
$user_dir_config = getDolGlobalString('FILEMANAGER4DOLIBARR_USER_DIRECTORIES');
if (!empty($user_dir_config)) {
	$mappings = explode(',', $user_dir_config);
	foreach ($mappings as $mapping) {
		$parts = explode(':', trim($mapping), 2);
		if (count($parts) == 2) {
			$username = trim($parts[0]);
			$path = trim($parts[1]);
			if (!empty($username) && !empty($path)) {
				if (isset($directories_users[$username])) {
					if (!is_array($directories_users[$username])) {
						$directories_users[$username] = array($directories_users[$username]);
					}
					$directories_users[$username][] = $path;
				} else {
					$directories_users[$username] = $path;
				}
			}
		}
	}
}

// === READONLY USERS ===
// Parse readonly users from Dolibarr configuration
// Format: user1,user2,user3
$readonly_users = array();
$readonly_config = getDolGlobalString('FILEMANAGER4DOLIBARR_READONLY_USERS');
if (!empty($readonly_config)) {
	$readonly_users = array_map('trim', explode(',', $readonly_config));
}

// === ROOT PATH ===
// Set root path - Full server access (no restrictions)
$root_path = getDolGlobalString('FILEMANAGER4DOLIBARR_ROOT_PATH');
if (empty($root_path)) {
	// Default: Dolibarr documents root
	$root_path = $conf->file->dir_documents;
}

// Fallback if configured path is invalid or suspicious (like /root)
if (empty($root_path) || strpos($root_path, '/root') !== false || !is_dir($root_path)) {
	// Try standard location relative to web root
	$candidate = realpath(DOL_DOCUMENT_ROOT . '/../documents');
	if ($candidate && is_dir($candidate)) {
		$root_path = $candidate;
	}
}

// Expand to parent directory (to include html, scripts, etc.)
if (!empty($root_path) && is_dir($root_path)) {
	$parent = dirname($root_path);
	if (is_dir($parent) && is_readable($parent)) {
		$root_path = $parent;
	}
}

// DEBUG: Remove after fixing






// === ROOT URL ===
$root_url = '';
$http_host = $_SERVER['HTTP_HOST'];

// === READONLY MODE ===
$global_readonly = getDolGlobalInt('FILEMANAGER4DOLIBARR_READONLY_MODE') ? true : false;

// === FILE EXTENSIONS ===
// Allow all file extensions by default
$allowed_file_extensions = '';
$allowed_upload_extensions = '';

// === UPLOAD SIZE ===
$max_upload_size_mb = getDolGlobalInt('FILEMANAGER4DOLIBARR_MAX_UPLOAD_SIZE');
if ($max_upload_size_mb > 0) {
	$max_upload_size_bytes = $max_upload_size_mb * 1024 * 1024;
} else {
	$max_upload_size_bytes = 5000000000; // 5GB default
}

// === EXCLUDED ITEMS ===
// User can configure excluded folders
$exclude_config = getDolGlobalString('FILEMANAGER4DOLIBARR_EXCLUDE_ITEMS');
if (!empty($exclude_config)) {
	$exclude_items = array_map('trim', explode(',', $exclude_config));
} else {
	$exclude_items = array(); // No exclusions by default - full access
}

// === EDITOR SETTINGS ===
$edit_files = true; // Enable code editor
$use_highlightjs = true; // Enable syntax highlighting
$highlightjs_style = 'vs'; // Editor theme

// === OTHER SETTINGS ===
$default_timezone = 'UTC';
$datetime_format = 'm/d/Y g:i A';
$path_display_mode = 'full';
$online_viewer = 'google'; // Google Docs viewer
$sticky_navbar = true;
$upload_chunk_size_bytes = 2000000; // 2MB chunks
$ip_ruleset = 'OFF'; // No IP restrictions - managed by Dolibarr
$favicon_path = '';

// === TRANSLATION ===
// Map Dolibarr language to TinyFileManager language code (33 languages supported)
$dolibarr_to_tfm = array(
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
$lang_config = $dolibarr_to_tfm[$langs->defaultlang] ?? 'en';

$CONFIG = json_encode(array(
	'lang' => $lang_config,
	'error_reporting' => false,
	'show_hidden' => true, // Always show hidden files (.htaccess, .html, etc.)
	'hide_Cols' => false,
	'theme' => 'light'
));

// Include TinyFileManager
// All configuration variables above will be used by TinyFileManager
include $tfm_file;

// Inject "Back to Dolibarr" button into TFM navbar (no modification to upstream tinyfilemanager.php)
$dolibarr_url = DOL_URL_ROOT;
echo '<script>
document.addEventListener("DOMContentLoaded", function() {
	var nav = document.querySelector(".main-nav .navbar-nav");
	if (nav) {
		var li = document.createElement("li");
		li.className = "nav-item";
		li.innerHTML = \'<a class="nav-link" href="' . dol_escape_js($dolibarr_url) . '" title="Dolibarr"><i class="fa fa-arrow-left"></i> Dolibarr</a>\';
		nav.insertBefore(li, nav.firstChild);
	}
});
</script>';
