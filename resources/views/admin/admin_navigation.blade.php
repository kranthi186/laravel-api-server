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
        <!-- <img src="img/demo/avatars/avatar-admin.png" class="profile-image" alt="local product"> -->
        <div class="info-card-text">
            <a href="#" class="d-flex align-items-center text-white">
                <span class="text-truncate text-truncate-sm d-inline-block">
                    Administrator
                </span>
            </a>
            <span class="d-inline-block text-truncate text-truncate-sm">Denver, Colorado</span>
        </div>
        <img src="{{asset('img/card-backgrounds/cover-2-lg.png')}}" class="cover" alt="cover">

    </div>
    <ul id="js-nav-menu" class="nav-menu">
        <li class="<?php if($page == 'dashboard') echo 'active' ?>">
            <a href="/" title="Package Info" data-filter-tags="package info">
                <i class="fal fa-chart-line"></i>
                <span class="nav-link-text" data-i18n="nav.package_info">Analytics Dashboard</span>
            </a>
        </li>
        <li class="open">
            <a href="#" title="Application Intel" data-filter-tags="application intel">
                <i class="fal fa-mobile"></i>
                <span class="nav-link-text" data-i18n="nav.application_intel">App Management</span>
            </a>
            <ul class="<?php echo $page != 'dashboard' ? 'show' : 'hide' ?>">
                <li class="<?php if($page == 'users') echo 'active' ?>">
                    <a href="/users" title="Users" data-filter-tags="application intel privacy">
                        <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Users</span>
                    </a>
                </li>
                <li class="<?php if($page == 'brands') echo 'active' ?>">
                    <a href="/brands" title="Brands" data-filter-tags="application intel analytics dashboard">
                        <span class="nav-link-text" data-i18n="nav.application_intel_analytics_dashboard">Brands</span>
                    </a>
                </li>
                <li class="<?php if($page == 'retailers') echo 'active' ?>">
                    <a href="/retailers" title="Retailers" data-filter-tags="application intel introduction">
                        <span class="nav-link-text" data-i18n="nav.application_intel_introduction">Retailers</span>
                    </a>
                </li>
                <li class="<?php if($page == 'products') echo 'active' ?>">
                    <a href="/admin_products" title="Products" data-filter-tags="application intel build notes">
                        <span class="nav-link-text" data-i18n="nav.application_intel_build_notes">Products</span>
                        <!-- <span class="">(5)</span> -->
                    </a>
                </li>
                <li class="<?php if($page == 'reviews') echo 'active' ?>">
                    <a href="/reviews" title="Reviews" data-filter-tags="application intel privacy">
                        <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Reviews</span>
                    </a>
                </li>
                <li class="<?php if($page == 'news') echo 'active' ?>">
                    <a href="/news" title="News" data-filter-tags="application intel privacy">
                        <span class="nav-link-text" data-i18n="nav.application_intel_privacy">News</span>
                    </a>
                </li>
                <li class="<?php if($page == 'notifications') echo 'active' ?>">
                    <a href="/notifications" title="Manage Reviews" data-filter-tags="application intel privacy">
                        <span class="nav-link-text" data-i18n="nav.application_intel_privacy">Push Notifications</span>
                    </a>
                </li>
            </ul>
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
                        <span class="nav-link-text" data-i18n="nav.package_info_documentation">Budbo Wallet</span>
                    </a>
                </li>
                <li>
                    <a href="info_app_docs.html" title="Documentation" data-filter-tags="package info documentation">
                        <span class="nav-link-text" data-i18n="nav.package_info_documentation">Send and Receive</span>
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
                        <span class="nav-link-text" data-i18n="nav.package_info_different_flavors">Token Exchange</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="filter-message js-filter-message bg-success-600"></div>
</nav>
<!-- END PRIMARY NAVIGATION -->