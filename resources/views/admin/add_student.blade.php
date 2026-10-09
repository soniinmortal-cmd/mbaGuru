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
                    <h1 class="m-0">Student</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Student</li>
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
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Bulk Upload</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#modal-default" onclick="document.getElementById('upload-excel-form').reset()" title="Upload Excel"><i class="fas fa-upload"></i> Upload Excel</button>
                            <a href="{{asset('public/assets/admin/SampleStudentExcel.xlsx')}}">
                                <button class="btn btn-warning btn-sm pull-right" data-toggle="tooltip" title="Download Excel"><i class="fas fa-download"></i> Sample Excel</button>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- Left col -->
                <section class="col-lg-12">
                    <!-- /.card -->

                    <div class="card card-primary">
                        <div class="card-header border-0">
                            <h3 class="card-title">Add Student</h3>
                        </div>
                        <form action="#" id="student-form" method="post">
                            <div class="card-body p-0">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                                                <input type="hidden" class="form-control" name="id" id="id">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="mobile">Mobile</label>
                                                <input type="mobile" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile No">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="button" onclick="clearForm()">Reset</button>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
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
                                        <th>Status</th>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" id="upload-excel-form" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Student Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="excel">Select Excel</label>
                            <input type="file" accept=".xlsx,.xlx" class="form-control" name="excel" id="excel">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>

    </div>
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
        $(document).on('submit', '#student-form', function(e) {
            e.preventDefault();
            var id = $('#student-form input[name=id]').val();
            var name = $('#student-form input[name=name]').val();
            var mobile = $('#student-form input[name=mobile]').val();
            var email = $('#student-form input[name=email]').val();
            if (name == '') {
                toastr.error('Name is mandatory.');
                return false;
            }
            if (email == '') {
                toastr.error('Email is mandatory.');
                return false;
            }
            if (mobile == '') {
                toastr.error('Mobile no is mandatory.');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /* $.ajax({
                url: "{{route('/admin/student/save')}}",
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.process_loader').show();
                },
                success: function(data) {
                    var msg = '';
                    if (data.code == 0) {
                        if (typeof data.message === 'object' && Object.keys(data.message).length > 0) {
                            $.each(data.message, function(key, value) {
                                msg += value + '<br/>';
                            });
                        } else {
                            msg = data.message;
                        }
                        toastr.error(msg);
                    } else {
                        msg = data.message;
                        toastr.success(msg);
                    }
                    loadStudents();
                    clearForm();
                },
                complete: function() {
                    $('.process_loader').hide();
                }
            }); */
        });

        $(document).on('submit', '#upload-excel-form', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /* $.ajax({
                url: "{{route('/admin/student/excel_upload')}}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.process_loader').show();
                },
                success: function(data) {
                    document.getElementById('upload-excel-form').reset();
                    $('.modal').modal('hide');
                    if (data.code == 0) {
                        if (typeof data.message === 'object' && Object.keys(data.message).length > 0) {
                            $.each(data.message, function(key, value) {
                                msg += value + '<br/>';
                            });
                        } else {
                            msg = data.message;
                        }
                        toastr.error(msg);
                    } else {
                        msg = data.message;
                        toastr.success(msg);
                    }
                    loadStudents();
                },
                complete: function() {
                    $('.process_loader').hide();
                },
                error: function(error) {
                    if (error.responseJSON.errors != undefined && error.responseJSON.errors.length > 0) {
                        $.each(error.responseJSON.errors, function(key, value) {
                            if (value != undefined && value.length > 0) {
                                $.each(value, function(k, val) {
                                    toastr.error(val);
                                });
                            }
                        });
                    }
                    document.getElementById('upload-excel-form').reset();
                }
            }); */
            return true;
        });


        loadStudents();
    });

    const editStudent = (id) => {
        if (id === undefined || id == '' || id == 0) {
            toastr.error('Data missing.');
            return false;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* $.ajax({
            url: "{{route('/admin/student/edit')}}",
            type: 'GET',
            data: {
                'id': id
            },
            beforeSend: function() {
                $('.process_loader').show();
            },
            success: function(data) {
                var msg = '';
                $('#student-form button[type=submit]').text('Update');
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
                    $('#student-form input[name=id]').val(data.data.id);
                    $('#student-form input[name=name]').val(data.data.name);
                    $('#student-form input[name=mobile]').val(data.data.mobile);
                    $('#student-form input[name=email]').val(data.data.email);
                }
            },
            complete: function() {
                $('.process_loader').hide();
            }
        }); */
    }

    const deleteStudent = (id) => {
        if (id === undefined || id == '' || id == 0) {
            toastr.error('Data missing.');
            return false;
        }
        Swal.fire({
            title: 'Warning!!',
            text: "Are you sure?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                /* $.ajax({
                    url: "{{route('/admin/student/delete')}}",
                    type: 'delete',
                    data: {
                        'id': id
                    },
                    beforeSend: function() {
                        $('.process_loader').show();
                    },
                    success: function(data) {
                        var msg = '';
                        $('#student-form button[type=submit]').text('Update');
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
                            loadStudents();
                        }
                    },
                    complete: function() {
                        $('.process_loader').hide();
                    }
                }); */
            }
        });
    }

    const loadStudents = () => {
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
            ajax: "{{ route('/admin/student') }}",
            drawCallback: function(settings) {
                $(document).find('[data-toggle="tooltip"]').tooltip();
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
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
                    data: 'status',
                    name: 'status',
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    const clearForm = () => {
        $('button[type=submit]').text('Submit');
        $('input[name=id]').val('');
        document.getElementById('student-form').reset();
    }
</script>
@endsection