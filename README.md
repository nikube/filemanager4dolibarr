# File Manager for Dolibarr

Integrate [TinyFileManager](https://tinyfilemanager.github.io/) file management tool directly into your Dolibarr installation with automatic authentication and comprehensive file management capabilities.

## Features

- **Seamless Integration**: Access TinyFileManager directly from Dolibarr's admin menu
- **Automatic Authentication**: Uses your Dolibarr authentication automatically
- **Security First**: Admin-only access with Dolibarr's authentication system
- **Full Directory Access**: Browse and manage any directory on your server
- **Rich File Operations**: Upload, download, copy, move, delete, create folders
- **File Editing**: Edit text files with syntax highlighting
- **Archive Support**: Create zip archives and extract compressed files
- **File Search**: Search files by name
- **Preview Files**: View images, PDFs, and documents inline
- **Configurable**: Customizable root path, upload size, exclusions, and more

## What is TinyFileManager?

TinyFileManager is a simple, fast and small web-based file manager in a single PHP file. It provides a web interface to browse, upload, edit, and manage files on your server with an intuitive interface.

## Installation

### Prerequisites

- Dolibarr 16.0 or higher
- PHP 5.5 or higher (PHP 7.0+ recommended)
- Administrator access to your Dolibarr installation

### Step 1: Install the Module

#### From ZIP file (recommended)

1. Download the module ZIP file: `module_filemanager4dolibarr-0.1.zip`
2. In Dolibarr, go to **Home → Setup → Modules → Deploy external module**
3. Upload the ZIP file
4. Click "Deploy"

The module includes TinyFileManager 2.6 - no additional downloads required!

#### From source

1. Clone or extract the module to your Dolibarr custom directory:
   ```bash
   cd /path/to/dolibarr/htdocs/custom/
   git clone <repository-url> filemanager4dolibarr
   ```

### Step 2: Enable the Module

1. Log into Dolibarr as an administrator
2. Go to **Home → Setup → Modules**
3. Search for "File Manager for Dolibarr"
4. Click **Activate**

### Step 3: Configure the Module

1. After activation, click **Setup** next to the module
2. Configure your preferences:
   - **Allow Non-Admin Access**: Enable if you want to allow non-admin users (default: No)
   - **Root Path**: Set the root directory for file browsing (default: server document root)
   - **Read-Only Mode**: Enable to prevent file modifications (default: No)
   - **Max Upload Size**: Maximum file upload size in MB (default: 100)
   - **Exclude Items**: Comma-separated list of paths to exclude from browsing
   - **Show Hidden Files**: Show files/folders starting with a dot (default: No)

## Usage

Once the module is enabled:

1. Go to **Home** in Dolibarr's main menu
2. In the left sidebar, you'll see **File Manager**
3. Click on it to access TinyFileManager

You can now:
- Browse directories and files
- Upload files (drag & drop supported)
- Create, rename, and delete files/folders
- Copy and move files
- Edit text files with syntax highlighting
- Download files
- Create zip archives
- Extract compressed files
- Search for files
- Preview images and documents

## Security

- **Admin-Only Access by Default**: Only users with administrator privileges can access File Manager
- **Optional Non-Admin Access**: Can be enabled in module configuration
- **Dolibarr Authentication**: Uses Dolibarr's existing security and session management
- **Configurable Restrictions**: Set root path, read-only mode, and exclude sensitive directories
- **No External Access**: Protected by Dolibarr's login system

## Configuration Options

### Root Path
Set the starting directory for file browsing. Use absolute paths:
- Linux/Mac: `/var/www/html` or `/home/user/documents`
- Windows: `C:\inetpub\wwwroot` or `D:\data`
- Default: Server's document root

### Read-Only Mode
Enable this to prevent any file modifications:
- No uploads
- No deletions
- No file editing
- No folder creation
- Only browsing and downloading allowed

### Exclude Items
Protect sensitive directories by excluding them from browsing. Enter comma-separated relative paths:
```
.git,.svn,node_modules,vendor,conf
```

### Max Upload Size
Set maximum file upload size in megabytes. Note: This is also limited by PHP's `upload_max_filesize` and `post_max_size` settings.

### Show Hidden Files
Enable to show files and folders starting with a dot (`.htaccess`, `.git`, etc.). By default, hidden files are not shown.

## Updating TinyFileManager

This module includes TinyFileManager 2.6. To update to a newer version:

1. Download the latest version from [tinyfilemanager.github.io](https://tinyfilemanager.github.io/)
2. Replace the existing `tinyfilemanager.php` file in `/custom/filemanager4dolibarr/`
3. Replace the `translation.json` file if updated

## Troubleshooting

### Cannot access the menu

- Ensure you're logged in as an administrator (or non-admin access is enabled)
- Check that the module is activated
- Clear your browser cache and refresh

### Permission denied errors

- Check that the PHP process has read/write permissions on the directories you're trying to access
- On Linux: `chmod -R 755 /path/to/directory` and `chown -R www-data:www-data /path/to/directory`
- On Windows: Ensure IIS/Apache user has appropriate NTFS permissions

### Upload fails

- Check PHP's `upload_max_filesize` and `post_max_size` in php.ini
- Ensure the target directory has write permissions
- Check module's Max Upload Size setting

### Cannot see certain directories

- Check if they're in the Exclude Items list
- Ensure the PHP process has permissions to read those directories

## Uninstallation

1. Go to **Home → Setup → Modules**
2. Find "File Manager for Dolibarr"
3. Click **Disable**
4. Optionally, delete the module folder from `/custom/filemanager4dolibarr/`

## Support

For issues, questions, or contributions:
- Check the [Dolibarr documentation](https://wiki.dolibarr.org/)
- Visit [TinyFileManager documentation](https://tinyfilemanager.github.io/)

## License

### Module Code
GPLv3 or (at your option) any later version. See file COPYING for more information.

### TinyFileManager
TinyFileManager is licensed under GNU GPL v3. See [TinyFileManager's license](https://github.com/prasathmani/tinyfilemanager/blob/master/LICENSE) for details.

## Credits

### TinyFileManager Tool
- **Author:** CCP Programmers (prasathmani)
- **Website:** [https://tinyfilemanager.github.io/](https://tinyfilemanager.github.io/)
- **License:** GNU GPL v3
- **Version included:** 2.6

### Dolibarr Integration
- **Developed by:** Anatole Conseil (nz@anatoleconseil.com)
- **License:** GPL v3+
- **Built with:** [Dolibarr Module Builder](https://wiki.dolibarr.org/index.php/Module_builder)

## Changelog

### Version 0.1 (Initial Release)
- Initial integration of TinyFileManager into Dolibarr
- Automatic authentication with Dolibarr
- Admin menu integration
- Configurable root path, read-only mode, and upload size
- Directory exclusion support
- Hidden files toggle
- Security restrictions (admin-only access by default)
- Dolibarr language integration
