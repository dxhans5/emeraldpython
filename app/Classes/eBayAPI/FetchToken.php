<?php

namespace App\Classes\eBayAPI;

use Illuminate\Support\Facades\Session;
use App\Classes\eBayAPI\eBaySession;

class FetchToken extends eBayAPI
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
        $requestXmlBody .= "<FetchTokenRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";
        $requestXmlBody .= "<SessionID> string </SessionID>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</FetchTokenRequest >";

        $session = new eBaySession(null, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'FetchToken');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');
        $this->displayErrors($errors);

        return $responseDoc->getElementsByTagName('SessionID')->item(0)->nodeValue;
    }
}
