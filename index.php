<!DOCTYPE html>
<html>
  <head>
    <title>Chris' CustomArt Webshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon" sizes="144x144" href="ico/apple-touch-icon-144.png">
    <link rel="apple-touch-icon" sizes="114x114" href="ico/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="ico/apple-touch-icon-72.png">
    <link rel="apple-touch-icon" href="ico/apple-touch-icon-57.png">
    <link rel="shortcut icon" href="img/icons/favicon.png">
    <style>
      /* GLOBAL STYLES
      -------------------------------------------------- */
      /* Padding below the footer and lighter body text */
      
      body {
        padding-bottom: 40px;
        color: #5a5a5a;
      }
      
      h1 {
      	font-size: 22px;
      }
      
      /* CUSTOMIZE THE NAVBAR
      -------------------------------------------------- */
      
      /* Special class on .container surrounding .navbar, used for positioning it into place. */
      .navbar-wrapper {
        margin-left: -15px;
        margin-right: -15px;
        position: relative;
        z-index: 15;
      }
      
      
      /* CUSTOMIZE THE CAROUSEL
      -------------------------------------------------- */
      
      /* Carousel base class */
      .carousel {
        margin-top: -20px;
        margin-bottom: 60px;
      }
      /* Since positioning the image, we need to help out the caption */
      .carousel-caption {
        z-index: 10;
      }
      
      /* Declare heights because of positioning of img element */
      .carousel .item {
        height: 250px;
        background-color: #EBAB2D;
      }
      .carousel-inner > .item > img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        height: auto;
      }

      @media (min-width: 768px) {
      h1 {
      	font-size: 36px;
      }

        /* Navbar positioning foo */
        .navbar-wrapper {
          margin-left: 0px;
          margin-right: 0px;
          margin-top: 20px;
        }
        /* The navbar becomes detached from the top, so we round the corners */
        .navbar-wrapper .navbar {
          border-radius: 4px;
        }
      
        /* Bump up size of carousel content */
        .carousel {
          margin-bottom: 60px;
        
          /* Negative margin to pull up carousel. 90px is roughly margins and height of navbar. */
          margin-top: -90px;
        }

        .carousel-caption p {
          margin-bottom: 20px;
          font-size: 21px;
          line-height: 1.4;
        }
      
        .featurette-heading {
          font-size: 50px;
        }

        .carousel .item {
          height: 500px;
        }
      }
      
      @media (min-width: 992px) {
        .featurette-heading {
          margin-top: 120px;
        }
      }
    </style>
  </head>
  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Chris' CustomArt Webshop</a>
            </div>
            <!-- 
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
            </div>
             -->
          </div>
        </div>

      </div>
    </div>

    <div id="artCarousel" class="carousel slide">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#artCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#artCarousel" data-slide-to="1"></li>
        <li data-target="#artCarousel" data-slide-to="2"></li>
        <li data-target="#artCarousel" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="img/dragon-artist.png" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Art, as you've never experienced before. <span class="text-muted">Except
                  if you did, then you might have.</span></h1>
              <p>
                You can choose the style, subject and author of the
                picture.
              </p>
              <a class="btn btn-large btn-primary" href="#">Sign up today</a>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="img/dragon-artist.png" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Each piece an unicate. <span class="text-muted">Or even a duplicate.</span></h1>
              <p>
                It's generated especially for you, with much love, by
                our servers.
              </p>
              <a class="btn btn-large btn-primary" href="#">Learn more</a>
            </div>
          </div>
        </div>
        <!-- item -->
        <div class="item">
          <img src="img/dragon-artist.png" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Blazing fast. <span class="text-muted">On a blazing fast internet
                  connection.</span></h1>
              <p class="lead">
                After you paid it, you can download it directly.
              </p>
              <a class="btn btn-large btn-primary" href="#">Browse gallery</a>
            </div>
          </div>
        </div>
        <!-- item -->
        <div class="item">
          <img src="img/dragon-artist.png" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Pay with Bitcoin. <span class="text-muted">The internet money you haven't
                  heard of. Yet.</span></h1>
              <p class="lead">
                If you already know Bitcoin, you can always try to make
                me accept Litecoin as well.
              </p>
              <a class="btn btn-large btn-primary" href="#">Browse gallery</a>
            </div>
          </div>
          <!-- container -->
        </div>
        <!-- item -->
      </div>
      <!-- carousel-inner -->
      <a class="left carousel-control" href="#artCarousel" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#artCarousel" data-slide="next">&rsaquo;</a>
    </div>
    <!-- carousel -->
    <?php

    ?>
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
  </body>
</html>
