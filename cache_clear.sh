#!/bin/bash
sudo rm -r var/cache/dev
sudo rm -r var/cache/prod
sudo rm -r var/log/dev.log
sudo rm -r var/log/prod.log
sudo chmod -R 777 var/cache
sudo chmod -R 777 var/log
