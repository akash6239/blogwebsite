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
                            <li class="breadcrumb-item"><a href="{{ route('viewpost') }}">View Post</a></li>
                            <li class="breadcrumb-item active">Add Post</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Post</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      <form action="{{ route('storepost') }}" method="POST" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">General</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="title" value="{{ old('title') }}">
                                @error('title')<p class="text-danger">{{ $message }}</p>@enderror
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('slug') }}">
                                @error('slug')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="tag_id" class="form-label">Tags <span class="text-danger">*</span></label>
                                <select name="tag_id[]" id="tag_id" class="form-control" multiple>
                                    @foreach ($tags as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ in_array($item->id, old('tag_id', [])) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tag_id')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>

                        <div class="mb-3">
                            <label for="summernote" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea id="summernote" name="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                            @error('content')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="excerpt" class="form-label">Excerpt <span class="text-danger">*</span></label>
                            <textarea id="excerpt" name="excerpt" class="form-control" rows="5" placeholder="Write excerpt">{{ old('excerpt') }}</textarea>
                            @error('excerpt')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id[]" id="category_id" class="form-control" multiple>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" 
                                        {{ in_array($item->id, old('category_id', [])) ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            
                            @error('category_id')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                        

                        <div class="mb-3">
                            <label class="mb-2">Status <span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status" value="active" id="inlineRadio1" {{ old('status') == 'active'  ? 'checked': '' }}>
                                    <label class="form-check-label" for="inlineRadio1">Active</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status" value="inactive" id="inlineRadio2" {{ old('status') == 'inactive'  ? 'checked': '' }} >
                                    <label class="form-check-label" for="inlineRadio2">Inactive</label>
                                </div>
                            </div>
                            @error('status')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="is_published" class="form-label">Published <span class="text-danger">*</span></label>
                            <select name="is_published" id="is_published" class="form-control">
                                    <option value="no" {{ old('is_published') == 'yes'  ? 'selected': '' }}>no</option>
                                    <option value="yes" {{ old('is_published') == 'yes'  ? 'selected': '' }}>yes</option>
                            </select>
                            @error('is_published')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-lg-4">
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Post Image</h5>
                        <div class="fallback mb-3">
                            <input name="image" type="file" class="form-control" />
                            @error('image')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="alt" class="form-label">Image Alt</label>
                            <input type="text" name="alt" class="form-control" id="alt" placeholder="Alt" value="{{ old('alt') }}">
                            @error('alt')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div> <!-- end col-->

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
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="text-center mb-3">
                    <a href="{{ route('viewpost') }}"><button type="button" class="btn w-sm btn-danger waves-effect waves-light">Cancel</button></a>
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->
      </form>        
    </div> <!-- container -->

</div> 
@endsection
@push('css')
     <link rel="stylesheet" href="{{asset('backend/assets/libs/summereditor/summernote/summernote-bs4.min.css')}}">
     <link rel="stylesheet" href="{{asset('backend/assets/libs/summereditor/codemirror/codemirror.css')}}">
     <link rel="stylesheet" href="{{asset('backend/assets/libs/summereditor/codemirror/theme/monokai.css')}}">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">
     <style>
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 0 0 0 11px;
            border-radius: 20px;
            margin: 5px;
            background-color: #CD485C;
        }

        .remove-tag {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
     </style>
@endpush
@push('js')
    <script src="{{ asset('backend/assets/libs/summereditor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/assets/libs/summereditor/bootstrap.bundle.js')}}"></script>
    <script src="{{ asset('backend/assets/libs/summereditor/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{ asset('backend/assets/libs/summereditor/codemirror/codemirror.js')}}"></script>
    <script src="{{ asset('backend/assets/libs/summereditor/codemirror/mode/css/css.js')}}"></script>
    <script src="{{ asset('backend/assets/libs/summereditor/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{ asset('backend/assets/libs/summereditor/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>
    <script>
        $('#summernote').summernote({
          height: 300 ,
          tabsize: 2,
        });
      
      </script>
      <script>
        document.getElementById('title').addEventListener('blur', function () {
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
    <script>
        new MultiSelectTag('category_id', {
        rounded: true,   
        placeholder: 'Search',
        tagColor: {
            textColor: '#327b2c',
            borderColor: '#92e681',
            bgColor: '#eaffe6',
        },
        onChange: function(values) {
            console.log(values)
        }
    });
    new MultiSelectTag('tag_id', {
        rounded: true,    
        placeholder: 'Search',
        tagColor: {
            textColor: '#327b2c',
            borderColor: '#92e681',
            bgColor: '#eaffe6',
        },
        onChange: function(values) {
            console.log(values)
        }
    });
    </script>
   
@endpush