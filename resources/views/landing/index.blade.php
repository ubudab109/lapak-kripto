<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Lapak Kripto" />
<!-- SITE TITLE -->
<title>Lapak Kripto</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="{{show_image(1,'login_logo')}}">
<!-- Animation CSS -->
<link rel="stylesheet" href="{{asset('assets/css/animate.css')}}" >
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
<!-- ionicons CSS -->
<link rel="stylesheet" href="{{asset('assets/css/ionicons.min.css')}}">
<!-- cryptocoins CSS -->
<link rel="stylesheet" href="{{asset('assets/css/cryptocoins.css')}}">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="{{asset('assets/owlcarousel/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/owlcarousel/css/owl.theme.default.min.css')}}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/spop.min.css')}}">
<!-- Style CSS -->
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
<!-- Color CSS -->
<link id="layoutstyle" rel="stylesheet" href="{{asset('assets/color/theme.css')}}">
</head>

<body class="v_dark" data-spy="scroll" data-offset="110">

<!-- START LOADER -->
<div id="loader-wrapper">
    <div id="loading-center-absolute">
        <div class="object" id="object_four"></div>
        <div class="object" id="object_three"></div>
        <div class="object" id="object_two"></div>
        <div class="object" id="object_one"></div>
    </div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>

</div>
<!-- END LOADER --> 

<!-- START HEADER -->
<header class="header_wrap fixed-top">
	<div class="container-fluid">
		<nav class="navbar navbar-expand-lg"> 
			<a class="navbar-brand page-scroll animation" href="#home_section" data-animation="fadeInDown" data-animation-delay="1s"> 
            	<img class="logo_light" src="{{show_image(1,'login_logo')}}" alt="logo" width="70"/> 
            </a>
            <button class="navbar-toggler animation" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" data-animation="fadeInDown" data-animation-delay="1.1s"> 
                <span class="ion-android-menu"></span> 
            </button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="dropdown animation" data-animation="fadeInDown" data-animation-delay="1.1s">
						          <a class="nav-link active" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="animation" data-animation="fadeInDown" data-animation-delay="1.2s"><a class="nav-link page-scroll nav_item" href="#service">Services</a></li>
                    <li class="animation" data-animation="fadeInDown" data-animation-delay="1.3s"><a class="nav-link page-scroll nav_item" href="#about">About</a></li>
                    <li class="animation" data-animation="fadeInDown" data-animation-delay="1.7s"><a class="nav-link page-scroll nav_item" href="#faq">FAQ</a></li>
                </ul>
                <ul class="navbar-nav nav_btn align-items-center">
                    @if (Route::has('login'))
                        @auth
                            <li class="animation" data-animation="fadeInDown" data-animation-delay="2s"><a class="btn btn-default btn-radius nav_item" href="{{route('login')}}">Home</a></li>
                        @else
                            <li class="animation" data-animation="fadeInDown" data-animation-delay="2s"><a class="btn btn-default btn-radius nav_item" href="{{route('login')}}">Login or Register</a></li>
                        @endauth
                    @endif
                    
                </ul>
			</div>
		</nav>
	</div>
</header>
<!-- END HEADER --> 

