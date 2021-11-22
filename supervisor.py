#!/usr/bin/python

# The supervisor app communicates with the handler apps (uhf rfid and student X card apps),
# with the server to check if a card is allowed to open the door
# and triggers the relay to open the door.



import json

import requests
import web
from time import sleep
from gpiozero import LED

EXTERNAL_SERVER = ""

BUZZER = 17
RELAY = 18

urls = (
    '/reader', 'reader'
)


class reader:
    def POST(self):
        buzzer = LED(BUZZER)
        relay = LED(RELAY)
        post_data = json.loads(web.data().decode('utf-8'))
        #when external server present remove next 2 lines and uncomment all others
        open_door(buzzer, relay)
        return 200
        """"
        db_status = check_database(post_data['reader'], post_data['id'])
        if db_status == 200:
            open_door(buzzer,relay)
        else:
            piezo_false(buzzer)

        return db_status
        """


def check_database(reader="", id=""):
    if reader and id:
        data = json.dumps({'reader': reader, 'id': id})
        print(data)
        r = requests.post(EXTERNAL_SERVER, data=data)
        print(r.status_code)
        return r.status_code
    return 401

def piezo_false(buzzer):
    buzzer.on()
    sleep(0.2)
    buzzer.off()
    sleep(0.2)

def piezo_true(buzzer):
    buzzer.on()
    sleep(1)
    buzzer.off()
    sleep(1)

def open_door(buzzer, relay):
    print("door opening")
    buzzer.on()
    relay.on()
    sleep(1)
    buzzer.off()
    relay.off()
    sleep(1)


if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()
