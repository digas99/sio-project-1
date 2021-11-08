#!/bin/bash

create_database () {
	conf="${1}db.opt"

	# create database
	sudo mkdir $1

	# change permissions of database folder
	sudo chmod -R a+rwx $1
	sudo chown $USER -R $1

	# create config file
	sudo touch $conf
	sudo sh -c "{ echo 'default-character-set=utf8mb4'; echo 'default-collation=utf8mb4_general_ci';} >> $conf"

	echo "Database created!"
}

if [[ $1 = '' ]]; then
	echo "Database name missing!"
	echo "Usage: $0 db_name"
else
	path='/opt/lampp/var/mysql/'
	db="${path}${1}/"

	if [[ -d $db ]];then
		echo "Database already exists!"
		echo "Overwrite database?(y/n)"
		read result

		if [[ $result = y ]]; then
			sudo rm -r $db

			create_database $db
		else
			echo "Database wasn't created."
		fi
	else
		create_database $db
	fi
fi