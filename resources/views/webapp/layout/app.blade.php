<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Default Title')</title>
    <meta content="@yield('meta_keywords', 'default, keywords, here')" name="keywords" />
    <meta content="@yield('meta_description', 'Default meta description for the website.')" name="description" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <!-- Favicon -->
    <link href="{{ asset('assets/img/favicon.ico') }}" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Flaticon Font -->
    <link href="{{ asset('assets/lib/flaticon/font/flaticon.css')}}" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" />
</head>

<body>
   
 @include('webapp.layout.header')
 @yield('content')
 @include('webapp.layout.footer')

    

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('assets/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{ asset('assets/mail/contact.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js')}}"></script>
</body>

</html>
