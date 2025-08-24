#!/usr/bin/env python3
"""
Local HTTP Server for MPA Website
Hosts the mark2-liquid directory on port 1732
"""

import http.server
import socketserver
import os
import sys
from pathlib import Path

def main():
    # Get the directory where this script is located
    script_dir = Path(__file__).parent.absolute()
    mark2_dir = script_dir / "mark2-liquid"
    
    # Check if mark2-liquid directory exists
    if not mark2_dir.exists():
        print(f"❌ Error: mark2-liquid directory not found at {mark2_dir}")
        print("Please make sure the mark2-liquid directory exists in the same location as this script.")
        sys.exit(1)
    
    # Change to the mark2-liquid directory
    os.chdir(mark2_dir)
    
    # Server configuration
    PORT = 1732
    Handler = http.server.SimpleHTTPRequestHandler
    
    # Create server
    with socketserver.TCPServer(("", PORT), Handler) as httpd:
        print(f"🚀 Starting local server for Mark 2...")
        print(f"📁 Serving directory: {mark2_dir}")
        print(f"🌐 Server URL: http://localhost:{PORT}")
        print(f"📄 Main page: http://localhost:{PORT}/index.html")
        print(f"⏹️  Press Ctrl+C to stop the server")
        print("-" * 50)
        
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print("\n🛑 Server stopped by user")
            httpd.shutdown()
            print("✅ Server shutdown complete")

if __name__ == "__main__":
    main()
