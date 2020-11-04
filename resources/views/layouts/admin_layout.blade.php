@extends('layouts.master')

@section('body')

<!-- DOC: script to save and load page settings -->
<script>
    /**
         *  This script should be placed right after the body tag for fast execution 
         *  Note: the script is written in pure javascript and does not depend on thirdparty library
         **/
        'use strict';

        var classHolder = document.getElementsByTagName("BODY")[0],
            /** 
             * Load from localstorage
             **/
            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
            themeURL = themeSettings.themeURL || '',
            themeOptions = themeSettings.themeOptions || '';
        /** 
         * Load theme options
         **/
        if (themeSettings.themeOptions)
        {
            classHolder.className = themeSettings.themeOptions;
            console.log("%c✔ Theme settings loaded", "color: #148f32");
        }
        else
        {
            console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
        }
        if (themeSettings.themeURL && !document.getElementById('mytheme'))
        {
            var cssfile = document.createElement('link');
            cssfile.id = 'mytheme';
            cssfile.rel = 'stylesheet';
            cssfile.href = themeURL;
            document.getElementsByTagName('head')[0].appendChild(cssfile);
        }
        /** 
         * Save to localstorage 
         **/
        var saveSettings = function()
        {
            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
            {
                return /^(nav|header|mod|display)-/i.test(item);
            }).join(' ');
            if (document.getElementById('mytheme'))
            {
                themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
            };
            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
        }
        /** 
         * Reset settings
         **/
        var resetSettings = function()
        {
            localStorage.setItem("themeSettings", "");
        }

