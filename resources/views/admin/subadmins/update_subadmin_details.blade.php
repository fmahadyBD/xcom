@extends('admin.layout.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Update Subadmin Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Subadmin Details</h3>
                                </div>

                                @if (Session::has('error_message'))
                                    <div class="alert alert-warning alert-denger fade show" role="alert">
                                        <strong>Error:</strong> {{ Session::get('error_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if (Session::has('success_message'))
                                    <div class="alert alert-success fade show" role="alert">
                                        <strong>Sussess:</strong> {{ Session::get('success_message') }}
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




                                {{-- <form method="post" action="{{ url('update-subadmin-Details/'. $id) }}"
                                    enctype="multipart/form-data"> --}}
                                <form method="post" action="{{ route('update-subadmin-Details', ['id' => $id]) }}"
                                    enctype="multipart/form-data">


                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="admin_name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Suuadmin Name" name="name" value="{{ $admin['name'] }}">

                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input name="email" class="form-control" id="email" value="{{ $admin['email'] }}"
                                                readonly="" style="background-color: darkgray">
                                        </div>



                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" id="mobile" placeholder="Mobile"
                                                name="mobile" value="{{ $admin['mobile'] }}">

                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input type="text" class="form-control" id="new_password"
                                                placeholder="New Password" name="new_password">

                                        </div>



                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </section>
        </div>

    </div>
@endsection
