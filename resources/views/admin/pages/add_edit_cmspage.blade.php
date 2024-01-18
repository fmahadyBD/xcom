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
              <li class="breadcrumb-item active">{{$title}}</li>
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
            <h3 class="card-title">{{$title}}</h3>

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

                <form name="cmsFrom" id="cmsFrom" action="{{url('admin/add-edit-cms-page')}}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Title*</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter Page title" name="title">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">URL*</label>
                        <input type="text" class="form-control" id="url" placeholder="Enter page URL" name="url">
                      </div>



                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Enter Description"></textarea>
                      </div>

                      <div class="form-group">
                        <label for="meta_title">Meta Title*</label>
                        <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title">
                      </div>
                      <div class="form-group">
                        <label for="meta_description">Meta Description*</label>
                        <input type="text" class="form-control" id="meta_description" placeholder="Enter Meta Description" name="meta_description">
                      </div>
                      <div class="form-group">
                        <label for="meta_keywords">Meta Keywords*</label>
                        <input type="text" class="form-control" id="meta_keywords" placeholder="Enter Meta Keywords" name="meta_keywords">
                      </div>


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
