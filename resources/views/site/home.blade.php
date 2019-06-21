@extends('layouts.mastersite')

@section('content')
     <!-- ================ start banner Area ================= -->
     <section class="home-banner-area">
            <div class="container">
                <div class="row justify-content-center fullscreen align-items-center">
                    <div class="col-lg-5 col-md-8 home-banner-left">
                        <h1 class="text-white">
                            Take the first step <br />
                            to learn with us
                        </h1>
                        <p class="mx-auto text-white  mt-20 mb-40">
                            In the history of modern astronomy, there is probably no one
                            greater leap forward than the building and launch of the space
                            telescope known as the Hubble.
                        </p>
                    </div>
                    <div class="offset-lg-2 col-lg-5 col-md-12 home-banner-right">
                        <img class="img-fluid" src="{{ asset('img') }}/header-img.png" alt="" />
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ End banner Area ================= -->
    
        <!-- ================ Start Feature Area ================= -->
        <section class="feature-area">
            <div class="container-fluid">
                <div class="feature-inner row">
                    <div class="col-lg-2 col-md-6">
                        <div class="feature-item d-flex">
                            <i class="ti-book"></i>
                            <div class="ml-20">
                                <h4>New Classes</h4>
                                <p>
                                    In the history of modern astronomy, there is probably no one greater leap forward.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="feature-item d-flex">
                            <i class="ti-cup"></i>
                            <div class="ml-20">
                                <h4>Top Courses</h4>
                                <p>
                                    In the history of modern astronomy, there is probably no one greater leap forward.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="feature-item d-flex border-right-0">
                            <i class="ti-desktop"></i>
                            <div class="ml-20">
                                <h4>Full E-Books</h4>
                                <p>
                                    In the history of modern astronomy, there is probably no one greater leap forward.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ End Feature Area ================= -->
    
        <!-- ================ Start Popular Course Area ================= -->
        <section class="popular-course-area section-gap">
            <div class="container-fluid">
                <div class="row justify-content-center section-title">
                    <div class="col-lg-12">
                        <h2>
                            Popular Courses <br />
                            Available Right Now
                        </h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>
                <div class="owl-carousel popuar-course-carusel">
                    <div class="single-popular-course">
                        <div class="thumb">
                            <img class="f-img img-fluid mx-auto" src="{{ asset('img') }}/popular-course/p1.jpg" alt="" />
                        </div>
                        <div class="details">
                            <div class="d-flex justify-content-between mb-20">
                                <p class="name">programming language</p>
                                <p class="value">$150</p>
                            </div>
                            <a href="#">
                                <h4>Learn Angular JS Course for Legendary Persons</h4>
                            </a>
                            <div class="bottom d-flex mt-15">
                                <ul class="list">
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                </ul>
                                <p class="ml-20">25 Reviews</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="single-popular-course">
                        <div class="thumb">
                            <img class="f-img img-fluid mx-auto" src="{{ asset('img') }}/popular-course/p2.jpg" alt="" />
                        </div>
                        <div class="details">
                            <div class="d-flex justify-content-between mb-20">
                                <p class="name">programming language</p>
                                <p class="value">$150</p>
                            </div>
                            <a href="#">
                                <h4>Learn Angular JS Course for Legendary Persons</h4>
                            </a>
                            <div class="bottom d-flex mt-15">
                                <ul class="list">
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                </ul>
                                <p class="ml-20">25 Reviews</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="single-popular-course">
                        <div class="thumb">
                            <img class="f-img img-fluid mx-auto" src="{{ asset('img') }}/popular-course/p3.jpg" alt="" />
                        </div>
                        <div class="details">
                            <div class="d-flex justify-content-between mb-20">
                                <p class="name">programming language</p>
                                <p class="value">$150</p>
                            </div>
                            <a href="#">
                                <h4>Learn Angular JS Course for Legendary Persons</h4>
                            </a>
                            <div class="bottom d-flex mt-15">
                                <ul class="list">
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                </ul>
                                <p class="ml-20">25 Reviews</p>
                            </div>
                        </div>
                    </div>
    
                    <div class="single-popular-course">
                        <div class="thumb">
                            <img class="f-img img-fluid mx-auto" src="{{ asset('img') }}/popular-course/p4.jpg" alt="" />
                        </div>
                        <div class="details">
                            <div class="d-flex justify-content-between mb-20">
                                <p class="name">programming language</p>
                                <p class="value">$150</p>
                            </div>
                            <a href="#">
                                <h4>Learn Angular JS Course for Legendary Persons</h4>
                            </a>
                            <div class="bottom d-flex mt-15">
                                <ul class="list">
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-star"></i></a>
                                    </li>
                                </ul>
                                <p class="ml-20">25 Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ End Popular Course Area ================= -->
    
        <!-- ================ Start Video Area ================= -->
        <section class="video-area section-gap-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="section-title text-white">
                            <h2 class="text-white">
                                Watch Our Trainers <br>
                                in Live Action
                            </h2>
                            <p>
                                In the history of modern astronomy, there is probably no one greater leap forward than the
                                building and
                                launch of the space telescope known as the Hubble.
                            </p>
                        </div>
                    </div>
                    <div class="offset-lg-1 col-md-6 video-left">
                        <div class="owl-carousel video-carousel">
                            <div class="single-video">
                                <div class="video-part">
                                    <img class="img-fluid" src="{{ asset('img') }}/video-img.jpg" alt="">
                                    <div class="overlay"></div>
                                    <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=VufDd-QL1c0">
                                        <img class="play-icon" src="{{ asset('img') }}/play-btn.png" alt="">
                                    </a>
                                </div>
                                <h4 class="text-white mb-20 mt-30">Learn Angular js Course for Legendary Persons</h4>
                                <p class="text-white mb-20">
                                    In the history of modern astronomy, there is probably no one greater leap forward than
                                    the building and
                                    launch of the space telescope known as the Hubble.
                                </p>
                            </div>
    
                            <div class="single-video">
                                <div class="video-part">
                                    <img class="img-fluid" src="{{ asset('img') }}/video-img.jpg" alt="">
                                    <div class="overlay"></div>
                                    <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=VufDd-QL1c0">
                                        <img class="play-icon" src="{{ asset('img') }}/play-btn.png" alt="">
                                    </a>
                                </div>
                                <h4 class="text-white mb-20 mt-30">Learn Angular js Course for Legendary Persons</h4>
                                <p class="text-white mb-20">
                                    In the history of modern astronomy, there is probably no one greater leap forward than
                                    the building and
                                    launch of the space telescope known as the Hubble.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ End Video Area ================= -->
    
        <!-- ================ Start Blog Post Area ================= -->
        <section class="blog-post-area section-gap">
            <div class="container-fluid">
                <div class="feature-inner row">
                    <div class="col-lg-12">
                        <div class="section-title text-left">
                            <h2>
                                Features That <br />
                                Can Avail By Everyone
                            </h2>
                            <p>
                                There is a moment in the life of any aspiring astronomer that it is time to buy that first
                                telescope.
                                It’s exciting to think about setting up your own viewing station.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-blog-post">
                            <img src="{{ asset('img') }}/blog-post/b1.jpg" class="img-fluid" alt="" />
                            <div class="overlay"></div>
                            <div class="top-text">
                                <p>29th, oct, 2018</p>
                                <p>121 likes</p>
                                <p>05 comments</p>
                            </div>
                            <div class="text">
                                <h4 class="text-white">Smart Kitchen Setup</h4>
                                <div>
                                    <p>
                                        Lorem ipsum dolor sit amet consec tetur adipisicing elit,
                                        sed do.
                                    </p>
                                </div>
                                <a href="#" class="primary-btn">
                                    View Details
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mt--160">
                        <div class="single-blog-post">
                            <img src="{{ asset('img') }}/blog-post/b2.jpg" class="img-fluid" alt="" />
                            <div class="overlay"></div>
                            <div class="top-text">
                                <p>29th, oct, 2018</p>
                                <p>121 likes</p>
                                <p>05 comments</p>
                            </div>
                            <div class="text">
                                <h4 class="text-white">Smart Kitchen Setup</h4>
                                <div>
                                    <p>
                                        Lorem ipsum dolor sit amet consec tetur adipisicing elit,
                                        sed do.
                                    </p>
                                </div>
                                <a href="#" class="primary-btn">
                                    View Details
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mt--260">
                        <div class="single-blog-post">
                            <img src="{{ asset('img') }}/blog-post/b3.jpg" class="img-fluid" alt="" />
                            <div class="overlay"></div>
                            <div class="top-text">
                                <p>29th, oct, 2018</p>
                                <p>121 likes</p>
                                <p>05 comments</p>
                            </div>
                            <div class="text">
                                <h4 class="text-white">Smart Kitchen Setup</h4>
                                <div>
                                    <p>
                                        Lorem ipsum dolor sit amet consec tetur adipisicing elit,
                                        sed do.
                                    </p>
                                </div>
                                <a href="#" class="primary-btn">
                                    View Details
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ End Blog Post Area ================= -->
@endsection