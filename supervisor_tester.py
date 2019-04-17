#!/usr/bin/python

from BaseHTTPServer import BaseHTTPRequestHandler, HTTPServer
import requests


r = requests.post('http://192.168.7.191:8080/nfc', data='{"type":"rfid", "key":"12324214354235235"}')
r = requests.post('http://192.168.7.191:8080/rfid', data='{"type":"nfc", "key":"12324214354235235"}')
print(r)
print(r.status_code)
