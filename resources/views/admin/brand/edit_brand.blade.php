@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item">Brands</li>
    <li class="breadcrumb-item active">Edit Brand</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Edit</span> Brand
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col">
        <form method="post" action="/edit_brand/<?php echo $user->id ?>" enctype="multipart/form-data">
            @csrf
        <!-- Status -->
        <div id="panel-product" class="panel" style="">
            <!-- <div class="panel-hdr">
                <h2>
                    Product Details</span>
                </h2>
            </div> -->
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="frame-wrap">
                            <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                <input type="radio" class="custom-control-input" id="product-active" value="1"
                                    name="brand_status" <?php if($user->status == 1){echo 'checked';}?>>
                                <label class="custom-control-label" for="product-active"><span
                                        class="badge badge-success w-100">ACTIVE</span></label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                <input type="radio" class="custom-control-input" id="product-restricted" value="0"
                                    name="brand_status" <?php if($user->status == 0){echo 'checked';}?>>
                                <label class="custom-control-label" for="product-restricted"><span
                                        class="badge badge-danger w-100">INACTIVE</span></label>
                            </div>
                            {{-- <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                <input type="radio" class="custom-control-input" id="product-pending" value="2"
                                    name="brand_status">
                                <label class="custom-control-label" for="product-pending"><span
                                        class="badge badge-warning w-100">PENDING</span></label>
                            </div> --}}
                        </div>
                    </div>
                    <!-- Email -->
                    @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $message)
                            <li>{{$message}}</li>
                        @endforeach
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="form-label" for="brand-email">Email</label>
                        <input type="text" id="brand-email" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                    <!-- Password -->
                    {{-- <div class="form-group">
                        <label class="form-label" for="brand-password">Password</label>
                        <input type="password" id="brand-password" class="form-control" name="password">
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Brand -->
        <div id="panel-product" class="panel" style="">
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    {{-- <form> --}}
                        <!-- Brand Name -->
                        <div class="form-group">
                            <label class="form-label" for="brand">Brand Name</label>
                            <input type="text" id="brand" class="form-control" name="name" value="{{$user->name}}">
                        </div>
                        <!-- Tagline -->
                        <div class="form-group">
                            <label class="form-label" for="tagline">Tagline</label>
                            <input type="text" id="tagline" class="form-control" name="tagline" value="{{$user->tagline}}">
                        </div>
                        <!-- Logo 128x128-->
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            <div clas="form-control">
                                @if($user->logo != '')
                                    <img src="{{$user->logo}}" width="128" height="128" class="img-border preview_logo" />
                                @else
                                    <img src="https://via.placeholder.com/128x128?text=LOGO" width="128" height="128" class="img-border preview_logo" />
                                @endif
                            </div>
                            <div id="upload-logo"></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                <label class="custom-file-label" for="logo">Choose file</label>
                            </div>
                        </div>
                        <!-- Cover 375x225-->
                        <div class="form-group">
                            <label class="form-label">Cover Photo</label>
                            <div clas="form-control">
                                @if($user->cover_photo != '')
                                    <img src="{{$user->cover_photo}}" width="375" height="225" class="img-border preview_cover" />
                                @else
                                    <img src="https://via.placeholder.com/375x225?text=COVER" width="375" height="225" class="img-border preview_cover" />
                                @endif
                            </div>
                            <div id="upload-cover"></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="cover" name="cover">
                                <label class="custom-file-label" for="cover">Choose file</label>
                            </div>
                        </div>
                        <!-- Featureed 279 x 144 -->
                        <div class="form-group">
                            <label class="form-label">Featured Photo</label>
                            <div clas="form-control">
                                @if($user->featured_image != '')
                                    <img src="{{$user->featured_image}}" width="279" height="144" class="img-border preview_featured" />
                                @else
                                    <img src="https://via.placeholder.com/279x144?text=FEATURED" width="279" height="144" class="img-border preview_featured" />
                                @endif
                            </div>
                            <div id="upload-featured"></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="featured" name="featured">
                                <label class="custom-file-label" for="featured">Choose file</label>
                            </div>
                        </div>
                </div>
                {{-- </form> --}}
            </div>
        </div>

        <button class="btn btn-primary btn-block" type="submit">Edit Brand</button>
    </form>
    </div>
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
                <div class="screen-scroll">
                    <img src="{{asset('img/brand-preview.svg')}}" width="100%">
                </div>
                <img src="{{asset('img/app-bottom-menu.svg')}}" width="100%" style="position: absolute; bottom: 0;">
            </div>
        </div>
    </div>
    <!-- END ACTUAL PAGE CONTENT -->
    @endsection

    @section('additional_scripts')
    <script>
        $(document).ready(function()
    {   
        $image_crop_photo = $('#upload-photo').croppie({
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

        $('#upload-photo').hide();
        
        $('#photo').on('change', function () { 
            $('#upload-photo').show();
            var readerPhoto = new FileReader();
            readerPhoto.onload = function (e) {
                $image_crop_photo.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });         
            }
            readerPhoto.readAsDataURL(this.files[0]);
        });


    });
    </script>
    @endsection