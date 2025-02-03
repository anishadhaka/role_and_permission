<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    <title>Directory Landing Page</title>
    <link rel="shortcut icon" type="image/icon" href="{{ asset('assets/logo/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/linearicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootsnav.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/blogsite.css') }}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .categories {
        padding: 40px 20px;
        background-color: white;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .categories h1 {
        font-size: 32px;
        color: #3498db;
        margin-bottom: 20px;
    }

    /* Featured Reviews Section */
    .featured-reviews {
        padding: 40px 20px;
        background-color: #f9f9f9;
        text-align: center;
    }

    .review-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Review Card Styles */
    .review-card,
    .review-card2 {
        background-color: rgb(255, 252, 252);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .review-card:hover,
    .review-card2:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .review-card img,
    .review-card2 img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        border-bottom: 1px solid #ddd;
    }

    .review-card h1,
    .review-card2 h1 {
        font-size: 24px;
        color: #333;
        margin: 15px;
        text-decoration: none;
    }

    .review-card h1:hover,
    .review-card2 h1:hover {
        color: #305968;
    }

    .review-card p,
    .review-card2 p {
        font-size: 16px;
        color: #555;
        padding: 0 15px;
        margin-bottom: 20px;
    }

    .review-card a.read-more,
    .review-card2 a.read-more {
        color: #113954;
        font-weight: bold;
        padding: 10px;
        display: inline-block;
        border-radius: 20px;
        background-color: #d0e1e5;
        text-decoration: none;
        margin-bottom: 10px;
    }

    .review-card a.read-more:hover,
    .review-card2 a.read-more:hover {
        background-color: #3498db;
        color: white;
    }

    /* Load More Button */
    #loadMore,
    #loadMore2 {
        display: inline-block;
        margin-top: 20px;
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 18px;
        transition: background-color 0.3s ease;
    }

    #loadMore:hover,
    #loadMore2:hover {
        background-color: #2980b9;
    }
    </style>
</head>

<body>

    <header id="header-top" class="header-top">
        <ul>
            <li>
                <div class="header-top-left">
                    <ul>
                        <li class="select-opt">
                            <select name="language" id="language">
                                <option value="default">EN</option>
                                <option value="Bangla">BN</option>
                                <option value="Arabic">AB</option>
                            </select>
                        </li>
                        <li class="select-opt">
                            <select name="currency" id="currency">
                                <option value="usd">USD</option>
                                <option value="euro">Euro</option>
                                <option value="bdt">BDT</option>
                            </select>
                        </li>
                        <li class="select-opt">
                            <a href="#"><span class="lnr lnr-magnifier"></span></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="head-responsive-right pull-right">
                <div class="header-top-right">
                    <ul>
                        <li class="header-top-contact">+1 222 777 6565</li>
                        <li class="header-top-contact">
                            <a href="#">sign in</a>
                        </li>
                        <li class="header-top-contact">
                            <a href="#">register</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </header>

    <!-- top-area Start -->
    <section class="top-area">
        <div class="header-area">
            <nav class="navbar navbar-default bootsnav navbar-sticky navbar-scrollspy" data-minus-value-desktop="70"
                data-minus-value-mobile="55" data-speed="1000">
                <div class="container">
                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="index.html">WEL<span>COME</span></a>
                    </div>

                    <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                            <li class="scroll active"><a href="#home">home</a></li>
                            <li class="scroll"><a href="#works">Blogs</a></li>
                            <!-- <li class="scroll"><a href="#explore">explore</a></li> -->
                            <li class="scroll"><a href="#reviews">review</a></li>
                            <li class="scroll"><a href="#blog">NEWS</a></li>
                            <li class="scroll"><a href="#contact">contact</a></li>
                        </ul>
                        <!--/.nav -->
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!--/.container-->
            </nav>
            <!--/nav-->
            <!-- End Navigation -->
        </div>
        <!--/.header-area-->
        <div class="clearfix"></div>
    </section>
    <!-- /.top-area-->
    <!-- top-area End -->

    <!--welcome-hero start -->
    <section id="home" class="welcome-hero">
        <div class="container">
            <div class="welcome-hero-txt">
                <h2>
                    best place to find and explore <br />
                    that all you need
                </h2>
                <p>
                    Find Best Place, Restaurant, Hotel, Real State and many more think
                    in just One click
                </p>
            </div>
            <div class="welcome-hero-serch-box">
                <div class="welcome-hero-form">
                    <div class="single-welcome-hero-form">
                        <h3>what?</h3>
                        <form action="index.html">
                            <input type="text" placeholder="Ex: palce, resturent, food, automobile" />
                        </form>
                        <div class="welcome-hero-form-icon">
                            <i class="flaticon-list-with-dots"></i>
                        </div>
                    </div>
                    <div class="single-welcome-hero-form">
                        <h3>location</h3>
                        <form action="index.html">
                            <input type="text" placeholder="Ex: london, newyork, rome" />
                        </form>
                        <div class="welcome-hero-form-icon">
                            <i class="flaticon-gps-fixed-indicator"></i>
                        </div>
                    </div>
                </div>
                <div class="welcome-hero-serch">
                    <button class="welcome-hero-btn" onclick="window.location.href='#'">
                        search <i data-feather="search"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!--/.welcome-hero-->
    <!--welcome-hero end -->

    <!--list-topics start -->
    <section id="list-topics" class="list-topics">
        <div class="container" style='position: relative;z-index: 1;bottom: 67px'>
            <ul class="topic-grid">
                <li class="topic-card">
                    <div class="topic-content">
                        <div class="topic-icon">
                            <i class="fas fa-blog"></i>
                        </div>
                        <h2 class="topic-title"><a href="#">Blog</a></h2>
                        <p class="topic-count">150 listings</p>
                    </div>
                </li>
                <li class="topic-card">
                    <div class="topic-content">
                        <div class="topic-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h2 class="topic-title"><a href="#">News</a></h2>
                        <p class="topic-count">214 listings</p>66
                    </div>
                </li>
                <li class="topic-card">
                    <div class="topic-content">
                        <div class="topic-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <h2 class="topic-title"><a href="#">Travel</a></h2>
                        <p class="topic-count">185 listings</p>
                    </div>
                </li>
                <li class="topic-card">
                    <div class="topic-content">
                        <div class="topic-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h2 class="topic-title"><a href="#">Healthcare</a></h2>
                        <p class="topic-count">200 listings</p>
                    </div>
                </li>
                <li class="topic-card">
                    <div class="topic-content">
                        <div class="topic-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h2 class="topic-title"><a href="#">Automotive</a></h2>
                        <p class="topic-count">120 listings</p>
                    </div>
                </li>
            </ul>
        </div>
        <!--/.container-->
    </section>