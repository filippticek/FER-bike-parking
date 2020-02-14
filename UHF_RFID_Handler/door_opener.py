import codecs
import time
from gpiozero import DigitalInputDevice

import serial

from uhf_reader import UHFReader


ser = serial.Serial(
  port='/dev/ttyUSB0',
  baudrate=57600,
  parity=serial.PARITY_NONE,
  stopbits=serial.STOPBITS_ONE,
  bytesize=serial.EIGHTBITS
)
print(ser.isOpen())

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

    if int(codecs.encode(j, 'hex'), 16) + 1 == i:
      break

    s = ser.read()
    data.append(codecs.encode(s, 'hex').decode('utf-8'))
  return ''.join(data)


def received_epc(response):
  return uhf.parse_single_tag_response(response)['epc'] != ''


def received_tid(response):
  return uhf.parse_ext_read(response)['tid'] != ''


def check_access(response):
  # TODO add communication with supervisor
  pass



def request_tid(response):
  print("got epc")
  epc = uhf.parse_single_tag_response(response)['epc']
  length = hex(len(epc) // 4)[2:]
  return uhf.ext_read(enum='0' + length, epc=epc)


def start_workflow():
  print("start")
  cmd = uhf.single_tag_read()
  i = 100
  while i > 0:
    ser.write(cmd)
    response = read()
  
    if received_epc(response):
      cmd = request_tid(response)
    elif received_tid(response):
      print("got tid")
      check_access(response)
      break
    else:
      cmd = uhf.single_tag_read()
  
    time.sleep(0.1)
    i -= 1



while True:
  start_workflow()
  time.sleep(2)
  #pir.when_activated = start_workflow

ser.close()
