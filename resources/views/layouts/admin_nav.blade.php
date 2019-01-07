<nav class='p-0 m-0'>
    <div class='row p-2'>
        <div class='col-sm-12'>
            <h5>EMERALD<span class='blue'>python</span></h5>
            <h5 class='pt-2'><span class='red'>ADMINISTRATION</span></h5>
            <ul class='mt-4'>
                <li><a href='{{ url("admin/") }}'><i class="fas fa-columns"></i> Dashboard</a></li>
                <li>
                    <a data-toggle='collapse' href='#account-dropdown'><i class="fas fa-scroll"></i> Account <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='account-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/account/fulfillment-policy") }}'>Fulfillment Policy</a></li>
                            <li><a href='{{ url("admin/account/payment-policy") }}'>Payment Policy</a></li>
                            <li><a href='{{ url("admin/account/payments-program") }}'>Payments Program</a></li>
                            <li><a href='{{ url("admin/account/privilege") }}'>Privilege</a></li>
                            <li><a href='{{ url("admin/account/program") }}'>Program</a></li>
                            <li><a href='{{ url("admin/account/rate-table") }}'>Rate Table</a></li>
                            <li><a href='{{ url("admin/account/return-policy") }}'>Return Policy</a></li>
                            <li><a href='{{ url("admin/account/sales-tax") }}'>Sales Tax</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#inventory-dropdown'><i class="fas fa-boxes"></i> Inventory <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='inventory-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/inventory/inventory-item") }}'>Inventory Item</a></li>
                            <li><a href='{{ url("admin/inventory/privilege") }}'>Inventory Item Group</a></li>
                            <li><a href='{{ url("admin/inventory/listing") }}'>Listing</a></li>
                            <li><a href='{{ url("admin/inventory/location") }}'>Location</a></li>
                            <li><a href='{{ url("admin/inventory/offer") }}'>Offer</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#fulfillment-dropdown'><i class="fas fa-truck"></i> Fulfillment <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='fulfillment-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/fulfillment/order") }}'>Order</a></li>
                            <li><a href='{{ url("admin/fulfillment/shipping-fulfillment") }}'>Shipping Fulfillment</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#marketing-dropdown'><i class="fas fa-ad"></i> Marketing <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='marketing-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/marketing/ad") }}'>Ad</a></li>
                            <li><a href='{{ url("admin/marketing/campaign") }}'>Campaign</a></li>
                            <li><a href='{{ url("admin/marketing/ad-report") }}'>Ad Report</a></li>
                            <li><a href='{{ url("admin/marketing/ad-report-metadata") }}'>Ad Report Metadata</a></li>
                            <li><a href='{{ url("admin/marketing/ad-report-taks") }}'>Ad Report Task</a></li>
                            <li><a href='{{ url("admin/marketing/item-price-markdown") }}'>Item Price Markdown</a></li>
                            <li><a href='{{ url("admin/marketing/item-promotion") }}'>Item Promotion</a></li>
                            <li><a href='{{ url("admin/marketing/promotion") }}'>Promotion</a></li>
                            <li><a href='{{ url("admin/marketing/promotion-report") }}'>Promotion Report</a></li>
                            <li><a href='{{ url("admin/marketing/promotion-summary-report") }}'>Promotion Summary Report</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#logistics-dropdown'><i class="fas fa-clipboard-list"></i> Logistics <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='logistics-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/logistics/shipping-quote") }}'>Shipping Quote</a></li>
                            <li><a href='{{ url("admin/logistics/shipment") }}'>Shipment</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#analytics-dropdown'><i class="fas fa-receipt"></i> Analytics <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='analytics-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/analytics/seller-standards-profile") }}'>Seller Standards Profile</a></li>
                            <li><a href='{{ url("admin/analytics/traffic-report") }}'>Traffic Report</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#metadata-dropdown'><i class="fas fa-allergies"></i> Metadata <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='metadata-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/metadata/country") }}'>Country</a></li>
                            <li><a href='{{ url("admin/metadata/marketplace") }}'>Marketplace</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a data-toggle='collapse' href='#compliance-dropdown'><i class="fas fa-bomb"></i> Compliance <i class="fas fa-sort-down"></i></a>
                    <div class='collapse mt-1' id='compliance-dropdown'>
                        <ul>
                            <li><a href='{{ url("admin/compliance/listing-violation") }}'>Listing Violation</a></li>
                            <li><a href='{{ url("admin/compliance/listing-violation-summary") }}'>Listing Violation Summary</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>









<!--<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav mr-auto">

                    </ul>


                    <ul class="navbar-nav ml-auto">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
-->
