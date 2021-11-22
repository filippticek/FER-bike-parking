#!/bin/bash

pull_changes () {
	cd ~/FER-bike-parking/
	# pull latest changes
	echo "Pulling latest changes"
	git pull 
}

install_dependecies () {
	echo "Installing supervisor"
	sudo apt install -y supervisor
	# setup virtual env
	echo "Setting up virtualenv"
	sudo pip3 install virtualenv
	mkdir venv
	virtualenv venv -p /usr/bin/python3
	source venv/bin/activate
	echo "Installing requirements"
	pip install -r requirements.txt
}

uhf_setup () {
	# add supervisord configuration 
	echo "Adding supervisord configuration"
	sudo cp supervisord_uhf.conf /etc/supervisor/supervisord.conf
}

nfc_uhf_setup () {
	# setup network interface
	echo "Adding subnet"
	chmod +x network_setup.sh
	./network_setup.sh

	# setup startup script
	echo "Setting up cronjob"
	crontab -l > mycron
	echo "@reboot /home/pi/FER-bike-parking/./network_setup.sh" > mycron
	crontab mycron
	rm mycron

	# add supervisord configuration 
	echo "Adding supervisord configuration"
	sudo cp supervisord.conf /etc/supervisor/supervisord.conf
}

restart_services () {
	# restart supervisor
	echo "Restarting supervisor"
	sudo service supervisor restart
}

print_usage () {
	echo "Usage: $0 [-a] [-u] [-r]"
	echo "Supply the following arguments:"
	echo "      -a for deploying nfc/uhf box"
	echo "      -u for deploying uhf box"
	echo "      -r for restarting the service"
	exit 1
}

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
			print_usage
			;;
    esac
done

if [ $# -eq 0 ]; then
	print_usage
fi