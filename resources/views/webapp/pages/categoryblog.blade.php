@extends('webapp.layout.app')
@section('title',$data['meta_title'])
@section('meta_keywords',$data['meta_keywords'])
@section('meta_description',$data['meta_description'])
@section('content')
 <main>
     <!-- Header Start -->
  <div class="container-fluid bg-primary mb-5">
    <div
      class="d-flex flex-column align-items-center justify-content-center"
      style="min-height: 400px"
    >
    <h3 class="display-3 font-weight-bold text-white">{{ $getcategory->title }}</h3>
  
  <div class="d-inline-flex text-white">
      <p class="m-0"><a class="text-white" href="{{ route('home') }}">Home</a></p>
      <p class="m-0 px-2">/</p>
      <p class="m-0">{{ $getcategory->title }}</p>
  </div>
    </div>
  </div>
  <!-- Header End -->
 <!-- Blog Start -->
 <div class="container-fluid pt-5">
    <div class="container">
      <div class="row pb-3">
        @foreach ($getcategorypost as $item)
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm mb-2">
              <img class="card-img-top mb-2" src="{{ asset($item->image) }}" alt="" />
              <div class="card-body bg-light text-center p-4">
                <a href="{{ url('blog/'.$item->slug) }}"><h4 class="">{{ $item->title }}</h4></a>
                <div class="d-flex justify-content-center mb-3">
                  <small class="mr-3"
                    ><i class="fa fa-user text-primary"></i> {{ $item->user->name }}</small
                  >
                  <small class="mr-3"
                    ><i class="fa fa-folder text-primary"></i> 
                    @foreach ($item->categories as $item2)
                      <a href="{{ route('categoryblog',$item2->name) }}"> {{ $item2->name }},</a>
                    @endforeach
                    </small
                  >
                  <small class="mr-3"
                    ><i class="fa fa-comments text-primary"></i> 15</small
                  >
                </div>
                <p>
                 {{ $item->excerpt  }}
                </p>
                <a href="{{ route('blogdetail',$item->slug) }}" class="btn btn-primary px-4 mx-auto my-2"
                  >Read More</a
                >
              </div>
            </div>
          </div>
        @endforeach
        <div class="col-lg-11 ">
            
        </div>
        <div class="col-lg-1">
            {{ $getcategorypost->links() }} 
        </div>
      </div>
      
    </div>
  </div>
  <!-- Blog End -->
 </main>
@endsection