<?php

namespace App\Classes\eBayAPI;

use Illuminate\Http\Request;
use App\Classes\eBayAPI\eBaySession;

class GetCategorySpecifics extends eBayAPI
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

    public function handle($request) {
        $user_token = $request->session()->get('user_token');

        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetCategorySpecificsRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";

        $requestXmlBody .= "<!-- Authentication -->";
        $requestXmlBody .= "<RequesterCredentials>";
        $requestXmlBody .= "<eBayAuthToken>$user_token</eBayAuthToken>";
        $requestXmlBody .= "</RequesterCredentials>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetCategorySpecificsRequest>";

        $session = new eBaySession($user_token, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'GetCategorySpecifics');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');

        print_r($request->session()->all()); die();
        print_r($responseDoc); die();
    }

}
