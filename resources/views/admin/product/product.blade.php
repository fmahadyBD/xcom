@extends('admin.layout.layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Products</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products Page</li>
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
                                <h3 class="card-title">Products Page</h3>
                                <a style="max-width: 150px;float: right;display: inline-block"
                                    href="{{ url('/admin/add-edit-products') }}" class="btn btn-block btn-primary">Add
                                    New Product</a>

                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table id="cattegories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>name</th>
                                            <th>Category name</th>
                                            <th>Brand name</th>
                                            <th>Color</th>
                                            <th>Product Code</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key)
                                            <tr>

                                                <td>{{ $key['product_name'] }}</td>

                                                <td>{{ isset($categories[$key['category_id']]) ? $categories[$key['category_id']] : 'N/A' }}
                                                </td>

                                                <td> </td>
                                                <td>{{ $key['product_color'] }}</td>
                                                <td>{{ $key['group_code'] }}</td>

                                                <td>
                                                    @if ($key['status'] == 1)
                                                        <a class="UpdateproductStatus" id="product-{{ $key['id'] }}"
                                                            product_id="{{ $key['id'] }}" page_id="{{ $key['id'] }}"
                                                            href="javascript:void(0)">
                                                            <i class="fas fa-toggle-on" status="Active"></i>
                                                        </a>
                                                    @else
                                                        <a class="UpdateproductStatus" id="product-{{ $key['id'] }}"
                                                            product_id="{{ $key['id'] }}" page_id="{{ $key['id'] }}"
                                                            style="color: gray" href="javascript:void(0)">
                                                            <i class="fas fa-toggle-off" status="Inactive"></i>
                                                        </a>
                                                    @endif

                                                    &nbsp; &nbsp;
                                                    <a style='color: rgb(238, 255, 0);'
                                                        href="{{ route('add-edit-products', ['id' => $key['id']]) }}">

                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    &nbsp; &nbsp;
                                                    <a style='color: rgb(253, 43, 43);' class="confirmedDeleteProduct"
                                                        href="javascript:void(0)" record="product"
                                                        recordid="{{ $key['id'] }}">
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
