<?php
class NavBar {
  public $brand;
  private $menuEntries;

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
    if($this->menuEntries) { 
    ?>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
    <?php
      foreach ($this->menuEntries as $entry) {
        $entry->active = ($entry == $this->menuEntries[0]);
        $entry->render();
      }
    ?>
              </ul>
            </div>
    <?php
    } 
    ?>
          </div>
        </div>

      </div>
    </div>
    <?php
  }

  public function addSubEntry(MenuEntry $entry) {
    $this->menuEntries[] = $entry;
  }
}

class MenuEntry {
  public $text;
  public $link;
  public $subEntries;
  public $active = false;

  public function __construct($text, $link = "#")    // Require first and last names when INSTANTIATING
  {
    $this->text = $text;
    $this->link = $link;
  }

  public function render() {
    $firstClass = ($this->active ? " class='active'" : "");
    if (!$this->subEntries) {
      echo "<li$firstClass><a href=\"$this->link\">$this->text</a></li>";
    } else {
      echo "<li class=\"dropdown\">";
      echo "  <a href=\"$this->link\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$this->text <b class=\"caret\"></b></a>";
      echo "    <ul class=\"dropdown-menu\">";
      foreach ($this->subEntries as $entry) {
        $entry->render();
      }
      echo " 	</ul>";
      echo "</li>";
    }
  }
  
  public function addSubEntry(MenuEntry $entry) {
    $this->subEntries[] = $entry;
  }
}
