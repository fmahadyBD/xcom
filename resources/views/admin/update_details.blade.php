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
                            <li class="breadcrumb-item active">Update Details</li>
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
                                    <h3 class="card-title">Update Details</h3>
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




                                <form method="post" action="{{ route('updateDetails') }}"
                                    enctype="multipart/form-data">


                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="admin_email">Email address</label>
                                            <input class="form-control" id="exampleInputEmail1"
                                                value="{{ Auth::guard('admin')->user()->email }}" readonly=""
                                                style="background-color: darkgray">
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_name">Name</label>
                                            <input type="text" class="form-control" id="admin_name"
                                                placeholder="Admin Name" name="admin_name"
                                                value="{{ Auth::guard('admin')->user()->name }}">

                                        </div>


                                        <div class="form-group">
                                            <label for="admin_mobile">Mobile</label>
                                            <input type="text" class="form-control" id="admin_mobile"
                                                placeholder="Mobile" name="admin_mobile"
                                                value="{{ Auth::guard('admin')->user()->mobile }}">

                                        </div>
                                        <div class="form-group">
                                            <label for="admin_image">Image</label>
                                            <input type="file" class="form-control" id="admin_image" name="admin_image">

                                            {{-- @if(!@empty(Auth::guard('admin')->user()->image))
                                            <a href="{{url(admin/images/photos/.Auth::guard('admin')->user()->image)}}" target="_blank">View Photo</a>
                                                <input type="hidden" name="crrent_image" value="{{Auth::guard('admin')->user()->image}}">
                                           @elseif () --}}

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
