#!/bin/bash

cd ~
cd FER-bike-parking/

# clone repo
git pull https://$TOKEN:x-oauth-basic@github.com/filippticek/FER-bike-parking.git
status=$?
if [[ $status -eq 128 ]];
then
	git clone https://$TOKEN:x-oauth-basic@github.com/filippticek/FER-bike-parking.git
fi

cd FER-bike-parking/

# setup virtual env
sudo pip3 install virtualenv
mkdir venv
virtualenv venv -p /usr/bin/python3
source venv/bin/activate
pip install -r requirements.txt


# setup network interface
chmod +x network_setup.sh
./network_setup.sh

# setup startup script?

# setup supervisor daemon to automatically restart apps in case of crashing
sudo cp supervisord.conf /etc/supervisord.conf
./supervisord