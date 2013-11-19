<?php
require_once 'renderable.php';

class Site {
  private $elements;

  public function render() {
    ?><!DOCTYPE html>
<html>
  <head>
    <title>Chris' CustomArt Webshop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/custom.css" rel="stylesheet" media="screen">
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon" sizes="144x144" href="img/icons/apple-touch-icon-144.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72.png">
    <link rel="apple-touch-icon" href="img/icons/apple-touch-icon-57.png">
    <link rel="shortcut icon" href="img/icons/favicon.png">
  </head>
  <body>
  <?php
    foreach ($this->elements as $element) {
      $element->render();
    }
  ?>
  	<div id="content" class="container"></div>
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/custom.js">
    </script>
  </body>
</html>
    <?php
  }

  public function addElement(Renderable $element) {
    $this->elements[] = $element;
  }
}