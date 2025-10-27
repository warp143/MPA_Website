#!/bin/bash
# ============================================================================
# WordPress Security Monitor - Every 30 Minutes
# ============================================================================
# Created: Oct 28, 2025
# Purpose: Monitor for malware reinfection and suspicious activity
# Interval: 30 minutes
# Log: security_monitor_log.txt
# ============================================================================

LOG_FILE="/Users/amk/Documents/GitHub/MPA_Website/security_monitor_log.txt"
WP_DIR="/Users/amk/Documents/GitHub/MPA_Website/mark9_wp"
BACKUP_DIR="/Users/amk/Documents/GitHub/MPA_Website/backup"

# Color codes for terminal output (not saved to log)
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# ============================================================================
# LOGGING FUNCTIONS
# ============================================================================

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

log_separator() {
    echo "" >> "$LOG_FILE"
    echo "========================================================================" >> "$LOG_FILE"
}

log_header() {
    log_separator
    log "=== $1 ==="
    log_separator
}

# ============================================================================
# MALWARE DETECTION FUNCTIONS
# ============================================================================

scan_elf_perl_malware() {
    log ""
    log "1. SCANNING: ELF/Perl malware files"
    
    cd "$WP_DIR" || exit 1
    MALWARE=$(find wp-content -type f -exec file {} \; 2>/dev/null | grep "ELF\|Perl script" | grep -v "\.pl:" | wc -l | xargs)
    
    if [ "$MALWARE" -eq 0 ]; then
        log "   ✅ CLEAN: 0 ELF/Perl malware files found"
        return 0
    else
        log "   ⚠️ ALERT: $MALWARE malware files detected!"
        log "   --- First 10 malware files ---"
        find wp-content -type f -exec file {} \; 2>/dev/null | grep "ELF\|Perl script" | grep -v "\.pl:" | head -10 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

scan_random_filenames() {
    log ""
    log "2. SCANNING: 8-character random filenames"
    
    cd "$WP_DIR" || exit 1
    RANDOM_FILES=$(find wp-content -type f -regex '.*\/[a-z0-9]{8}$' 2>/dev/null | wc -l | xargs)
    
    if [ "$RANDOM_FILES" -eq 0 ]; then
        log "   ✅ CLEAN: 0 suspicious random filenames"
        return 0
    else
        log "   ⚠️ ALERT: $RANDOM_FILES files with random 8-char names!"
        log "   --- First 10 random filename files ---"
        find wp-content -type f -regex '.*\/[a-z0-9]{8}$' 2>/dev/null | head -10 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

scan_php_backdoors() {
    log ""
    log "3. SCANNING: PHP backdoor patterns"
    
    cd "$WP_DIR" || exit 1
    BACKDOORS=$(find wp-content -name "*.php" -type f -exec grep -l "hex2bin.*POST\|eval.*base64_decode.*POST\|getallheaders.*eval" {} \; 2>/dev/null | wc -l | xargs)
    
    if [ "$BACKDOORS" -eq 0 ]; then
        log "   ✅ CLEAN: 0 PHP backdoor patterns"
        return 0
    else
        log "   ⚠️ ALERT: $BACKDOORS files with backdoor patterns!"
        log "   --- Backdoor files ---"
        find wp-content -name "*.php" -type f -exec grep -l "hex2bin.*POST\|eval.*base64_decode.*POST\|getallheaders.*eval" {} \; 2>/dev/null | head -5 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

scan_file_count() {
    log ""
    log "4. SCANNING: File count changes"
    
    cd "$WP_DIR" || exit 1
    CURRENT_COUNT=$(find wp-content -type f | wc -l | xargs)
    BASELINE=1970
    
    log "   Current: $CURRENT_COUNT files | Baseline: $BASELINE"
    
    if [ "$CURRENT_COUNT" -eq "$BASELINE" ]; then
        log "   ✅ STABLE: File count unchanged"
        return 0
    elif [ "$CURRENT_COUNT" -gt "$BASELINE" ]; then
        DIFF=$((CURRENT_COUNT - BASELINE))
        log "   ⚠️ INCREASED: +$DIFF files (potential malware)"
        return 1
    else
        DIFF=$((BASELINE - CURRENT_COUNT))
        log "   ⚠️ DECREASED: -$DIFF files (files removed)"
        return 1
    fi
}

scan_recent_modifications() {
    log ""
    log "5. SCANNING: Recently modified files (last 30 min)"
    
    cd "$WP_DIR" || exit 1
    RECENT_FILES=$(find wp-content -type f -mmin -30 2>/dev/null | wc -l | xargs)
    
    if [ "$RECENT_FILES" -eq 0 ]; then
        log "   ✅ CLEAN: No unexpected file modifications"
        return 0
    else
        log "   ⚠️ ALERT: $RECENT_FILES files modified in last 30 minutes"
        log "   --- Recently modified files ---"
        find wp-content -type f -mmin -30 -exec ls -lh {} \; 2>/dev/null | head -10 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

scan_php_in_uploads() {
    log ""
    log "6. SCANNING: PHP files in uploads directory"
    
    cd "$WP_DIR" || exit 1
    PHP_UPLOADS=$(find wp-content/uploads -name "*.php" -type f 2>/dev/null | wc -l | xargs)
    
    if [ "$PHP_UPLOADS" -eq 0 ]; then
        log "   ✅ CLEAN: No PHP files in uploads"
        return 0
    else
        log "   ⚠️ ALERT: $PHP_UPLOADS PHP files in uploads directory!"
        log "   --- PHP files in uploads ---"
        find wp-content/uploads -name "*.php" -type f 2>/dev/null | while read line; do
            log "   $line"
        done
        return 1
    fi
}

scan_backup_directory() {
    log ""
    log "7. SCANNING: Backup directory for infected files"
    
    INFECTED_BACKUPS=$(ls -1 "$BACKUP_DIR"/*.zip 2>/dev/null | grep -v "CLEAN" | wc -l | xargs)
    
    if [ "$INFECTED_BACKUPS" -eq 0 ]; then
        log "   ✅ CLEAN: No infected backup files"
        return 0
    else
        log "   ⚠️ ALERT: $INFECTED_BACKUPS potentially infected backup files!"
        log "   --- Infected backups ---"
        ls -lh "$BACKUP_DIR"/*.zip 2>/dev/null | grep -v "CLEAN" | while read line; do
            log "   $line"
        done
        return 1
    fi
}

scan_suspicious_processes() {
    log ""
    log "8. SCANNING: Suspicious processes"
    
    # Check for running ELF processes or perl scripts with random names
    SUSPICIOUS_PROCS=$(ps aux | grep -E "^[a-z]+\s+[0-9]+.*[a-z0-9]{8}" | grep -v "grep" | grep -v "python" | grep -v "StreamingUnzip" | grep -v "Cursor" | wc -l | xargs)
    
    if [ "$SUSPICIOUS_PROCS" -eq 0 ]; then
        log "   ✅ CLEAN: No suspicious processes"
        return 0
    else
        log "   ⚠️ ALERT: $SUSPICIOUS_PROCS potentially suspicious processes"
        log "   --- Suspicious processes ---"
        ps aux | grep -E "^[a-z]+\s+[0-9]+.*[a-z0-9]{8}" | grep -v "grep" | grep -v "python" | grep -v "StreamingUnzip" | grep -v "Cursor" | head -5 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

check_plugin_env_integrity() {
    log ""
    log "9. SCANNING: Python plugin_env directory integrity"
    
    cd "$WP_DIR" || exit 1
    
    if [ ! -d "wp-content/plugins/mpa-image-processor/plugin_env" ]; then
        log "   ✅ CLEAN: plugin_env doesn't exist (or clean install)"
        return 0
    fi
    
    # Check for suspicious files in plugin_env
    SUSPICIOUS_ENV=$(find wp-content/plugins/mpa-image-processor/plugin_env -type f -exec file {} \; 2>/dev/null | grep "ELF\|Perl script" | wc -l | xargs)
    
    if [ "$SUSPICIOUS_ENV" -eq 0 ]; then
        log "   ✅ CLEAN: plugin_env directory clean"
        return 0
    else
        log "   ⚠️ ALERT: $SUSPICIOUS_ENV suspicious files in plugin_env!"
        log "   --- Suspicious files in plugin_env ---"
        find wp-content/plugins/mpa-image-processor/plugin_env -type f -exec file {} \; 2>/dev/null | grep "ELF\|Perl script" | head -5 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

check_twentytwentyfive_theme() {
    log ""
    log "10. SCANNING: twentytwentyfive theme integrity"
    
    cd "$WP_DIR" || exit 1
    
    if [ ! -d "wp-content/themes/twentytwentyfive" ]; then
        log "   ✅ CLEAN: twentytwentyfive theme not present"
        return 0
    fi
    
    # Check for suspicious files in theme
    SUSPICIOUS_THEME=$(find wp-content/themes/twentytwentyfive -type f -exec file {} \; 2>/dev/null | grep "ELF\|Perl script" | wc -l | xargs)
    
    if [ "$SUSPICIOUS_THEME" -eq 0 ]; then
        log "   ✅ CLEAN: twentytwentyfive theme clean"
        return 0
    else
        log "   ⚠️ ALERT: $SUSPICIOUS_THEME suspicious files in twentytwentyfive!"
        log "   --- Suspicious files in theme ---"
        find wp-content/themes/twentytwentyfive -type f -exec file {} \; 2>/dev/null | grep "ELF\|Perl script" | head -5 | while read line; do
            log "   $line"
        done
        return 1
    fi
}

# ============================================================================
# MAIN SCAN FUNCTION
# ============================================================================

run_security_scan() {
    log_header "SECURITY SCAN STARTED"
    log "Scan time: $(date '+%A, %B %d, %Y at %I:%M:%S %p')"
    log "WordPress directory: $WP_DIR"
    log "Backup directory: $BACKUP_DIR"
    
    # Track if any threats found
    THREATS_FOUND=0
    
    # Run all scans
    scan_elf_perl_malware || THREATS_FOUND=1
    scan_random_filenames || THREATS_FOUND=1
    scan_php_backdoors || THREATS_FOUND=1
    scan_file_count || THREATS_FOUND=1
    scan_recent_modifications || THREATS_FOUND=1
    scan_php_in_uploads || THREATS_FOUND=1
    scan_backup_directory || THREATS_FOUND=1
    scan_suspicious_processes || THREATS_FOUND=1
    check_plugin_env_integrity || THREATS_FOUND=1
    check_twentytwentyfive_theme || THREATS_FOUND=1
    
    # Final verdict
    log ""
    log_separator
    if [ "$THREATS_FOUND" -eq 0 ]; then
        log "✅✅✅ VERDICT: SYSTEM COMPLETELY CLEAN ✅✅✅"
    else
        log "⚠️⚠️⚠️ VERDICT: THREATS OR ANOMALIES DETECTED ⚠️⚠️⚠️"
        log "ACTION REQUIRED: Review log and investigate!"
    fi
    log_separator
    log "Next scan in 30 minutes..."
    log ""
}

# ============================================================================
# STARTUP
# ============================================================================

# Create log file if it doesn't exist
touch "$LOG_FILE"

log ""
log "=========================================================================="
log "🛡️  SECURITY MONITORING SYSTEM STARTED"
log "=========================================================================="
log "Start time: $(date '+%A, %B %d, %Y at %I:%M:%S %p')"
log "Scan interval: Every 30 minutes"
log "Log file: $LOG_FILE"
log "Monitoring: $WP_DIR"
log "=========================================================================="
log ""

# ============================================================================
# MAIN LOOP
# ============================================================================

while true; do
    run_security_scan
    sleep 1800  # 30 minutes = 1800 seconds
done

