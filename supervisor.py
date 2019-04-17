#!/usr/bin/python
# PLACEHOLDER FOR THE SUPERVISOR APP

# The supervisor app communicates with the handler apps (uhf rfid and student X card apps),
# with the server to check if a card is allowed to open the door
# and triggers the relay to open the door.

# TODO add communication with the server
# TODO add communication with the handler apps
# TODO add relay triggering



import web
import json
import requests

NFC = "nfc"
RFID = "rfid"

urls = (
    '/rfid', 'rfid',
    '/nfc', 'nfc'
)

class rfid:
    def POST(self):
        post_data = json.loads(web.data())
        if check_database(post_data['type'], post_data['key']):
            open_door()

class nfc:
    def POST(self):
        post_data = json.loads(web.data())
        if check_database(post_data['type'], post_data['key']):
            open_door()
        



def check_database(type="", key=""):
    if key == NFC and key:
        return request_nfc_access(key)
    if key == RFID and key:
        return request_rfid_access(key)

    return False

def request_nfc_access(key=""):
    if key:
        #r = requests.post(...)
        pass
    return r.status_code

def request_rfid_access(key=""):
    if key:
        #r = requests.post(...)
        pass
    return r.status_code

def open_door():
    '''
    import RPi.GPIO as GPIO
    
    GPIO.setmode(GPIO.BCM)  # GPIO Numbers instead of board numbers
    RELAY1 = 17
    GPIO.setup(RELAY1, GPIO.OUT)  # GPIO Assign mode
    GPIO.output(RELAY1, GPIO.LOW)  # out
    GPIO.output(RELAY1, GPIO.HIGH)  # on
    '''
    pass

if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()