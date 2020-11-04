@extends('layouts.retailer_layout')

@section('navigation')
@include('retailer.retailer_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item active">Manage Products</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> Manage <span class='fw-300'>Products</span>
    </h1>
</div>
<div class="row">
    <div class="col-lg-12">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">
                <h2 class="m-2 ml-0">
                <a href="/retailer_add_product"><button class="btn btn-primary btn-block" tabindex="0" aria-controls="dt-basic-example" type="button"><span><i class="fal fa-plus mr-1"></i> Add Product</span></button></a>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table id="products-list" class="table table-bordered table-hover table-striped w-100">
                        <thead class="" style="background: #f3f3f3;">
                            <tr>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Name</th>
                                {{-- <th>Brand</th> --}}
                                <th>Type</th>
                                <th>Category</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Name</th>
                                {{-- <th>Brand</th> --}}
                                <th>Type</th>
                                <th>Category</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- datatable end -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
    $(document).ready(function()
    {   
        var products = <?php echo $products; ?>;
        // var products = [
        //     {
        //         'status' : 'active',
        //         'image' : 'img/retailers/curaleaf.png',
        //         'name' : 'O.G. Kush',
        //         'brand' : '3CHI',
        //         'type' : 'Flower',
        //         'species': 'Indica',
        //         'description': 'This is OG Kush',
        //     },
        //     {
        //         'status' : 'draft',
        //         'image' : 'img/retailers/fluent.jpg',
        //         'name' : 'Brownies',
        //         'brand' : '420Smart',
        //         'type' : 'Edibles',
        //         'species': 'Sativa',
        //         'description': 'This is a brownie',
        //     },
        //     {
        //         'status' : 'inactive',
        //         'image' : 'img/retailers/trulieve.png',
        //         'name' : 'Wax',
        //         'brand' : '7Acres',
        //         'type' : 'Concentrate',
        //         'species': 'Hybrid',
        //         'description': 'Knocks your head off.',
        //     },
        // ];
        var types = ['indica', 'savita', 'hybrid'];
        var categories = ['flower', 'edible', 'concentrate', 'deal'];

        /* init datatables */
        $('#products-list').dataTable(
        {
            data: products,
            columns: [
                {   
                    title: 'Status',
                    data: 'status',
                    render: function(data, type, full, meta) {
                        if(data == 1){
                            return '<span class="badge badge-success w-100">ACTIVE</span>';
                        // }else if(data == 'draft'){
                        //     return '<span class="badge badge-secondary w-100">DRAFT</span>';
                        }else if(data == 0){
                            return '<span class="badge badge-danger w-100">INACTIVE</span>';
                        }
                    },
                    orderable: true,
                    searchable: true,
                },
                {   
                    title: 'Image',
                    data : 'image',
                    class: 'text-center',
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
                // {   
                //     title: 'Brand',
                //     data : 'brand',
                //     orderable: true,
                //     searchable: true,
                // },
                {   
                    title: 'Product Type',
                    data : 'types',
                    render: function(data, type, full, meta) {
                        var res = '';
                        if(data.includes(0)){
                            res += '<span class="badge border border-danger text-danger w-100">INDICA</span>';
                        }
                        if(data.includes(1)){
                            res += '<span class="badge border border-warning text-warning w-100">SATIVA</span>';
                        }
                        if(data.includes(2)){
                            res += '<span class="badge border border-success text-success w-100">HYBRID</span>';
                        }
                        if(data.includes(3)){
                            res += '<span class="badge border border-secondary text-secondary w-100">CBD</span>';
                        }
                        return res;
                    },
                    orderable: true,
                    searchable: true,
                },
                {   
                    title: 'Category',
                    data : 'category',
                    render: function(data, type, full, meta) {
                        return '<span class="badge border border-secondary text-secondary w-100">'+categories[data]+'</span>';
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    title: 'Edit',
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta)
                    {
                        return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"/retailer_edit_product/" + full['connection_id'] + "\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-primary btn-block mr-1\" tabindex=\"0\" aria-controls=\"brands-list\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-edit mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Edit</span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
                    },
                },
                {
                    title: 'Delete',
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta)
                    {
                        return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"/delete_product_connection/" + full['connection_id'] + "\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-primary btn-block mr-1\" tabindex=\"0\" aria-controls=\"brands-list\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-trash mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Delete</span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
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