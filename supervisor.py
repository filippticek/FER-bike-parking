#!/usr/bin/python

# The supervisor app communicates with the handler apps (uhf rfid and student X card apps),
# with the server to check if a card is allowed to open the door
# and triggers the relay to open the door.



import json

import requests
import web

EXTERNAL_SERVER = "http://167.99.129.57:8001/readerHandler.php"

urls = (
    '/reader', 'reader'
)


class reader:
    def POST(self):
        post_data = json.loads(web.data().decode('utf-8'))
        db_status = check_database(post_data['reader'], post_data['id'])
        if db_status == 200:
            open_door()

        return db_status


def check_database(reader="", id=""):
    if reader and id:
        data = json.dumps({'reader': reader, 'id': id})
        print(data)
        r = requests.post(EXTERNAL_SERVER, data=data)
        print(r.status_code)
        return r.status_code
    return 401


def open_door():
    print("door opening")
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
