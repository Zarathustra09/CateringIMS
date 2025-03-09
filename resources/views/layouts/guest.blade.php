<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{env('APP_NAME')}}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{asset('landingpage/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('landingpage/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('landingpage/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('landingpage/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('landingpage/assets/vendor/aos/aos.css" rel="stylesheet')}}">
    <link href="{{asset('landingpage/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('landingpage/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <!-- Main CSS File -->
    <link href="{{asset('landingpage/assets/css/main.css')}}" rel="stylesheet">
    @stack('styles')
</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{asset('landingpage/assets/img/logoname.jpg')}}" class="img-fluid" alt="" style="max-height: 60px;">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @guest
                    <li><a href="{{url('/')}}" class="active">Home<br></a></li>
                    <li><a href="{{ url('/') }}#about">About</a></li>
                    <li><a href="{{ url('/') }}#events">Events</a></li>
                    <li><a href="{{ url('/') }}#gallery">Gallery</a></li>
                    <li><a href="{{ url('/') }}#contact">Contact</a></li>
                @endguest

                @auth
                        <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home<br></a></li>
                        <li><a href="{{ route('reservation.index') }}" class="{{ Request::routeIs('reservation.index') ? 'active' : '' }}">Reservation</a></li>
                        <li><a href="{{ route('payment.index') }}" class="{{ Request::routeIs('payment.index') ? 'active' : '' }}">Payment</a></li>
                @endauth
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @guest
            <a class="btn-getstarted me-2" href="{{ route('login') }}">Sign In</a>
        @endguest

        @auth
            <div class="dropdown">
                <a class="btn-getstarted dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @endauth

    </div>
</header>

<main class="main">

    @yield('content')

</main>

<footer id="footer" class="footer dark-background">
    <div class="container">
        <div class="row gy-3 justify-content-center"> <!-- Added justify-content-center -->
            <div class="col-lg-3 col-md-6 d-flex">

                <i class="bi bi-geo-alt icon"></i>
                <div class="address">
                    <h4>Address</h4>
                    <p>Tinurik 4232</p>
                    <p>Tanauan, Philippines</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex">
                <i class="bi bi-telephone icon"></i>
                <div>
                    <h4>Contact</h4>
                    <p>
                        <strong>Phone:</strong> <span>0917 504 4011</span><br>
                        <strong>Email:</strong> <span>jhulianscateringservices2003@gmail.com</span><br>
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex">
                <h4>Follow Us</h4>
                <div class="social-links d-flex justify-content-center"> <!-- Center the social links -->
                    <a href="https://www.facebook.com/JhuliansCatering" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/jhulians_catering/" class="instagram"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Jhulian's Suite</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            <!-- Licensing information -->
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="{{asset('landingpage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('landingpage/assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('landingpage/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('landingpage/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('landingpage/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
<script src="{{asset('landingpage/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/jquery/jquery.js') }}"></script>
<!-- Main JS File -->
<script src="{{asset('landingpage/assets/js/main.js')}}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')


</body>

</html>
