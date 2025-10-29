#!/bin/bash
# ============================================================================
# SECURITY PHASES IMPLEMENTATION SCRIPT
# PropTech.org.my - Automated Security Upgrade
# Target: 88/100 → 100/100
# ============================================================================

set -e  # Exit on error

echo "🔒 PropTech.org.my Security Implementation"
echo "=========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if running on server
if [[ ! -d ~/public_html/proptech.org.my ]]; then
    echo -e "${RED}❌ Error: Must run this script on the PropTech server${NC}"
    echo "SSH into server first: ssh -i ssh/proptech_mpa_new proptech@smaug.cygnusdns.com"
    exit 1
fi

echo -e "${GREEN}✅ Running on PropTech server${NC}"
echo ""

# ============================================================================
# BACKUP FIRST
# ============================================================================

BACKUP_DIR=~/backups/security_upgrade_$(date +%Y%m%d_%H%M%S)
echo "📦 Creating backup in: $BACKUP_DIR"
mkdir -p "$BACKUP_DIR"

cd ~/public_html/proptech.org.my

# Backup critical files
cp wp-content/plugins/mpa-image-processor/mpa-image-processor-plugin.php "$BACKUP_DIR/"
cp wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater.php "$BACKUP_DIR/"
cp wp-content/themes/mpa-custom/functions.php "$BACKUP_DIR/"
cp wp-config.php "$BACKUP_DIR/"
cp .htaccess "$BACKUP_DIR/"

echo -e "${GREEN}✅ Backup completed${NC}"
echo ""

# ============================================================================
# PHASE 1: QUICK WINS
# ============================================================================

echo "🎯 PHASE 1: Quick Wins (88 → 91/100)"
echo "======================================"

read -p "Continue with Phase 1? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Skipping Phase 1"
else
    echo "Phase 1.1: Adding file validation to image processor..."
    
    # Check if already applied
    if grep -q "Enhanced File Type Validation" wp-content/plugins/mpa-image-processor/mpa-image-processor-plugin.php; then
        echo -e "${YELLOW}⚠️  Phase 1.1 already applied${NC}"
    else
        echo -e "${RED}⚠️  Manual edit required for Phase 1.1${NC}"
        echo "   Edit: wp-content/plugins/mpa-image-processor/mpa-image-processor-plugin.php"
        echo "   See: SECURITY_IMPLEMENTATION_GUIDE.md Section 1.1"
    fi
    
    echo ""
    echo "Phase 1.2: Updating SQL queries in event updater..."
    
    if grep -q "wpdb->prepare" wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater.php; then
        echo -e "${YELLOW}⚠️  Phase 1.2 already applied${NC}"
    else
        echo -e "${RED}⚠️  Manual edit required for Phase 1.2${NC}"
        echo "   Edit: wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater.php"
        echo "   See: SECURITY_IMPLEMENTATION_GUIDE.md Section 1.2"
    fi
    
    echo -e "${GREEN}✅ Phase 1 review completed${NC}"
fi

echo ""

# ============================================================================
# PHASE 2: RATE LIMITING
# ============================================================================

echo "🎯 PHASE 2: Rate Limiting (91 → 95/100)"
echo "=========================================="

read -p "Continue with Phase 2? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Skipping Phase 2"
else
    echo "Phase 2: Adding rate limiting and session timeout..."
    
    if grep -q "PHASE 2" wp-content/themes/mpa-custom/functions.php; then
        echo -e "${YELLOW}⚠️  Phase 2 already applied${NC}"
    else
        echo -e "${RED}⚠️  Manual edit required for Phase 2${NC}"
        echo "   Edit: wp-content/themes/mpa-custom/functions.php"
        echo "   See: SECURITY_IMPLEMENTATION_GUIDE.md Section 2.1 & 2.2"
    fi
    
    echo -e "${GREEN}✅ Phase 2 review completed${NC}"
fi

echo ""

# ============================================================================
# PHASE 3: SECRETS MANAGEMENT
# ============================================================================

echo "🎯 PHASE 3: Secrets Management (95 → 100/100)"
echo "==============================================="

read -p "Continue with Phase 3? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Skipping Phase 3"
else
    # Phase 3.1: Create .env file
    echo "Phase 3.1: Creating .env file..."
    
    if [[ -f .env ]]; then
        echo -e "${YELLOW}⚠️  .env file already exists${NC}"
        read -p "Overwrite? (y/n) " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            echo "Keeping existing .env"
        else
            mv .env .env.backup_$(date +%Y%m%d_%H%M%S)
            echo "Backed up existing .env"
        fi
    fi
    
    if [[ ! -f .env ]]; then
        cat > .env << 'ENVFILE'
# Database Configuration
DB_NAME=proptech_wp_vpwr5
DB_USER=proptech_wp_zns32
DB_PASSWORD=$LGMY#0DhF4QeH03
DB_HOST=localhost
DB_CHARSET=utf8mb4
DB_COLLATE=

# WordPress Security Keys (REPLACE THESE!)
AUTH_KEY='put your unique phrase here'
SECURE_AUTH_KEY='put your unique phrase here'
LOGGED_IN_KEY='put your unique phrase here'
NONCE_KEY='put your unique phrase here'
AUTH_SALT='put your unique phrase here'
SECURE_AUTH_SALT='put your unique phrase here'
LOGGED_IN_SALT='put your unique phrase here'
NONCE_SALT='put your unique phrase here'

