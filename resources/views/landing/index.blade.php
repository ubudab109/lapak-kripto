<!DOCTYPE html>
<html lang="en">

<head>
    <!--- Basic Page Needs  -->
    <meta charset="utf-8">
    <title>Home One || Crizal</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Meta  -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('assets/landing/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/stellarnav.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/responsive.css')}}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/landing/img/favicon.ico')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="home1-bg-color">
    <div id="preloader"></div>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-6 col-6">
                    <div class="logo">
                        <a href="{{route('home')}}">LAPAK KRIPTO</a>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-12 col-12">
                    <div class="main-menu">
                        <div class="stellarnav">
                            <nav class="menu-list">
                                <ul>
                                    <li><a href="#_about" class="smoothscroll">About Us</a></li>
                                    <li><a href="#_token" class="smoothscroll">Token sale</a></li>
                                    <li><a href="#_roadmap" class="smoothscroll">roadmap</a></li>
                                    <li><a href="#_team" class="smoothscroll">team</a></li>
                                    <li><a href="#_contact" class="smoothscroll">contact</a></li>
                                    @if (Route::has('login'))
                                    @auth
                                    <li><a href="{{route('login')}}" class="link btn-style-1" >Home</a> </li>
                                    @else
                                    <li> <a href="{{route('login')}}" class="link btn-style-1">Login</a> </li>
                                    @endauth
                                @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="ht-buy-token">
                      @if (Route::has('login'))
                            @auth
                                <a href="{{route('login')}}" class="link btn-style-1" >Home</a>
                            @else
                                <a href="{{route('login')}}" class="link btn-style-1">Login</a>
                            @endauth
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="hero-area">
        <div class="hero-bg"><img src="{{asset('assets/landing/img/home-one/hero-bg.png')}}" alt=""></div>
        <div class="hero-banner item-bounce"><img src="{{asset('assets/landing/img/home-one/hero-banner.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="hero-content">
                        <h2 class="title">Blockchain Technology to Ensure Seamless</h2>
                        <p class="text">We to help tenants unfreeze millions of dollars</p>
                        <div class="btns">
                            <a href="#" class="btn-style-3 link hvr-bs btn-hvr-anim-top">Sign Up To Join</a>
                            <a href="#" class="btn-style-4 link hvr-bs btn-hvr-anim-top">Token Distribution</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="top-brands-area">
        <div class="container">
            <h3 class="title">More Then 3,000+ Companyt Trust Us</h3>
            <div class="all-brands">
                <div class="single">
                    <img src="{{asset('assets/landing/img/home-one/top-brand-1.png')}}" alt="">
                </div>
                <div class="single">
                    <img src="{{asset('assets/landing/img/home-one/top-brand-2.png')}}" alt="">
                </div>
                <div class="single">
                    <img src="{{asset('assets/landing/img/home-one/top-brand-3.png')}}" alt="">
                </div>
                <div class="single">
                    <img src="{{asset('assets/landing/img/home-one/top-brand-4.png')}}" alt="">
                </div>
                <div class="single">
                    <img src="{{asset('assets/landing/img/home-one/top-brand-5.png')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="counter-area">
        <div class="counter-bg"><img src="{{asset('assets/landing/img/home-one/counter-bg.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.2s">
                    <div class="ca-starts-in">
                        <h3 class="title">ICO Starts in</h3>
                        <p class="info">Token will start on Aug 1st 2019</p>
                        <div class="timer-area">
                            <div data-countdown="2020/5/16"></div>
                        </div>
                        <a href="#" class="buy btn-style-5 hvr-bs btn-hvr-anim-top">Buy token now</a>
                        <div class="buy-icons">
                            <img src="{{asset('assets/landing/img/home-one/token-icons.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.4s">
                    <div class="cs-recived">
                        <h2 class="contribution"><span>$</span><span class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">5,256,432</span> Contribution Received</h2>
                        <div class="progress-box">
                            <p class="info"><span class="left">$10m</span><span class="right">$1000m</span></p>
                            <div class="box w-40 b-10"></div>
                            <p class="info"><span class="left">Softcap</span><span class="right">Hardcap</span></p>
                        </div>
                        <div class="video-link">
                            <a class="popup-youtube" href="https://www.youtube.com/watch?v=QOtuX0jL85Y"><i class="fas fa-play"></i>How It Works</a>
                            <a href="#" class="link btn-style-1"> Whitepaper</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-v1-area" id="_about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="about-v1-banner">
                        <img class="item-bounce" src="{{asset('assets/landing/img/home-one/about-one-banner.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
                    <div class="about-v1-content">
                        <h2 class="title">Crizal is a block chain based marketplace</h2>
                        <h3 class="title-2">Automatic matching of buyers & sellers via unique artificial intelligence approach.</h3>
                        <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental experience and wants to help tenants unfreeze millions of dollars tied up in rental deposits</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-v2-area">
        <div class="about-v2-bg"><img src="{{asset('assets/landing/img/home-one/about-bg-total.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
                    <div class="about-v2-content">
                        <h2 class="title">We’re reinventing the global equity blockchian</h2>
                        <h3 class="title-2">Automatic matching of buyers & sellers via unique artificial intelligence approach.</h3>
                        <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental experience and wants to help tenants unfreeze millions of dollars tied up in rental deposits</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="about-v1-banner">
                        <img class="item-bounce" src="{{asset('assets/landing/img/home-one/about-tow-banner.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="roadmap-area" id="_roadmap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <h2 class="title">Our Roadmap</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new equity blockchain.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="roadmap-slider">
            <div class="single-roadmap wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.2s">
                <h3 class="title">Oct 2012</h3>
                <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages</p>
            </div>
            <div class="single-roadmap v2 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.4s">
                <h3 class="title">Oct 2014</h3>
                <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages</p>
            </div>
            <div class="single-roadmap wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.6s">
                <h3 class="title">Oct 2018</h3>
                <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages</p>
            </div>
            <div class="single-roadmap v2 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.8s">
                <h3 class="title">Oct 2016</h3>
                <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages</p>
            </div>
            <div class="single-roadmap wow fadeIn" data-wow-duration="0.5s" data-wow-delay="1.0s">
                <h3 class="title">Oct 2016</h3>
                <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages</p>
            </div>
        </div>
    </section>
    <section class="download-area">
        <div class="download-bg"><img src="{{asset('assets/landing/img/home-one/download-bg.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="download-banner">
                        <img class="item-bounce" src="{{asset('assets/landing/img/home-one/download-banner.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
                    <div class="download-content">
                        <h2 class="title">Download App</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new
                            equity blockchain.</p>
                        <div class="buttons">
                            <a href="#" class="link download-button-1 btn-hvr-anim-top">
                                <span class="icon"><i class="fab fa-apple"></i></span>
                                <span class="available">Available on the</span>
                                <span class="store-name">App Store</span>
                            </a>
                            <a href="#" class="link download-button-2 btn-hvr-anim-top">
                                <span class="icon"><i class="fas fa-play"></i></span>
                                <span class="available">Available on the</span>
                                <span class="store-name">Play Store</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="why-area">
        <div class="why-bg"><img src="{{asset('assets/landing/img/home-one/why-icon-bg.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="why-left-content">
                        <h2 class="title">Why Choose Us?</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new equity.</p>
                        <p class="text-2">We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental experience and wants to help tenants unfreeze .</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="why-right-content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="service-box service-1">
                                    <span class="icon"><img src="{{asset('assets/landing/img/home-one/choose-icon-1.png')}}" alt=""></span>
                                    <h2 class="title">Wallet</h2>
                                    <p class="text">We offers users a fully operational long-term rental platform to get
                                        noney sure.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="service-box service-1">
                                    <span class="icon"><i class="fas fa-lock"></i></span>
                                    <h2 class="title">Safe & Secure</h2>
                                    <p class="text">We offers users a fully operational long-term rental platform to get
                                        noney sure.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="service-box service-1">
                                    <span class="icon"><img src="{{asset('assets/landing/img/home-one/choose-icon-3.png')}}" alt=""></span>
                                    <h2 class="title">Buy & Sell</h2>
                                    <p class="text">We offers users a fully operational long-term rental platform to get
                                        noney sure.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="service-box service-1">
                                    <span class="icon"><img src="{{asset('assets/landing/img/home-one/choose-icon-4.png')}}" alt=""></span>
                                    <h2 class="title">Flexibility</h2>
                                    <p class="text">We offers users a fully operational long-term rental platform to get
                                        noney sure.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="token-area" id="_token">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <h2 class="title">Token Sale</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new equity blockchain.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="token-info-all">
                        <div class="single">
                            <h2 class="title">Start</h2>
                            <p class="text">Feb 8, 2018 <br> (9:00AM GMT)</p>
                        </div>
                        <div class="single">
                            <h2 class="title">End</h2>
                            <p class="text">Feb 8, 2018 <br> (9:00AM GMT)</p>
                        </div>
                        <div class="single">
                            <h2 class="title">Currency</h2>
                            <p class="text">Feb 8, 2018 <br> (9:00AM GMT)</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="token-banner-main">
                        <span class="tb-bg"><img src="{{asset('assets/landing/img/home-one/token-bg.png')}}" alt=""></span>
                        <img class="item-bounce" src="{{asset('assets/landing/img/home-one/token-banner.png')}}" alt="">
                        <a href="#" class="btn-style-3 link hvr-bs btn-hvr-anim-top">Sign Up To Join</a>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="token-info-all style-2">
                        <div class="single">
                            <h2 class="title">Number of tokens</h2>
                            <p class="text">900,000 ICC (9%)</p>
                        </div>
                        <div class="single">
                            <h2 class="title">End</h2>
                            <p class="text">1 ETH = 2,500 </p>
                        </div>
                        <div class="single">
                            <h2 class="title">Currency</h2>
                            <p class="text">30,000,000 <br> USD</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12 wow bounceInUp" data-wow-duration="0.9s" data-wow-delay="0.2s">
                    <div class="token-down-banner">
                        <h2 class="title">Token Distribution</h2>
                        <img src="{{asset('assets/landing/img/home-one/token-banner-2-1-1.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-12 wow bounceInUp" data-wow-duration="0.9s" data-wow-delay="0.5s">
                    <div class="token-down-banner">
                        <h2 class="title">Fund Distribution</h2>
                        <img src="{{asset('assets/landing/img/home-one/token-banner-2-2-1.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="team-area" id="_team">
        <div class="team-bg"><img src="{{asset('assets/landing/img/home-one/team-bg.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <h2 class="title">Our Team</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new equity blockchain.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="single-team">
                        <div class="img"><img src="{{asset('assets/landing/img/home-one/team-1.png')}}" alt=""></div>
                        <div class="content">
                            <h4 class="title">Mario Hegeer</h4>
                            <p class="desg">CEO & Head Office</p>
                            <ul class="social">
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="single-team">
                        <div class="img"><img src="{{asset('assets/landing/img/home-one/team-2.png')}}" alt=""></div>
                        <div class="content">
                            <h4 class="title">Andry Flower</h4>
                            <p class="desg">CEO & Head Office</p>
                            <ul class="social">
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="single-team">
                        <div class="img"><img src="{{asset('assets/landing/img/home-one/team-3.png')}}" alt=""></div>
                        <div class="content">
                            <h4 class="title">Mike Tyson</h4>
                            <p class="desg">CEO & Head Office</p>
                            <ul class="social">
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="single-team">
                        <div class="img"><img src="{{asset('assets/landing/img/home-one/team-4.png')}}" alt=""></div>
                        <div class="content">
                            <h4 class="title">Mario Hegeer</h4>
                            <p class="desg">CEO & Head Office</p>
                            <ul class="social">
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-area">
        <div class="blog-bg"><img src="{{asset('assets/landing/img/home-one/blog-bg.png')}}" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <h2 class="title">Our Blog</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new equity blockchain.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog">
                        <div class="img">
                            <a href="#"><img src="{{asset('assets/landing/img/home-one/blog-1.png')}}" alt=""></a>
                        </div>
                        <div class="content">
                            <ul class="meta">
                                <li><a href="#"><span class="icon"><i class="far fa-calendar-alt"></i></span> 08 Dec, 2019</a></li>
                                <li><a href="#"><span class="icon"><i class="fas fa-user"></i></span> Admin</a></li>
                            </ul>
                            <a href="#" class="title">A platform for the future of funding that powering</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog">
                        <div class="img">
                            <a href="#"><img src="{{asset('assets/landing/img/home-one/blog-2.png')}}" alt=""></a>
                        </div>
                        <div class="content">
                            <ul class="meta">
                                <li><a href="#"><span class="icon"><i class="far fa-calendar-alt"></i></span> 08 Dec, 2019</a></li>
                                <li><a href="#"><span class="icon"><i class="fas fa-user"></i></span> Admin</a></li>
                            </ul>
                            <a href="#" class="title">A platform for the future of funding that powering</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog">
                        <div class="img">
                            <a href="#"><img src="{{asset('assets/landing/img/home-one/blog-3.png')}}" alt=""></a>
                        </div>
                        <div class="content">
                            <ul class="meta">
                                <li><a href="#"><span class="icon"><i class="far fa-calendar-alt"></i></span> 08 Dec, 2019</a></li>
                                <li><a href="#"><span class="icon"><i class="fas fa-user"></i></span> Admin</a></li>
                            </ul>
                            <a href="#" class="title">A platform for the future of funding that powering</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="faq-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
                    <div class="faq-content">
                        <h2 class="title">Asked Questions</h2>
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><span class="icon"><i class="fas fa-chevron-down"></i></span> What Is Crizal?</button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental experience 
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><span class="icon"><i class="fas fa-chevron-down"></i></span> How to purchase?</button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental experience 
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><span class="icon"><i class="fas fa-chevron-down"></i></span> Can i use for free ?</button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental experience 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="faq-banner">
                        <img class="item-bounce" src="{{asset('assets/landing/img/home-one/faq-banner.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-area" id="_contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="section-title">
                        <h2 class="title">Contact Us</h2>
                        <p class="text">Crizal is a platform for the future of funding that powering dat for the new equity blockchain.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="contact-info-single">
                                <p class="info"><span class="icon"><i class="fas fa-phone"></i></span><a href="tel:+4401234567">+44 0123 4567</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="contact-info-single">
                                <p class="info"><span class="icon"><i class="fas fa-envelope"></i></span><a href="mailto:info@yourcompany.com">info@yourcompany.com</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="contact-info-single">
                                <p class="info"><span class="icon"><i class="fas fa-map"></i></span><a href="https://www.google.com.bd/maps/">Get Office Locations</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="cf-msg"></div>
                    <form action="mail.php" method="post" id="cf">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="contact-form-input">
                                    <input type="text" placeholder="Name" id="fname" name="fname" required="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="contact-form-input">
                                    <input type="text" placeholder="Email" id="email" name="email" required="">
                                </div>
                            </div>
                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="contact-form-input">
                                    <input type="text" placeholder="Subject" id="subject" name="subject">
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="contact-form-input">
                                    <textarea class="contact-textarea" placeholder="Message" id="msg" name="msg"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-form-input text-center">
                                    <button id="submit" class="cont-submit btn-style-3 link hvr-bs btn-hvr-anim-top" name="submit">SEND MESSAGE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="footer-widget">
                            <h2 class="title">Crizal</h2>
                            <p class="text">We offers users a fully operational long-term rental platform. It plans to leverages blockchain technology to ensure seamless rental.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 col-12">
                        <div class="footer-widget">
                            <h3 class="title-2">Follow Us</h3>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <ul class="social">
                                        <li><a href="#"><span class="ico"><i class="fab fa-facebook-f"></i></span> Facebook</a></li>
                                        <li><a href="#"><span class="ico"><i class="fab fa-linkedin-in"></i></span> Linkedin</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <ul class="social">
                                        <li><a href="#"><span class="ico"><i class="fab fa-twitter"></i></span> Twitter</a></li>
                                        <li><a href="#"><span class="ico"><i class="fab fa-google-plus"></i></span> Google</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-12">
                        <div class="footer-widget">
                            <h3 class="title-2">Follow Us</h3>
                            <p class="text">You will always be update with the latest news from us.</p>
                            <div class="newsletter">
                                <form action="#">
                                    <div class="newsletter-inputbox">
                                        <input type="text" placeholder="Enter Email Address">
                                        <button class="btn-style-3">sUBSCRIBE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="copyright">
                            <p class="text">2019 Copyright Crizal. All Rights Reserved</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="footer-links">
                            <ul class="links">
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Policy</a></li>
                                <li><a href="#">Terms & Condition</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="{{asset('assets/landing/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/landing/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/countdown.js')}}"></script>
    <script src="{{asset('assets/landing/js/stellarnav.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/jquery.scrollUp.js')}}"></script>
    <script src="{{asset('assets/landing/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/landing/js/theme.js')}}"></script>
</body>

</html>
