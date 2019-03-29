import sys
import json

from ebaysdk.exception import ConnectionError
from ebaysdk.trading import Connection as trading

APPID = "PugVentu-Primary-PRD-d5d7504c4-fe7871e2"
DEVID = "cb70e5b0-d647-4401-a33f-91702d7ed6c4"
CERTID = "PRD-5d7504c42790-3986-4fac-a791-e208"
TOKEN = "AgAAAA**AQAAAA**aAAAAA**AyKdXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ACmYOiD5iLqQ+dj6x9nY+seQ**mBUEAA**AAMAAA**lvv/CYRnI3v8D/ejgOazwtdal0tY664jJrmRh0EvuXcbBUy6ag8CGWBVionEp6HrjQIg0j14E5yo7+30y+Apwn2wGd11ja7OrR2D6Bg1TRiByaRAa4KmFBLu6u6dmlIZzWWUhkWEDoN0jjDA6MOyZOWkfUu9xpLeU6QxLB+oXZwgtoi/4OmKdhCTmLbng6I+KLhQki3gj6wrVo/hFaaD1XXPRaUju2coeouZtpywtFok50jhq3e1+PuSC4vhXzunJQOTdnmpIdUU5XUBBmwalB8IHCIuJcvSgYUqwDpCxW5tSzn6IZLwyRqn0YRDlDoVsLg6+jRdGa4bs5lZpKBYFsbv0ElKwv0a5uiVe6MCcqonSAo1cy5CtL1k0tGoVtexGs1SvUvcu6uXY7dQJ0/WnLyHLc++8VhOo8tFO0IP4xTLx6pbNppWnsKFHc3DFUIQ+/ZncyemLE4tDe6qJV3OoVqD7tnWEbT0x6P4bp5MJWZ5PaTbA8ZODHOVIxvnoUIUh2y5EnsNg9nCfrQNFD3BmVE4oqcT5SEePHOt7OLohCO1SsuOavHmBIkqP4zyBToEWRYvTWGQsNcZ7VrQL2AN1298y00oiZJaYNe5tDJJay44j3/JpeAnk0kZscTUn/w0eIOF2M33vSh6D0xnibYIdr0kbxi1vDuGXGD1FxJChIeEzao/GNX5Sd+6r2dH1DYG/ZHxDJ41Znq8y387BWeeGzAkkU2qalYu8PfoS04hbdns5pXpAfFTkL2niNbbUerd"


class Ebay:

    def __init__(self, module, endpoint, payload):
        mods = {
            'Trading':  trading(appid=APPID, devid=DEVID, certid=CERTID, token=TOKEN, config_file=None)
        }
        try:
            api = mods.get(module)
            response = api.execute(endpoint, json.loads(payload))
            print(json.dumps(response.dict()))
            print(json.dumps(response.reply))
        except ConnectionError as e:
            print(json.dumps(e.response.dict()))


Ebay(sys.argv[1], sys.argv[2], sys.argv[3])
