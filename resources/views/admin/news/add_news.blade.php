@extends('layouts.admin_layout')

@section('additional_css')
<link rel="stylesheet" media="screen, print" href="css/devices.min.css">
@endsection

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item">News</li>
    <li class="breadcrumb-item active">Add Article</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Add</span> Article
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col">
        <form method="post" action="/add_news" enctype="multipart/form-data">
            @csrf
        <!-- Status -->
        <div id="panel-product" class="panel" style="">
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="news-active" value="1"
                                        name="news_status" checked>
                                    <label class="custom-control-label" for="news-active"><span
                                            class="badge badge-success w-100">ACTIVE</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="news-inactive" value="0"
                                        name="news_status">
                                    <label class="custom-control-label" for="news-inactive"><span
                                            class="badge badge-danger w-100">INACTIVE</span></label>
                                </div>
                            </div>
                        </div><!-- PRODUCT INFO -->
                        @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $message)
                                <li>{{$message}}</li>
                            @endforeach
                        </div>
                        @endif
                </div>
            </div>
        </div>
        <div id="panel-product" class="panel" style="">
            <!-- <div class="panel-hdr">
                <h2>
                    Product Details</span>
                </h2>
            </div> -->
            <div class="panel-container collapse show" style="">
                <div class="panel-content">
                    {{-- <form> --}}
                        <!-- Category -->
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select id="news-category" class="custom-select form-control" name="news_category">
                                <option selected="" value="">Select Category</option>
                                <option value="0">News</option>
                                <option value="1">Update</option>
                                <option value="2">General</option>
                            </select>
                        </div>
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" id="title" class="form-control" name="title" value="<?php if( Session::get('data')){echo Session::get('data')['title'];} ?>">
                        </div>
                        <!-- Link -->
                        <div class="form-group">
                            <label class="form-label" for="link">Link</label>
                            <input type="text" id="link" class="form-control" name="link" value="<?php if( Session::get('data')){echo Session::get('data')['link'];} ?>">
                        </div>
                        <!-- Image -->
                        <div class="form-group">
                            <label class="form-label">Photo</label>
                            <div clas="form-control">
                                <img src="https://via.placeholder.com/279x144?text=NEWS-IMAGE" width="279" height="144" class="img-border preview_photo" />
                            </div>
                            <div id="upload-photo"></div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="photo" name="photo">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="form-group">
                            <label class="form-label" for="date">Date</label>
                            <input class="form-control" type="datetime-local" id="date" name="date" value="<?php if( Session::get('data')){echo Session::get('data')['date'];} ?>">
                        </div>
                                               
                    </div>
                {{-- </form> --}}
            </div>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Add News Article</button>
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
                <!-- <object id="svg-object" data="img/app.svg" type="image/svg+xml"></object> -->
                <!-- <img src="img/app.svg" width="100%"> -->
                <!-- <img src="img/app-top-menu.svg" width="100%" style="position: absolute; top: 0;"> -->
                <div class="screen-scroll">
                    <!-- <img src="img/app.svg" width="100%"> -->
                </div>
                <img src="{{asset('img/app-bottom-menu.svg')}}" width="100%" style="position: absolute; bottom: 0;">
                
                
            </div>
        </div>
    </div>
</div>
<!-- END ACTUAL PAGE CONTENT -->
@endsection

@section('additional_scripts')
@endsection