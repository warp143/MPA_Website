#!/usr/bin/env python3
"""
WordPress Nginx + PHP-FPM Server Manager
Automatically manages Nginx and PHP-FPM for WordPress development on port 8000
"""

import os
import sys
import subprocess
import time
import signal
from pathlib import Path

class NginxWordPressServer:
    def __init__(self):
        self.base_dir = Path(__file__).parent
        self.wp_dir = self.base_dir / "mark9_wp"
        self.nginx_conf = self.base_dir / "nginx-wordpress.conf"
        self.nginx_pid_file = self.base_dir / "nginx.pid"
        self.php_fpm_pid_file = self.base_dir / "php-fpm.pid"
        
    def check_port_8000(self):
        """Check if port 8000 is in use"""
        try:
            result = subprocess.run(['lsof', '-ti:8000'], capture_output=True, text=True)
            if result.returncode == 0 and result.stdout.strip():
                return result.stdout.strip().split('\n')
        except:
            pass
        return None
    
    def check_php_fpm_running(self):
        """Check if PHP-FPM is running on port 9000"""
        try:
            result = subprocess.run(['lsof', '-ti:9000'], capture_output=True, text=True)
            return result.returncode == 0 and result.stdout.strip()
        except:
            return False
    
    def start_php_fpm(self):
        """Start PHP-FPM"""
        print("Starting PHP-FPM...")
        try:
            # Stop any existing PHP-FPM
            subprocess.run(['pkill', '-f', 'php-fpm'], 
                         stdout=subprocess.DEVNULL, 
                         stderr=subprocess.DEVNULL)
            time.sleep(1)
            
            # Start PHP-FPM with default config
            result = subprocess.Popen(
                ['php-fpm', '-D'],  # -D to daemonize
                stdout=subprocess.PIPE,
                stderr=subprocess.PIPE,
                text=True
            )
            
            # Wait for PHP-FPM to start
            for i in range(10):
                time.sleep(0.5)
                if self.check_php_fpm_running():
                    print("✓ PHP-FPM started on port 9000")
                    return True
            
            # If failed, check error
            stdout, stderr = result.communicate(timeout=1)
            if stderr:
                print(f"✗ PHP-FPM failed to start: {stderr}")
            else:
                print("✗ PHP-FPM failed to start")
            return False
            
        except Exception as e:
            print(f"✗ Error starting PHP-FPM: {e}")
            return False
    
    def start_nginx(self):
        """Start Nginx"""
        print("Starting Nginx...")
        try:
            # Stop any existing Nginx
            if self.nginx_pid_file.exists():
                try:
                    subprocess.run(['nginx', '-s', 'stop', '-c', str(self.nginx_conf)],
                                 stdout=subprocess.DEVNULL,
                                 stderr=subprocess.DEVNULL)
                except:
                    pass
                time.sleep(1)
            
            # Start Nginx
            result = subprocess.run(
                ['nginx', '-c', str(self.nginx_conf)],
                capture_output=True,
                text=True
            )
            
            if result.returncode == 0:
                time.sleep(1)
                
                # Test if it's working
                test = subprocess.run(['curl', '-I', 'http://localhost:8000'],
                                    capture_output=True,
                                    timeout=5)
                
                if test.returncode == 0:
                    print("✓ Nginx started on port 8000")
                    return True
                else:
                    print("✗ Nginx started but not responding")
                    print(f"Error: {result.stderr}")
                    return False
            else:
                print(f"✗ Failed to start Nginx: {result.stderr}")
                return False
                
        except Exception as e:
            print(f"✗ Error starting Nginx: {e}")
            return False
    
    def stop_all(self):
        """Stop Nginx and PHP-FPM"""
        print("\nStopping services...")
        
        # Stop Nginx
        try:
            if self.nginx_pid_file.exists():
                subprocess.run(['nginx', '-s', 'stop', '-c', str(self.nginx_conf)],
                             stdout=subprocess.DEVNULL,
                             stderr=subprocess.DEVNULL)
                print("✓ Nginx stopped")
        except:
            pass
        
        # Stop PHP-FPM
        try:
            subprocess.run(['pkill', '-f', 'php-fpm'],
                         stdout=subprocess.DEVNULL,
                         stderr=subprocess.DEVNULL)
            print("✓ PHP-FPM stopped")
        except:
            pass
    
    def enable_wordfence(self):
        """Re-enable Wordfence WAF"""
        print("\nEnabling Wordfence...")
        wf_config = self.wp_dir / "wp-content/wflogs/config.php"
        
        if wf_config.exists():
            try:
                content = wf_config.read_text()
                if 'wafStatus";s:8:"disabled"' in content:
                    content = content.replace('wafStatus";s:8:"disabled"', 'wafStatus";s:15:"learning-mode"')
                    wf_config.write_text(content)
                    print("✓ Wordfence WAF enabled in learning mode")
                else:
                    print("✓ Wordfence already enabled")
            except Exception as e:
                print(f"⚠ Could not enable Wordfence: {e}")
    
    def run(self):
        """Main run method"""
        print("WordPress Nginx + PHP-FPM Server Manager")
        print("=" * 50)
        
        # Check WordPress directory
        if not self.wp_dir.exists():
            print(f"✗ WordPress directory not found: {self.wp_dir}")
            return 1
        
        # Check Nginx config
        if not self.nginx_conf.exists():
            print(f"✗ Nginx config not found: {self.nginx_conf}")
            return 1
        
        # Check port 8000
        pids = self.check_port_8000()
        if pids:
            print(f"⚠ Port 8000 in use by process(es): {', '.join(pids)}")
            print("Stopping processes...")
            for pid in pids:
                try:
                    os.kill(int(pid), signal.SIGTERM)
                except:
                    pass
            time.sleep(1)
        
        # Start PHP-FPM
        if not self.start_php_fpm():
            return 1
        
        # Start Nginx
        if not self.start_nginx():
            self.stop_all()
            return 1
        
        # Enable Wordfence
        self.enable_wordfence()
        
        # Success message
        print("\n" + "=" * 50)
        print("✓ WordPress server running successfully!")
        print("=" * 50)
        print(f"\nWordPress URL: http://localhost:8000")
        print(f"Admin URL: http://localhost:8000/wp-admin")
        print(f"\nError log: tail -f {self.wp_dir}/nginx_error.log")
        print(f"Access log: tail -f {self.wp_dir}/nginx_access.log")
        print("\nTo stop: Run this script again and Ctrl+C")
        print("=" * 50)
        
        # Keep running
        try:
            print("\nPress Ctrl+C to stop the server...")
            while True:
                time.sleep(1)
        except KeyboardInterrupt:
            print("\n")
            self.stop_all()
            print("\nServer stopped")
        
        return 0

def main():
    server = NginxWordPressServer()
    return server.run()

if __name__ == "__main__":
    try:
        sys.exit(main())
    except KeyboardInterrupt:
        print("\n\nScript interrupted by user")
        sys.exit(1)
