<?php

namespace App\Classes\eBayAPI;

use Illuminate\Http\Request;
use App\Classes\eBayAPI\eBaySession;

class GetSuggestedCategories extends eBayAPI
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

    public function handle($request, String $query) {
        $user_token = $request->session()->get('user_token');

        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<GetSuggestedCategoriesRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";

        $requestXmlBody .= "<Query>$query</Query>";

        $requestXmlBody .= "<!-- Authentication -->";
        $requestXmlBody .= "<RequesterCredentials>";
        $requestXmlBody .= "<eBayAuthToken>" . env('PROD_KEY'). "</eBayAuthToken>";
        $requestXmlBody .= "</RequesterCredentials>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</GetSuggestedCategoriesRequest>";

        $session = new eBaySession(env('PROD_KEY'), env('EBAY_DEV_ID_PROD'), env('EBAY_CLIENT_ID_PROD'), env('EBAY_SECRET_PROD'), env('EBAY_XML_DOMAIN_PROD'), 1085, 0, 'GetSuggestedCategories');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        print_r($responseXml); die();

        return ['category_count' => $categoryCount->item(0)->nodeValue];

    }

}
