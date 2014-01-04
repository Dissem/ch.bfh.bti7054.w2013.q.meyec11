<?php
require_once 'data/data.php';
DBO::createTables();

function getLocale(){
  $locales = array('en', 'de');
  $accepted_languages = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
  foreach ($accepted_languages as $l) {
    if (substr($l, 0, 2) == 'de'){
      return 'de';
    }else if (substr($l, 0, 2) == 'en'){
      return 'en';
    }
  }
  return 'en';
}

$locale = getLocale();
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
$navBarList->addEntry(new MenuEntry(_("Products"), "overview"));
$navBarList->addEntry(new CartMenuEntry());

//$navBar->addEntry(new MenuEntry("Test 1"));
//$me = new MenuEntry("Test 2");
//$me->right = true;
//$me->addSubEntry(new MenuEntry("Test 3"));
//$me->addSubEntry(new MenuEntry("Test 4"));
//$navBar->addEntry($me);
$navBar->addEntry(new Login());

$carousel = new Carousel("artCarousel");
$site->addNavElement($carousel);
$slide = new Slide();
$slide->title = _("Art, as you've never experienced before.");
$slide->subtitle = _("Except if you did, then you might have.");
$slide->text = _("You can choose the style, subject and author of the picture.");
$slide->image = "dragon-artist.png";
$carousel->addSlide($slide);
$slide = new Slide();
$slide->title = _("Each piece an unicate.");
$slide->subtitle = _("Or even a duplicate.");
$slide->text = _("It's generated especially for you, with much love, by our servers.");
$slide->image = "dragon-artist.png";
$carousel->addSlide($slide);
$slide = new Slide();
$slide->title = _("Blazing fast.");
$slide->subtitle = _("On a blazing fast internet connection.");
$slide->text = _("After you paid it, you can download it directly.");
$slide->image = "dragon-artist.png";
$carousel->addSlide($slide);
$slide = new Slide();
$slide->title = _("Pay with Bitcoin.");
$slide->subtitle = _("The internet money you haven't heard of. Yet.");
$slide->text = _("If you already know Bitcoin, you can always try to make me accept Litecoin as well.");
$slide->image = "dragon-bitcoin.png";
$carousel->addSlide($slide);

$site->addElement(new ProductOverview());

// This should probably always come last:
$site->render();
?>