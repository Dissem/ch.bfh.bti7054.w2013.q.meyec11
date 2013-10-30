<?php
require_once 'renderable.php';

class Carousel implements Renderable {
  public $id;
  private $slides;

  public function __construct($id){
    $this->id = $id;
  }

  public function render() {
    ?>
    <div id="<?php echo $this->id; ?>" class="carousel slide">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#<?php echo $this->id; ?>" data-slide-to="0" class="active"></li>
      <?php
        for ($i = 1; $i < count($this->slides); $i++) {
          echo "        <li data-target=\"#$this->id\" data-slide-to=\"$i\"></li>\n";
        }
      ?>
      </ol>
      <div class="carousel-inner">
      <?php
        foreach ($this->slides as $slide) {
          if ($slide == $this->slides[0])
            $slide->active = true;
          $slide->render();
        }
      ?>
      </div>
      <a class="left carousel-control" href="#<?php echo $this->id; ?>" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#<?php echo $this->id; ?>" data-slide="next">&rsaquo;</a>
    </div>
    <?php
  }

  public function addSlide(Slide $slide) {
    $this->slides[] = $slide;
  }
}

class Slide {
  public $image;
  public $title;
  public $subtitle;
  public $text;
  public $active = false;

  public function render() {
    ?>
        <div class="item<?php if ($this->active) echo " active"; ?>">
          <img src="img/<?php echo $this->image; ?>" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1><?php echo $this->title; ?> <span class="text-muted"><?php echo $this->subtitle; ?></span></h1>
              <p><?php echo $this->text; ?></p>
            </div>
          </div>
        </div>
    <?php
  }
}