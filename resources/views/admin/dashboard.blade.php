@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item active">Analytics Dashboard</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span>
    </li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> Analytics <span class='fw-300'>Dashboard</span>
    </h1>
</div>
<div id="page-main-content" class="row">

</div>
@endsection