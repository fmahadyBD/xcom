@extends('admin.layout.layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
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

                                <form name="cmsForm" id="cmsForm" method="post"
                                    @if (empty($productEA['id'])) action="{{ url('admin/add-edit-products') }}"

                                @else action="{{ url('admin/add-edit-products/' . $productEA['id']) }}" @endif
                                    method="post" enctype="multipart/form-data" class="col-6">
                                    @csrf

                                    <div class="d-flex justify-content-center">
                                        <div class="card-body card border-0 border-primary">

                                            <div class="form-group">
                                                <label for="product_name">Name of products</label>
                                                <input type="text" class="form-control" id="product_name"
                                                    placeholder="Enter Name of product" name="product_name"
                                                    @if (!empty($productEA['product_name'])) value="{{ $productEA['product_name'] }}" @endif>
                                            </div>

                                            <div class="form-group" id="parentCategorySelector">

                                                <label
                                                    for="parent_category_id input-group-text bg-secondary text-white">Parent
                                                    Category</label>
                                                <select class="form-control " id="parent_category_id"
                                                    name="parent_category_id">
                                                    <option value="">Select Parent Category</option>
                                                    @foreach ($parentCategories as $parentCategory)
                                                        <option value="{{ $parentCategory['id'] }}"
                                                            @if (isset($productEA['category_id']) && $productEA['category_id'] == $parentCategory['id']) selected @endif>

                                                            @if ($parentCategory['parent_id'] == 0)
                                                                {{ $parentCategory['category_name'] }}
                                                            @else
                                                                &nbsp; &nbsp; &nbsp; &nbsp; {{-- Add more spaces based on your preference --}}
                                                                @for ($i = 0; $i < $parentCategory['level']; $i++)
                                                                    &nbsp; &nbsp; &nbsp; &nbsp;
                                                                @endfor


                                                                -> {{ $parentCategory['category_name'] }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="product_code">Code of products</label>
                                                <input type="text" class="form-control" id="product_code"
                                                    placeholder="Enter Name of product" name="product_code"
                                                    @if (!empty($productEA['product_code'])) value="{{ $productEA['product_code'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="product_color">Product Color</label>
                                                <input type="text" class="form-control" id="product_color"
                                                    placeholder="Enter Name of product" name="product_color"
                                                    @if (!empty($productEA['product_color'])) value="{{ $productEA['product_color'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="family_color">Product Familty color</label>
                                                <input type="text" class="form-control" id="family_color"
                                                    placeholder="Enter Name of product" name="family_color"
                                                    @if (!empty($productEA['family_color'])) value="{{ $productEA['family_color'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="group_code">Group Code of Product</label>
                                                <input type="text" class="form-control" id="group_code"
                                                    placeholder="Enter Name of product" name="group_code"
                                                    @if (!empty($productEA['group_code'])) value="{{ $productEA['group_code'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="product_price">Product Price</label>
                                                <input type="number" class="form-control" id="product_price"
                                                    placeholder="Enter Name of product" name="product_price"
                                                    @if (!empty($productEA['product_price'])) value="{{ $productEA['product_price'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="product_discount">Discount of products</label>
                                                <input type="number" class="form-control" id="product_discount"
                                                    placeholder="Enter Name of product" name="product_discount"
                                                    @if (!empty($productEA['product_discount'])) value="{{ $productEA['product_discount'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="discount_type">Discount Type</label>
                                                <input type="text" class="form-control" id="discount_type"
                                                    placeholder="Enter Name of product" name="discount_type"
                                                    @if (!empty($productEA['discount_type'])) value="{{ $productEA['discount_type'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description of products</label>
                                                <input type="text" class="form-control" id="description"
                                                    placeholder="Enter Name of product" name="description"
                                                    @if (!empty($productEA['description'])) value="{{ $productEA['description'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="wish_care">Wish Care</label>
                                                <input type="text" class="form-control" id="wish_care"
                                                    placeholder="Enter Name of product" name="wish_care"
                                                    @if (!empty($productEA['wish_care'])) value="{{ $productEA['wish_care'] }}" @endif>
                                            </div>



                                            <div class="form-group">
                                                <label for="keywords">Keywords of products</label>
                                                <input type="text" class="form-control" id="keywords"
                                                    placeholder="Enter Discount of products" name="keywords"
                                                    @if (!empty($productEA['keywords'])) value="{{ $productEA['keywords'] }}" @endif>
                                            </div>
                                            <div class="form-group">
                                                <label for="fabric">Cloth:&nbsp;</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="fabricOption"
                                                        @if (!empty($productEA['fabric'] == 'yes')) checked @endif name="fabric"
                                                        value="yes">
                                                    <label class="form-check-label" for="fabricOption">Fabric</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="patternOption"
                                                        @if (!empty($productEA['pattern'] == 'yes')) checked @endif name="pattern"
                                                        value="yes">
                                                    <label class="form-check-label" for="patternOption">Pattern</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="sleeveOption"
                                                        @if (!empty($productEA['sleeve'] == 'yes')) checked @endif name="sleeve"
                                                        value="yes">
                                                    <label class="form-check-label" for="sleeveOption">Sleeve</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="fitOption"
                                                        @if (!empty($productEA['fit'] == 'yes')) checked @endif name="fit"
                                                        value="yes">
                                                    <label class="form-check-label" for="fitOption">Fit</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="ocassionOption"
                                                        @if (!empty($productEA['ocassion'] == 'yes')) checked @endif name="occasion"
                                                        value="yes">
                                                    <label class="form-check-label" for="ocassionOption">Occasion</label>
                                                </div>
                                            </div>









                                            <div class="form-group">
                                                <label for="meta_title">Meta Title of products</label>
                                                <input type="text" class="form-control" id="meta_title"
                                                    placeholder="Enter Meta Title of products" name="meta_title"
                                                    @if (!empty($productEA['meta_title'])) value="{{ $productEA['meta_title'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_description">Meta Description of products</label>
                                                <input type="text" class="form-control" id="meta_description"
                                                    placeholder="Enter Meta Description of products"
                                                    name="meta_description"
                                                    @if (!empty($productEA['meta_description'])) value="{{ $productEA['meta_description'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_keywords">Meta Keywords of products</label>
                                                <input type="text" class="form-control" id="meta_keywords"
                                                    placeholder="Enter Meta Keywords of products" name="meta_keywords"
                                                    @if (!empty($productEA['meta_keywords'])) value="{{ $productEA['meta_keywords'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="product_video">Product Video</label>
                                                {{-- @if (!empty($productEA['product_video']))
                                                    <video width="320" height="240" controls>
                                                        <source src="{{ asset('admin/videos/videos/' . $productEA['product_video']) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <p>No video available</p>
                                                @endif
                                            </div> --}}

                                                <div class="form-group">
                                                    <label for="product_video_file">Upload Product Video</label>

                                                    <input type="file" class="form-control" id="product_video_file"
                                                        name="product_video_file" accept="video/*">


                                                </div>

                                                <div class="form-group">
                                                    <label for="product_images">Products Images</label>

                                                    {{-- <input type="file" class="form-control" id="product_images"
                                                        name="product_images[]" multiple=""> --}}
                                                    <input type="file" class="form-control" id="product_images"
                                                        name="product_images[]" multiple="">


                                                </div>


                                                <button type="submit" class="btn btn-info float-left">Submit</button>

                                            </div>
                                        </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
