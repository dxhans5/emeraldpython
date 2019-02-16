<?php

namespace App\Classes\eBayAPI;

use Illuminate\Http\Request;
use App\Classes\eBayAPI\eBaySession;
use Facades\App\Classes\eBayAPI\GetSuggestedCategories;

class AddFixedPriceItem extends eBayAPI
{

    private $listing;
    private $listing_type = 'FixedPriceItem';
    private $listing_duration = 'Days_30';
    private $autopay = true;
    private $condition_id = 1000; // New w/ Tags
    private $country = 'US';
    private $currency = 'USD';
    private $item_location = 'Boise, ID USA';
    private $dispatch_max_time = 1; // One Day
    private $include_recommendations = true;
    private $payment_methods = ['PayPal'];
    private $paypal_email_address = 'info@the-vaping-pug.com';
    private $site_id = 0; // US
    private $free_shipping = true;
    /* The following options need to go away if we ever offer options for shipping */
    private $shipping_service_priority = 1;
    private $shipping_service = 'USPSPriority';
    private $shipping_service_cost = 0.00;
    private $shipping_service_additional_cost = 0.00;
    /*   */

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
    public function handle(Request $request, $productScrape)
    {
        $user_token = $request->session()->get('user_token');
        $product = json_decode($productScrape);

        $requestXmlBody = "<?xml version='1.0' encoding='utf-8' ?>";
        $requestXmlBody .= "<AddFixedPriceItemRequest xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $requestXmlBody .= "<!-- Call-specific Input Fields -->";

        $requestXmlBody .= "<Item>";

        // Currency
        $requestXmlBody .= "<Currency>$this->currency</Currency>";

        // Country
        $requestXmlBody .= "<Country>$this->country</Country>";

        // Listing Duration
        $requestXmlBody .= "<ListingDuration>$this->listing_duration</ListingDuration>";

        // Primary Category
        $primary_category_id = $this->getPrimaryCategoryID($request, $product);
        $requestXmlBody .= "<PrimaryCategory>";
        $requestXmlBody .= "<CategoryID>$primary_category_id</CategoryID>";
        $requestXmlBody .="</PrimaryCategory>";

        // Condition
        $requestXmlBody .= "<ConditionID>$this->condition_id</ConditionID>";

        // Price
        $requestXmlBody .= "<StartPrice>" . floatval($product->price). "</StartPrice>";

        // Shipping
        $requestXmlBody .= "<ShippingDetails>";
        $requestXmlBody .= "<ShippingServiceOptions>";
        $requestXmlBody .= "<ShippingServicePriority>$this->shipping_service_priority</ShippingServicePriority>";
        $requestXmlBody .= "<FreeShipping>$this->free_shipping</FreeShipping>";
        $requestXmlBody .= "<ShippingService>$this->shipping_service</ShippingService>";
        $requestXmlBody .= "<ShippingServiceCost currencyID='$this->currency'>$this-> </ShippingServiceCost>";
        $requestXmlBody .= "<ShippingService>$this->shipping_service</ShippingService>";
        $requestXmlBody .= "</ShippingServiceOptions>";
        $requestXmlBody .= "</ShippingDetails>";

        $requestXmlBody .= "</Item>";

        $requestXmlBody .= "<!-- Authentication -->";
        $requestXmlBody .= "<RequesterCredentials>";
        $requestXmlBody .= "<eBayAuthToken>$user_token</eBayAuthToken>";
        $requestXmlBody .= "</RequesterCredentials>";

        $requestXmlBody .= "<!-- Standard Input Fields -->";
        $requestXmlBody .= "<ErrorLanguage>$this->ErrorLanguage</ErrorLanguage>";
        $requestXmlBody .= "<MessageID>$this->MessageID</MessageID>";
        $requestXmlBody .= "<Version>$this->Version</Version>";
        $requestXmlBody .= "<WarningLevel>$this->WarningLevel</WarningLevel>";
        $requestXmlBody .= "</AddFixedPriceItemRequest >";

        $session = new eBaySession($user_token, env('EBAY_DEV_ID'), env('EBAY_CLIENT_ID'), env('EBAY_SECRET'), env('EBAY_XML_DOMAIN'), 1085, 0, 'AddFixedPriceItem');
        $responseXml = $session->sendHttpRequest($requestXmlBody);

        $responseDoc = new \DomDocument();
        $responseDoc->loadXML($responseXml);

        //get any error nodes
        $errors = $responseDoc->getElementsByTagName('Errors');
        $this->displayErrors($errors);

        return [];
    }

    /*
     *      getPrimaryCategoryID
     *      Returns the primary category ID for the product
     */
    private function getPrimaryCategoryID($request, $product) {
        $category_path = $this->getCategorySuggestions($request, $product->title);

        end($category_path);

        return key($category_path);
    }

    /*
     *      getCategorySuggestions
     *      Returns the suggestions for a given category
     */
    private function getCategorySuggestions($request, String $title) {
        $query = $this->formatForCategorySuggestions($title);

        return GetSuggestedCategories::handle($request, $query);
    }

    /*
     *      formatForCategorySuggestions
     *      Formats the title to remove all unneccesary items used for category suggestions
     */
    private function formatForCategorySuggestions(String $title) {
        $removePhrases = [
            'in.'
        ];
        $query = preg_replace("/[0-9]+/", "", $title);
        $query = preg_replace("/(^| ).( |$)/", "", $query);

        foreach($removePhrases as $phrase) {
            $query = preg_replace("/$phrase/", "", $query);
        }

        return $query;
    }
}