<!-- START SECTION BANNER -->
<section id="home_section" class="section_banner bg_black_dark" data-z-index="1" data-parallax="scroll" data-image-src="{{asset('')}}assets/images/banner_bg2.png">
    <div id="banner_bg_effect" class="banner_effect"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 order-lg-first">
                <div class="banner_text_s2 text_md_center">
                    <h1 class="animation text-white" data-animation="fadeInUp" data-animation-delay="1.1s"><strong>Beli Bitcoin, USDT dan Cryptocurrency</strong> dengan lebih cepat dan mudah</h1>
                    <div class="btn_group pt-2 pb-3 animation" data-animation="fadeInUp" data-animation-delay="1.4s"> 
                        <a href="#whitepaper" class="btn btn-default btn-radius nav-link content-popup">Robot Crypto <i class="ion-ios-arrow-thin-right"></i></a> 
                        <a href="#" class="btn btn-border btn-radius">Beli Coin Sekarang! <i class="ion-ios-arrow-thin-right"></i></a> 
                    </div>
                    <span class="text-white icon_title animation" data-animation="fadeInUp" data-animation-delay="1.4s">Tersedia :</span>
                    <ul class="list_none currency_icon">
                        <li class="animation" data-animation="fadeInUp" data-animation-delay="1.5s"><i class="cc BTC-alt"></i><span>Bitcoin</span></li>
                        <li class="animation" data-animation="fadeInUp" data-animation-delay="1.6s"><i class="cc ETC"></i><span>Ethereum </span></li>
                        <li class="animation" data-animation="fadeInUp" data-animation-delay="1.7s"><i class="cc LTC-alt"></i><span>Litecoin</span></li>
                        <li class="animation" data-animation="fadeInUp" data-animation-delay="1.8s"><i class="cc XRP-alt"></i><span>Ripple</span></li>
                    </ul>
                    <div id="whitepaper" class="team_pop mfp-hide">
                        <div class="row m-0">
                            <div class="col-md-7">
                                <div class="pt-3 pb-3">
                                    <div class="title_dark title_border"> 
                                        <h4>Download Whitepaper</h4>
                                        <p>A purely peer-to-peer version of electronic cash would allow online payments to be sent directly from one party to another without going through a financial institution.Digital signatures provide part of the solution, but the main benefits are lost if a trusted third party is still required to prevent double-spending.</p>
                                        <p>The network timestamps transactions by hashing them into an ongoing chain of hash-based proof-of-work, forming a record that cannot be changed without redoing the proof-of-work.</p>
										<a href="#" class="btn btn-default btn-radius">Download Now <i class="ion-ios-arrow-thin-right"></i></a>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5"> 
                                <img class="pt-3 pb-3" src="{{asset('assets/images/whitepaper.png')}}" alt="whitepaper"/> 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 order-first">
                <div class="banner_image_right res_md_mb_50 res_xs_mb_30 animation" data-animation-delay="1.5s" data-animation="fadeInRight"> 
                    <img alt="banner_vector2" src="{{asset('assets/images/banner_img2.png')}}"> 
                </div>
          	</div>
        </div>
        </div>
</section>
<!-- END SECTION BANNER --> 

<!-- START SECTION SERVICES -->
<section id="service" class="small_pb">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-8 offset-lg-2 col-md-12 col-sm-12">
				<div class="title_default_light title_border text-center">
                  <h4 class="animation" data-animation="fadeInUp" data-animation-delay="0.2s">Temui Solusi Kami Untuk Anda</h4>
                  <p class="animation" data-animation="fadeInUp" data-animation-delay="0.4s">Lapak Kripto akan membantu anda dalam membeli Crypto dengan mudah</p>
        		</div>
			</div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
            	<div class="box_wrap text-center animation" data-animation="fadeInUp" data-animation-delay="0.6s">
                	<img src="{{asset('assets/images/service_icon1.png')}}" alt="service_icon1"/>
                    <h4>Secure Storage</h4>
                    <p>Dompet Anda harus diamankan. Bitcoin memungkinkan untuk mentransfer nilai di mana saja dengan cara yang sangat mudah dan memungkinkan Anda untuk mengendalikan uang Anda.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
            	<div class="box_wrap text-center animation" data-animation="fadeInUp" data-animation-delay="0.8s">
                	<img src="{{asset('assets/images/service_icon2.png')}}" alt="service_icon2"/>
                    <h4>Mobile App</h4>
                    <p>Beli Coin sangat mudah dan dimana saja, melalai smartphone atau desktop anda.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
            	<div class="box_wrap text-center animation" data-animation="fadeInUp" data-animation-delay="1s">
                	<img src="{{asset('assets/images/service_icon3.png')}}" alt="service_icon3"/>
                    <h4>Exchange Service</h4>
                    <p>Setiap pengguna memiliki kebutuhan yang unik, jadi tidak ada satu ukuran yang cocok untuk semua pertukaran. Ulasan pertukaran Bitcoin kami merinci setiap negara yang didukung pertukaran</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
            	<div class="box_wrap text-center animation" data-animation="fadeInUp" data-animation-delay="1s">
                	<img src="{{asset('assets/images/service_icon4.png')}}" alt="service_icon4"/>
                    <h4>Investment projects</h4>
                    <p>Peluang investasi Crypto ada di luar sekadar berspekulasi tentang nilai tukar Crypto. jual Crypto dan dapatkan untung dari perubahan ekstrem</p>
                </div>
            </div>
            <div class="col-lg-4  col-md-6 col-sm-12">
            	<div class="box_wrap text-center animation" data-animation="fadeInUp" data-animation-delay="1s">
                	<img src="{{asset('assets/images/service_icon5.png')}}" alt="service_icon5"/>
                    <h4>Transfer Bank</h4>
                    <p>Kami menerima kartu transfer dari bank mana saja. Opsi ini mungkin sangat berguna bagi anda yang mencari cara mudah dan cepat</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
            	<div class="box_wrap text-center animation" data-animation="fadeInUp" data-animation-delay="1s">
                	<img src="{{asset('assets/images/service_icon6.png')}}" alt="service_icon6"/>
                    <h4>Planning</h4>
                    <p>Masalah mutakhir dalam perencanaan real tradisional adalah Cryptocash. Cryptocash adalah mata uang digital atau virtual yang menggunakan kriptografi untuk keamanan</p>
                </div>
            </div>
    	</div>
  	</div>
