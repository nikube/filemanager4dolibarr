# Changelog

All notable changes to the File Manager for Dolibarr module will be documented in this file.

## [0.1] - 2025

### Added
- Initial release of File Manager for Dolibarr
- Integration of TinyFileManager 2.6 into Dolibarr
- Automatic authentication using Dolibarr credentials
- Admin menu integration
- Configuration options:
  - Allow non-admin access setting
  - Configurable root path for file browsing
  - Read-only mode to prevent modifications
  - Maximum upload size configuration (in MB)
  - Directory/file exclusion support
  - Show/hide hidden files toggle
- Full TinyFileManager features:
  - Browse files and directories
  - Upload files (with drag & drop support)
  - Create, rename, delete files and folders
  - Copy and move files
  - Edit text files with syntax highlighting
  - Download files
  - Create zip archives
  - Extract compressed files
  - Search files by name
  - Preview images and documents inline
- Security features:
  - Admin-only access by default
  - Integration with Dolibarr authentication
  - Configurable directory restrictions
- Multilingual support (English and French)
- About page with credits and information
- Comprehensive documentation (README.md)

### Security
- Module uses Dolibarr's authentication system
- Access restricted to administrators by default
- Optional non-admin access can be enabled in configuration
- Directory exclusion to protect sensitive files
- Read-only mode for safe browsing

## Future Enhancements
- User-specific directory isolation
- Per-user file operation permissions
- Integration with Dolibarr's document management
- File version history
- Advanced search capabilities
