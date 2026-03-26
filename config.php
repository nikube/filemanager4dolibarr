<?php
/*
#################################################################################################################
TinyFileManager Configuration for Dolibarr Module

This configuration file allows you to customize TinyFileManager settings beyond what's available
in the Dolibarr module setup interface.

IMPORTANT:
- This file is OPTIONAL - all basic settings are configured through Dolibarr module setup
- Settings here will OVERRIDE the Dolibarr module configuration
- Be careful when modifying these settings

How to use:
1. Uncomment the settings you want to customize
2. Save the file
3. Clear your browser cache and reload the File Manager

For Dolibarr module setup, go to: Home → Setup → Modules → File Manager → Setup
#################################################################################################################
*/

// === USER-SPECIFIC DIRECTORIES ===
// Map Dolibarr users to specific root directories
// When a user logs in, they will only see their assigned directory
// This overrides the global $root_path setting

// Example configuration:
// $directories_users = array(
//     'admin' => '/var/www/documents',           // Admin sees all documents
//     'john' => '/var/www/documents/users/john', // John sees only his folder
//     'accounting' => '/var/www/documents/accounting' // Accounting team folder
// );

// Default: empty (all users see the same root_path configured in Dolibarr)
// $directories_users = array();


// === READONLY USERS ===
// Dolibarr users who can only view/download files (no edit/upload/delete)
// Example:
// $readonly_users = array('guest', 'viewer', 'auditor');

// Default: empty (all users have same permissions based on Dolibarr module config)
// $readonly_users = array();


// === FILE EXTENSION RESTRICTIONS ===
// Limit which file types can be created/renamed
// Leave empty to allow all extensions (default)
// Example:
// $allowed_file_extensions = 'txt,html,css,js,php,json,xml,md';

// Default: empty (all extensions allowed)
// $allowed_file_extensions = '';


// === UPLOAD EXTENSION RESTRICTIONS ===
// Limit which file types can be uploaded
// Leave empty to allow all extensions (default)
// Example:
// $allowed_upload_extensions = 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip';

// Default: empty (all extensions allowed)
// $allowed_upload_extensions = '';


// === DATE/TIME SETTINGS ===
// Customize date/time display format and timezone

// Date format for file modification times
// See: https://www.php.net/manual/en/datetime.format.php
// Examples:
//   'd/m/Y H:i:s' => 24/01/2025 14:30:00
//   'm/d/Y g:i A' => 01/24/2025 2:30 PM
//   'Y-m-d H:i' => 2025-01-24 14:30
// $datetime_format = 'd/m/Y H:i:s';

// Timezone for date/time display
// See: http://php.net/manual/en/timezones.php
// Examples: 'Europe/Paris', 'America/New_York', 'Asia/Tokyo', 'UTC'
// $default_timezone = 'Europe/Paris';


// === DISPLAY SETTINGS ===

// Path display mode when viewing file information
// Options:
//   'full' => Show complete path from root (default)
//   'relative' => Show path relative to root_path
//   'host' => Show full server path
// $path_display_mode = 'full';

// Syntax highlighting theme for code editor
// Popular themes: 'vs', 'github', 'monokai', 'atom-one-dark', 'dracula'
// See: https://highlightjs.org/static/demo/
// $highlightjs_style = 'vs';

// Favicon (icon shown in browser tab)
// Can be full URL or relative path
// $favicon_path = '/custom/filemanager4dolibarr/img/favicon.png';


// === SECURITY SETTINGS ===

// IP address restrictions
// Useful for restricting access to specific networks
// Note: Users still need valid Dolibarr authentication

// IP restriction mode
// Options: 'OFF', 'AND', 'OR'
//   'OFF' => No IP restrictions (default)
//   'AND' => IP must be on whitelist AND not on blacklist
//   'OR' => IP must be on whitelist OR not on blacklist
// $ip_ruleset = 'OFF';

// Show message to blocked IPs?
// $ip_silent = false;

// IP whitelist (only these IPs allowed)
// Supports wildcards: '192.168.1.*' or CIDR: '192.168.1.0/24'
// Example:
// $ip_whitelist = array('127.0.0.1', '::1', '192.168.1.*', '10.0.0.0/8');
// $ip_whitelist = array();

// IP blacklist (these IPs are blocked)
// $ip_blacklist = array('0.0.0.0', '::');


// === ADVANCED SETTINGS ===

// Encoding for filename conversions
// $iconv_input_encoding = 'UTF-8';

// Chunk size for file uploads (in bytes)
// Smaller chunks help with large files and slow connections
// Default: 2MB (2000000 bytes)
// $upload_chunk_size_bytes = 2 * 1024 * 1024;

// Online document viewer
// Options: 'google', 'microsoft', false
//   'google' => Use Google Docs Viewer (default)
//   'microsoft' => Use Microsoft Office Online
//   false => Disable online viewer
// $online_viewer = 'google';

// Enable sticky navigation bar
// $sticky_navbar = true;

// File permissions for newly created files (octal notation)
// $chmod_file = 0644;

// Directory permissions for newly created folders (octal notation)
// $chmod_dir = 0755;


// === OVERRIDE DOLIBARR MODULE SETTINGS (NOT RECOMMENDED) ===
// These settings are managed through Dolibarr module setup
// Only uncomment if you absolutely need to override

// Override root path from Dolibarr config
// $root_path = '/var/www/custom-path';

// Override readonly mode from Dolibarr config
// $global_readonly = true;

// Override excluded items from Dolibarr config
// $exclude_items = array('.git', '.svn', 'vendor', 'node_modules', 'conf');

// Override max upload size from Dolibarr config (in bytes)
// $max_upload_size_bytes = 100 * 1024 * 1024; // 100 MB

?>
