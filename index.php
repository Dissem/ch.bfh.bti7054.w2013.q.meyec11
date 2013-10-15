<!DOCTYPE html>
<html>
<?php
  include('views/navbar.php');
?>
  <head>
    <title>Chris' CustomArt Webshop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/custom.css" rel="stylesheet" media="screen">
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon" sizes="144x144" href="ico/apple-touch-icon-144.png">
    <link rel="apple-touch-icon" sizes="114x114" href="ico/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="ico/apple-touch-icon-72.png">
    <link rel="apple-touch-icon" href="ico/apple-touch-icon-57.png">
    <link rel="shortcut icon" href="img/icons/favicon.png">
  </head>
  <body>
  <?php
  $navBar = new NavBar();
  $navBar->brand = "Chris' CustomArt Webshop";
//  $navBar->addSubEntry(new MenuEntry("Google", "https://www.google.com"));
//  $navBar->addSubEntry(new MenuEntry("Test 1"));
//  $me = new MenuEntry("Test 2");
//  $me->addSubEntry(new MenuEntry("Test 3"));
//  $me->addSubEntry(new MenuEntry("Test 4"));
//  $navBar->addSubEntry($me);
  $navBar->render();
  ?>

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
            </div>
          </div>
        </div>
        <!-- item -->
        <div class="item">
          <img src="img/dragon-bitcoin.png" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Pay with Bitcoin. <span class="text-muted">The internet money you haven't
                  heard of. Yet.</span></h1>
              <p class="lead">
                If you already know Bitcoin, you can always try to make
                me accept Litecoin as well.
              </p>
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
