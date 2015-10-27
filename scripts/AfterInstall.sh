#!/bin/bash

cd /home/ec2-user/TradeTrackerIM
chown -R ec2-user:nginx *
runuser -l ec2-user -c 'cd /home/ec2-user/TradeTrackerIM;/usr/local/bin/composer install'