</section>
<!-- END SECTION SERVICES --> 

<!-- START SECTION ABOUT US -->
<section id="about" class="small_pt">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
            	<div class="text_md_center">
                	<img class="animation" data-animation="zoomIn" data-animation-delay="0.2s" src="{{asset('assets/images/about_img2.png')}}" alt="aboutimg2"/> 
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 res_md_mt_30 res_sm_mt_20">
                <div class="title_default_light title_border">
                  <h4 class="animation" data-animation="fadeInUp" data-animation-delay="0.2s">Robot Crypto</h4>
                  <p class="animation" data-animation="fadeInUp" data-animation-delay="0.4s">Robot Crypto adalah salah satu teknologi paling transformatif sejak penemuan Internet. Membantu Anda untuk menentukan menjual atau membeli. </p>
                  <p class="animation" data-animation="fadeInUp" data-animation-delay="0.8s"></p>
                </div>
                <a href="https://www.youtube.com/watch?v=ZE2HxTmxfrI" class="btn btn-default btn-radius video animation" data-animation="fadeInUp" data-animation-delay="1s">Let's Start <i class="ion-ios-arrow-thin-right"></i></a> 
            </div>
        </div>
    </div>
</section>
<!-- END SECTION ABOUT US --> 

<!-- START SECTION FAQ -->
<section id="faq" class="bg_light_dark">
	<div class="container">
    	<div class="row">
        	<div class="col-lg-8 col-md-12 offset-lg-2">
              <div class="title_default_light title_border text-center">
                <h4 class="animation" data-animation="fadeInUp" data-animation-delay="0.2s">Pertanyaan dan Jawaban?</h4>
              </div>
            </div>
        </div>
        <div class="row small_space">
        	<div class="col-lg-12 col-md-12">
            <div class="row">
              <div class="col-md-12">
                  <div id="accordion1" class="faq_content">
                        <div class="card animation" data-animation="fadeInUp" data-animation-delay="0.4s">
                          <div class="card-header" id="headingOne">
                            <h6 class="mb-0"> <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Apa itu Lapakripto.com?</a> </h6>
                          </div>
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion1">
                            <div class="card-body"> Lapakripto.com adalah sebuah platform untuk membeli Bitcoin, USDT dan Cryptocurrency secara online dengan cepat dan mudah.</div>
                          </div>
                        </div>
                        <div class="card animation" data-animation="fadeInUp" data-animation-delay="0.6s">
                          <div class="card-header" id="headingTwo">
                            <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Cara Topup di Lapakripto.com</a> </h6>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion1">
                            <div class="card-body"> 
                              <br>
                              •	Login ke Lapakripto.com<br>
                              •	Pada halaman Dashboard, klik tombol ‘My Wallet’ > ‘My Pocket’<br>
                              •	Klik tombol ‘Topup’ berwarna biru<br>
                              •	Kotak akan menampilkan saldo Dollar<br>
                              •	Masukkan nominal Dollar<br>
                              •	Kotak akan menampilkan jumlah total Rupiah yang anda akan transfer<br>
                              •	Klik ‘Bank Deposit’<br>
                              •	Select Bank tujuan BCA<br>
                              •	Lihat kanan layar detail tujuan bank<br>
                              •	Upload bukti transfer sesuai dengan total rupiah<br>
                              •	Tunggu sekitar 10 – 20 Menit<br>
                              •	Transaksi berhasil<br>
                            </div>
                          </div>
                        </div>
                        <div class="card animation" data-animation="fadeInUp" data-animation-delay="0.8s">
                          <div class="card-header" id="headingThree">
                            <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Cara membeli coin di Lapakripto.com</a> </h6>
                          </div>
                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion1">
                            <div class="card-body">
                              <br>
                              •	Login ke Lapakripto.com<br>
                              •	Pada halaman Dashboard, klik tombol ‘Buy coin’<br>
                              •	Pilih Coin yang ingin di beli<br>
                              •	Masukkan nominal dollar<br>
                              •	Di bagian total coin akan terjumlah dari total dollar menjadi coin<br>
                              •	Masukkan Coin Address atau Alamat Wallet Crypto<br>
                              •	Klik ‘Buy Now’<br>
                              •	Select Bank tujuan BCA<br>
                              •	Tunggu sekitar 10 – 20 Menit<br>
                              •	Transaksi berhasil<br>
                            </div>
                          </div>
                        </div>
                        <div class="card animation" data-animation="fadeInUp" data-animation-delay="1s">
                          <div class="card-header" id="headingFour">
                            <h6 class="mb-0"> <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Bagaimana penentuan harga beli Bitcoin?</a> </h6>
                          </div>
                          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion1">
                            <div class="card-body"> Sistem penentuan harga beli dan jual di Lapakripto.com berjalan secara otomatis berdasarkan pergerakan harga Bitcoin di Indonesia. Sistem Lapakripto.com akan berusaha mendapatkan harga terbaik untuk transaksi anda. </div>
                          </div>
                        </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>
