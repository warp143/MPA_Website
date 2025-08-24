#!/usr/bin/env python3
"""
Local HTTP Server for MPA Website
Hosts the mark9 directory on port 1739
"""

import http.server
import socketserver
import os
import sys
import subprocess
import time
import signal
import threading
import stat
from pathlib import Path

def check_and_kill_port(port):
    """Check if port is in use and kill the process if found"""
    try:
        # Check if port is in use
        result = subprocess.run(['lsof', '-ti', f':{port}'], 
                              capture_output=True, text=True)
        
        if result.returncode == 0 and result.stdout.strip():
            # Port is in use, get the PID
            pid = result.stdout.strip()
            print(f"⚠️  Port {port} is in use by process {pid}")
            print(f"🔄 Killing process {pid}...")
            
            # Kill the process with sudo using password
            password = "VdLiEwQHQxHwqu"
            kill_cmd = f'echo "{password}" | sudo -S kill -9 {pid}'
            subprocess.run(kill_cmd, shell=True, check=True)
            print(f"✅ Process {pid} killed successfully")
            
            # Wait for the port to be released (TCP TIME_WAIT can take up to 60 seconds)
            print("⏳ Waiting for port to be released...")
            for attempt in range(10):  # Try for up to 10 seconds
                time.sleep(1)
                result = subprocess.run(['lsof', '-ti', f':{port}'], 
                                      capture_output=True, text=True)
                if result.returncode != 0 or not result.stdout.strip():
                    print(f"✅ Port {port} is now free")
                    return True
                print(f"⏳ Still waiting... (attempt {attempt + 1}/10)")
            
            print(f"❌ Failed to free port {port} after 10 seconds")
            return False
        else:
            print(f"✅ Port {port} is available")
            return True
            
    except subprocess.CalledProcessError as e:
        print(f"❌ Error checking/killing port {port}: {e}")
        return False
    except FileNotFoundError:
        print(f"⚠️  'lsof' command not found, skipping port check")
        return True

def check_file_modified(file_path, last_modified):
    """Check if file has been modified"""
    try:
        current_mtime = os.stat(file_path).st_mtime
        return current_mtime > last_modified
    except:
        return False

def file_watcher(script_path, stop_event):
    """Watch for file changes and trigger reload"""
    last_modified = os.stat(script_path).st_mtime
    while not stop_event.is_set():
        time.sleep(1)
        if check_file_modified(script_path, last_modified):
            print(f"\n🔄 Script file modified, restarting...")
            os.kill(os.getpid(), signal.SIGTERM)
            break

def main():
    # Get the directory where this script is located
    script_dir = Path(__file__).parent.absolute()
    script_path = Path(__file__).absolute()
    mark9_dir = script_dir / "mark9"
    
    # Start file watcher in background
    stop_event = threading.Event()
    watcher_thread = threading.Thread(target=file_watcher, args=(script_path, stop_event), daemon=True)
    watcher_thread.start()
    
    # Check if mark9 directory exists
    if not mark9_dir.exists():
        print(f"❌ Error: mark9 directory not found at {mark9_dir}")
        print("Please make sure the mark9 directory exists in the same location as this script.")
        sys.exit(1)
    
    # Server configuration
    PORT = 1739
    
    # Check and kill any existing process on the port
    if not check_and_kill_port(PORT):
        print(f"❌ Failed to free port {PORT}. Please try again or use a different port.")
        sys.exit(1)
    
    # Change to the mark9 directory
    os.chdir(mark9_dir)
    
    class NoCacheHTTPRequestHandler(http.server.SimpleHTTPRequestHandler):
        def end_headers(self):
            # Add aggressive headers to prevent caching
            self.send_header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private')
            self.send_header('Pragma', 'no-cache')
            self.send_header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
            self.send_header('Last-Modified', time.strftime('%a, %d %b %Y %H:%M:%S GMT', time.gmtime()))
            self.send_header('ETag', f'"{int(time.time())}"')
            super().end_headers()
        
        def do_GET(self):
            # Force cache-busting for all requests
            separator = '&' if '?' in self.path else '?'
            self.path += f'{separator}_t={int(time.time())}'
            super().do_GET()
    
    Handler = NoCacheHTTPRequestHandler
    
    # Create server with retry mechanism
    max_retries = 5
    for retry in range(max_retries):
        try:
            with socketserver.TCPServer(("", PORT), Handler) as httpd:
                print(f"🚀 Starting local server for Mark 9...")
                print(f"📁 Serving directory: {mark9_dir}")
                print(f"🌐 Server URL: http://localhost:{PORT}")
                print(f"📄 Main page: http://localhost:{PORT}/index.html")
                print(f"⏹️  Press Ctrl+C to stop the server")
                print(f"🔄 Auto-reload enabled - save the script file to restart")
                print("-" * 50)
                
                try:
                    httpd.serve_forever()
                except KeyboardInterrupt:
                    print("\n🛑 Server stopped by user")
                    stop_event.set()
                    httpd.shutdown()
                    print("✅ Server shutdown complete")
                except SystemExit:
                    print("\n🔄 Server restarting...")
                    stop_event.set()
                    httpd.shutdown()
                    os.execv(sys.executable, ['python3'] + sys.argv)
                break  # Success, exit retry loop
                
        except OSError as e:
            if "Address already in use" in str(e) and retry < max_retries - 1:
                print(f"⚠️  Port still in use, retrying in 2 seconds... (attempt {retry + 1}/{max_retries})")
                time.sleep(2)
                continue
            else:
                print(f"❌ Failed to start server: {e}")
                sys.exit(1)

if __name__ == "__main__":
    main()