</script>
<!-- BEGIN Page Wrapper -->
<div class="page-wrapper">
    <div class="page-inner">
        <!-- BEGIN Left Aside -->
        <aside class="page-sidebar">
            <div class="page-logo">
                <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                    data-toggle="modal" data-target="#modal-shortcut">
                    <img src="{{asset('img/logo.png')}}" alt="Budbo" width="29px" aria-roledescription="logo">
                    <span class="page-logo-text mr-1">Budbo</span>
                    <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>

                </a>
            </div>
            <!-- BEGIN PRIMARY NAVIGATION -->
            @yield('navigation')
            <!-- END PRIMARY NAVIGATION -->
            <!-- NAV FOOTER -->

            <!-- END NAV FOOTER -->
        </aside>
        <!-- END Left Aside -->
        <div class="page-content-wrapper">
            <!-- BEGIN Page Header -->
            <header class="page-header" role="banner">
                <!-- we need this logo when user switches to nav-function-top -->
                <div class="page-logo">
                    <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                        data-toggle="modal" data-target="#modal-shortcut">
                        <img src="{{asset('img/logo.png')}}" alt="Budbo" aria-roledescription="logo">
                        <span class="page-logo-text mr-1">Budbo</span>
                        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                        <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                    </a>
                </div>

                <div class="hidden-lg-up">
                    <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                        <i class="ni ni-menu"></i>
                    </a>
                </div>

                <div class="ml-auto d-flex">
                    <!-- Approve Users -->
                    <a href="#" class="header-icon">
                        <i class="fal fa-user-plus"></i>
                        <span class="badge badge-icon">5</span>
                    </a>
                    <!-- Active Deliveries -->
                    <a href="#" class="header-icon">
                        <i class="fal fa-shipping-fast"></i>
                        <span class="badge badge-icon">4</span>
                    </a>
                    <!-- app notification -->
                    <div>
                        <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                            <i class="fal fa-bell"></i>
                            <span class="badge badge-icon">1</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
                            <div
                                class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
                                <h4 class="m-0 text-center color-white">
                                    1 New
                                    <small class="mb-0 opacity-80">User Notifications</small>
                                </h4>
                            </div>
                            <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab"
                                        href="#tab-feeds" data-i18n="drpdwn.feeds">Notifications</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-notification">
                                <div class="tab-pane active p-3 text-center">
                                    <h5 class="mt-4 pt-4 fw-500">
                                        <span class="d-block fa-3x pb-4 text-muted">
                                            <i class="ni ni-arrow-up text-gradient opacity-70"></i>
                                        </span> Select a tab above to activate
                                        <small class="mt-3 fs-b fw-400 text-muted">
                                            This blank page message helps protect your privacy, or you can show the
                                            first message here automatically through
                                            <a href="#">settings page</a>
                                        </small>
                                    </h5>
                                </div>
                                <div class="tab-pane" id="tab-feeds" role="tabpanel">
                                    <div class="custom-scroll h-100">
                                        <ul class="notification">
                                            <li class="unread">
                                                <div class="d-flex align-items-center show-child-on-hover">
                                                    <span class="d-flex flex-column flex-1">
                                                        <span class="name d-flex align-items-center">Administrator <span
                                                                class="badge badge-success fw-n ml-1">UPDATE</span></span>
                                                        <span class="msg-a fs-sm">
                                                            System updated to version <strong>4.0.2</strong> <a
                                                                href="intel_build_notes.html">(patch notes)</a>
                                                        </span>
                                                        <span class="fs-nano text-muted mt-1">5 mins ago</span>
                                                    </span>
                                                    <div
                                                        class="show-on-hover-parent position-absolute pos-right pos-bottom p-3">
                                                        <a href="#" class="text-muted" title="delete"><i
                                                                class="fal fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="py-2 px-3 bg-faded d-block rounded-bottom text-right border-faded border-bottom-0 border-right-0 border-left-0">
                                <a href="#" class="fs-xs fw-500 ml-auto">view all notifications</a>
                            </div>
                        </div>
                    </div>
                    <!-- app user menu -->
                    <div>
                        <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com"
                            class="header-icon d-flex align-items-center justify-content-center ml-2">
                            <img src="{{asset('img/demo/avatars/avatar-admin.png')}}"
                                class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                            <!-- you can also add username next to the avatar with the codes below:
                                <span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
                                <i class="ni ni-chevron-down hidden-xs-down"></i> -->
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                            <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                    <span class="mr-2">
                                        <img src="{{asset('img/demo/avatars/avatar-admin.png')}}"
                                            class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                                    </span>
                                    <div class="info-card-text">
                                        <div class="fs-lg text-truncate text-truncate-lg">Local Product</div>
                                        <span class="text-truncate text-truncate-md opacity-80">Denver, CO</span>
                                    </div>
                                </div>
                            </div>

                            <a class="dropdown-item fw-500 pt-3 pb-3" href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <span data-i18n="drpdwn.page-logout">Logout</span>
                                <span class="float-right fw-n">&commat;LocalProduct</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END Page Header -->
            <!-- BEGIN Page Content -->

            <!-- the #js-page-content id is needed for some plugins to initialize -->
            <main id="js-page-content" role="main" class="page-content">

                @yield('page_content')

            </main>
            <!-- this overlay is activated only when mobile menu is triggered -->
            <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
            <!-- END Page Content -->
            <!-- BEGIN Page Footer -->
            <footer class="page-footer" role="contentinfo">
                <div class="d-flex align-items-center flex-1 text-muted">
                    <span class="hidden-md-down fw-700">2020 © Budbo </span>
                </div>
                <div>
                    <ul class="list-table m-0">
                        <li class="pl-3"><a href="#" class="text-secondary fw-700">About</a></li>
                        <li class="pl-3"><a href="#" class="text-secondary fw-700">Privacy Policy</a></li>
                        <li class="pl-3"><a href="#" class="text-secondary fw-700">Terms</a></li>
                    </ul>
                </div>
            </footer>
            <!-- END Page Footer -->

            <!-- BEGIN Color profile -->
            <!-- this area is hidden and will not be seen on screens or screen readers -->
            <!-- we use this only for CSS color refernce for JS stuff -->
            <p id="js-color-profile" class="d-none">
                <span class="color-primary-50"></span>
                <span class="color-primary-100"></span>
                <span class="color-primary-200"></span>
                <span class="color-primary-300"></span>
                <span class="color-primary-400"></span>
                <span class="color-primary-500"></span>
                <span class="color-primary-600"></span>
                <span class="color-primary-700"></span>
                <span class="color-primary-800"></span>
                <span class="color-primary-900"></span>
                <span class="color-info-50"></span>
                <span class="color-info-100"></span>
                <span class="color-info-200"></span>
                <span class="color-info-300"></span>
                <span class="color-info-400"></span>
                <span class="color-info-500"></span>
                <span class="color-info-600"></span>
                <span class="color-info-700"></span>
                <span class="color-info-800"></span>
                <span class="color-info-900"></span>
                <span class="color-danger-50"></span>
                <span class="color-danger-100"></span>
                <span class="color-danger-200"></span>
                <span class="color-danger-300"></span>
                <span class="color-danger-400"></span>
                <span class="color-danger-500"></span>
                <span class="color-danger-600"></span>
                <span class="color-danger-700"></span>
                <span class="color-danger-800"></span>
                <span class="color-danger-900"></span>
                <span class="color-warning-50"></span>
                <span class="color-warning-100"></span>
                <span class="color-warning-200"></span>
                <span class="color-warning-300"></span>
                <span class="color-warning-400"></span>
                <span class="color-warning-500"></span>
                <span class="color-warning-600"></span>
                <span class="color-warning-700"></span>
                <span class="color-warning-800"></span>
                <span class="color-warning-900"></span>
                <span class="color-success-50"></span>
                <span class="color-success-100"></span>
                <span class="color-success-200"></span>
                <span class="color-success-300"></span>
                <span class="color-success-400"></span>
                <span class="color-success-500"></span>
                <span class="color-success-600"></span>
                <span class="color-success-700"></span>
                <span class="color-success-800"></span>
                <span class="color-success-900"></span>
                <span class="color-fusion-50"></span>
                <span class="color-fusion-100"></span>
                <span class="color-fusion-200"></span>
                <span class="color-fusion-300"></span>
                <span class="color-fusion-400"></span>
                <span class="color-fusion-500"></span>
                <span class="color-fusion-600"></span>
                <span class="color-fusion-700"></span>
                <span class="color-fusion-800"></span>
                <span class="color-fusion-900"></span>
            </p>
            <!-- END Color profile -->
        </div>
    </div>
