#!/bin/sh

## ADDITIONAL INSTALLATIONS
cd /usr/local

## lxml
sudo pip install lxml

## Selenium
sudo pip install -U Selenium

## Beautiful Soup
sudo pip install beautifulsoup4

## Firefox
sudo wget http://ftp.mozilla.org/pub/firefox/releases/65.0.1/linux-x86_64/en-US/firefox-65.0.1.tar.bz2
sudo tar xvjf firefox-65.0.1.tar.bz2
sudo ln -s /usr/local/firefox/firefox /usr/local/bin/firefox
sudo chown -R vagrant:vagrant /usr/local/bin/firefox

## GeckoDriver
sudo wget https://github.com/mozilla/geckodriver/releases/download/v0.24.0/geckodriver-v0.24.0-linux64.tar.gz
sudo tar -xvzf geckodriver*
sudo chmod +x geckodriver
sudo chown -R vagrant:vagrant /usr/local/geckodriver
sudo mv geckodriver /usr/local/bin/

## Cleanup
sudo apt --fix-broken install
sudo apt autoremove

## Setup the database
cd /vagrant/
php artisan migrate --seed