# WordPress Configuration
WP_DEBUG=false
WP_DEBUG_LOG=false
WP_DEBUG_DISPLAY=false
ENVFILE

        chmod 600 .env
        echo -e "${GREEN}✅ .env file created with secure permissions${NC}"
        echo -e "${YELLOW}⚠️  IMPORTANT: Generate new security keys!${NC}"
        echo "   Run: curl -s https://api.wordpress.org/secret-key/1.1/salt/"
        echo "   Then edit .env and replace the 'put your unique phrase here' lines"
    fi
    
    echo ""
    
    # Phase 3.2: Update wp-config.php
    echo "Phase 3.2: Checking wp-config.php..."
    
    if grep -q "PHASE 3.2" wp-config.php; then
        echo -e "${YELLOW}⚠️  wp-config.php already updated${NC}"
    else
        echo -e "${RED}⚠️  Manual edit required for wp-config.php${NC}"
        echo "   Edit: wp-config.php"
        echo "   See: SECURITY_IMPLEMENTATION_GUIDE.md Section 3.2"
    fi
    
    echo ""
    
    # Phase 3.3: Protect .env in .htaccess
    echo "Phase 3.3: Protecting .env file in .htaccess..."
    
    if grep -q "PHASE 3.3" .htaccess; then
        echo -e "${YELLOW}⚠️  .htaccess already protected${NC}"
    else
        echo "Updating .htaccess..."
        
        # Create temporary file with protection rules
        cat > .htaccess.new << 'HTACCESS'
# ============================================================================
# ✅ PHASE 3.3: PROTECT SENSITIVE FILES
# ============================================================================

# Deny access to .env file
<Files .env>
    Order allow,deny
    Deny from all
</Files>

# Deny access to wp-config.php
<Files wp-config.php>
    Order allow,deny
    Deny from all
</Files>

# Deny access to error logs
<Files error_log>
    Order allow,deny
    Deny from all
</Files>

# Deny access to .git directory
<DirectoryMatch "\.git">
    Order allow,deny
    Deny from all
</DirectoryMatch>

# ============================================================================

HTACCESS

        # Prepend to existing .htaccess
        cat .htaccess >> .htaccess.new
        mv .htaccess .htaccess.backup_$(date +%Y%m%d_%H%M%S)
        mv .htaccess.new .htaccess
        
        echo -e "${GREEN}✅ .htaccess updated${NC}"
    fi
    
    echo ""
    
    # Phase 3.4: CSP Headers
    echo "Phase 3.4: Checking security headers..."
    
    if grep -q "PHASE 3.4" wp-content/themes/mpa-custom/functions.php; then
        echo -e "${YELLOW}⚠️  Security headers already added${NC}"
    else
        echo -e "${RED}⚠️  Manual edit required for security headers${NC}"
        echo "   Edit: wp-content/themes/mpa-custom/functions.php"
        echo "   See: SECURITY_IMPLEMENTATION_GUIDE.md Section 3.4"
    fi
    
    echo -e "${GREEN}✅ Phase 3 review completed${NC}"
fi

echo ""

# ============================================================================
# VERIFICATION
# ============================================================================

echo "🔍 VERIFICATION"
echo "==============="
echo ""

echo "Testing website..."
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://proptech.org.my)
if [[ $HTTP_CODE == "200" ]]; then
    echo -e "${GREEN}✅ Website is accessible (HTTP $HTTP_CODE)${NC}"
else
    echo -e "${RED}❌ Website returned HTTP $HTTP_CODE${NC}"
fi

echo ""

if [[ -f .env ]]; then
    echo "Testing .env protection..."
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" https://proptech.org.my/.env)
    if [[ $HTTP_CODE == "403" ]]; then
        echo -e "${GREEN}✅ .env file is protected (HTTP $HTTP_CODE)${NC}"
    else
        echo -e "${RED}❌ .env file is NOT protected (HTTP $HTTP_CODE)${NC}"
    fi
else
    echo -e "${YELLOW}⚠️  .env file not created yet${NC}"
fi

echo ""

echo "Testing security headers..."
if curl -s -I https://proptech.org.my | grep -q "X-Frame-Options"; then
    echo -e "${GREEN}✅ Security headers are active${NC}"
else
    echo -e "${YELLOW}⚠️  Security headers not detected${NC}"
fi

echo ""

# ============================================================================
# SUMMARY
# ============================================================================

echo "📊 IMPLEMENTATION SUMMARY"
echo "=========================="
echo ""
echo "Backup location: $BACKUP_DIR"
echo ""
echo "Manual edits required:"
echo "  1. wp-content/plugins/mpa-image-processor/mpa-image-processor-plugin.php"
echo "  2. wp-content/plugins/mpa-event-status-updater/mpa-event-status-updater.php"
echo "  3. wp-content/themes/mpa-custom/functions.php (2 sections)"
echo "  4. wp-config.php"
echo "  5. Generate new WordPress security keys for .env"
echo ""
echo "See SECURITY_IMPLEMENTATION_GUIDE.md for detailed instructions"
echo ""
echo -e "${GREEN}✅ Script completed${NC}"
echo ""
echo "Next steps:"
echo "  1. Complete manual edits (see guide)"
echo "  2. Generate and update security keys in .env"
echo "  3. Test all functionality"
echo "  4. Monitor error logs: tail -f wp-content/debug.log"
echo ""
echo "🎉 Target: 100/100 Perfect Security!"

