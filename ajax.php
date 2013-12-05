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
}