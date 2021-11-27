import requests
from gpiozero import Button

WARNING = 27
SUPERVISOR_ADDRESS = "http://localhost:8080/buzzer"

button = Button(WARNING)

while True:
    button.wait_for_press()
    requests.get(SUPERVISOR_ADDRESS)