@extends('admin.layout.layout')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
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
                                    @if (empty($categoryEA['id'])) action="{{ url('admin/add-edit-category') }}"

                                @else action="{{ url('admin/add-edit-category/' . $categoryEA['id']) }}" @endif
                                    method="post" enctype="multipart/form-data" class="col-6">
                                    @csrf
                                    <div class="d-flex justify-content-center">
                                        <div class="card-body card border-0 border-primary">

                                            <div class="form-group">
                                                <label for="category_name">Name of Category</label>
                                                <input type="text" class="form-control" id="category_name"
                                                    placeholder="Enter Name of Category" name="category_name"
                                                    @if (!empty($categoryEA['category_name'])) value="{{ $categoryEA['category_name'] }}" @endif>
                                            </div>

                                            {{-- <div class="form-group">
                                                <label for="NameOfcategory">Name of Parent Category</label>
                                                <input type="text" class="form-control" id="name_category"
                                                    placeholder="Enter Name of Category" name="Name">
                                            </div> --}}

                                            <div class="form-group">
                                                <label for="category_discount">Discount of Category</label>
                                                <input type="number" class="form-control" id="category_discount"
                                                    placeholder="Enter Discount of Category" name="category_discount"
                                                    @if (!empty($categoryEA['category_discount'])) value="{{ $categoryEA['category_discount'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Category Description</label>
                                                <textarea class="form-control" name="description" id="description" placeholder="Enter Category Description">
                                                    @if (!empty($categoryEA['description']))
{{ $categoryEA['description'] }}
@endif
                                                </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="url">URL of Category</label>
                                                <input type="text" class="form-control" id="url"
                                                    placeholder="Enter URL of Category" name="url"
                                                    @if (!empty($categoryEA['url'])) value="{{ $categoryEA['url'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_title">Meta Title of Category</label>
                                                <input type="text" class="form-control" id="meta_title"
                                                    placeholder="Enter Meta Title of Category" name="meta_title"
                                                    @if (!empty($categoryEA['meta_title'])) value="{{ $categoryEA['meta_title'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_description">Meta Description of Category</label>
                                                <input type="text" class="form-control" id="meta_description"
                                                    placeholder="Enter Meta Description of Category" name="meta_description"
                                                    @if (!empty($categoryEA['meta_description'])) value="{{ $categoryEA['meta_description'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="meta_keywords">Meta Keywords of Category</label>
                                                <input type="text" class="form-control" id="meta_keywords"
                                                    placeholder="Enter Meta Keywords of Category" name="meta_keywords"
                                                    @if (!empty($categoryEA['meta_keywords'])) value="{{ $categoryEA['meta_keywords'] }}" @endif>
                                            </div>

                                            <div class="form-group">
                                                <label for="is_parent_category">Make it as Parent Category</label>
                                                <input type="checkbox" id="is_parent_category" name="is_parent_category"
                                                    @if ($categoryEA['parent_id'] == 0 || old('is_parent_category') == 1) checked @endif>
                                            </div>
                                            @if ($x)
                                                <div class="form-group" id="parentCategorySelector"
                                                    @if ($categoryEA['parent_id'] == 0 || old('is_parent_category') == 1) style="display: none;" @endif>

                                                    <label for="parent_category_id input-group-text bg-secondary text-white">Parent Category</label>
                                                    <select class="form-control " id="parent_category_id"
                                                        name="parent_category_id">
                                                        <option value="">Select Parent Category</option>
                                                        @foreach ($parentCategories as $parentCategory)
                                                            <option value="{{ $parentCategory['id'] }}"
                                                                @if ($categoryEA['parent_id'] == $parentCategory['id']) selected @endif>
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
                                            @endif

                                            <div class="form-group">
                                                <label for="image">Category Image</label>
                                                @if (!empty($categoryEA['image']))
                                                    <img src="{{ asset('admin/images/photos/' . $categoryEA['image']) }}"
                                                        alt="image" class="img-thumbnail">
                                                @else
                                                    <p>No image available</p>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control" id="image"
                                                    name="image">
                                            </div>

                                            <button type="submit" class="btn btn-info float-left">Add</button>

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