</div>
<!-- END Page Wrapper -->
<!-- BEGIN Quick Menu -->
<!-- to add more items, please make sure to change the variable '$menu-items: number;' in your _page-components-shortcut.scss -->
<nav class="shortcut-menu d-none d-sm-block">
    <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
    <label for="menu_open" class="menu-open-button ">
        <span class="app-shortcut-icon d-block"></span>
    </label>
    <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
        <i class="fal fa-arrow-up"></i>
    </a>
    <a href="page_login_alt.html" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Logout">
        <i class="fal fa-sign-out"></i>
    </a>
    <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left"
        title="Full Screen">
        <i class="fal fa-expand"></i>
    </a>
    <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left"
        title="Print page">
        <i class="fal fa-print"></i>
    </a>
</nav>
<!-- END Quick Menu -->
<!-- BEGIN Page Settings -->
<div class="modal fade js-modal-settings modal-backdrop-transparent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-md">
        <div class="modal-content">
            <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center w-100">
                <h4 class="m-0 text-center color-white">
                    Layout Settings
                    <small class="mb-0 opacity-80">User Interface Settings</small>
                </h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2"
                    data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="settings-panel">
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">
                                App Layout
                            </h5>
                        </div>
                    </div>
                    <div class="list" id="fh">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="header-function-fixed"></a>
                        <span class="onoffswitch-title">Fixed Header</span>
                        <span class="onoffswitch-title-desc">header is in a fixed at all times</span>
                    </div>
                    <div class="list" id="nff">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-function-fixed"></a>
                        <span class="onoffswitch-title">Fixed Navigation</span>
                        <span class="onoffswitch-title-desc">left panel is fixed</span>
                    </div>
                    <div class="list" id="nfm">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-function-minify"></a>
                        <span class="onoffswitch-title">Minify Navigation</span>
                        <span class="onoffswitch-title-desc">Skew nav to maximize space</span>
                    </div>
                    <div class="list" id="nfh">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-function-hidden"></a>
                        <span class="onoffswitch-title">Hide Navigation</span>
                        <span class="onoffswitch-title-desc">roll mouse on edge to reveal</span>
                    </div>
                    <div class="list" id="nft">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-function-top"></a>
                        <span class="onoffswitch-title">Top Navigation</span>
                        <span class="onoffswitch-title-desc">Relocate left pane to top</span>
                    </div>
                    <div class="list" id="mmb">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-main-boxed"></a>
                        <span class="onoffswitch-title">Boxed Layout</span>
                        <span class="onoffswitch-title-desc">Encapsulates to a container</span>
                    </div>
                    <div class="expanded">
                        <ul class="">
                            <li>
                                <div class="bg-fusion-50" data-action="toggle" data-class="mod-bg-1"></div>
                            </li>
                            <li>
                                <div class="bg-warning-200" data-action="toggle" data-class="mod-bg-2"></div>
                            </li>
                            <li>
                                <div class="bg-primary-200" data-action="toggle" data-class="mod-bg-3"></div>
                            </li>
                            <li>
                                <div class="bg-success-300" data-action="toggle" data-class="mod-bg-4"></div>
                            </li>
                        </ul>
                        <div class="list" id="mbgf">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                                data-class="mod-fixed-bg"></a>
                            <span class="onoffswitch-title">Fixed Background</span>
                        </div>
                    </div>
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">
                                Mobile Menu
                            </h5>
                        </div>
                    </div>
                    <div class="list" id="nmp">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-mobile-push"></a>
                        <span class="onoffswitch-title">Push Content</span>
                        <span class="onoffswitch-title-desc">Content pushed on menu reveal</span>
                    </div>
                    <div class="list" id="nmno">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-mobile-no-overlay"></a>
                        <span class="onoffswitch-title">No Overlay</span>
                        <span class="onoffswitch-title-desc">Removes mesh on menu reveal</span>
                    </div>
                    <div class="list" id="sldo">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="nav-mobile-slide-out"></a>
                        <span class="onoffswitch-title">Off-Canvas <sup>(beta)</sup></span>
                        <span class="onoffswitch-title-desc">Content overlaps menu</span>
                    </div>
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">
                                Accessibility
                            </h5>
                        </div>
                    </div>
                    <div class="list" id="mbf">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-bigger-font"></a>
                        <span class="onoffswitch-title">Bigger Content Font</span>
                        <span class="onoffswitch-title-desc">content fonts are bigger for readability</span>
                    </div>
                    <div class="list" id="mhc">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-high-contrast"></a>
                        <span class="onoffswitch-title">High Contrast Text (WCAG 2 AA)</span>
                        <span class="onoffswitch-title-desc">4.5:1 text contrast ratio</span>
                    </div>
                    <div class="list" id="mcb">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-color-blind"></a>
                        <span class="onoffswitch-title">Daltonism <sup>(beta)</sup> </span>
                        <span class="onoffswitch-title-desc">color vision deficiency</span>
                    </div>
                    <div class="list" id="mpc">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-pace-custom"></a>
                        <span class="onoffswitch-title">Preloader Inside</span>
                        <span class="onoffswitch-title-desc">preloader will be inside content</span>
                    </div>
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">
                                Global Modifications
                            </h5>
                        </div>
                    </div>
                    <div class="list" id="mcbg">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-clean-page-bg"></a>
                        <span class="onoffswitch-title">Clean Page Background</span>
                        <span class="onoffswitch-title-desc">adds more whitespace</span>
                    </div>
                    <div class="list" id="mhni">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-hide-nav-icons"></a>
                        <span class="onoffswitch-title">Hide Navigation Icons</span>
                        <span class="onoffswitch-title-desc">invisible navigation icons</span>
                    </div>
                    <div class="list" id="dan">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-disable-animation"></a>
                        <span class="onoffswitch-title">Disable CSS Animation</span>
                        <span class="onoffswitch-title-desc">Disables CSS based animations</span>
                    </div>
                    <div class="list" id="mhic">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-hide-info-card"></a>
                        <span class="onoffswitch-title">Hide Info Card</span>
                        <span class="onoffswitch-title-desc">Hides info card from left panel</span>
                    </div>
                    <div class="list" id="mlph">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-lean-subheader"></a>
                        <span class="onoffswitch-title">Lean Subheader</span>
                        <span class="onoffswitch-title-desc">distinguished page header</span>
                    </div>
                    <div class="list" id="mnl">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle"
                            data-class="mod-nav-link"></a>
                        <span class="onoffswitch-title">Hierarchical Navigation</span>
                        <span class="onoffswitch-title-desc">Clear breakdown of nav links</span>
                    </div>
                    <div class="list mt-1">
                        <span class="onoffswitch-title">Global Font Size <small>(RESETS ON REFRESH)</small> </span>
                        <div class="btn-group btn-group-sm btn-group-toggle my-2" data-toggle="buttons">
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-sm"
                                data-target="html">
                                <input type="radio" name="changeFrontSize"> SM
                            </label>
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text"
                                data-target="html">
                                <input type="radio" name="changeFrontSize" checked=""> MD
                            </label>
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-lg"
                                data-target="html">
                                <input type="radio" name="changeFrontSize"> LG
                            </label>
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-xl"
                                data-target="html">
                                <input type="radio" name="changeFrontSize"> XL
                            </label>
                        </div>
                        <span class="onoffswitch-title-desc d-block mb-0">Change <strong>root</strong> font size to
                            effect rem
                            values</span>
                    </div>
                    <hr class="mb-0 mt-4">
                    <div class="mt-2 d-table w-100 pl-5 pr-3">
                        <div class="fs-xs text-muted p-2 alert alert-warning mt-3 mb-2">
                            <i class="fal fa-exclamation-triangle text-warning mr-2"></i>The settings below uses
                            localStorage to load
                            the external CSS file as an overlap to the base css. Due to network latency and CPU
                            utilization, you may
                            experience a brief flickering effect on page load which may show the intial applied theme
                            for a split
                            second. Setting the prefered style/theme in the header will prevent this from happening.
                        </div>
                    </div>
                    <div class="mt-2 d-table w-100 pl-5 pr-3">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">
                                Theme colors
                            </h5>
                        </div>
                    </div>
                    <div class="expanded theme-colors pl-5 pr-3">
                        <ul class="m-0">
                            <li>
                                <a href="#" id="myapp-0" data-action="theme-update" data-themesave data-theme=""
                                    data-toggle="tooltip" data-placement="top" title="Wisteria (base css)"
                                    data-original-title="Wisteria (base css)"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-1" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-1.css" data-toggle="tooltip" data-placement="top"
                                    title="Tapestry" data-original-title="Tapestry"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-2" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-2.css" data-toggle="tooltip" data-placement="top"
                                    title="Atlantis" data-original-title="Atlantis"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-3" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-3.css" data-toggle="tooltip" data-placement="top"
                                    title="Indigo" data-original-title="Indigo"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-4" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-4.css" data-toggle="tooltip" data-placement="top"
                                    title="Dodger Blue" data-original-title="Dodger Blue"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-5" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-5.css" data-toggle="tooltip" data-placement="top"
                                    title="Tradewind" data-original-title="Tradewind"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-6" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-6.css" data-toggle="tooltip" data-placement="top"
                                    title="Cranberry" data-original-title="Cranberry"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-7" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-7.css" data-toggle="tooltip" data-placement="top"
                                    title="Oslo Gray" data-original-title="Oslo Gray"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-8" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-8.css" data-toggle="tooltip" data-placement="top"
                                    title="Chetwode Blue" data-original-title="Chetwode Blue"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-9" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-9.css" data-toggle="tooltip" data-placement="top"
                                    title="Apricot" data-original-title="Apricot"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-10" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-10.css" data-toggle="tooltip" data-placement="top"
                                    title="Blue Smoke" data-original-title="Blue Smoke"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-11" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-11.css" data-toggle="tooltip" data-placement="top"
                                    title="Green Smoke" data-original-title="Green Smoke"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-12" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-12.css" data-toggle="tooltip" data-placement="top"
                                    title="Wild Blue Yonder" data-original-title="Wild Blue Yonder"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-13" data-action="theme-update" data-themesave
                                    data-theme="css/themes/cust-theme-13.css" data-toggle="tooltip" data-placement="top"
                                    title="Emerald" data-original-title="Emerald"></a>
                            </li>
                        </ul>
                    </div>
                    <hr class="mb-0 mt-4">
                    <div class="pl-5 pr-3 py-3 bg-faded">
                        <div class="row no-gutters">
                            <div class="col-6 pr-1">
                                <a href="#" class="btn btn-outline-danger fw-500 btn-block"
                                    data-action="app-reset">Reset Settings</a>
                            </div>
                            <div class="col-6 pl-1">
                                <a href="#" class="btn btn-danger fw-500 btn-block" data-action="factory-reset">Factory
                                    Reset</a>
                            </div>
                        </div>
                    </div>
                </div> <span id="saving"></span>
            </div>
        </div>
    </div>
