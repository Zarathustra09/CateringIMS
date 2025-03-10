@extends('layouts.guest')


@section('content')

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

        <div class="container">
            <div class="row gy-4 justify-content-center justify-content-lg-between">
                <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up">Delicious Moments Served:<br>Your Perfect Catering Awaits!</h1>
                    <p data-aos="fade-up" data-aos-delay="100">Elevate your events with our seamless catering reservations, where every bite is a celebration!</p>
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <a href="#book-a-table" class="btn-get-started">Reserve Now!</a>
                        {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a> --}}
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                    <img src="{{asset('landingpage/assets/img/hero-img.jpg')}}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>About Us<br></h2>
            <p><span>Learn More</span> <span class="description-title">About Us</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{asset('landingpage/assets/img/about.jpg')}}" class="img-fluid mb-4" alt="">
                    <div class="book-a-table">
                        <h3>Inquire Now!</h3>
                        <p>Globe: 0917 504 4011 / 0917 892 5128</p>
                            <p>Smart: 0939 924 9377</p>
                            <p>Landline: (043)741 1278</p>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
                    <div class="content ps-0 ps-lg-5">
                        <p class="fst-italic">
                            Welcome to Jhulians Suite, where we believe that every event deserves to be unforgettable! Located in the heart of Tinurik, Tanauan, Philippines, we have been serving our community since 2013 with a passion for exceptional food and memorable experiences
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Jhulians Suite offers a diverse range of services, including wedding packages, debut celebrations, birthday parties, and corporate events.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i> <span>In addition to Suite, we provide flower arrangements, photo booth services, and event coordination for a complete event experience.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i> <span>Jhulians Suite is known for its stunning food presentation, transforming each dish into a visual masterpiece that enhances the overall dining experience at your event.</span></li>
                        </ul>
                        <p>
                            In addition to our catering services, we offer beautiful flower arrangements, engaging photo booths, and comprehensive event coordination to ensure every detail is taken care of. Our team is committed to providing you with delicious cuisine and exceptional service, allowing you to relax and enjoy your event to the fullest.
                        </p>

                        {{-- <div class="position-relative mt-4">
                            <img src="{{asset('landingpage/assets/img/about-2.jpg')}}" class="img-fluid" alt="">
                            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /About Section -->

    <!-- Why Us Section -->


    <!-- Stats Section -->
    <section id="stats" class="stats section dark-background">

        <img src="{{asset('landingpage/assets/img/stats-bg.jpg')}}" alt="" data-aos="fade-in">

        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="123" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Clients</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="342" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Projects</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Hours Of Support</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Workers</p>
                    </div>
                </div><!-- End Stats Item -->

            </div>

        </div>

    </section><!-- /Stats Section -->


    <section id="why-us" class="why-us section light-background">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-box">
                        <h3>Why Choose Jhulian's Suite?</h3>
                        <p>
                            Choosing Jhulians Catering means selecting a dedicated team that creates unforgettable culinary
                            experiences tailored to your events. With diverse menu options, quality ingredients, and exceptional
                            service, we ensure a delightful experience for you and your guests. Let us handle every detail, so you can relax and enjoy your special occasion!
                        </p>
                        <div class="text-center">
                            <a href="#" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Why Box -->

                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-xl-4">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Local Ingredients</h4>
                                <p>Jhulians Catering prioritizes the use of fresh, locally sourced ingredients to ensure the highest quality and flavor in every dish.</p>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-gem"></i>
                                <h4>Customizable Menus</h4>
                                <p>We offer customizable menu options that cater to various dietary preferences and restrictions, allowing you to create a dining experience that suits all your guests.</p>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-inboxes"></i>
                                <h4>Client-Centric Approach</h4>
                                <p>Our team takes a client-centric approach, working closely with you to understand your vision and preferences, ensuring that your event is personalized and meets your expectations.</p>
                            </div>
                        </div><!-- End Icon Box -->

                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Why Us Section -->

    {{-- <!-- Menu Section -->
    <section id="menu" class="menu section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Menu</h2>
            <p><span>Check Our</span> <span class="description-title">Yummy Menu</span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">

                <li class="nav-item">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-starters">
                        <h4>Starters</h4>
                    </a>
                </li><!-- End tab nav item -->

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-breakfast">
                        <h4>Breakfast</h4>
                    </a><!-- End tab nav item -->

                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-lunch">
                        <h4>Lunch</h4>
                    </a>
                </li><!-- End tab nav item -->

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-dinner">
                        <h4>Dinner</h4>
                    </a>
                </li><!-- End tab nav item -->

            </ul>

            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                <div class="tab-pane fade active show" id="menu-starters">

                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>Starters</h3>
                    </div>

                    <div class="row gy-5">

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/"assets/img/menu/menu-item-1.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Magnam Tiste</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $5.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Aut Luia</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $14.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/"assets/img/menu/menu-item-3.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Est Eligendi</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $8.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Laboriosam Direva</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $9.95
                            </p>
                        </div><!-- Menu Item -->

                    </div>
                </div><!-- End Starter Menu Content -->

                <div class="tab-pane fade" id="menu-breakfast">

                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>Breakfast</h3>
                    </div>

                    <div class="row gy-5">

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Magnam Tiste</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $5.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Aut Luia</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $14.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Est Eligendi</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $8.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Laboriosam Direva</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $9.95
                            </p>
                        </div><!-- Menu Item -->

                    </div>
                </div><!-- End Breakfast Menu Content -->

                <div class="tab-pane fade" id="menu-lunch">

                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>Lunch</h3>
                    </div>

                    <div class="row gy-5">

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Magnam Tiste</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $5.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/"assets/img/menu/menu-item-2.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Aut Luia</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $14.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Est Eligendi</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $8.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Laboriosam Direva</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $9.95
                            </p>
                        </div><!-- Menu Item -->

                    </div>
                </div><!-- End Lunch Menu Content -->

                <div class="tab-pane fade" id="menu-dinner">

                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>Dinner</h3>
                    </div>

                    <div class="row gy-5">

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-1.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Magnam Tiste</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $5.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-2.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Aut Luia</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $14.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-3.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Est Eligendi</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $8.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-4.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-5.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Eos Luibusdam</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $12.95
                            </p>
                        </div><!-- Menu Item -->

                        <div class="col-lg-4 menu-item">
                            <a href="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="glightbox"><img src="{{asset('landingpage/assets/img/menu/menu-item-6.png')}}" class="menu-img img-fluid" alt=""></a>
                            <h4>Laboriosam Direva</h4>
                            <p class="ingredients">
                                Lorem, deren, trataro, filede, nerada
                            </p>
                            <p class="price">
                                $9.95
                            </p>
                        </div><!-- Menu Item -->

                    </div>
                </div><!-- End Dinner Menu Content -->

            </div>

        </div>

    </section><!-- /Menu Section --> --}}

    <!-- Testimonials Section -->
{{--    <section id="testimonials" class="testimonials section light-background">--}}

{{--        <!-- Section Title -->--}}
{{--        <div class="container section-title" data-aos="fade-up">--}}
{{--            <h2>TESTIMONIALS</h2>--}}
{{--            <p>What Are They <span class="description-title">Saying About Us</span></p>--}}
{{--        </div><!-- End Section Title -->--}}

{{--        <div class="container" data-aos="fade-up" data-aos-delay="100">--}}

{{--            <div class="swiper init-swiper">--}}
{{--                <script type="application/json" class="swiper-config">--}}
{{--                    {--}}
{{--                      "loop": true,--}}
{{--                      "speed": 600,--}}
{{--                      "autoplay": {--}}
{{--                        "delay": 5000--}}
{{--                      },--}}
{{--                      "slidesPerView": "auto",--}}
{{--                      "pagination": {--}}
{{--                        "el": ".swiper-pagination",--}}
{{--                        "type": "bullets",--}}
{{--                        "clickable": true--}}
{{--                      }--}}
{{--                    }--}}
{{--                </script>--}}
{{--                <div class="swiper-wrapper">--}}

{{--                    <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                            <div class="row gy-4 justify-content-center">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <div class="testimonial-content">--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                        <h3>Saul Goodman</h3>--}}
{{--                                        <h4>Ceo &amp; Founder</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2 text-center">--}}
{{--                                    <img src="{{asset('landingpage/assets/img/testimonials/testimonials-1.jpg')}}" class="img-fluid testimonial-img" alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End testimonial item -->--}}

{{--                    <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                            <div class="row gy-4 justify-content-center">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <div class="testimonial-content">--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                        <h3>Sara Wilsson</h3>--}}
{{--                                        <h4>Designer</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2 text-center">--}}
{{--                                    <img src="{{asset('landingpage/assets/img/testimonials/testimonials-2.jpg')}}" class="img-fluid testimonial-img" alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End testimonial item -->--}}

{{--                    <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                            <div class="row gy-4 justify-content-center">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <div class="testimonial-content">--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                        <h3>Jena Karlis</h3>--}}
{{--                                        <h4>Store Owner</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2 text-center">--}}
{{--                                    <img src="{{asset('landingpage/assets/img/testimonials/testimonials-3.jpg')}}" class="img-fluid testimonial-img" alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End testimonial item -->--}}

{{--                    <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                            <div class="row gy-4 justify-content-center">--}}
{{--                                <div class="col-lg-6">--}}
{{--                                    <div class="testimonial-content">--}}
{{--                                        <p>--}}
{{--                                            <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                                            <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>--}}
{{--                                            <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                                        </p>--}}
{{--                                        <h3>John Larson</h3>--}}
{{--                                        <h4>Entrepreneur</h4>--}}
{{--                                        <div class="stars">--}}
{{--                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-2 text-center">--}}
{{--                                    <img src="{{asset('landingpage/assets/img/testimonials/testimonials-4.jpg')}}" class="img-fluid testimonial-img" alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- End testimonial item -->--}}

{{--                </div>--}}
{{--                <div class="swiper-pagination"></div>--}}
{{--            </div>--}}

{{--        </div>--}}

{{--    </section><!-- /Testimonials Section -->--}}

    <!-- Events Section -->
    <section id="events" class="events section">

        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                      "loop": true,
                      "speed": 600,
                      "autoplay": {
                        "delay": 5000
                      },
                      "slidesPerView": "auto",
                      "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                      },
                      "breakpoints": {
                        "320": {
                          "slidesPerView": 1,
                          "spaceBetween": 40
                        },
                        "1200": {
                          "slidesPerView": 3,
                          "spaceBetween": 1
                        }
                      }
                    }
                </script>
                <div class="swiper-wrapper">

                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(landingpage/assets/img/events-1.jpg)">
                        <h3>Custom Parties</h3>
                        {{-- <div class="price align-self-start">$99</div> --}}
                        <p class="description">
                            Quo corporis voluptas ea ad. Consectetur inventore sapiente ipsum voluptas eos omnis facere. Enim facilis veritatis id est rem repudiandae nulla expedita quas.
                        </p>
                    </div><!-- End Event item -->

                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(landingpage/assets/img/events-2.jpg)">
                        <h3>Private Parties</h3>
                        {{-- <div class="price align-self-start">$289</div> --}}
                        <p class="description">
                            In delectus sint qui et enim. Et ab repudiandae inventore quaerat doloribus. Facere nemo vero est ut dolores ea assumenda et. Delectus saepe accusamus aspernatur.
                        </p>
                    </div><!-- End Event item -->

                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(landingpage/assets/img/events-3.jpg)">
                        <h3>Birthday Parties</h3>
                        {{-- <div class="price align-self-start">$499</div> --}}
                        <p class="description">
                            Laborum aperiam atque omnis minus omnis est qui assumenda quos. Quis id sit quibusdam. Esse quisquam ducimus officia ipsum ut quibusdam maxime. Non enim perspiciatis.
                        </p>
                    </div><!-- End Event item -->

                    <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(landingpage/assets/img/events-4.jpg)">
                        <h3>Wedding Parties</h3>
                        {{-- <div class="price align-self-start">$899</div> --}}
                        <p class="description">
                            Laborum aperiam atque omnis minus omnis est qui assumenda quos. Quis id sit quibusdam. Esse quisquam ducimus officia ipsum ut quibusdam maxime. Non enim perspiciatis.
                        </p>
                    </div><!-- End Event item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Events Section -->

    {{-- <!-- Chefs Section -->
    <section id="chefs" class="chefs section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>chefs</h2>
            <p><span>Our</span> <span class="description-title">Proffesional Chefs<br></span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{asset('landingpage/assets/img/chefs/chefs-1.jpg')}}" class="img-fluid" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Walter White</h4>
                            <span>Master Chef</span>
                            <p>Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur ipsa quae aut. Ipsum exercitationem iure minima enim corporis et voluptate.</p>
                        </div>
                    </div>
                </div><!-- End Chef Team Member -->

                <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{asset('landingpage/assets/img/chefs/chefs-2.jpg')}}" class="img-fluid" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Sarah Jhonson</h4>
                            <span>Patissier</span>
                            <p>Quo esse repellendus quia id. Est eum et accusantium pariatur fugit nihil minima suscipit corporis. Voluptate sed quas reiciendis animi neque sapiente.</p>
                        </div>
                    </div>
                </div><!-- End Chef Team Member -->

                <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member">
                        <div class="member-img">
                            <img src="{{asset('landingpage/assets/img/chefs/chefs-3.jpg')}}" class="img-fluid" alt="">
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>William Anderson</h4>
                            <span>Cook</span>
                            <p>Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae deserunt. Voluptates enim aut architecto porro aspernatur molestiae modi.</p>
                        </div>
                    </div>
                </div><!-- End Chef Team Member -->

            </div>

        </div>

    </section><!-- /Chefs Section --> --}}

    <!-- Book A Table Section -->
    <section id="book-a-table" class="book-a-table section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Hire us</h2>
            <p><span>Book for your</span> <span class="description-title">special day!<br></span></p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row g-0" data-aos="fade-up" data-aos-delay="100">

                <div class="col-lg-4 reservation-img" style="background-image: url(landingpage/assets/img/reservation.jpg);"></div>

                <div class="col-lg-8 d-flex align-items-center reservation-form-bg" data-aos="fade-up" data-aos-delay="200">
                    <form action="forms/book-a-table.php" method="post" role="form" class="php-email-form">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-md-6">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="date" name="date" class="form-control" id="date" placeholder="Date" required="">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="time" class="form-control" name="time" id="time" placeholder="Time" required="">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <input type="number" class="form-control" name="people" id="people" placeholder="# of people" required="">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message"></textarea>
                        </div>

                        <div class="text-center mt-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
                            <button type="submit">Book a Table</button>
                        </div>
                    </form>
                </div><!-- End Reservation Form -->

            </div>

        </div>

    </section><!-- /Book A Table Section -->

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Gallery</h2>
            <p><span>Check</span> <span class="description-title">Our Gallery</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                      "loop": true,
                      "speed": 600,
                      "autoplay": {
                        "delay": 5000
                      },
                      "slidesPerView": "auto",
                      "centeredSlides": true,
                      "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                      },
                      "breakpoints": {
                        "320": {
                          "slidesPerView": 1,
                          "spaceBetween": 0
                        },
                        "768": {
                          "slidesPerView": 3,
                          "spaceBetween": 20
                        },
                        "1200": {
                          "slidesPerView": 5,
                          "spaceBetween": 20
                        }
                      }
                    }
                </script>
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-1.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-1.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-2.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-2.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-3.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-3.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-4.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-4.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-5.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-5.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-6.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-6.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-7.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-7.jpg')}}" class="img-fluid" alt=""></a></div>
                    <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-8.jpg"><img src="{{asset('landingpage/assets/img/gallery/gallery-8.jpg')}}" class="img-fluid" alt=""></a></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Gallery Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="mb-5">
                <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d483.78003528434397!2d121.12082605359308!3d14.062983621155947!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd6f946f9d1bc7%3A0xd46c976a848bebda!2sJhulians%20Catering%20Services!5e0!3m2!1sen!2sph!4v1734617857176!5m2!1sen!2sph" frameborder="0" allowfullscreen=""></iframe>
            </div><!-- End Google Maps -->

            <div class="row gy-4">

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                        <i class="icon bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>Tinurik 4232 Tanauan, Philippines</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
                        <i class="icon bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>Globe: 0917 504 4011 / 0917 892 5128</p>
                            <p>Smart: 0939 924 9377</p>
                            <p>Landline: (043)741 1278</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="400">
                        <i class="icon bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>jhulianscateringservices2003@gmail.com</p>
                        </div>
                    </div>
                </div><!-- End Info Item -->

                {{-- <div class="col-md-6">
                    <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="500">
                        <i class="icon bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h3>Opening Hours<br></h3>
                            <p><strong>Mon-Sat:</strong> 11AM - 23PM; <strong>Sunday:</strong> Closed</p>
                        </div>
                    </div> --}}
                </div><!-- End Info Item -->

            </div>

            {{-- <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="600">
                <div class="row gy-4">

                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                    </div>

                    <div class="col-md-6 ">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                    </div>

                    <div class="col-md-12">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                    </div>

                    <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>

                        <button type="submit">Send Message</button>
                    </div>

                </div>
            </form><!-- End Contact Form --> --}}

        </div>

    </section><!-- /Contact Section -->


@endsection
