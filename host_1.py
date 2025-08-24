#!/usr/bin/env python3
"""
Local HTTP Server for MPA Website
Hosts the mark1-mpa directory on port 1731
"""

import http.server
import socketserver
import os
import sys
from pathlib import Path

def main():
    # Get the directory where this script is located
    script_dir = Path(__file__).parent.absolute()
    mark1_dir = script_dir / "mark1-mpa"
    
    # Check if mark1-mpa directory exists
    if not mark1_dir.exists():
        print(f"❌ Error: mark1-mpa directory not found at {mark1_dir}")
        print("Please make sure the mark1-mpa directory exists in the same location as this script.")
        sys.exit(1)
    
    # Change to the mark1-mpa directory
    os.chdir(mark1_dir)
    
    # Server configuration
    PORT = 1731
    Handler = http.server.SimpleHTTPRequestHandler
    
    # Create server
    with socketserver.TCPServer(("", PORT), Handler) as httpd:
        print(f"🚀 Starting local server for Mark 1...")
        print(f"📁 Serving directory: {mark1_dir}")
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
