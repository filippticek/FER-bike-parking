#!/usr/bin/env python3
from http.server import HTTPServer
import socket

HOST_NAME = '192.168.7.191'
PORT_NUMBER = 80

SERVER_IP = 'localhost'
SERVER_PORT = '4000'

#This class will handles any incoming request from
#the browser
class Server(BaseHTTPRequestHandler):
	#Handler for the GET requests
	def do_GET(self):
		handle_nfc(self.path)
		self.send_response(200)
		self.send_header('Content-type','text/html')
		self.end_headers()
		self.wfile.write("<ORBIT>\nUI=a00332\n\n</ORBIT>")
		return

def handle_nfc(url):
	uid_len, uid = get_uid(url)
	if uid_len is not False:
		send_response(uid_len, uid)

def send_response(uid_len, uid):
	serve = socket.socket(socket.AF_INET, socket.SOCKSTREAM)
	serve.connect((SERVER_IP, SERVER_PORT))
	response = 'uidLen=' + str(uid_len) + '&uid=' + uid + '&\r\n'
	serve.send(response.encode('utf-8'))
	serve.close()


def get_uid(url):
	if "ulen" in url:
		uid_len = int(url[url.find("ulen") + 5])
		uid_start = int(url.find("uid")) + 4
		uid = url[uid_start:(uid_start + uid_len * 2)]
		return (uid_len, uid)
	else:
		return (False, False)
try:
	#Create a web server and define the handler to manage the
	#incoming request
	server = HTTPServer((HOST_NAME, PORT_NUMBER), Server)
	print 'Started httpserver on port ' , PORT_NUMBER

	#Wait forever for incoming http requests
	server.serve_forever()

except KeyboardInterrupt:
	print '^C received, shutting down the web server'
	server.socket.close()

