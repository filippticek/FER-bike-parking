#!/usr/bin/python

# The supervisor app communicates with the handler apps (uhf rfid and student X card apps),
# with the server to check if a card is allowed to open the door
# and triggers the relay to open the door.

# TODO add communication with the server
# TODO add relay triggering



import web
import json
import requests

NFC = "nfc"
UHF = "uhf"

urls = (
    '/uhf', 'uhf',
    '/nfc', 'nfc'
)

class uhf:
    def POST(self):
        post_data = json.loads(web.data())
        db_status = check_database(UHF, post_data['key'])
        if db_status:
            open_door()

        return db_status

class nfc:
    def POST(self):
        post_data = json.loads(web.data())
        db_status = check_database(NFC, post_data['key'])
        if db_status:
            open_door()

        return db_status
        



def check_database(type="", key=""):
    if key == NFC and key:
        return request_nfc_access(key)
    if key == UHF and key:
        return request_uhf_access(key)

    return 500

def request_nfc_access(key=""):
    if key:
        #r = requests.post(...)
        pass
    return r.status_code

def request_uhf_access(key=""):
    print(key)
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