</div>
<!-- END Page Settings -->
<!-- base vendor bundle: 
            DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations 
                    + pace.js (recommended)
                    + jquery.js (core)
                    + jquery-ui-cust.js (core)
                    + popper.js (core)
                    + bootstrap.js (core)
                    + slimscroll.js (extension)
                    + app.navigation.js (core)
                    + ba-throttle-debounce.js (core)
                    + waves.js (extension)
                    + smartpanels.js (extension)
                    + src/../jquery-snippets.js (core) -->
<script src="{{asset('js/vendors.bundle.js')}}"></script>
<script src="{{asset('js/app.bundle.js')}}"></script>
<script type="text/javascript">
    /* Activate smart panels */
        $('#js-page-content').smartPanel();

</script>
<!-- The order of scripts is irrelevant. Please check out the plugin pages for more details about these plugins below: -->
<script src="{{asset('js/statistics/peity/peity.bundle.js')}}"></script>
<script src="{{asset('js/statistics/flot/flot.bundle.js')}}"></script>
<script src="{{asset('js/statistics/easypiechart/easypiechart.bundle.js')}}"></script>
<script src="{{asset('js/datagrid/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('js/croppie.js')}}"></script>
@yield('additional_scripts')
<script src="{{asset('js/custom.js')}}"></script>
@endsection