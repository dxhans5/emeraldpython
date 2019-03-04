#!/usr/bin/env python

import sys
import SoupXPath
import json
import re
import uuid
import os
import requests

from os.path import basename
from selenium import webdriver
from selenium.webdriver.firefox.options import Options
from bs4 import BeautifulSoup


# Methods
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


# launch url
URL = sys.argv[1]

DRIVER = webdriver.PhantomJS()
DRIVER.implicitly_wait(30)
DRIVER.get(URL)

# Selenium hands the page source to Beautiful Soup
SOUP = BeautifulSoup(DRIVER.page_source, 'lxml')

dollars = SOUP.select(".price__dollars")
cents = SOUP.select(".price__cents")
title = SOUP.select(".product-title__title")
brand = SOUP.select(".product-title__brand > a > span")
dimensionsData = SOUP.select(".specs__title > h4:contains(Dimensions)")
detailsData = SOUP.select(".specs__title > h4:contains(Details)")
sku = SOUP.select("#product_store_sku")
model = SOUP.select(".modelNo")
description = SOUP.select("p[itemprop='description']")
productId = str(uuid.uuid4())

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
    print("creation of the directory %s failed" % path)

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

DRIVER.quit()

data = {}
data['title'] = (title[0].text).strip()
data['brand'] = (brand[0].text).strip()
data['price'] = (dollars[0].text).strip() + "." + (cents[0].text).strip()
data['bullets'] = bullets
data['images'] = imgs
data['dimensions'] = dimensions
data['details'] = details
data['sku'] = (sku[0].text).strip()
data['model'] = (model[0].text).strip().replace('Model # ', '')
data['description'] = (description[0].text).strip()
data['productId'] = productId

print(json.dumps(data))
