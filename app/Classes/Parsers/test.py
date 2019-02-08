#!/usr/bin/env python3

from selenium import webdriver
from selenium.webdriver.firefox.firefox_binary import FirefoxBinary

binary = FirefoxBinary('/usr/lib/firefox/firefox')
driver = webdriver.Firefox(firefox_binary=binary)
driver.get('https://google.com')
