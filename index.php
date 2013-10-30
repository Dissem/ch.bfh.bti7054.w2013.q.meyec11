<?php
require_once 'views/site.php';
require_once 'views/navbar.php';
require_once 'views/login.php';
require_once 'views/carousel.php';

$site = new Site();

$navBar = new NavBar();
$site->addElement($navBar);
$navBar->brand = "Chris' CustomArt Webshop";
//$navBar->addEntry(new MenuEntry("Google", "#"));
//$navBar->addEntry(new MenuEntry("Test 1"));
//$me = new MenuEntry("Test 2");
//$me->right = true;
//$me->addSubEntry(new MenuEntry("Test 3"));
//$me->addSubEntry(new MenuEntry("Test 4"));
//$navBar->addEntry($me);

$navBar->addEntry(new Login());

$carousel = new Carousel("artCarousel");
$site->addElement($carousel);
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

// This should probably always come last:
$site->render();
?>