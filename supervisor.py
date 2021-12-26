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
    '/reader', 'reader',
    '/buzzer', 'buzzer'
)


class reader:
    def POST(self):
        relay = LED(RELAY)
        #buzzer = LED(BUZZER)
        post_data = json.loads(web.data().decode('utf-8'))
        #when external server present remove next 2 lines and uncomment all others
        open_door(relay)
        return 200
        """"
        db_status = check_database(post_data['reader'], post_data['id'])
        if db_status == 200:
            open_door(relay)
        else:
            piezo_false(buzzer)

        return db_status
        """

class buzzer:
    def GET(self):
        buzzer = LED(BUZZER)
        piezo_true(buzzer)
        return 200



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
    sleep(0.1)
    buzzer.off()

def open_door(relay):
    print("door opening")
    relay.on()
    relay.off()


if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()
