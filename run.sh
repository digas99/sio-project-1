#!/bin/bash

sudo docker build -t webapp .

sudo docker run -dti --name app -p 80:80 webapp
