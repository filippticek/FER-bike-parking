# PLACEHOLDER FOR THE SUPERVISOR APP

# The supervisor app communicates with the handler apps (uhf rfid and student X card apps),
# with the server to check if a card is allowed to open the door
# and triggers the relay to open the door.

# TODO add communication with the server
# TODO add communication with the handler apps
# TODO add relay triggering

'''
import RPi.GPIO as GPIO

GPIO.setmode(GPIO.BCM)  # GPIO Numbers instead of board numbers
RELAY1 = 17
GPIO.setup(RELAY1, GPIO.OUT)  # GPIO Assign mode
GPIO.output(RELAY1, GPIO.LOW)  # out
GPIO.output(RELAY1, GPIO.HIGH)  # on
'''