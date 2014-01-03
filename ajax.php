<?php
$site = strtolower($_GET["site"]);

switch ($site) {
  case "signup":
    require_once 'views/signup.php';
    $signup = new SignUp();
    $signup->render();
    break;
  case "signup-submit":
    require_once 'views/signup.php';
    $signup = new SignUp();
    $signup->doSignup();
    break;
  case "signin":
    require_once 'views/login.php';
    $login = new Login();
    echo $login->login();
    break;
  case "signout":
    require_once 'views/login.php';
    $login = new Login();
    $login->logout();
    break;
  case "product":
    require_once 'views/product.php';
    $id = $_GET["id"];
    $p = Product::find($id);
    $p->renderDetail();
    break;
  case "addtocart":
    require_once 'views/shoppingcart.php';
    require_once 'views/product.php';
    $cart = ShoppingCart::get();
    $product = Product::find($_POST["id"]);
    $painter = $_POST["painter"];
    echo $cart->addItem(new OrderItem($product, $painter));
    break;
  case "removecartitem":
    require_once 'views/shoppingcart.php';
    $cart = ShoppingCart::get();
    $cart->removeItem($_GET["id"]);
    echo $cart->total();
    break;
  case "cart":
    require_once 'views/shoppingcart.php';
    ShoppingCart::get()->render();
    break;
}