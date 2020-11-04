@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('additional_css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/ion-rangeslider/ion-rangeslider.css')}}">
<link rel="stylesheet" media="screen, print" href="{{asset('css/devices.min.css')}}">
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item active">Push Notifications</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Manage</span> Push Notifications
    </h1>
</div>
<div id="page-main-content" class="row">
    <div class="col">
        <div id="panel-message" class="panel" style="">
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    <form>
                        <!-- Message -->
                        <div class="form-group">
                            <label class="form-label" for="message">Message</label>
                            <textarea class="form-control" id="message" rows="5"></textarea>
                        </div>
                        <!-- Action -->
                        <div class="form-group">
                            <label class="form-label">Action</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio custom-radio-rounded">
                                        <input type="radio" class="custom-control-input" id="action-open-url"
                                            name="defaultExampleRadios" checked>
                                        <label class="custom-control-label" for="action-open-url">Open URL</label>
                                    </div>
                                </div>
                                <input class="form-control" id="open-url" type="text" name="open-url">
                            </div>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio custom-radio-rounded">
                                        <input type="radio" class="custom-control-input" id="action-open-app"
                                            name="defaultExampleRadios">
                                        <label class="custom-control-label" for="action-open-app">Open App</label>
                                    </div>
                                </div>
                                <select id="open-app" class="custom-select form-control">
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                    <option value="Open App">Open App</option>
                                    <option value="Puff or Pass">Puff or Pass</option>
                                    <option value="Strain Match">Strain Match</option>
                                    <option value="Nearby Dispensaries">Nearby Dispensaries</option>
                                    <option value="Specific Dispensary Profile">Specific Dispensary Profile</option>
                                    <option value="Nearby Strains">Nearby Strains</option>
                                    <option value="Specific Strain Profile">Specific Strain Profile</option>
                                    <option value="List View Specific Strain">List View Specific Strain</option>
                                    <option value="Map View Specific Strai">Map View Specific Strain</option>
                                    <option value="User Settings Profile">User Settings/Profile</option>
                                </select>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
        <!-- <div id="panel-destination" class="panel" style="">
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label">Send To</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-active" name="send-to-users" checked>
                                    <label class="custom-control-label" for="product-active">All Users</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-restricted" name="send-to-users">
                                    <label class="custom-control-label" for="product-restricted">Speecifc Users</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-pending" name="send-to-phones">
                                    <label class="custom-control-label" for="product-pending">iPhones</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="product-pending" name="send-to-phones">
                                    <label class="custom-control-label" for="product-pending">Androids</label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div> -->
        <div id="panel-users" class="panel" style="">
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    <form>
                        <!-- Message -->
                        <div class="form-group">
                            <label class="form-label" for="message">Send to</label>
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="send-to-all" name="sendTo" checked>
                                <label class="custom-control-label" for="send-to-all">All Users</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="send-to-iphones" name="sendTo">
                                <label class="custom-control-label" for="send-to-iphones">iPhones</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="send-to-androids" name="sendTo">
                                <label class="custom-control-label" for="send-to-androids">Androids</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="radio" class="custom-control-input" id="send-to-specific" name="sendTo">
                                <label class="custom-control-label" for="send-to-specific">Specific Users</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-user fs-xl"></i></span>
                                </div>
                                <input type="text" id="basic-addon1" class="form-control" placeholder="Username"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="example-fileinput">Specific Users CSV</label>
                            <input type="file" id="example-fileinput" class="form-control-file">
                        </div>
                </div>
                </form>
            </div>
        </div>

        <div id="panel-destination" class="panel">
            <!-- <div class="panel-hdr">
                <h2>
                Listing
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div> -->
            <div class="panel-container collapse show" style="">
                <form>
                    <div class="panel-content">
                        <!-- Address -->
                        <div class="form-group">
                            <label class="form-label" for="address-1">Within radius of Address</label>
                            <input type="text" id="address-1" class="form-control" placeholder="Address">
                            <input type="text" id="address-2" class="form-control" placeholder="Address Line 2"
                                style="margin-top:10px;">
                            <input type="text" id="address-city" class="form-control" placeholder="City"
                                style="margin-top:10px;">
                            <select id="address-state" class="custom-select form-control" style="margin-top:10px;">
                                <option selected="">State</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <input type="text" id="address-zip" class="form-control" placeholder="Zip Code"
                                style="margin-top:10px;">
                            <select id="address-country" class="custom-select form-control" style="margin-top:10px;">
                                <option selected="">Country</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <!-- Radius -->
                        <div class="form-group">
                            <label class="form-label" for="">Mile Radius</label>
                            <input id="demo_4" type="text" value="" class="characteristic d-none form-control"
                                tabindex="-1" readonly="">
                        </div>
                        <div class="form-group">
                            <div id="map" style="height: 400px"></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div id="panel-destination" class="panel">
            <div class="panel-container collapse show" style="">
                <form>
                    <div class="panel-content">
                        <label class="form-label" for="basic-addon2">Totals to be Sent</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">iPhone</span>
                                </div>
                                <input type="text" id="basic-addon2" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Android</span>
                                </div>
                                <input type="text" id="basic-addon3" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Total Users</span>
                                </div>
                                <input type="text" id="basic-addon4" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button class="btn btn-primary btn-block" type="submit">PUSH NOTIFICATION</button>
    </div>
    <!-- <div class="col" style="max-width: 440px; min-width: 440px; width: 440px;">
        <div class="marvel-device iphone-x">
            <div class="notch">
                <div class="camera"></div>
                <div class="speaker"></div>
            </div>
            <div class="top-bar"></div>
            <div class="sleep"></div>
            <div class="bottom-bar"></div>
            <div class="volume"></div>
            <div class="overflow">
                <div class="shadow shadow--tr"></div>
                <div class="shadow shadow--tl"></div>
                <div class="shadow shadow--br"></div>
                <div class="shadow shadow--bl"></div>
            </div>
            <div class="inner-shadow"></div>
            <div class="screen">
                <img src="img/app-top-menu.svg" width="100%" style="position: absolute; top: 0;">
                <div class="screen-scroll">
                    <img src="img/app.svg" width="100%">
                </div>
                <img src="img/app-bottom-menu.svg" width="100%" style="position: absolute; bottom: 0;">
                
                
            </div>
        </div>
    </div> -->
</div>
@endsection

@section('additional_scripts')
<script src="{{asset('js/croppie.js')}}"></script>
<script src="{{asset('js/formplugins/ion-rangeslider/ion-rangeslider.js')}}"></script>
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>

<script type="text/javascript">
    
    var ionskin = "flat";
    
    function my_prettify(n)
    {
        // var num = Math.log2(n);
        // return n + " → " + (+num.toFixed(3));
        return n+" miles";
    }

    $(".characteristic").ionRangeSlider(
    {
        skin: ionskin,
        grid: true,
        min: 0,
        max: 100,
        from: 0,
        prettify: my_prettify
    });

</script>
@endsection