#!/bin/sh

## ADDITIONAL INSTALLATIONS

## Selenium
sudo pip install Selenium

## Beautiful Soup
sudo pip install beautifulsoup4

## Firefox
sudo apt-add-repository ppa:mozillateam/firefox-next
sudo apt-get update
sudo apt-get install firefox xvfb
Xvfb :10 -ac &
export DISPLAY=:10

## Geckodriver
wget https://github.com/mozilla/geckodriver/releases/download/v0.23.0/geckodriver-v0.23.0-linux64.tar.gz
sudo sh -c 'tar -x geckodriver -zf geckodriver-v0.23.0-linux64.tar.gz -O > /usr/bin/geckodriver'
sudo chmod +x /usr/bin/geckodriver
rm geckodriver-v0.23.0-linux64.tar.gz

## Chromedriver
wget https://chromedriver.storage.googleapis.com/2.29/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
sudo chmod +x chromedriver
sudo mv chromedriver /usr/bin/
rm chromedriver_linux64.zip
