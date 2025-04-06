@php
    use App\Models\Category;
    $getcategoryheader = Category::orderBy('id', 'DESC')
                        ->where('menu',1)
                        ->where('status', 'active')->get();
@endphp
 <!-- Navbar Start -->
 <div class="container-fluid bg-light position-relative shadow">
  <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
      <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px">
          <i class="flaticon-043-teddy-bear"></i>
          <span class="text-primary">KidKinder</span>
      </a>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
          <div class="navbar-nav font-weight-bold mx-auto py-0">
              <a href="{{ route('home') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }} ">Home</a>
              @foreach ($getcategoryheader as $item)
                  <a href="{{ route('categoryblog',$item->slug) }}" class="nav-item nav-link {{ Route::currentRouteName() == 'categoryblog' && request()->slug == $item->slug ? 'active' : '' }}">{{ $item->name }}</a>
              @endforeach
              <a href="{{ route('blog') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'blog' ? 'active' : '' }}">Blog</a>
              {{-- <div class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                  <div class="dropdown-menu rounded-0 m-0">
                      <a href="blog.html" class="dropdown-item">Blog Grid</a>
                      <a href="single.html" class="dropdown-item">Blog Detail</a>
                  </div>
              </div> --}}
          </div>
          <div>
            <a href="{{ route('login') }}" class="btn btn-primary px-4">Login </a>
            <a href="{{ route('signup') }}" class="btn btn-primary px-4">Register </a>
          </div>
      </div>
  </nav>
</div>
<!-- Navbar End -->


