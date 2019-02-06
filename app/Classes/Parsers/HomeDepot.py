from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from bs4 import BeautifulSoup
import re
import pandas as pd
import os
import sys
import json
import SoupXPath

# launch url
URL = sys.argv[1]

# create a new Firefox session
DRIVER = webdriver.Firefox()
DRIVER.implicitly_wait(30)
DRIVER.get(URL)

# Selenium hands the page source to Beautiful Soup
SOUP = BeautifulSoup(DRIVER.page_source, 'lxml')

dollars = SOUP.select(".price__dollars")
cents = SOUP.select(".price__cents")
title = SOUP.select(".product-title__title")
brand = SOUP.select(".product-title__brand > a > span")

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
xcount = 1
for overlayThumb in SOUP2.findAll("a", {"class": "overlayThumbnail"}):
    if overlayThumb['data-media_type'] == "IMAGE":
        # Click the individual thumbs to bring up the main image popup
        # /html/body/div[15]/div/div[2]/div[2]/div/a[1]
        # /html/body/div[16]/div/div[2]/div[2]/div/a[1]

        # CSSPath to the media viewer:
        # html body.smart.desktop.appliance div#mediaOverlay.mediaPlayer
        # Unfortunately, the div ID seems to be different on every item
        # so XPath won't work to this point, however, everything past this
        # point seems to follow the same pattern of: /div/div[2]/div[2]/div/a[...]
        xpath = SoupXPath.xpath_soup(overlayThumb)
        print(xpath)

        # DRIVER.find_element_by_xpath(
        #    "/html/body/div[25]/div/div[2]/div[2]/div/a[" + str(xcount) + "]").click()
        # img_element = SOUP2.select("#overlay-zoom-image")
        # imgs.append(img_element[0]['src'])

#xcount = 1
# for imgLink in imgLinks:
#    if imgLink['data-media_type'] == "IMAGE":
#        # Click the individual thumbs to bring up the main image popup
#        DRIVER.find_element_by_xpath(
#            "//*[@id='thumbnails']/a[" + str(xcount) + "]").click()
#
#        SOUP2 = BeautifulSoup(DRIVER.page_source, 'lxml')
#        img_element = SOUP2.select("#overlay-zoom-image")
#        imgs.append(img_element[0]['src'])
#
#        # Close the popup
#        DRIVER.find_element_by_xpath("//*[@id='overlay-close']").click()
#
#    xcount = xcount + 1

# end the Selenium browser session
DRIVER.quit()

data = {}
data['title'] = title[0].text
data['brand'] = brand[0].text
data['price'] = dollars[0].text + "." + cents[0].text
data['images'] = imgs

print(data)
