<!DOCTYPE html>
<html>
<?php
  include('views/navbar.php');
  include('views/carousel.php');
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

  $carousel = new Carousel("artCarousel");
  $slide = new Slide();
  $slide->title = "Art, as you've never experienced before.";
  $slide->subtitle = "Except if you did, then you might have.";
  $slide->text = "You can choose the style, subject and author of the picture.";
  $slide->image = "dragon-artist.png";
  $carousel->addSlide($slide);
  $slide = new Slide();
  $slide->title = "Each piece an unicate.";
  $slide->subtitle = "Or even a duplicate.";
  $slide->text = "It's generated especially for you, with much love, by our servers.";
  $slide->image = "dragon-artist.png";
  $carousel->addSlide($slide);
  $slide = new Slide();
  $slide->title = "Blazing fast.";
  $slide->subtitle = "On a blazing fast internet connection.";
  $slide->text = "After you paid it, you can download it directly.";
  $slide->image = "dragon-artist.png";
  $carousel->addSlide($slide);
  $slide = new Slide();
  $slide->title = "Pay with Bitcoin.";
  $slide->subtitle = "The internet money you haven't heard of. Yet.";
  $slide->text = "If you already know Bitcoin, you can always try to make me accept Litecoin as well.";
  $slide->image = "dragon-bitcoin.png";
  $carousel->addSlide($slide);
  $carousel->render();
  ?>

    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
  </body>
</html>
