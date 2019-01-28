<?php

namespace App\Classes\eBayAPI;

use Illuminate\Http\Request;
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
    public function handle(Request $request)
    {
        $user_token = $request->session()->get('user_token');

        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetMyeBaySellingRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";

        // Active List
        $requestXmlBody .= "<ActiveList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</ActiveList>";

        // Deleted From Sold List
        $requestXmlBody .= "<DeletedFromSoldList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</DeletedFromSoldList>";

        // Deleted From UnSold List
        $requestXmlBody .= "<DeletedFromUnsoldList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</DeletedFromUnsoldList>";

        // Scheduled List
        $requestXmlBody .= "<ScheduledList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</ScheduledList>";

        // Selling Summary
        $requestXmlBody .= "<SellingSummary>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</SellingSummary>";

        // Sold List
        $requestXmlBody .= "<SoldList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</SoldList>";

        // Unsold List
        $requestXmlBody .= "<UnsoldList>";
        $requestXmlBody .= "<Include>true</Include>";
        $requestXmlBody .= "</UnsoldList>";

        $requestXmlBody .= "<!-- Authentication -->";
        $requestXmlBody .= "<RequesterCredentials>";
        $requestXmlBody .= "<eBayAuthToken>$user_token</eBayAuthToken>";
        $requestXmlBody .= "</RequesterCredentials>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetMyeBaySellingRequest >";

        $session = new eBaySession($user_token, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'GetMyeBaySelling');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');

        $activeList = $responseDoc->getElementsByTagName('ActiveList');
        $deletedFromSoldList = $responseDoc->getElementsByTagName('DeletedFromSoldList');
        $deletedFromUnsoldList = $responseDoc->getElementsByTagName('DeletedFromUnsoldList');
        $scheduledList = $responseDoc->getElementsByTagName('ScheduledList');
        $sellingSummary = $responseDoc->getElementsByTagName('SellingSummary');
        $soldList = $responseDoc->getElementsByTagName('SoldList');
        $unsoldList = $responseDoc->getElementsByTagName('UnsoldList');

        return ['active_list' => $activeList, 'deleted_from_sold_list' => $deletedFromSoldList, 'deleted_from_unsold_list' => $deletedFromUnsoldList, 'scheduled_list' => $scheduledList, 'selling_summary' => $sellingSummary, 'sold_list' => $soldList, 'unsold_list' => $unsoldList];
    }
}
