from ebaysdk.exception import ConnectionError
from ebaysdk.trading import Connection as trading


class TradingModule:

    def AddItem(self, payload):
        item = payload
        print(item)

    def __init__(self, endpoint, payload):
        funcs = {
            'AddItem': self.AddItem
        }

        # Execute the func
        func = funcs.get(endpoint)
        func(payload)
