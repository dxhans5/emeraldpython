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


def populateTable(table, data):
    nextSibling = data[0].parent.next_sibling.next_sibling
    for specCell in nextSibling.select('.specs__group'):
        label = specCell.select('.specs__cell--label')[0].text
        value = specCell.select(
            '.specs__cell--label')[0].next_sibling.next_sibling.text

        table.update({label: value})


def download_image(image_url, path):
    session = requests.Session()
    local_filename = image_url.split('/')[-1].split("?")[0]

    r = session.get(image_url, stream=True, verify=False)
    with open(path + local_filename, 'wb') as f:
        for chunk in r.iter_content(chunk_size=1024):
            f.write(chunk)

    return local_filename


def attemptConnection(url):
    try:
        DRIVER.get(url)
        attempt = 0
    except ConnectionError:
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

title = SOUP.select(".product-title__title")
brand = SOUP.select(".product-title__brand > a > span")
dimensionsData = SOUP.select(".specs__title > h4:contains(Dimensions)")
detailsData = SOUP.select(".specs__title > h4:contains(Details)")
sku = SOUP.select("#product_store_sku")
model = SOUP.select(".modelNo")
description = SOUP.select("p[itemprop='description']")
productId = str(uuid.uuid4())

# HomeDepot will sometimes sell products for lower than manufacturers price...when this happens
# they have a special dom in place that requires someone to add the item to the cart to view
# the price
if SOUP.select(".map-pricing__message"):
    DRIVER.find_element_by_xpath(
        "//*[@id='atc_shipIt']").click()

    try:
        # Wait for the checkout button to appear
        iframe = WebDriverWait(DRIVER, 60).until(
            EC.presence_of_element_located((By.TAG_NAME, "iframe")))

        print(iframe.get_attribute('src'))
        # data-automation-id="checkoutNowButton"

    finally:
        print('moving on...')


# else:
#     dollars = SOUP.select(".price__dollars")
#     cents = SOUP.select(".price__cents")


# HomeDepot images are run by a single thumbnail that opens a popup gallery
# Other images are listed on the gallery, but so are videos and 360 images, which we don't want
# 1) Open popup by clicking on the first thumbnail
# 2) Scan the popup for all the rest of the thumbnails and only match the ones that are IMAGES
# 3) Grab the URL of the #overlay-zoom-image
# 4) Click on the next thumbnail
# 5) Repeat 3-4 until all of the thumbs have been snagged

# Create the image directory
path = '/vagrant/public/gallery-images/' + productId + '/'
try:
    os.mkdir(path)
except OSError:
    sys.exit("creation of the directory %s failed" % path)

DRIVER.find_element_by_xpath(
    "//*[@id='thumbnails']/a[1]").click()
SOUP2 = BeautifulSoup(DRIVER.page_source, 'lxml')
imgs = []

for overlayThumb in SOUP2.findAll("a", {"class": "overlayThumbnail"}):
    if overlayThumb['data-media_type'] == "IMAGE":
        # Get the individual xpath for each of the valid thumbnails
        xpath = SoupXPath.xpath_soup(overlayThumb)
        # Click on the individual thumbnail
        DRIVER.find_element_by_xpath(xpath).click()
        # Rescan the source to get the updated main image
        SOUP3 = BeautifulSoup(DRIVER.page_source, 'lxml')

        img_element = SOUP3.select("#overlay-zoom-image")
        img = img_element[0]['src']
        fileName = download_image(img, path)

        imgs.append(productId + '/' + fileName)

bullets = []
for item in SOUP.select('.list__item'):
    if not item.findChildren('a') and not item.findChildren('img'):
        bullets.append(item.text)
bullets = list(dict.fromkeys(bullets))  # Remove any duplicates

# Populate Product Tables
dimensions = {}
details = {}
populateTable(dimensions, dimensionsData)
populateTable(details, detailsData)

# We're done scraping
DRIVER.quit()


data = {}
data = parseData(data, 'title', {'text': title})
data = parseData(data, 'brand', {'text': brand})
data = parseData(data, 'dollars', {'text': dollars})
data = parseData(data, 'cents', {'text': cents})
data = parseData(data, 'bullets', {'object': bullets})
data = parseData(data, 'images', {'object': imgs})
data = parseData(data, 'dimensions', {'object': dimensions})
data = parseData(data, 'details', {'object': details})
data = parseData(data, 'sku', {'text': sku})
data = parseData(data, 'model', {'text': model})
data = parseData(data, 'description', {'text': description})
data = parseData(data, 'productId', {'object': productId})

print(json.dumps(data))
