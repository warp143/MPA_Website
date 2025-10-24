#!/usr/bin/env python3
"""
WordPress Local Development Server Manager
Automatically manages the WordPress PHP development server on port 8000
"""

import os
import sys
import subprocess
import time
import signal
import psutil
from pathlib import Path

def check_port_8000():
    """Check if port 8000 is in use and return the process if found"""
    try:
        # Use lsof to check if port 8000 is in use
        result = subprocess.run(['lsof', '-ti:8000'], capture_output=True, text=True)
        if result.returncode == 0 and result.stdout.strip():
            pid = result.stdout.strip()
            return int(pid)
    except Exception as e:
        print(f"Error checking port 8000: {e}")
    return None

def kill_process(pid):
    """Kill a process by PID"""
    try:
        print(f"Killing process {pid} on port 8000...")
        os.kill(pid, signal.SIGTERM)
        time.sleep(1)
        
        # Check if process is still running
        if psutil.pid_exists(pid):
            print(f"Process {pid} still running, force killing...")
            os.kill(pid, signal.SIGKILL)
            time.sleep(1)
        
        print(f"Process {pid} terminated successfully")
        return True
    except Exception as e:
        print(f"Error killing process {pid}: {e}")
        return False

def start_wordpress():
    """Start WordPress development server"""
    try:
        # Get the absolute path to mark9_wp directory
        current_dir = Path(__file__).parent
        wp_dir = current_dir / "mark9_wp"
        
        if not wp_dir.exists():
            print(f"Error: WordPress directory not found at {wp_dir}")
            return False
        
        print(f"Starting WordPress server from: {wp_dir}")
        print("WordPress will be available at: http://localhost:8000")
        print("Admin setup: http://localhost:8000/wp-admin/install.php")
        print("Press Ctrl+C to stop the server")
        print("-" * 50)
        
        # Change to WordPress directory and start server with better error handling
        os.chdir(wp_dir)
        
        # Start PHP server with better configuration for WordPress
        process = subprocess.Popen(
            ['php', '-S', 'localhost:8000', '-d', 'max_execution_time=300', '-d', 'default_socket_timeout=30'],
            stdout=subprocess.PIPE,
            stderr=subprocess.STDOUT,
            text=True,
            bufsize=1,
            universal_newlines=True
        )
        
        # Monitor the process
        try:
            while True:
                output = process.stdout.readline()
                if output == '' and process.poll() is not None:
                    break
                if output:
                    # Filter out excessive reload messages
                    if not any(x in output for x in ['Closing', 'Accepted', '[200]: GET']):
                        print(output.strip())
        except KeyboardInterrupt:
            print("\n\nStopping WordPress server...")
            process.terminate()
            process.wait()
            print("WordPress server stopped by user")
        
    except KeyboardInterrupt:
        print("\n\nWordPress server stopped by user")
    except Exception as e:
        print(f"Error starting WordPress: {e}")
        return False
    
    return True

def main():
    """Main function to manage WordPress server"""
    print("WordPress Local Development Server Manager")
    print("=" * 50)
    
    # Check if port 8000 is in use
    pid = check_port_8000()
    
    if pid:
        print(f"Port 8000 is in use by process {pid}")
        if kill_process(pid):
            print("Port 8000 is now free")
        else:
            print("Failed to free port 8000")
            return 1
    else:
        print("Port 8000 is free")
    
    # Start WordPress
    print("\nStarting WordPress development server...")
    return start_wordpress()

if __name__ == "__main__":
    try:
        sys.exit(0 if main() else 1)
    except KeyboardInterrupt:
        print("\nScript interrupted by user")
        sys.exit(1)
