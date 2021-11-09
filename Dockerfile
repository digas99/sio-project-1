FROM tomsik68/xampp:latest

# make project-1 the web app running in the server
COPY analysis /www/analysis

COPY app /www/app

COPY app_sec /www/app_sec

COPY php /www/php
	
# create database
WORKDIR /opt/lampp/var/mysql/

RUN mkdir admin

RUN chmod -R a+rwx admin

# redirect localhost to app/index.php
COPY index.php /opt/lampp/htdocs/