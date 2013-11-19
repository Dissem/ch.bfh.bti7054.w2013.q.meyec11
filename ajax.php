<?php
$site = strtolower($_GET["site"]);

switch ($site) {
  case "signup":
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