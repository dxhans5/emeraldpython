<?php

namespace App\Classes\eBayAPI;

use App\Classes\eBayAPI\eBaySession;

class GetSessionID
{
    private $RuName;
    private $ErrorLanguage;
    private $MessageID;
    private $Version;
    private $WarningLevel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->RuName = env("EBAY_RUNAME");
        $this->ErrorLanguage = 'en_US';
        $this->MessageID = 'PUGeBay_GetSessionID';
        $this->Version = '1085';
        $this->WarningLevel = 'High';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetSessionIDRequest  xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";
        $requestXmlBody .= "<RuName>$this->RuName</RuName>";
        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetSessionIDRequest >";

        $session = new eBaySession(null, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'GetSessionID');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        //Xml string is parsed and creates a DOM Document object
        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //print_r($responseDoc->getElementsByTagName('SessionID')->item(0)->nodeValue); die();
        return $responseDoc->getElementsByTagName('SessionID')->item(0)->nodeValue;
    }
}
