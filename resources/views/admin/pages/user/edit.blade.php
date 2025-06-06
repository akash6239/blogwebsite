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
                            <li class="breadcrumb-item"><a href="{{ route('viewpost') }}">View User</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit user</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->


      <form action="{{ route('updateuser',$user->id) }}" method="POST" enctype="multipart/form-data">@csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">User</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="name" value="{{ old('name',$user->name) }}">
                                @error('name')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
    
                            <div class="col-md-6 mb-3">
                                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email',$user->email) }}">
                                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="password" value="">
                                @error('password')<p class="text-danger">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Status <span class="text-danger">*</span></label>
                            <br/>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status" value="active" id="inlineRadio1" {{ old('status',$user->status) == 'active'  ? 'checked': '' }}>
                                    <label class="form-check-label" for="inlineRadio1">Active</label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="status" value="inactive" id="inlineRadio2" {{ old('status',$user->status) == 'inactive'  ? 'checked': '' }} >
                                    <label class="form-check-label" for="inlineRadio2">Inactive</label>
                                </div>
                            </div>
                            @error('status')<p class="text-danger">{{ $message }}</p>@enderror
                        </div>
                        <div class="text-center mb-3">
                            <a href="{{ route('viewuser') }}"><button type="button" class="btn w-sm btn-danger waves-effect">Cancel</button></a>
                            <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Update</button>
                        </div>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col --> <!-- end col-->
        </div>
        <!-- end row -->
      </form>        
    </div> <!-- container -->

</div>
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush