<?php
session_start();
require_once 'lib/data.php';
require_once 'lib/utils.php';
DBO::createTables();

$locale = Utils::getLocale();
putenv("LANG=$locale");
setlocale(LC_ALL, $locale);

$domain = 'messages';
bindtextdomain($domain, "./locale");
textdomain($domain);

require_once 'views/site.php';
require_once 'views/navbar.php';
require_once 'views/login.php';
require_once 'views/carousel.php';
require_once 'views/product.php';
require_once 'views/shoppingcart.php';

$site = new Site();

$navBar = new NavBar();
$site->addNavElement($navBar);
$navBar->brand = _("Chris' CustomArt Webshop");

$navBarList = new NavBarList();
$navBar->addEntry($navBarList);
$user = User::getLoggedIn();
$userInfo = new MenuEntry("<em id='username'>".($user?$user->name:"")."</em>", "userinfo");
$userInfo->attrs = "class='loginRequired'";
$navBarList->addEntry($userInfo);
$navBarList->addEntry(new MenuEntry(_("Products"), "overview"));
$navBarList->addEntry(new CartMenuEntry());

//$navBar->addEntry(new MenuEntry("Test 1"));
//$me = new MenuEntry("Test 2");
//$me->right = true;
//$me->addSubEntry(new MenuEntry("Test 3"));
//$me->addSubEntry(new MenuEntry("Test 4"));
//$navBar->addEntry($me);
$navBar->addEntry(new Login());

$slides =Slide::findAll();
if (count($slides) > 0) {
  $carousel = new Carousel("artCarousel");
  $site->addNavElement($carousel);
  foreach ($slides as $slide) {
    $carousel->addSlide($slide);
  }
}
//$slide = new Slide();
//$slide->title = _("Art, as you've never experienced before.");
//$slide->subtitle = _("Except if you did, then you might have.");
//$slide->text = _("You can choose the style, subject and author of the picture.");
//$slide->image = "dragon-artist.png";
//$carousel->addSlide($slide);
//$slide = new Slide();
//$slide->title = _("Each piece an unicate.");
//$slide->subtitle = _("Or even a duplicate.");
//$slide->text = _("It's generated especially for you, with much love, by our servers.");
//$slide->image = "dragon-artist.png";
//$carousel->addSlide($slide);
//$slide = new Slide();
//$slide->title = _("Blazing fast.");
//$slide->subtitle = _("On a blazing fast internet connection.");
//$slide->text = _("After you paid it, you can download it directly.");
//$slide->image = "dragon-artist.png";
//$carousel->addSlide($slide);
//$slide = new Slide();
//$slide->title = _("Pay with Bitcoin.");
//$slide->subtitle = _("The internet money you haven't heard of. Yet.");
//$slide->text = _("If you already know Bitcoin, you can always try to make me accept Litecoin as well.");
//$slide->image = "dragon-bitcoin.png";
//$carousel->addSlide($slide);

$site->addElement(new ProductOverview());

// This should probably always come last:
$site->render();
?>