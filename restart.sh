#!/bin/bash

# remove docker container of app
echo "Stopping app container..."
sudo docker stop app
echo "Removing app container..."
sudo docker rm -f app

# run app
./run.sh
