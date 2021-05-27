#!/usr/bin/python

# The supervisor app communicates with the handler apps (uhf rfid and student X card apps),
# with the server to check if a card is allowed to open the door
# and triggers the relay to open the door.



import json

import requests
import web
from time import sleep
from gpiozero import LED

EXTERNAL_SERVER = "http://vukovic-art.com/FERaccess/access-chk.php"

BUZZER = LED(17)
RELAY = LED(18)

urls = (
    '/reader', 'reader'
)


class reader:
    def POST(self):
        post_data = json.loads(web.data().decode('utf-8'))
        db_status = check_database(post_data['reader'], post_data['id'])
        if db_status == 200:
            # Unncomment the next line and comment the piezo_true() when relay is attached
            # open_door()
            piezo_true()
        else:
            piezo_false()

        return db_status


def check_database(reader="", id=""):
    if reader and id:
        data = json.dumps({'reader': reader, 'id': id})
        print(data)
        r = requests.post(EXTERNAL_SERVER, data=data)
        print(r.status_code)
        return r.status_code
    return 401

def piezo_false():
    BUZZER.on()
    sleep(0.2)
    BUZZER.off()
    sleep(0.2)

def piezo_true():
    BUZZER.on()
    sleep(1)
    BUZZER.off()
    sleep(1)

def open_door():
    print("door opening")
    BUZZER.on()
    RELAY.on()
    sleep(1)
    BUZZER.off()
    RELAY.off()
    sleep(1)


if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()
