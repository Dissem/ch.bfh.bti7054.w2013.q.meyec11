<?php
interface Renderable {
  public function render();
}

class Text implements Renderable {
  private $text;
  private $class;

  public function __construct($text, $class = ""){
    $this->text = $text;
    $this->class = $class;
  }

  public function render() {
    echo "<p class=\"$this->class\">$this->text</p>"; 
  }
}

class Button implements Renderable {
  private $text;
  private $type;
  private $class;

  public function __construct($text, $type = "submit", $class = ""){
    $this->text = $text;
    $this->type = $type;
    $this->class = $class;
  }

  public function render() {
    echo "<button type=\"$this->type\" class=\"btn btn-default $this->class\">$this->text</button>"; 
  }
}

class Input implements Renderable {
  private $label;
  private $text;
  private $type;
  private $class;

  public function __construct($label, $type = "text", $class = "form-control", $text=""){
    $this->label = $label;
    $this->text = $text;
    $this->type = $type;
    $this->class = $class;
  }

  public function render() {
    echo "<input type=\"$this->type\" class=\"$this->class\" placeholder=\"$this->label\">$this->text</input>"; 
  }
}