#!/bin/bash

cd ~

# clone repo
git pull ...
status=$?
if [[ $status -eq 128 ]];
then
	git clone ...
fi

cd FER-bike-parking/

# setup virtual env
sudo pip3 install virtualenv
mkdir venv
virtualenv venv -p /usr/bin/python3
source venv/bin/activate
pip install -r requirements.txt

# setup firewall

# setup network interface
chmod +x network_setup.sh
./network_setup.sh

# setup supervisor daemon to automatically restart apps in case of crashing
sudo mv supervisord.conf /etc/supervisord.conf
./supervisord