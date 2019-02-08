#!/bin/sh

## ADDITIONAL INSTALLATIONS

## Selenium
sudo pip install -U Selenium

## Beautiful Soup
sudo pip install beautifulsoup4

## Firefox
sudo wget https://github.com/mozilla/geckodriver/releases/download/v0.24.0/geckodriver-v0.24.0-linux32.tar.gz
sudo tar xzvf geckodriver-v0.24.0-linux32.tar.gz
sudo cp -f geckodriver /usr/bin/
