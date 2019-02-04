from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from bs4 import BeautifulSoup
import re
import pandas as pd
import os
import sys

# launch url
url = sys.argv[1]

# create a new Firefox session
driver = webdriver.Firefox()
driver.implicitly_wait(30)
driver.get(url)

# Selenium hands the page source to Beautiful Soup
soup_level1 = BeautifulSoup(driver.page_source, 'lxml')
print(soup_level1)
