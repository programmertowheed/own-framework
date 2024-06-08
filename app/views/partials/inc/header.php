<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= isset($page) ? $page : "" ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= assets("assets/img/favicon.png") ?>" rel="icon">
    <link href="<?= assets("assets/img/apple-touch-icon.png") ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= assets("assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= assets("assets/vendor/icofont/icofont.min.css") ?>" rel="stylesheet">
    <link href="<?= assets("assets/vendor/boxicons/css/boxicons.min.css") ?>" rel="stylesheet">
    <link href="<?= assets("assets/vendor/venobox/venobox.css") ?>" rel="stylesheet">
    <link href="<?= assets("assets/vendor/owl.carousel/assets/owl.carousel.min.css") ?>" rel="stylesheet">
    <link href="<?= assets("assets/vendor/aos/aos.css") ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= assets("assets/css/style.css") ?>" rel="stylesheet">

</head>

<body>

<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-none d-lg-block">
    <div class="container d-flex">
        <div class="contact-info mr-auto">
            <ul>
                <li><i class="icofont-envelope"></i><a href="<?= url("/") ?>">contact@example.com</a></li>
                <li><i class="icofont-phone"></i> +1 5589 55488 55</li>
                <li><i class="icofont-clock-time icofont-flip-horizontal"></i> Mon-Fri 9am - 5pm</li>
            </ul>

        </div>
        <div class="cta">
            <a href="#about" class="scrollto">Get Started</a>
        </div>
    </div>
</section>

<!-- ======= Header ======= -->
<header id="header">
    <div class="container d-flex">

        <div class="logo mr-auto">
            <h1 class="text-light"><a href="<?= url("/") ?>"><span>Flexor</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="<?php //url("/") ?>"><img src="<?php //assets("assets/img/logo.png") ?>" alt="" class="img-fluid"></a>-->
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="<?= url("/") ?>">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="<?= url("/") ?>">Blog</a></li>
                <li class="drop-down"><a href="">Drop Down</a>
                    <ul>
                        <li><a href="#">Drop Down 1</a></li>
                        <li class="drop-down"><a href="#">Drop Down 2</a>
                            <ul>
                                <li><a href="#">Deep Drop Down 1</a></li>
                                <li><a href="#">Deep Drop Down 2</a></li>
                                <li><a href="#">Deep Drop Down 3</a></li>
                                <li><a href="#">Deep Drop Down 4</a></li>
                                <li><a href="#">Deep Drop Down 5</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Drop Down 3</a></li>
                        <li><a href="#">Drop Down 4</a></li>
                        <li><a href="#">Drop Down 5</a></li>
                    </ul>
                </li>
                <li><a href="#contact">Contact</a></li>

            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End Header -->