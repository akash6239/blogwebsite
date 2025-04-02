@extends('webapp.layout.app')
@section('content')

<main>
 <!-- Header Start -->
 <div class="container-fluid bg-primary mb-5">
    <div
      class="d-flex flex-column align-items-center justify-content-center"
      style="min-height: 400px"
    >
      <h3 class="display-3 font-weight-bold text-white">blog detail</h3>
      <div class="d-inline-flex text-white">
        <p class="m-0"><a class="text-white" href="/">Home</a></p>
        <p class="m-0 px-2">/</p>
        <p class="m-0">About Us</p>
      </div>
    </div>
  </div>
  <!-- Header End -->
   <!-- Detail Start -->
   <div class="container py-5">
    <div class="row pt-5">
      <div class="col-lg-8">
        <div class="d-flex flex-column text-left mb-3">
          <p class="section-title pr-5">
            <span class="pr-2">Blog Detail Page</span>
          </p>
          <h1 class="mb-3">{{ $post->title }}</h1>
          <div class="d-flex">
            <p class="mr-3"><i class="fa fa-user text-primary"></i> {{ $post->user->name }}</p>
            <p class="mr-3">
              <i class="fa fa-folder text-primary"></i>
              @foreach ($post->categories  as $item2)
                {{ $item2->name }},
              @endforeach
            </p>
            <p class="mr-3"><i class="fa fa-comments text-primary"></i> 15</p>
          </div>
        </div>
        <div class="mb-5">
          @if ($post->image)
          <img
          style="max-height: 574px;object-fit:cover;"
            class="img-fluid rounded w-100 mb-4"
            src="{{asset($post->image)}}"
            alt="{{ $post->alt }}"
          />
          @else
            <p>No image found</p>
          @endif
          {!! $post->content !!}
        </div>

        <!-- Related Post -->
        <div class="mb-5 mx-n3">
          <h2 class="mb-4 ml-3">Related Post</h2>
          <div class="owl-carousel post-carousel position-relative">
            @foreach ($getrecentpost as $item)
            <div class="d-flex align-items-center bg-light shadow-sm rounded overflow-hidden mx-3">
                <img
                  class="img-fluid"
                  src="{{asset($item->image)}}"
                  style="width: 80px; height: 80px"
                />
                <div class="pl-3">
                  <a href="{{ route('blogdetail',$item->slug) }}"><h5 class="">{{ $item->title }}</h5></a>
                  <div class="d-flex">
                    <small class="mr-3"
                      ><i class="fa fa-user text-primary"></i> {{ $item->user->name }}</small
                    >
                    <small class="mr-3"
                      ><i class="fa fa-folder text-primary"></i> 
                      @foreach ($item->categories as $item2)
                          {{ $item2->name }}
                      @endforeach
                      </small
                    >
                    <small class="mr-3"
                      ><i class="fa fa-comments text-primary"></i> 15</small
                    >
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Comment List -->
        <div class="mb-5">
          <h2 class="mb-4">3 Comments</h2>
          <div class="media mb-4">
            <img
              src="{{asset('assets/img/user.jpg')}}"
              alt="Image"
              class="img-fluid rounded-circle mr-3 mt-1"
              style="width: 45px"
            />
            <div class="media-body">
              <h6>
                John Doe <small><i>01 Jan 2045 at 12:00pm</i></small>
              </h6>
              <p>
                Diam amet duo labore stet elitr ea clita ipsum, tempor labore
                accusam ipsum et no at. Kasd diam tempor rebum magna dolores
                sed sed eirmod ipsum. Gubergren clita aliquyam consetetur
                sadipscing, at tempor amet ipsum diam tempor consetetur at
                sit.
              </p>
              <button class="btn btn-sm btn-light">Reply</button>
            </div>
          </div>
          <div class="media mb-4">
            <img
              src="{{asset('assets/img/user.jpg')}}"
              alt="Image"
              class="img-fluid rounded-circle mr-3 mt-1"
              style="width: 45px"
            />
            <div class="media-body">
              <h6>
                John Doe <small><i>01 Jan 2045 at 12:00pm</i></small>
              </h6>
              <p>
                Diam amet duo labore stet elitr ea clita ipsum, tempor labore
                accusam ipsum et no at. Kasd diam tempor rebum magna dolores
                sed sed eirmod ipsum. Gubergren clita aliquyam consetetur
                sadipscing, at tempor amet ipsum diam tempor consetetur at
                sit.
              </p>
              <button class="btn btn-sm btn-light">Reply</button>
              <div class="media mt-4">
                <img
                  src="{{asset('assets/img/user.jpg')}}"
                  alt="Image"
                  class="img-fluid rounded-circle mr-3 mt-1"
                  style="width: 45px"
                />
                <div class="media-body">
                  <h6>
                    John Doe <small><i>01 Jan 2045 at 12:00pm</i></small>
                  </h6>
                  <p>
                    Diam amet duo labore stet elitr ea clita ipsum, tempor
                    labore accusam ipsum et no at. Kasd diam tempor rebum
                    magna dolores sed sed eirmod ipsum. Gubergren clita
                    aliquyam consetetur, at tempor amet ipsum diam tempor at
                    sit.
                  </p>
                  <button class="btn btn-sm btn-light">Reply</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Comment Form -->
        <div class="bg-light p-5">
          <h2 class="mb-4">Leave a comment</h2>
          <form>
            <div class="form-group">
              <label for="name">Name *</label>
              <input type="text" class="form-control" id="name" />
            </div>
            <div class="form-group">
              <label for="email">Email *</label>
              <input type="email" class="form-control" id="email" />
            </div>
            <div class="form-group">
              <label for="website">Website</label>
              <input type="url" class="form-control" id="website" />
            </div>

            <div class="form-group">
              <label for="message">Message *</label>
              <textarea
                id="message"
                cols="30"
                rows="5"
                class="form-control"
              ></textarea>
            </div>
            <div class="form-group mb-0">
              <input
                type="submit"
                value="Leave Comment"
                class="btn btn-primary px-3"
              />
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-4 mt-5 mt-lg-0">
        <!-- Author Bio -->
        {{-- <div
          class="d-flex flex-column text-center bg-primary rounded mb-5 py-5 px-4"
        >
          <img
            src="{{asset('assets/img/user.jpg')}}"
            class="img-fluid rounded-circle mx-auto mb-3"
            style="width: 100px"
          />
          <h3 class="text-secondary mb-3">John Doe</h3>
          <p class="text-white m-0">
            Conset elitr erat vero dolor ipsum et diam, eos dolor lorem ipsum,
            ipsum ipsum sit no ut est. Guber ea ipsum erat kasd amet est elitr
            ea sit.
          </p>
        </div> --}}

        <!-- Search Form -->
        <div class="mb-5">
            <form action="{{ route('blog') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-lg" placeholder="Keyword" value="{{ request('search') }}" />
                    <div class="input-group-append">
                        <button class="input-group-text bg-transparent text-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Category List -->
        <div class="mb-5">
          <h2 class="mb-4">Categories</h2>
          <ul class="list-group list-group-flush">
            @foreach ($category as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                <a href="">{{ $item->name }}</a>
                <span class="badge badge-primary badge-pill">{{ $item->posts()->count() }}</span>
              </li>
            @endforeach
          </ul>
        </div>

        <!-- Recent Post -->
        <div class="mb-5">
          <h2 class="mb-4">Recent Post</h2>
          @foreach ($getrecentpost as $item)
          <div class="d-flex align-items-center bg-light shadow-sm rounded overflow-hidden mb-3">
            <img
              class="img-fluid"
              src="{{asset($item->image)}}"
              style="width: 80px; height: 80px"
            />
            <div class="pl-3">
             <a href="{{ asset('blog/'.$item->slug) }}"> <h5 class="">{{ $item->title }}</h5></a>
              <div class="d-flex">
                <small class="mr-3"
                  ><i class="fa fa-user text-primary"></i> {{ $item->user->name }}</small
                >
                <small class="mr-3"
                  ><i class="fa fa-folder text-primary"></i> 
                  @foreach ($item->categories as $item2)
                      {{ $item2->name }}
                  @endforeach
                  </small
                >
                <small class="mr-3"
                  ><i class="fa fa-comments text-primary"></i> 15</small
                >
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Tag Cloud -->
        <div class="mb-5">
          <h2 class="mb-4">Tag Cloud</h2>
          <div class="d-flex flex-wrap m-n1">
           @foreach ($tags as $item)
                <a href="" class="btn btn-outline-primary m-1">{{ $item->name }}</a>
           @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Detail End -->

</main>

@endsection