#!/bin/bash

while getopts 'aur' OPTION; do
    case "$OPTION" in
        a)
			pull_changes
			install_dependecies
			nfc_uhf_setup
			restart_services
            ;;
        u)
			pull_changes
			install_dependecies
			uhf_setup
			restart_services
            ;;
        r)
			pull_changes
			restart_services
            ;;
        *)
			echo "Usage: $0 [-a] [-u] [-r]"
			echo "Supply the following arguments:"
			echo "      -a for deploying nfc/uhf box"
			echo "      -u for deploying uhf box"
			echo "      -r for restarting the service"
            exit 1
			;;
    esac
done

pull_changes () {
	cd ~/FER-bike-parking/
	# pull latest changes
	git pull 
}

install_dependecies (){
	sudo apt install -y supervisor
	# setup virtual env
	sudo pip3 install virtualenv
	mkdir venv
	virtualenv venv -p /usr/bin/python3
	source venv/bin/activate
	pip install -r requirements.txt
}

uhf_setup () {
	# add supervisord configuration 
	sudo cp supervisord_uhf.conf /etc/supervisor/supervisord.conf
}

nfc_uhf_setup () {
	# setup network interface
	chmod +x network_setup.sh
	./network_setup.sh

	# setup startup script
	crontab -l > mycron
	echo "@reboot /home/pi/FER-bike-parking/./network_setup.sh" > mycron
	crontab mycron
	rm mycron

	# add supervisord configuration 
	sudo cp supervisord.conf /etc/supervisor/supervisord.conf
}

restart_services() {
	# restart supervisor
	sudo service supervisor restart
}