<!-- END SECTION FAQ -->







<!-- START FOOTER SECTION -->
<footer>
	<div class="top_footer bg_light_dark" data-z-index="1" data-parallax="scroll" data-image-src="{{asset('')}}assets/images/footer_bg.png">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-12">
                    <div class="footer_logo mb-3 animation" data-animation="fadeInUp" data-animation-delay="0.2s"> 
                        <a href="#home_section" class="page-scroll">
                            <img class="logo_light" src="{{show_image(1,'login_logo')}}" alt="logo" width="70"/> 
                        </a> 
                    </div>
                    <div class="footer_desc">
          				<p class="animation" data-animation="fadeInUp" data-animation-delay="0.4s"></p>
                    </div>
         		</div>
                <div class="col-lg-3 col-md-6 res_md_mt_30 res_sm_mt_20">
                	<h4 class="footer_title border_title animation" data-animation="fadeInUp" data-animation-delay="0.2s">Quick Links</h4>
                    <ul class="footer_link list_arrow">
                        <li class="animation" data-animation="fadeInUp" data-animation-delay="0.3s"><a href="#">How It Works</a></li>
                        <li class="animation" data-animation="fadeInUp" data-animation-delay="0.5s"><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 res_md_mt_30 res_sm_mt_20">
                	<div class="newsletter_form">
                        <h4 class="footer_title border_title animation" data-animation="fadeInUp" data-animation-delay="0.2s">Newsletter</h4>
                        <p class="animation" data-animation="fadeInUp" data-animation-delay="0.4s">By subscribing to our mailing list you will always be update with the latest news from us.</p>
                        <form class="subscribe_form animation" data-animation="fadeInUp" data-animation-delay="0.4s">
                            <input class="input-rounded" type="text" required placeholder="Enter Email Address"/>
                          <button type="submit" title="Subscribe" class="btn-info" name="submit" value="Submit"> Subscribe </button>
                        </form>
                    </div>
                </div>
      		</div>
    	</div>
    </div>
    <div class="bottom_footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p class="copyright">Copyright &copy; 2021 All Rights Reserved.</p>
        </div>
        <div class="col-md-6">
          <ul class="list_none footer_menu">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms & Conditions</a></li>
          </ul>
        </div>
      </div>
    </div>
    </div>
</footer>
<!-- END FOOTER SECTION --> 

<a href="#" class="scrollup btn-default"><i class="ion-ios-arrow-up"></i></a> 

<!-- Latest jQuery --> 
<script src="{{asset('assets/js/jquery-1.12.4.min.js')}}"></script> 
<!-- Latest compiled and minified Bootstrap --> 
<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script> 
<!-- owl-carousel min js  --> 
<script src="{{asset('assets/owlcarousel/js/owl.carousel.min.js')}}"></script> 
<!-- magnific-popup min js  --> 
<script src="{{asset('assets/js/magnific-popup.min.js')}}"></script> 
<!-- waypoints min js  --> 
<script src="{{asset('assets/js/waypoints.min.js')}}"></script> 
<!-- parallax js  --> 
<script src="{{asset('assets/js/parallax.js')}}"></script> 
<!-- countdown js  --> 
<script src="{{asset('assets/js/jquery.countdown.min.js')}}"></script> 
<!-- particles min js  --> 
<script src="{{asset('assets/js/particles.min.js')}}"></script> 
<!-- scripts js --> 
<script src="{{asset('assets/js/jquery.dd.min.js')}}"></script> 
<!-- jquery.counterup.min js --> 
<script src="{{asset('assets/js/jquery.counterup.min.js')}}"></script> 
<script src="{{asset('assets/js/notification.js')}}"></script> 
<!-- scripts js --> 
<script src="{{asset('assets/js/scripts.js')}}"></script>
</body>
</html>