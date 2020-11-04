@extends('layouts.admin_layout')

@section('navigation')
@include('admin.admin_navigation')
@endsection

@section('page_content')
<ol class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0);">Budbo</a></li>
    <li class="breadcrumb-item">App Management</li>
    <li class="breadcrumb-item active">Users</li>
    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
</ol>
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-edit'></i> <span class='fw-300'>Manage</span> Users
    </h1>
</div>
<div class="row">
    <div class="col-lg-12">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">

                <h2 class="m-2 ml-0">
                    <a href="/add_user"><button class="btn btn-success btn-block" tabindex="0"
                            aria-controls="users-list" type="button"><span><i class="fal fa-plus mr-1"></i> Add
                                User</span></button></a>
                </h2>

                <div class="panel-toolbar">

                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table id="users-list" class="table table-bordered table-hover table-striped w-100">
                        <thead class="" style="background: #f3f3f3;">
                            <tr>
                                <th>Status</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->status }}</td>
                            <td>{{ $user->image }}</td>
                            <td>{{ $user->first_name }} </td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->city }}</td>
                            <td>{{ $user->state }}</td>
                            <td>{{ $user->country }}</td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Status</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Controls</th>
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
        var users = <?php echo json_encode($users); ?>;

        startDatatable();

        //CREATE LIST OF RANDOM USERS
        // var status = ['approved', 'pending', 'restricted'];

        // $.ajax({
        //     url: '/api/login', 
        //     type: 'post', 
        //     data: {email: 'admin@admin.com', password: '!QAZxsw2'}, 
        //     success: function(result){
        //         $auth_token = result.response.token;

        //         $.ajax({
        //             url: '/api/users',
        //             dataType: 'json',
        //             headers: {authorization: 'Bearer ' + $auth_token}, 
        //             success: function(data) {
        //                 users = data;
        //                 // for (var i = users.length - 1; i >= 0; i--) {
        //                 //     users[i]['status'] = status[Math.floor(Math.random()*status.length)]
        //                 // }
        //                 startDatatable();
        //             }
        //         });
        //     }, 
        //     fail: function(err) {
        //         console.log(err);
        //     }
        // })
        


        

        /* init datatables */
        

        function startDatatable(){
            $('#users-list').dataTable(
            {
                
                data: users,
                columns: [
                    {   
                        title: "Status",
                        data: 'status',
                        render: function(data, type, full, meta) {
                            if(data == 1){
                                return '<span class="badge badge-success w-100">ACTIVE</span>';
                            }else if(data == 0){
                                return '<span class="badge badge-warning w-100">INACTIVE</span>';
                            // }else if(data == 2){
                            //     return '<span class="badge badge-danger w-100">RESTRICTED</span>';
                            }
                        },
                        orderable: true,
                        searchable: true,
                    },
                    {   
                        title: "Image",
                        data : 'image',
                        render: function(data, type, full, meta) {
                                return '<img src="'+data+'" class="product-img"/>';
                        },
                        orderable: false,
                        searchable: false,
                    },
                    {   
                        title: "First Name",
                        data : 'first_name',
                        orderable: true,
                        searchable: true,
                    },
                    {   
                        title: "Last Name",
                        data : 'last_name',
                        orderable: true,
                        searchable: true,
                    },
                    {   
                        title: "Email",
                        data : 'email',
                        orderable: true,
                        searchable: true,
                    },
                    {   
                        title: "City",
                        data : 'city',
                        orderable: true,
                        searchable: true,
                    },
                    {   
                        title: "State",
                        data : 'state',
                        orderable: true,
                        searchable: true,
                    },
                    {   
                        title: "Country",
                        data : 'country',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        title: "Controls",
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta)
                        {
                            return "\n\t\t\t\t\t\t<div class=\"dt-buttons\"><a href=\"/edit_user/" + data + "\">\n\t\t\t\t\t\t<button class=\"btn buttons-selected btn-primary btn-block mr-1\" tabindex=\"0\" aria-controls=\"users-list\" type=\"button\">\n\t\t\t\t\t\t<span>\n\t\t\t\t\t\t<i class=\"fal fa-edit mr-1\">\n\t\t\t\t\t\t</i>\n\t\t\t\t\t\t Edit</span>\n\t\t\t\t\t\t</button>\n\t\t\t\t\t\t</a>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t";
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
        }
    });
</script>
@endsection