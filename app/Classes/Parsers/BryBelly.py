#!/usr/bin/env python

import sys
import SoupXPath
import json
import re
import uuid
import os
import requests
import urllib3

from os.path import basename
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait  # available since 2.4.0
# available since 2.26.0
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.firefox.options import Options
from bs4 import BeautifulSoup

# Suppress the warnings
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

attempt = 0

# Methods go here:


def attemptConnection(url):
    try:
        DRIVER.get(url)
        attempt = 0
    except requests.ConnectionError:
        if(attempt <= 3):
            attempt = attempt + 1
            print("connection error to %s. trying again...(attempt: %s)" %
                  path, attempt)
            attemptConnection(url)
        else:
            sys.exit("connection error to %s. (fatal - attempts maxed out)" %
                     path, attempt)


def parseData(obj, param, rule):
    if 'text' in rule:
        try:
            obj[param] = (rule['text'][0].text).strip()
        except IndexError:
            obj[param] = ''
            pass
    elif 'object' in rule:
        obj[param] = rule['object']

    return obj


# launch url
url = sys.argv[1]

DRIVER = webdriver.PhantomJS()
DRIVER.implicitly_wait(30)
attemptConnection(url)

# Selenium hands the page source to Beautiful Soup
SOUP = BeautifulSoup(DRIVER.page_source, 'lxml')

print(SOUP)

# title = SOUP.select("h1")
# print(title)
# We're done scraping
DRIVER.quit()


data = {}
# data = parseData(data, 'title', {'text': title})
# data = parseData(data, 'brand', {'text': brand})
# data = parseData(data, 'dollars', {'text': dollars})
# data = parseData(data, 'cents', {'text': cents})
# data = parseData(data, 'bullets', {'object': bullets})
# data = parseData(data, 'images', {'object': imgs})
# data = parseData(data, 'dimensions', {'object': dimensions})
# data = parseData(data, 'details', {'object': details})
# data = parseData(data, 'sku', {'text': sku})
# data = parseData(data, 'model', {'text': model})
# data = parseData(data, 'description', {'text': description})
# data = parseData(data, 'productId', {'object': productId})

print(json.dumps(data))
