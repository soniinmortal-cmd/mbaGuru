@extends('Admin/master')
@extends('Admin/header')
@extends('Admin/asidebar')
@section('main')
<!-- Content Wrapper. Contains page content -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Student List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Student List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row ">
                <!-- Right col -->
                <section class="col-lg-12">
                    <!-- /.card -->
                    <div class="card card-primary">
                        <div class="card-header border-0">
                            <h3 class="card-title">List Students</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle" id="student_table">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Signed On</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Signed On</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('links')
<link rel="stylesheet" href="{{asset('public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<script src="{{asset('public/assets/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // loadStudents();
    });

    const editStudent = (id) => {
        if (id === undefined || id == '' || id > 0) {
            toastr.error('Data missing.');
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* $.ajax({
            url: "{{route('/admin/student/edit')}}",
            type: 'POST',
            data: {
                'id': id
            },
            beforeSend: function() {
                $('.process_loader').show();
            },
            success: function(data) {
                var msg = '';
                if (data.code == 0) {
                    if (typeof data.message === 'object' && Object.keys(data.message).length > 0) {
                        $.each(data.message, function(key, value) {
                            msg += value + '<br />';
                        });
                    } else {
                        msg = data.message;
                    }
                    toastr.error(msg);
                } else {
                    msg = data.message;
                    toastr.success(msg);
                }
                console.log(data);
            },
            complete: function() {
                $('.process_loader').hide();
            }
        }); */
    }

    /* const loadStudents = () => {
        $('#student_table').dataTable().fnDestroy();
        $('#student_table').DataTable({
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            "responsive": true,
            "bAutoWidth": false,
            "scrollX": true,
            "pageLength": 10,
            processing: true,
            serverSide: true,
            ajax: "{{ route('/admin/student_list') }}",
            drawCallback: function(settings) {
                $(document).find('[data-toggle="tooltip"]').tooltip();
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'signed_on',
                    name: 'signed_on'
                },
                {
                    data: 'last_login',
                    name: 'last_login'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    } */
</script>
@endsection