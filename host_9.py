#!/usr/bin/env python3
"""
Local HTTP Server for MPA Website
Hosts the mark9 directory on port 1739
"""

import http.server
import socketserver
import os
import sys
from pathlib import Path

def main():
    # Get the directory where this script is located
    script_dir = Path(__file__).parent.absolute()
    mark9_dir = script_dir / "mark9"
    
    # Check if mark9 directory exists
    if not mark9_dir.exists():
        print(f"❌ Error: mark9 directory not found at {mark9_dir}")
        print("Please make sure the mark9 directory exists in the same location as this script.")
        sys.exit(1)
    
    # Change to the mark9 directory
    os.chdir(mark9_dir)
    
    # Server configuration
    PORT = 1739
    Handler = http.server.SimpleHTTPRequestHandler
    
    # Create server
    with socketserver.TCPServer(("", PORT), Handler) as httpd:
        print(f"🚀 Starting local server for Mark 9...")
        print(f"📁 Serving directory: {mark9_dir}")
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
