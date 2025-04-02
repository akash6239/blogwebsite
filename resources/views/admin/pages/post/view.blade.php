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
                            <li class="breadcrumb-item active">View Posts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">View Posts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('admin.layout.toast')
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('addpost') }}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Posts</a>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table id="example" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Sno</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Published</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th style="width: 75px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                            </div>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="table-user">
                                            <img src="{{ asset($item->image) }}" alt="table-user" width="70px">
                                        </td>
                                        <td>{{ $item->title }}</td>
                                       <td>
                                        @foreach ($item->categories as $item2)
                                        <span class="badge badge-soft-primary">{{ $item2->name }}</span>
                                        @endforeach
                                       </td>
                                        <td>
                                            @if ($item->is_published == 'yes')
                                                <span class="badge badge-soft-success">Published</span>
                                            @else
                                                <span class="badge badge-soft-danger">not published</span>    
                                            @endif
                                        </td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            @if ($item->status == 'active')
                                                <span class="badge badge-soft-success">Active</span>
                                            @else
                                                <span class="badge badge-soft-danger">Inactive</span>    
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('editpost',$item->id) }}" class="action-icon"> <i class="mdi mdi-square-edit-outline fs-3"></i></a>
                                            <a href="javascript:void(0);" 
                                                class="action-icon text-danger" 
                                                onclick="confirmDelete('{{ route('deletepost', $item->id) }}')">
                                                <i class="mdi mdi-delete fs-3"></i>
                                            </a>
                                        </td>
                                    </tr>
                                   @endforeach

                                    
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
        
    </div> <!-- container -->

</div>
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>
    <script>
    new DataTable('#example', {
        responsive: true,
        paging: true, 
        // dom: 'Bfrtip',
        // buttons: ['csv', 'excel', 'pdf'],
    });
    </script>
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This post will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endpush