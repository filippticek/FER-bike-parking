import requests
from gpiozero import Button
from time import sleep

WARNING = 27
SUPERVISOR_ADDRESS = "http://localhost:8080/buzzer"

button = Button(WARNING, pull_up=False)

while True:
    button.wait_for_press()
    requests.get(SUPERVISOR_ADDRESS)
    sleep(0.1)