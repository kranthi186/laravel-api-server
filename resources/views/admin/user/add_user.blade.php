@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Add User</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Add </span>User
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col">
        <!-- Status -->
        <div id="panel-product" class="panel" style="">
            <form method="post" action="/add_user">
                <div class="panel-container collapse show" style="">
                    <div class="panel-content">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="frame-wrap">
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="user-active" value="1"
                                        name="user_status" checked>
                                    <label class="custom-control-label" for="user-active"><span
                                            class="badge badge-success w-100">ACTIVE</span></label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="user-restricted" value="0"
                                        name="user_status">
                                    <label class="custom-control-label" for="user-restricted"><span
                                            class="badge badge-danger w-100">INACTIVE</span></label>
                                </div>
                                {{-- <div class="custom-control custom-radio custom-control-inline custom-radio-rounded">
                                    <input type="radio" class="custom-control-input" id="user-pending" value="2"
                                        name="user_status">
                                    <label class="custom-control-label" for="user-pending"><span
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
                            <input type="text" id="user-email" name="email" class="form-control">
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
                                <option selected="" value="">Select User Type</option>
                                <option value="100">Admin</option>
                                <option value="2">Brand</option>
                                <option value="1">Retailer</option>
                                <option value="0">Consumer</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Add User</button>
        </form>
    </div>
</div>
<!-- END ACTUAL PAGE CONTENT -->
@endsection

@section('additional_scripts')
<script type="text/javascript">
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

    var ionskin = "flat";
    
    function my_prettify(n)
    {
        // var num = Math.log2(n);
        // return n + " → " + (+num.toFixed(3));
        return n+"%";
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