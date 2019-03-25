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
    elif 'content' in rule:
        obj[param] = rule['content'][0]['content']

    return obj


def download_image(image_url, path):
    session = requests.Session()
    local_filename = image_url.split('/')[-1].split("?")[0]

    r = session.get(image_url, stream=True, verify=False)
    with open(path + local_filename, 'wb') as f:
        for chunk in r.iter_content(chunk_size=1024):
            f.write(chunk)

    return local_filename


# launch url
url = sys.argv[1]

DRIVER = webdriver.PhantomJS()
DRIVER.implicitly_wait(30)
attemptConnection(url)

# Selenium hands the page source to Beautiful Soup
SOUP = BeautifulSoup(DRIVER.page_source, 'lxml')

title = SOUP.select("h1[itemprop='name']")
brand = SOUP.select(".BrandName > a > span")
price = SOUP.select("meta[itemprop='price']")
sku = SOUP.select(".VariationProductSKU")
productId = str(uuid.uuid4())

bullets = []
for item in SOUP.select('.ProductDescriptionContainer > ul > li'):
    bullets.append(item.text)
bullets = list(dict.fromkeys(bullets))  # Remove any duplicates

# Diecast Models uses a standard thumbnail > large image modal
# Create the image directory
path = '/vagrant/public/gallery-images/' + productId + '/'
try:
    os.mkdir(path)
except OSError:
    sys.exit("creation of the directory %s failed" % path)


DRIVER.find_element_by_xpath(
    "//*[@id='ProductDetails']/div/div[1]/div/div[2]/a/img").click()
overlay = WebDriverWait(DRIVER, 60).until(
    EC.presence_of_element_located((By.ID, "fancy_frame")))
SOUP2 = BeautifulSoup(DRIVER.page_source, 'lxml')
iframe = SOUP2.select('#fancy_frame')

# Get iframe content
attemptConnection(iframe[0]['src'])
SOUP3 = BeautifulSoup(DRIVER.page_source, 'lxml')
imgs = []

for overlayThumb in SOUP3.select(".TinyOuterDiv > a"):
    # Get the individual xpath for each of the valid thumbnails
    xpath = SoupXPath.xpath_soup(overlayThumb)
    # Click on the individual thumbnail
    DRIVER.find_element_by_xpath(xpath).click()
    # Rescan the source to get the updated main image
    SOUP4 = BeautifulSoup(DRIVER.page_source, 'lxml')

    img_element = SOUP4.select(".ProductZoomImage > img")
    img = img_element[0]['src']
    fileName = download_image(img, path)

    imgs.append(productId + '/' + fileName)

# We're done scraping
DRIVER.quit()


data = {}
data = parseData(data, 'title', {'text': title})
data = parseData(data, 'brand', {'text': brand})
data = parseData(data, 'price', {'content': price})
data = parseData(data, 'bullet_points', {'object': bullets})
data = parseData(data, 'images', {'object': imgs})
data = parseData(data, 'sku', {'text': sku})
data = parseData(data, 'product_id', {'object': productId})

print(json.dumps(data))
