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


                                
                                <form name="subadminFrom" id="subadminFrom" action="{{ url('admin/update-role/' . $id) }}"
                                    method="post" class="col-6">
                                    @csrf
                                    <input type="hidden" name="subadmin_id" value="{{ $id }}">

                                    @if (!@empty($subadminRoles))
                                        @foreach ($subadminRoles as $role)
                                            @if ($role['module'] == 'cms_page')
                                                @if ($role['view_access'] == 1)
                                                    @php $viewCMSPage="checked"@endphp
                                                @else
                                                    @php $viewCMSPage=""@endphp
                                                @endif
                                            @endif
                                            @if ($role['module'] == 'cms_page')
                                                @if ($role['edit_access'] == 1)
                                                    @php $editCMSPage="checked"@endphp
                                                @else
                                                    @php $editCMSPage=""@endphp
                                                @endif
                                            @endif
                                            @if ($role['module'] == 'cms_page')
                                                @if ($role['full_access'] == 1)
                                                    @php $fullCMSPage="checked"@endphp
                                                @else
                                                    @php $fullCMSPage=""@endphp
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="form-group">
                                        <label for="">CMS Pages:</label>
                                        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="cms_page[view]" value="1"
                                            @if (isset($viewCMSPage)) {{ $viewCMSPage }} @endif> &nbsp;View
                                        &nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="cms_page[edit]"value="1"
                                            @if (isset($editCMSPage)) {{ $editCMSPage }} @endif> &nbsp;View/Edit
                                        Access
                                        &nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="cms_page[full_access]"value="1"
                                            @if (isset($fullCMSPage)) {{ $fullCMSPage }} @endif> &nbsp;Full Access
                                        &nbsp;&nbsp;&nbsp;

                                    </div>
                                    <button type="submit" id="submitBtn" class="btn btn-info btn-flat">Update</button>
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
