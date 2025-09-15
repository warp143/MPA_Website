# Server Access Guide - Proptech.org.my

## Server Information
- **Server**: smaug.cygnusdns.com
- **OS**: Ubuntu 20.04.6 LTS
- **IP Address**: 103.152.12.27
- **Username**: proptech
- **Password**: D!~EzNB$KHbE

## SSH Access Instructions

### Method 1: Direct SSH with Password
```bash
ssh proptech@smaug.cygnusdns.com
```
When prompted, enter the password: `D!~EzNB$KHbE`

### Method 2: SSH with Key Authentication (Recommended)
If you want to use the SSH keys from your local project:

1. **Copy your public key to the server** (if not already done):
```bash
ssh-copy-id -i /Users/amk/Documents/GitHub/MPA_Website/id_rsa.pub proptech@smaug.cygnusdns.com
```

2. **Connect using the private key**:
```bash
ssh -i /Users/amk/Documents/GitHub/MPA_Website/id_rsa proptech@smaug.cygnusdns.com
```

## Server Directory Structure

### Main Directories
- **Home Directory**: `/home/proptech/`
- **Web Root**: `/home/proptech/public_html/`
- **Main Website**: `/home/proptech/public_html/proptech.org.my/`
- **Test Environment**: `/home/proptech/public_html/proptech.org.my/test/`

### Key Files and Directories
```
/home/proptech/
├── public_html/
│   └── proptech.org.my/          # Main WordPress installation
│       ├── wp-admin/             # WordPress admin
│       ├── wp-content/           # Themes, plugins, uploads
│       ├── wp-config.php         # WordPress configuration
│       └── test/                 # Test/staging environment
├── backup-*.tar.gz              # Server backups
├── .ssh/                        # SSH keys
└── logs/                        # Server logs
```

## Test Project Access

### Web Access
- **Test Site URL**: https://proptech.org.my/test/
- **Test Admin URL**: https://proptech.org.my/test/wp-admin/
- **Test Admin Login**: https://proptech.org.my/test/wp-admin/index.php

### File System Access
The test project is located at:
```bash
/home/proptech/public_html/proptech.org.my/test/
```

### Navigating to Test Project via SSH
```bash
# Connect to server
ssh proptech@smaug.cygnusdns.com

# Navigate to test directory
cd public_html/proptech.org.my/test/

# List contents
ls -la
```

## WordPress Management

### WP-CLI Commands
The server has WP-CLI installed. You can manage WordPress from command line:

```bash
# Navigate to WordPress directory
cd public_html/proptech.org.my/

# Check WordPress status
wp core version

# List plugins
wp plugin list

# Update WordPress
wp core update
```

### Database Access
WordPress database credentials are in `/home/proptech/public_html/proptech.org.my/wp-config.php`

## Backup Information

### Available Backups
- `backup-8.10.2025_16-49-14_proptech.tar.gz` (4.9GB) - August 2025
- `backup-9.14.2024_05-58-54_proptech.tar.gz` (3.7GB) - September 2024

### Creating New Backups
```bash
# Create a backup of the current site
tar -czf backup-$(date +%m.%d.%Y_%H-%M-%S)_proptech.tar.gz public_html/
```

## Security Notes

- The server has Wordfence security plugin installed
- SSH keys are available in `/home/proptech/.ssh/`
- Server has Imunify security patches applied
- SSL certificates are managed through cPanel

## Troubleshooting

### Common Issues
1. **Permission Denied**: Check file permissions with `ls -la`
2. **WordPress Issues**: Check error logs in `/home/proptech/logs/`
3. **Database Connection**: Verify wp-config.php settings

### Useful Commands
```bash
# Check disk usage
df -h

# Check running processes
ps aux | grep php

# Check Apache status
systemctl status apache2

# View recent logs
tail -f /home/proptech/logs/error_log
```

## cPanel Access
- **cPanel URL**: https://smaug.cygnusdns.com:2083
- **Username**: proptech
- **Password**: D!~EzNB$KHbE

## Local Development Connection
If you want to connect your local development environment to this server, you can use the `host_9_wp.py` script in your project root, which manages a local WordPress development server on port 8000.

---

**Last Updated**: September 15, 2025
**Server Status**: Active (Ubuntu 20.04.6 LTS)
**Disk Usage**: 75% (352GB/494GB used)
