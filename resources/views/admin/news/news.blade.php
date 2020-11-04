@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item active">News</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Manage</span> News
    </h1>
</div>
<!-- BEGIN ACTUAL PAGE CONTENT -->
<div class="row">
    <div class="col-lg-12">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">
                <h2 class="m-2 ml-0">
                    <a href="/add_news"><button class="btn btn-primary btn-block" tabindex="0" aria-controls="products-list" type="button"><span><i class="fal fa-plus mr-1"></i> Add Article</span></button></a>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table id="news-list" class="table table-bordered table-hover table-striped w-100">
                        <thead class="" style="background: #f3f3f3;">
                            <tr>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Link</th>
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $article)
                            <tr>
                                <td>
                                    @if($article->status == 1)
                                    <span class="badge badge-success w-100">ACTIVE</span>
                                    @else
                                    <span class="badge badge-danger w-100">INACTIVE</span>
                                    @endif
                                </td>
                                <?php $time = strtotime($article->date); ?>
                                <td>{{date("Y/m/d", $time)}}</td>
                                <td style="text-align: center;">
                                    @if($article->photo != '')
                                        <img src="{{$article->photo}}" class="product-img"/>
                                    @else
                                        <img src="https://via.placeholder.com/279x144?text=NEWS-IMAGE" class="product-img"/>
                                    @endif
                                </td>
                                <td>{{$article->title}}</td>
                                <?php
                                    $category_num = $article->category;
                                    $arr = array("NEWS", "UPDATE", "GENERAL");
                                    $category = $arr[intval($category_num)];
                                ?>
                                <td>
                                    <span class="badge border border-secondary text-secondary w-100">{{$category}}</span>
                                </td>
                                <td>{{$article->link}}</td>
                                <td>{{$article->id}}</td>
                            </tr>
                            @endforeach
                            {{-- <tr>
                                <td><span class="badge badge-success w-100">ACTIVE</span></td>
                                <td>04/20/2020</td>
                                <td style="text-align: center;"><img src="https://ww1.prweb.com/prfiles/2020/06/09/17179366/gI_101899_budbopr2.png" class="product-img"/></td>
                                <td>Forged in fire: Beating the odds Budbo set to release v2 of mobile application with cannabis delivery and cryptocurrency wallet</td>
                                <td><span class="badge border border-secondary text-secondary w-100">NEWS</span></td>
                                <td>https://www.prweb.com/releases/forged_in_fire_beating_the_odds_budbo_set_to_release_v2_of_mobile_application_with_cannabis_delivery_and_cryptocurrency_wallet/prweb17179366.htm</td>
                                                                                        
                                <td></td>
                            </tr> --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Link</th>
                                
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
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

        /* init datatables */
        $('#news-list').dataTable(
        {
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
            columnDefs: [
                {
                    targets: -1,
                    title: '',
                    orderable: false,
                    render: function(data, type, full, meta)
                    {
                        /*
                        -- ES6
                        -- convert using https://babeljs.io online transpiler
                        return `
                        <a href='javascript:void(0);' class='btn btn-sm btn-icon btn-outline-danger rounded-circle mr-1' title='Delete Record'>
                            <i class="fal fa-times"></i>
                        </a>
                        <div class='dropdown d-inline-block dropleft '>
                            <a href='#'' class='btn btn-sm btn-icon btn-outline-primary rounded-circle shadow-0' data-toggle='dropdown' aria-expanded='true' title='More options'>
                                <i class="fal fa-ellipsis-v"></i>
                            </a>
                            <div class='dropdown-menu'>
                                <a class='dropdown-item' href='javascript:void(0);'>Change Status</a>
                                <a class='dropdown-item' href='javascript:void(0);'>Generate Report</a>
                            </div>
                        </div>`;
                            
                        ES5 example below:  

                        */
                        // return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"edit-product.html\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-warning btn-sm mr-1\" tabindex=\"0\" aria-controls=\"dt-basic-example\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-edit mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Edit</span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t<a href=\"#\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-danger btn-sm mr-1\" tabindex=\"0\" aria-controls=\"dt-basic-example\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-times mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Delete\n\t\t\t\t\t\t</span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
                        return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"/edit_news/" + full[6] + "\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-primary btn-block mr-1\" tabindex=\"0\" aria-controls=\"dt-basic-example\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-edit mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Edit</span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
                    },
                }
            ]

        });



    });

</script>
@endsection