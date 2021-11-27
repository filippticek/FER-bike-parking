import codecs
import json
import sys
import time

import requests
import serial
from gpiozero import DigitalInputDevice
from uhf_reader import UHFReader

SUPERVISOR_ADDRESS = "http://localhost:8080/reader"
TIMEOUT = 1 # Set timeout between two reads

ser = serial.Serial(
    port='/dev/ttyUSB0',
    baudrate=57600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS
)
if not ser.isOpen():
    sys.exit(-1)

uhf = UHFReader()


def read():
    data = []
    i = 0
    j = 0
    while True:
        i += 1

        if j == 0:
            j = ser.read()
            data.append(codecs.encode(j, 'hex').decode('utf-8'))

        # ako je procitano bajtova koliko pise u paketu, izadi
        if int(codecs.encode(j, 'hex'), 16) + 1 == i:
            break

        s = ser.read()
        data.append(codecs.encode(s, 'hex').decode('utf-8'))
    return ''.join(data)


def received_epc(response):
    return uhf.parse_single_tag_response(response)['epc'] != ''


def received_tid(response):
    return get_tid(response) != ''


def get_tid(response):
    return uhf.parse_ext_read(response)['tid']


def check_access(response):
    tid = get_tid(response)
    print(tid)
    req_data = json.dumps({'reader': 'UHF', 'id': tid})
    requests.post(SUPERVISOR_ADDRESS, data=req_data)


def request_tid(response):
    epc = uhf.parse_single_tag_response(response)['epc']
    length = hex(len(epc) // 4)[2:]
    return uhf.ext_read(enum='0' + length, epc=epc)


def start_workflow():
    cmd = uhf.single_tag_read()
    i = 100
    while i > 0:
        ser.write(cmd)
        response = read()

        if received_epc(response):
            cmd = request_tid(response)
        elif received_tid(response):
            check_access(response)
            break
        else:
            cmd = uhf.single_tag_read()

        time.sleep(0.1)
        i -= 1


#pir = DigitalInputDevice(4)

while True:
    start_workflow()
    time.sleep(TIMEOUT)
    #pir.when_activated = start_workflow

ser.close()
