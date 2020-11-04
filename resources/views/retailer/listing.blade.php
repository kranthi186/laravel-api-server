@extends('layouts.retailer_layout')

@section('navigation')
@include('retailer.retailer_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item active">Manage Listing</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> Manage <span class='fw-300'>Listing</span>
    </h1>
</div>
<div class="row">
    <div class="col">
        <form method="post" action="/update_listing" enctype="multipart/form-data">
            @csrf
        <!-- <div class="col-md-8 order-sm-1 order-md-0 order-xl-0 order-1"> -->
        <div id="panel-1" class="panel">
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
                    <div class="panel-content">
                        <!-- <div class="panel-tag">
                        Page notification updats.
                    </div> -->

                        <!-- License Number -->
                        <div class="form-group">
                            <label class="form-label" for="license_number">License Number</label>
                            <div class="input-group flex-nowrap">
                                <input id="license_number" type="text" class="form-control" placeholder="License Number"
                                    aria-label="Username" aria-describedby="license_number" name="license_number" value="{{$user->license_number}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fal fa-check fs-xl"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- Medical / Recreational / N/A  -->
                        <div class="form-group">
                            <label class="form-label" for="checkbox-group-4">License Type</label>
                            <div class="input-group">
                                <div class="input-group-text" style="background: none; border: none;">
                                    <div class="custom-control d-flex custom-switch">
                                        <input id="license-type-1" type="checkbox" class="custom-control-input" name="license_medical" <?php if($user->license_type->medical) echo 'checked'; ?>>
                                        <label class="custom-control-label fw-500" for="license-type-1">Medical</label>
                                    </div>
                                </div>
                                <div class="input-group-text" style="background: none; border: none;">
                                    <div class="custom-control d-flex custom-switch">
                                        <input id="license-type-2" type="checkbox" class="custom-control-input" name="license_recreational" <?php if($user->license_type->recreational) echo 'checked'; ?>>
                                        <label class="custom-control-label fw-500"
                                            for="license-type-2">Recreational</label>
                                    </div>
                                </div>
                            </div>
                            <!-- <span class="help-block">
                                What is your license type?
                            </span> -->
                        </div>
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{$retailer->name}}">
                        </div>
                        <!-- Address -->
                        <div class="form-group">
                            <label class="form-label" for="address-1">Address</label>
                            <input type="text" id="address-1" class="form-control" placeholder="Address" name="address1" value="<?php if($retailer->address){echo $retailer->address;} ?>">
                            {{-- <input type="text" id="address-2" class="form-control" placeholder="Address Line 2"
                                style="margin-top:10px;"> --}}
                            <input type="text" id="address-city" class="form-control" placeholder="City" name="city" value="{{$user->city}}"
                                style="margin-top:10px;">
                            {{-- <select class="custom-select form-control" style="margin-top:10px;">
                                <option selected="">State</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select> --}}
                            <input type="text" id="address-state" class="form-control" placeholder="State" name="state" value="{{$user->state}}"
                                style="margin-top:10px;">
                            {{-- <input type="text" id="address-zip" class="form-control" placeholder="Zip Code"
                                style="margin-top:10px;"> --}}
                            <!-- <div class="input-group" style="margin-top:5px;">
                                <input type="text" class="form-control" aria-label="City" id="dropdown-on-both" placeholder="City">
                                <div class="input-group-append">
                                    <select class="form-control" id="example-select">
                                        <option>STATE</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                
                                <div class="input-group-append">
                                    <input type="text" class="form-control" aria-label="Zip Code" id="zip" placeholder="Zip Code">
                                </div>
                            </div> -->
                        </div>
                        <!-- Phone -->
                        <div class="form-group">
                            <label class="form-label" for="name">Phone</label>
                            <input type="text" id="phone" class="form-control" name="phone" value="{{$user->phone}}">
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" for="name">Email</label>
                            <input type="email" id="email" class="form-control" name="email" value="{{$user->email}}">
                        </div>
                        <!-- Website -->
                        <div class="form-group">
                            <label class="form-label" for="name">Website</label>
                            <input type="text" id="website" class="form-control" name="website" value="<?php if($retailer->website){echo $retailer->website;} ?>">
                        </div>
                    </div>
                    <!-- <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="invalidCheck" required="">
                            <label class="custom-control-label" for="invalidCheck">Agree to terms and conditions <span class="text-danger">*</span></label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                        <button class="btn btn-primary ml-auto" type="submit">Update Listing</button>
                    </div> -->
            </div>
        </div>
        <!-- IMAGES -->
        <div id="panel-2" class="panel">
            <!-- <div class="panel-hdr">
                <h2>
                Photos
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div> -->
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    <!-- <div class="panel-tag">
                        Page notification updats.
                    </div> -->
                        <!-- Logo 128x128-->
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            <div clas="form-control">
                                @if($retailer->logo != '')
                                    <img src="{{$retailer->logo}}" width="128" height="128" class="img-border preview_logo" />
                                @else
                                    <img src="https://via.placeholder.com/128x128?text=LOGO" width="128" height="128" class="img-border preview_logo" />
                                @endif
                            </div>
                            {{-- <div id="upload-logo"></div> --}}
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                <label class="custom-file-label" for="logo">Choose file</label>
                            </div>
                        </div>
                        <!-- Cover 375x225-->
                        <div class="form-group">
                            <label class="form-label">Cover Photo</label>
                            <div clas="form-control">
                                @if($retailer->cover_photo != '')
                                    <img src="{{$retailer->cover_photo}}" width="375" height="225" class="img-border preview_cover" />
                                @else
                                    <img src="https://via.placeholder.com/375x225?text=COVER" width="375" height="225" class="img-border preview_cover" />
                                @endif
                            </div>
                            {{-- <div id="upload-cover"></div> --}}
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="cover" name="cover">
                                <label class="custom-file-label" for="cover">Choose file</label>
                            </div>
                        </div>
                        <!-- Featureed 279 x 144 -->
                        <div class="form-group">
                            <label class="form-label">Featured Photo</label>
                            <div clas="form-control">
                                @if($retailer->featured_image != '')
                                    <img src="{{$retailer->featured_image}}" width="279" height="144" class="img-border preview_featured" />
                                @else
                                    <img src="https://via.placeholder.com/279x144?text=FEATURED" width="279" height="144" class="img-border preview_featured" />
                                @endif
                            </div>
                            {{-- <div id="upload-featured"></div> --}}
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="featured" name="featured">
                                <label class="custom-file-label" for="featured">Choose file</label>
                            </div>
                        </div>
                </div>
                <!-- <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="invalidCheck" required="">
                            <label class="custom-control-label" for="invalidCheck">Agree to terms and conditions <span class="text-danger">*</span></label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                        <button class="btn btn-primary ml-auto" type="submit">Update Photos</button>
                    </div> -->
            </div>
        </div>
        <!-- HOURS -->
        <div id="panel-3" class="panel">
            <!-- <div class="panel-hdr">
                <h2>
                Hours
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div> -->
            @if($user->user_type == 1)
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    <!-- <div class="panel-tag">
                        Page notification updats.
                    </div> -->
                        <!-- Hours Sunday -->
                        <div class="form-group">
                            <label class="form-label">Hours Sunday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="sunday-closed" name="sunday_closed" <?php if($retailer->hours->sun->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="sunday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-sunday-open" type="time" name="hours_sunday_open" value="{{$retailer->hours->sun->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-sunday-closed" type="time" name="hours_sunday_closed" value="{{$retailer->hours->sun->closed_time}}">
                            </div>
                        </div>
                        <!-- Hours Monday -->
                        <div class="form-group">
                            <label class="form-label">Hours Monday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="monday-closed" name="monday_closed" <?php if($retailer->hours->mon->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="monday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-monday-open" type="time" name="hours_monday_open" value="{{$retailer->hours->mon->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-monday-closed" type="time" name="hours_monday_closed" value="{{$retailer->hours->mon->closed_time}}">
                            </div>
                        </div>
                        <!-- Hours Tuesday -->
                        <div class="form-group">
                            <label class="form-label">Hours Tuesday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="tuesday-closed" name="tuesday_closed" <?php if($retailer->hours->tue->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="tuesday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-tuesday-open" type="time" name="hours_tuesday_open" value="{{$retailer->hours->tue->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-tuesday-closed" type="time" name="hours_tuesday_closed" value="{{$retailer->hours->tue->closed_time}}">
                            </div>
                        </div>
                        <!-- Hours Wednesday -->
                        <div class="form-group">
                            <label class="form-label">Hours Wednesday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="wednesday-closed" name="wednesday_closed" <?php if($retailer->hours->wed->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="wednesday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-wednesday-open" type="time" name="hours_wednesday_open" value="{{$retailer->hours->wed->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-wednesday-closed" type="time" name="hours_wednesday_closed" value="{{$retailer->hours->wed->closed_time}}">
                            </div>
                        </div>
                        <!-- Hours Thursday -->
                        <div class="form-group">
                            <label class="form-label">Hours Thursday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="thursday-closed" name="thursday_closed" <?php if($retailer->hours->thu->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="thursday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-thursday-open" type="time" name="hours_thursday_open" value="{{$retailer->hours->thu->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-thursday-closed" type="time" name="hours_thursday_closed" value="{{$retailer->hours->thu->closed_time}}">
                            </div>
                        </div>
                        <!-- Hours Friday -->
                        <div class="form-group">
                            <label class="form-label">Hours Friday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="friday-closed" name="friday_closed" <?php if($retailer->hours->fri->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="friday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-friday-open" type="time" name="hours_friday_open" value="{{$retailer->hours->fri->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-friday-closed" type="time" name="hours_friday_closed" value="{{$retailer->hours->fri->closed_time}}">
                            </div>
                        </div>
                        <!-- Hours Saturday -->
                        <div class="form-group">
                            <label class="form-label">Hours Saturday</label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="saturday-closed" name="saturday_closed" <?php if($retailer->hours->sat->closed == 1){echo 'checked';}?>>
                                        <label class="custom-control-label" for="saturday-closed">Closed</label>
                                    </div>
                                </div>
                                <input class="form-control" id="hours-saturday-open" type="time" name="hours_saturday_open" value="{{$retailer->hours->sat->open_time}}">
                                <div class="input-group-append input-group-prepend">
                                    <span class="input-group-text"><i class="fal fa-exchange fs-xl"></i></span>
                                </div>
                                <input class="form-control" id="hours-saturday-closed" type="time" name="hours_saturday_closed" value="{{$retailer->hours->sat->closed_time}}">
                            </div>
                        </div>



                </div>
                <!-- <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="invalidCheck" required="">
                            <label class="custom-control-label" for="invalidCheck">Agree to terms and conditions <span class="text-danger">*</span></label>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                        <button class="btn btn-primary ml-auto" type="submit">Update Listing</button>
                    </div> -->
            </div>
            @endif
        </div>
        <!-- HOURS -->
        <button class="btn btn-primary btn-block" type="submit">Update Listing</button>
    </form>
    </div>
    <!-- <div class="col-md-4 order-sm-0 order-md-1 order-xl-1 order-0"> -->
    <div class="col" style="max-width: 440px; min-width: 440px; width: 440px;">
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
                <object id="svg-object" data="img/listing.svg" type="image/svg+xml"></object>
                <!-- <img src="img/app.svg" width="100%"> -->

            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="js/croppie.js"></script>

<script type="text/javascript">
    $image_crop_logo = $('#upload-logo').croppie({
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'square'
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });
            $('#upload-logo').hide();
            $('#logo').on('change', function () { 
                $('#upload-logo').show();
                var readerLogo = new FileReader();
                readerLogo.onload = function (e) {
                    $image_crop_logo.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });         
                }
                readerLogo.readAsDataURL(this.files[0]);
            });
</script>
<script type="text/javascript">
    $image_crop_cover = $('#upload-cover').croppie({
                enableExif: true,
                viewport: {
                    width: 300,
                    height: 200,
                    type: 'square'
                },
                boundary: {
                    width: 400,
                    height: 300
                }
            });
            $('#upload-cover').hide();
            $('#cover').on('change', function () { 
                $('#upload-cover').show();
                var readerCover = new FileReader();
                readerCover.onload = function (e) {
                    $image_crop_cover.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });         
                }
                readerCover.readAsDataURL(this.files[0]);
            });
</script>
@endsection