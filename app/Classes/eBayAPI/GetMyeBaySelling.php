<?php

namespace App\Classes\eBayAPI;

use App\Classes\eBayAPI\eBaySession;

class GetMyeBaySelling extends eBayAPI
{

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetMyeBaySellingRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";

        // Active List
        $requestXmlBody .= "<ActiveList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "<IncludeNotes>true</IncludeNotes>";
        $requestXmlBody .= "<ListingType>FixedPriceItem</ListingType>";
        $requestXmlBody .= "</ActiveList>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetMyeBaySellingRequest >";

        $session = new eBaySession(null, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'GetMyeBaySelling');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');
        $this->displayErrors($errors);

        print_r($responseDoc); die();

        $eBayAuthToken = $responseDoc->getElementsByTagName('eBayAuthToken')->item(0)->nodeValue;
        $HardExpirationTime = $responseDoc->getElementsByTagName('HardExpirationTime')->item(0)->nodeValue;

        return ['user_token' => $eBayAuthToken, 'user_token_expires_at' => $HardExpirationTime];
    }
}
