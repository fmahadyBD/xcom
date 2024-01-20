@extends('admin.layout.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Advanced Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">


                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if (Session::has('success_message'))
                                    <div class="alert alert-warning alert-denger fade show" role="alert">
                                        <strong>Success:</strong> {{ Session::get('success_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form name="subadminFrom" id="subadminFrom"
                                    @if (empty($subadmin['id'])) action="{{ url('admin/add-subadmin') }}"

                                        @else action="{{ url('admin/add-subadmin/' . $subadmin['id']) }}" @endif
                                    method="post" enctype="multipart/form-data" class="col-6">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Enter Subadmin" name="name"
                                               @if (!empty($subadmin['name'])) value="{{ $subadmin['name'] }}" @endif>

                                               
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Enter subadmin email" name="email"
                                                @if (!empty($subadmin['email'])) value="{{ $subadmin['email'] }}" @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" id="mobile"
                                                placeholder="Enter Subadmin Mobile" name="mobile"
                                                @if (!empty($subadmin['mobile'])) value="{{ $subadmin['mobile'] }}" @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" class="form-control" id="password"
                                                placeholder="Enter password" name="password"
                                                @if (!empty($subadmin['password'])) value="{{ $subadmin['password'] }}" @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">

                                                @if (isset($subadmin['image']))
                                                    <a target="_blank"
                                                        href="{{ url('admin/images/photos/' . $subadmin['image']) }}">View
                                                        Photo</a>
                                                @endif

                                        </div>

                                        <button type="submit" class="btn btn-info btn-flat">Add</button>
                                    </div>

                                </form>


                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>

                </div>


                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
