@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Update User</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Update </span>User
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col">
        <!-- Status -->
        <form method="post" action="/edit_user/<?php echo $user->id ?>">
            @csrf
            <div id="panel-product" class="panel" style="">
                <div class="panel-container collapse show" style="">
                    <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="user-active" value="1"
                                        name="user_status" <?php if($user->status == 1){echo 'checked';}?>>
                                    <label class="custom-control-label" for="user-active"><span
                                            class="badge badge-success w-100">ACTIVE</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="user-restricted" value="0"
                                        name="user_status" <?php if($user->status == 0){echo 'checked';}?>>
                                    <label class=" custom-control-label" for="user-restricted"><span
                                            class="badge badge-danger w-100">INACTIVE</span></label>
                                </div>
                                {{-- <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="user-pending" value="2"
                                        name="user_status">
                                    <label class=" custom-control-label" for="user-pending"><span
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
                            <label class="form-label" for="user-email">Email</label>
                            <input type="text" id="user-email" class="form-control" name="email"
                                value="{{$user->email}}">
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="form-label" for="user-password">Password</label>
                            <input type="password" id="user-password" name="password" class="form-control">
                        </div>
                        <!-- User Type -->
                        <div class="form-group">
                            <label class="form-label">User Type</label>
                            <select id="user-type" class="custom-select form-control" name="user_type">
                                <option>Select User Type</option>
                                <option value="100" <?php if($user->user_type > 50){echo 'selected';}?>>Admin</option>
                                <option value="2" <?php if($user->user_type == 2){echo 'selected';}?>>Brand</option>
                                <option value="1" <?php if($user->user_type == 1){echo 'selected';}?>>Retailer</option>
                                <option value="0" <?php if($user->user_type == 0){echo 'selected';}?>>Consumer</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Update User</button>
        </form>
    </div>
</div>
<!-- END ACTUAL PAGE CONTENT -->
@endsection