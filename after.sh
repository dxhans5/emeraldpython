#!/bin/sh

## ADDITIONAL INSTALLATIONS
cd /usr/local

## lxml
sudo pip install lxml

## Selenium
sudo pip install -U Selenium

## Beautiful Soup
sudo pip install beautifulsoup4

## PhantomJS
sudo wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2
sudo tar -vxjf phantomjs-2.1.1-linux-x86_64.tar.bz2
sudo mv -f phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/bin/phantomjs
sudo chown vagrant:vagrant /usr/bin/phantomjs

## Cleanup
sudo apt --fix-broken install -y
sudo apt autoremove

## Setup the database
cd /vagrant/
php artisan migrate --seed
