@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sub Admins</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Sub Admins</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">


                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sub Admins</h3>
                                <a style="max-width: 150px;float: right;display: inline-block"
                                    href="{{ url('/admin/add-subadmin') }}" class="btn btn-block btn-primary">Add Sub
                                    Admin</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="subadmins" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>MOBILE</th>
                                            <th>EMAIL</th>
                                            <th>TYPE</th>
                                            <th>CREATED ON</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subadmins as $subadmin)
                                            <tr>
                                                <td>{{ $subadmin->id }}</td>
                                                <td>{{ $subadmin->name }}</td>
                                                <td>{{ $subadmin->mobile }}</td>
                                                <td>{{ $subadmin->email }}</td>
                                                <td>{{ $subadmin->type }}</td>


                                                <td>{{ date('F j,Y,g:i a', strtotime($subadmin->created_at)) }}</td>
                                                <td>

                                                    @if ($subadmin->status == 1)
                                                        <a class="updateSubadminsStatus" id="subadmin-{{ $subadmin->id }}"
                                                            subadmin_id="{{ $subadmin->id }}" style="color: blue"
                                                            href="javascript:void(0)">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateSubadminsStatus" id="subadmin-{{ $subadmin->id }}"
                                                            subadmin_id="{{ $subadmin->id }}" style="color: gray"
                                                            href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif


                                                    &nbsp; &nbsp;
                                                    <a style='color: red;' class="confirmedDelete" name="Subadmin "title="
                                                        Delete Subadmin" href="javascript:void(0)" record="subadmin"
                                                        recordid={{ $subadmin->id }}>
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {{-- <a style='color: red;' class="confirmedDelete" name="Delete CMS Page"
                                                        title="Delete CMS Page" href="javascript:void(0)" record="cms-page"
                                                        recordid={{ $page['id'] }}>
                                                        <i class="fas fa-trash"></i>
                                                    </a> --}}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
