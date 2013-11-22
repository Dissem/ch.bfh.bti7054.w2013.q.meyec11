<?php
require_once 'renderable.php';

class Product implements Renderable {
  private $id;
  public $name;
  public $description;
  public $price;

  public function render() {
    ?>
    <h1><?php echo $this->name?></h1>
    <p><?php echo $this->description?></p>
    <p>BTC <?php echo $this->price?></p>
    <?php
  }
}