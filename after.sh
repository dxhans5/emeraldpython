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
sudo wget http://ftp.mozilla.org/pub/firefox/releases/62.0.2/linux-x86_64/en-US/firefox-62.0.2.tar.bz2
sudo tar xvjf firefox-62.0.2.tar.bz2
sudo ln -s /usr/local/firefox/firefox /usr/local/bin/firefox

## GeckoDriver
sudo wget https://github.com/mozilla/geckodriver/releases/download/v0.22.0/geckodriver-v0.22.0-linux64.tar.gz
sudo tar xzvf geckodriver-v0.22.0-linux64.tar.gz
sudo ln -s /usr/local/geckodriver /usr/local/bin/geckodriver

## Chrome
sudo apt-get install -y chromium-browser
sudo wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i --force-depends google-chrome-stable_current_amd64.deb

## Setup the database
cd /vagrant/
php artisan migrate --seed
