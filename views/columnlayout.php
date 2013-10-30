<?php
require_once 'renderable.php';

class ColumnLayout implements Renderable {
  private $elements;

  public function render() {
    ?>
      <div class="row">
    <?php foreach ($this->elements as $element) { ?>
        <div class="col-md-6">
    <?php   $element->render(); ?>
        </div>
    <?php } ?>
      </div>
    <?php
  }

  public function addElement(Renderable $element) {
    $this->elements[] = $element;
  }
}