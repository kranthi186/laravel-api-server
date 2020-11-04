<?php
use App\Models\Retailer;
use App\Models\Brand;

$user = Auth::user();
if($user->user_type == 1) {
    $retailer = Retailer::where('user_id', $user->id)->first();
} else if ($user->user_type == 2) {
    $retailer = Brand::where('user_id', $user->id)->first();
}

$avatar_url = asset('img/demo/avatars/avatar-user.png');
if($retailer) {
    if($retailer->logo) {
        $avatar_url = $retailer->logo;
    }
}
?>
<!-- BEGIN PRIMARY NAVIGATION -->
<nav id="js-primary-nav" class="primary-nav" role="navigation">
    <div class="nav-filter">
        <div class="position-relative">
            <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
            <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle"
                data-class="list-filter-active" data-target=".page-sidebar">
                <i class="fal fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="info-card">
        <img src="{{$avatar_url}}" class="profile-image" alt="local product">
        <div class="info-card-text">
            <a href="#" class="d-flex align-items-center text-white">
                <span class="text-truncate text-truncate-sm d-inline-block">
                    Local Product
                </span>
            </a>
            <span class="d-inline-block text-truncate text-truncate-sm">Denver, Colorado</span>
        </div>
        <img src="{{asset('img/card-backgrounds/cover-2-lg.png')}}" class="cover" alt="cover">

    </div>
    <ul id="js-nav-menu" class="nav-menu">

        <li class="<?php if($kind == 'app') echo 'open' ?>">
            <a href="#" title="Application Intel" data-filter-tags="application intel">
                <i class="fal fa-chart-line"></i>
                <span class="nav-link-text" data-i18n="nav.application_intel">App Management</span>
            </a>
            <ul class="<?php echo $kind == 'app' ? 'show' : 'hide' ?>">
                <li class="<?php if($page == 'dashboard') echo 'active' ?>">
                    <a href="/dashboard" title="Marketing Dashboard"
                        data-filter-tags="application intel marketing dashboard">
                        <span class="nav-link-text" data-i18n="nav.application_intel_marketing_dashboard">Analytics
                            Dashboard</span>
                    </a>
                </li>
                <li class="<?php if($page == 'listing') echo 'active' ?>">
                    <a href="/listing" title="Manage Listing" data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Manage
                            Listing</span>
                    </a>
                </li>
                <li class="<?php if($page == 'products') echo 'active' ?>">
                    <a href="/retailer_products" title="Manage Products"
                        data-filter-tags="application intel introduction">
                        <span class="nav-link-text" data-i18n="nav.application_intel_introduction">Manage
                            Products</span>
                    </a>
                </li>
                <li>
                    <a href="cutsomers.html" title="Manage Customers" data-filter-tags="application intel build notes">
                        <span class="nav-link-text" data-i18n="nav.application_intel_build_notes">Approve
                            Customers</span>
                        <span class="">(5)</span>
                    </a>
                </li>
                <li>
                    <a href="reviews.html" title="Manage Reviews" data-filter-tags="application intel privacy">
                        <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Manage
                            Reviews</span>
                    </a>
                </li>
                < </ul> </li> <li class="<?php if($kind == 'fleet') echo 'open' ?>">
                    <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                        <i class="fal fa-truck"></i>
                        <span class="nav-link-text" data-i18n="nav.theme_settings">Fleet Management</span>
                    </a>
                    <ul class="<?php echo $kind == 'fleet' ? 'show' : 'hide' ?>">
                        <li>
                            <a href="settings_how_it_works.html" title="How it works"
                                data-filter-tags="theme settings how it works">
                                <span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Vehicle
                                    Tracking</span>
                                <span class="">(4)</span>
                            </a>
                        </li>
                        <li>
                            <a href="settings_layout_options.html" title="Layout Options"
                                data-filter-tags="theme settings layout options">
                                <span class="nav-link-text" data-i18n="nav.theme_settings_layout_options">History</span>
                            </a>
                        </li>
                        <li>
                            <a href="settings_skin_options.html" title="Skin Options"
                                data-filter-tags="theme settings skin options">
                                <span class="nav-link-text" data-i18n="nav.theme_settings_skin_options">Driver
                                    Management</span>
                            </a>
                        </li>
                    </ul>
        </li>

        <li class="nav-title">Active Orders</li>
        <li>
            <a href="#" title="Package Info" data-filter-tags="package info">
                <i class="fal fa-shipping-fast"></i>
                <span class="nav-link-text" data-i18n="nav.package_info">Deliveries</span>
                <span class="">(4)</span>
            </a>
            <a href="#" title="Package Info" data-filter-tags="package info">
                <i class="fal fa-shopping-bag"></i>
                <span class="nav-link-text" data-i18n="nav.package_info">In-store Pick-Ups</span>
                <span class="">(3)</span>
            </a>
            <a href="#" title="Package Info" data-filter-tags="package info">
                <i class="fal fa-clock"></i>
                <span class="nav-link-text" data-i18n="nav.package_info">History</span>
            </a>
            <a href="#" title="Package Info" data-filter-tags="package info">
                <i class="fal fa-cogs"></i>
                <span class="nav-link-text" data-i18n="nav.package_info">Settings</span>
            </a>
        </li>
        <li class="nav-title">Earnings and Balance</li>
        <li>
            <a href="#" title="Package Info" data-filter-tags="package info">
                <i class="ni ni-wallet"></i>
                <span class="nav-link-text" data-i18n="nav.package_info">Wallet</span>
            </a>
            <ul>
                <li>
                    <a href="info_app_docs.html" title="Documentation" data-filter-tags="package info documentation">
                        <span class="nav-link-text" data-i18n="nav.package_info_documentation">Budbo
                            Wallet</span>
                    </a>
                </li>
                <li>
                    <a href="info_app_docs.html" title="Documentation" data-filter-tags="package info documentation">
                        <span class="nav-link-text" data-i18n="nav.package_info_documentation">Send and
                            Receive</span>
                    </a>
                </li>
                <li>
                    <a href="info_app_licensing.html" title="Product Licensing"
                        data-filter-tags="package info product licensing">
                        <span class="nav-link-text" data-i18n="nav.package_info_product_licensing">Token
                            Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="info_app_flavors.html" title="Different Flavors"
                        data-filter-tags="package info different flavors">
                        <span class="nav-link-text" data-i18n="nav.package_info_different_flavors">Token
                            Exchange</span>
                    </a>
                </li>
            </ul>
        </li>
        <div class="filter-message js-filter-message bg-success-600"></div>
</nav>
<!-- END PRIMARY NAVIGATION -->