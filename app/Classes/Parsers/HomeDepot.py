#!/usr/bin/env python

import sys
import SoupXPath
import json
import re

from selenium import webdriver
from selenium.webdriver.firefox.options import Options
from bs4 import BeautifulSoup

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
dimensions = SOUP.select(".specs__title > h4", text=re.compile(r'Dimensions'))

# HomeDepot images are run by a single thumbnail that opens a popup gallery
# Other images are listed on the gallery, but so are videos and 360 images, which we don't want
# 1) Open popup by clicking on the first thumbnail
# 2) Scan the popup for all the rest of the thumbnails and only match the ones that are IMAGES
# 3) Grab the URL of the #overlay-zoom-image
# 4) Click on the next thumbnail
# 5) Repeat 3-4 until all of the thumbs have been snagged

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
        imgs.append(img_element[0]['src'])

bullets = []
for item in SOUP.select('.list__item'):
    if not item.findChildren('a') and not item.findChildren('img'):
        bullets.append(item.text)

print(dimensions)
# for tableTitle in SOUP.select(".specs__title > h4"):
#     if tableTitle.text == "Dimensions":
#         nextSibling = tableTitle.parent.next_sibling.next_sibling
#         print(nextSibling)

DRIVER.quit()

data = {}
data['title'] = title[0].text
data['brand'] = brand[0].text
data['price'] = dollars[0].text + "." + cents[0].text
data['bullets'] = bullets
data['images'] = imgs

# print(json.dumps(data))
