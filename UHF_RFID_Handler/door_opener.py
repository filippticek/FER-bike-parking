import codecs
import time
from random import randint

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


def wait_for_motion():
  i = 0
  while True:
    rand = randint(0, 100)
    if rand > 95:
      print("put tag")
      return 50


def received_epc(response):
  return uhf.parse_single_tag_response(response)['epc'] != ''


def received_tid(response):
  return uhf.parse_ext_read(response)['tid'] != ''


def check_access(response):
  # TODO add communication with supervisor
  return ok_in_db(uhf.parse_ext_read(response)['tid'])


def ok_in_db(tid):
  # TODO remove
  if tid.upper() == 'E2003412013CF20010D5B1060C11016A00055FFB':
    time.sleep(1)
    return True
  return False


def trigger_relay():
  # TODO remove
  print("triggered relay")
  time.sleep(1)
  print("closing relay")


def open_gate():
  # TODO remove
  print("opening gate")
  trigger_relay()


def request_tid():
  print("got epc")
  epc = uhf.parse_single_tag_response(response)['epc']
  length = hex(len(epc) // 4)[2:]
  return uhf.ext_read(enum='0' + length, epc=epc)





i = wait_for_motion()
cmd = uhf.single_tag_read()
while i > 0:
  ser.write(cmd)
  response = read()

  if received_epc(response):
    cmd = request_tid()
  elif received_tid(response):
    print("got tid")
    if check_access(response):
      open_gate()
      break
    else:
      cmd = uhf.single_tag_read()

  time.sleep(0.1)
  i -= 1

ser.close()
