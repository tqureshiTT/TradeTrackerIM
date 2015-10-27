#!/bin/bash

cd /home/ec2-user/TradeTrackerIM
chown -R ec2-user:nginx *
chmod -R a+rwx /home/ec2-user/TradeTrackerIM/app/cache
runuser -l ec2-user -c 'cd /home/ec2-user/TradeTrackerIM;/usr/local/bin/composer install'
chmod -R a+rwx /home/ec2-user/TradeTrackerIM/app/cache
