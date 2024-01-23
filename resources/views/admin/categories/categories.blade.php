@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Category Page</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Category Page</li>
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
                                <h3 class="card-title">Category Page</h3>
                                <a style="max-width: 150px;float: right;display: inline-block" href="#"
                                    class="btn btn-block btn-primary">Add Category</a>

                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="cattegories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>PARENT NAME</th>
                                            <th>URL</th>
                                            <th>CREATED ON</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key)
                                            <tr>
                                                <td>{{ $key['id'] }}</td>
                                                <td>{{ $key['category_name'] }}</td>
                                                <td>


                                                    @if (isset($key['parentcategory']['category_name']))
                                                        {{ $key['parentcategory']['category_name'] }}
                                                    @endif

                                                </td>
                                                <td>{{ $key['url'] }}</td>
                                                <td>{{ date('F j, Y, g:i a', strtotime($key['created_at'])) }}</td>
                                                <td>
                                                    @if ($key['status'] == 1)
                                                        <a class="" id="{{ $key['id'] }}"
                                                            page_id="{{ $key['id'] }}" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="" id="{{ $key['id'] }}"
                                                            page_id="{{ $key['id'] }}" style="color: gray"
                                                            href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif
                                                    &nbsp; &nbsp;
                                                    <a style='color: #3fed3;' href="{{-- Your edit URL here --}}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    &nbsp; &nbsp;
                                                    <a style='color: red;' class="confirmedDelete" href="javascript:void(0)"
                                                        record="{{-- Your record data here --}}" recordid="{{ $key['id'] }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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
