@extends('admin.layout.sidebar')
@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('viewcategory') }}">View category</a></li>
                            <li class="breadcrumb-item active">Add category</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Category</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->


      <form action="{{ route('storecategory') }}" method="POST" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">General</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('slug') }}">
                                @error('slug')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="title" value="{{ old('title') }}">
                                @error('title')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="mb-2">Status <span class="text-danger">*</span></label>
                                <br/>
                                <div class="d-flex flex-wrap">
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="status" value="active" id="inlineRadio1" {{ old('status') == 'active'  ? 'checked': '' }}>
                                        <label class="form-check-label" for="inlineRadio1">active</label>
                                    </div>
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="status" value="inactive" id="inlineRadio2" {{ old('status') == 'inactive'  ? 'checked': '' }} >
                                        <label class="form-check-label" for="inlineRadio2">inactive</label>
                                    </div>
                                </div>
                                @error('status')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="text-center mb-3">
                                <a href="{{ route('viewcategory') }}"><button type="button" class="btn w-sm btn-danger waves-effect">Cancel</button></a>
                                <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Meta Data</h5>

                        <div class="mb-3">
                            <label for="meta-title" class="form-label">Meta title</label>
                            <input type="text" name="meta_title" class="form-control" id="meta-title" placeholder="Enter title" value="{{ old('meta_title') }}">
                            @error('meta_title')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta-keywords" class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control" id="meta-keywords" placeholder="Enter keywords" value="{{ old('meta_keywords') }}">
                            @error('meta_keywords')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="meta-description" class="form-label">Meta Description </label>
                            <textarea name="meta_description" class="form-control" rows="5" id="meta-description" placeholder="Please enter description">{{ old('meta_description') }}</textarea>
                            @error('meta_description')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div> <!-- end card -->

            </div> <!-- end col-->
        </div>
      </form>        
    </div> <!-- container -->

</div> <!-- content -->
@endsection
@push('js')
      <script>
        document.getElementById('name').addEventListener('blur', function () {
            var name = this.value;
            var slug = slugify(name); 
            document.getElementById('slug').value = slug;
        });
    
        function slugify(text) {
            return text
                .toString()                    // Convert to string
                .toLowerCase()                 // Convert to lowercase
                .normalize('NFD')              // Normalize characters to separate accents
                .replace(/[\u0300-\u036f]/g, "") // Remove accents
                .replace(/\s+/g, '-')          // Replace spaces with hyphens
                .replace(/[^\w\-]+/g, '')      // Remove non-word characters
                .replace(/\-\-+/g, '-')        // Replace multiple hyphens with one
                .replace(/^-+/, '')            // Remove leading hyphens
                .replace(/-+$/, '');           // Remove trailing hyphens
        }
    </script>
@endpush