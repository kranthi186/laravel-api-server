@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item active">Brands</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Manage</span> Brands
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col-lg-12">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">

                <h2 class="m-2 ml-0">
                    <a href="/add_brand"><button class="btn btn-success btn-block" tabindex="0"
                            aria-controls="brands-list" type="button"><span><i class="fal fa-plus mr-1"></i> Add
                                Brand</span></button></a>
                </h2>

                <div class="panel-toolbar">

                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table id="brands-list" class="table table-bordered table-hover table-striped w-100">
                        <thead class="" style="background: #f3f3f3;">
                            <tr>
                                <th>Status</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Product Types</th>
                                <th>Tagline</th>
                                <th>Email</th>
                                {{-- <th>Product Types</th> --}}
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Status</th>
                                <th>Logo</th>
                                <th>Name</th>
                                {{-- <th>Product Types</th> --}}
                                <th>Tagline</th>
                                <th>Email</th>
                                {{-- <th>Product Types</th> --}}
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <table id="brands-list-alt" class="table table-bordered table-hover table-striped w-100"></table>
                    <!-- datatable end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ACTUAL PAGE CONTENT -->
@endsection

@section('additional_scripts')
<script>
    $(document).ready(function()
    {   

        // var brands = [
        //     {
        //         'status' : 'approved',
        //         'logo' : 'img/brands/3chi.png',
        //         'name' : '3CHI',
        //         'admin': 'user_id',
        //         'email' : 'info@brand.com',
        //         'city' : 'Denver',
        //         'state' : 'CO',
        //         'country' : 'US',
        //         'products': 10,
        //         'types' : ['Edibles', 'Concentrates'],
        //         'tagline': 'Only THC Best',
        //     },
        //     {
        //         'status' : 'pending',
        //         'logo' : 'img/brands/420smart.jpg',
        //         'name' : '420Smart',
        //         'admin': 'user_id',
        //         'email' : 'info@420smart.com',
        //         'city' : 'Denver',
        //         'state' : 'CO',
        //         'country' : 'US',
        //         'products': 4,
        //         'types' : ['Flower', 'Edibles', 'Concentrates', 'CBD'],
        //         'tagline': 'Stay High',
        //     },
        //     {
        //         'status' : 'restricted',
        //         'logo' : 'img/brands/7acres.jpg',
        //         'name' : '7Acres',
        //         'admin': 'user_id',
        //         'email' : 'info@7acres.com',
        //         'city' : 'Denver',
        //         'state' : 'CO',
        //         'country' : 'US',
        //         'products': 12,
        //         'types' : ['CBD'],
        //         'tagline': 'Making Health Feel Better',
        //     }
        // ];

        var brands = <?php echo json_encode($users); ?>;

        

        /* init datatables */
        $('#brands-list').dataTable(
        {
            
            data: brands,
            columns: [
                {   
                    title: 'Status',
                    data: 'status',
                    render: function(data, type, full, meta) {
                        if(data == '1'){
                            return '<span class="badge badge-success w-100">ACTIVE</span>';
                        }else if(data == '0'){
                            return '<span class="badge badge-warning w-100">INACTIVE</span>';
                        // }else if(data == 'restricted'){
                        //     return '<span class="badge badge-danger w-100">RESTRICTED</span>';
                        }
                    },
                    orderable: true,
                    searchable: true,
                },
                {   
                    title: 'Logo',
                    data : 'logo',
                    render: function(data, type, full, meta) {
                        const url = data;
                        const res = data ? '<img src="' + url + '" class="product-img"/>'
                                : '<img src="https://via.placeholder.com/128x128?text=LOGO" class="product-img"/>'
                        return res;
                    },
                    orderable: false,
                    searchable: false,
                },
                {   
                    title: 'Name',
                    data : 'name',
                    orderable: true,
                    searchable: true,
                },
                {   
                    title: 'Tagline',
                    data : 'tagline',
                    orderable: true,
                    searchable: true,
                },
                {   
                    title: 'Email',
                    data : 'email',
                    orderable: true,
                    searchable: true,
                },
                // {   
                //     title: 'Product Types',
                //     data : 'types',
                //     render: function(data, type, full, meta) {
                //         var productTypes = '';
                        
                //         $.each(data, function( index, value ) {
                //             productTypes+= '<span class="badge border border-secondary text-secondary w-100">'+value+'</span>';
                //         });

                //         return productTypes;

                //     },
                //     orderable: true,
                //     searchable: true,
                // },
                {   
                    title: '',
                    data : 'products',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {

                        return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"/manage_brand_products/" + full['id'] + "\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-primary btn-block mr-1\" tabindex=\"0\" aria-controls=\"brands-list\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t Manage Products</span>\n\t\t\t\t\t\t<span class=\"badge bg-primary-300 ml-2\">"+data+"</span></button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";

                    },
                },
                {
                    title: '',
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta)
                    {
                        return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"/edit_brand/" + data + "\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-primary btn-block mr-1\" tabindex=\"0\" aria-controls=\"brands-list\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-edit mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Edit </span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
                    },
                },
            ],
            responsive: true,
            dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Column Visibility',
                    titleAttr: 'Col visibility',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    titleAttr: 'Generate CSV',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    titleAttr: 'Copy to clipboard',
                    className: 'btn-outline-default'
                },
                {
                    extend: 'print',
                    text: '<i class="fal fa-print"></i>',
                    titleAttr: 'Print Table',
                    className: 'btn-outline-default'
                }
            ],
        });
    });
</script>
@endsection