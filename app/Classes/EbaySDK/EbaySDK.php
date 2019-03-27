<?php

namespace App\Classes\EbaySDK;

use DTS\eBaySDK\Trading\Types;
use DTS\eBaySDK\Trading\Services\TradingService;
use DTS\eBaySDK\Trading\Types\AddItemRequestType;
use DTS\eBaySDK\Trading\Types\ItemType;
use DTS\eBaySDK\Credentials\Credentials;

class EbaySDK {

    private $service;

    public function __construct() {
        $this->service = new TradingService([
            'apiVersion'  => '1099',
            'globalId'    => 'EBAY-US',
            'siteId'      => '1',
            'credentials' => [
                'appId'  => env("EBAY_APPID"),
                'certId' => env("EBAY_CERTID"),
                'devId'  => env("EBAY_DEVID")
            ]
        ]);
    }

    public function AddItem($request) {
        // Create item to sell here
        $item = [];

        $addItemRequestType = new AddItemRequestType($item);
        $addItemRequestType->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $addItemRequestType->RequesterCredentials->eBayAuthToken = env("EBAY_TOKEN");

        $request = $this->service->addItem($addItemRequestType);

        return $request;
    }

}
