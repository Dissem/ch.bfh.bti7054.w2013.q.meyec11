<?php
require_once 'renderable.php';

class NavBar implements Renderable {
  public $brand;
  private $entries;

  function render() {
    ?>
    <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><?php print $this->brand; ?></a>
            </div>
    <?php
    if ($this->entries) { 
      foreach ($this->entries as $entry) {
        $entry->render();
      }
    }
    ?>
          </div>
        </div>

      </div>
    </div>
    <?php
  }

  public function addEntry(Renderable $entry) {
    $this->entries[] = $entry;
  }
}

class NavBarList implements Renderable {
  public $entries;
  public $right = false;

  public function render() {
    ?>
    <ul class="nav navbar-nav<?php echo $this->right?' navbar-right':''?>">
    <?php
      foreach ($this->entries as $entry) {
        $entry->render();
      }
    ?>
    </ul>
    <?php
  }

  public function addEntry(MenuEntry $entry) {
    $this->entries[] = $entry;
  }
}

class NavBarForm implements Renderable {
  private $submitName;
  private $entries;
  public $right = false;

  public function __construct($submitName){
    $this->submitName = $submitName;
  }

  public function render() {
    ?>
    <form class="navbar-form<?php echo $this->right?' navbar-right':''?>">
      <div class="form-group">
      	<div class="input-group">
      <?php
      foreach ($this->entries as $entry) {
        $entry->render();
      }
      ?>
        </div>
      </div>
      <button type="submit" class="btn btn-default"><?php echo $this->submitName; ?></button>
    </form>
    <?php
  }

  public function addEntry(Renderable $entry) {
    $this->entries[] = $entry;
  }
}

class MenuEntry {
  public $text;
  public $link = "#";
  public $action;
  public $subEntries;
  public $active = false;

  public function __construct($text, $action = NULL)    // Require first and last names when INSTANTIATING
  {
    $this->text = $text;
    $this->action = $action;
  }

  public function render() {
    $firstClass = ($this->active ? " class='active'" : "");
    if (!$this->subEntries) {
      echo "<li$firstClass><a href=\"$this->link\" ".$this->onclick().">$this->text</a></li>";
    } else {
      echo "<li class=\"dropdown\">";
      echo "  <a href=\"$this->link\" ".$this->onclick()." class=\"dropdown-toggle\" data-toggle=\"dropdown\">$this->text <b class=\"caret\"></b></a>";
      echo "    <ul class=\"dropdown-menu\">";
      foreach ($this->subEntries as $entry) {
        $entry->render();
      }
      echo " 	</ul>";
      echo "</li>";
    }
  }

  private function onclick() {
    if ($this->action) {
      return "onclick=\"return go('$this->action')\"";
    } else {
      return "";
    }
  }
  
  public function addSubEntry(MenuEntry $entry) {
    $this->subEntries[] = $entry;
  }
}
