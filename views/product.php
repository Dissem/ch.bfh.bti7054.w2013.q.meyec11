<?php
require_once __DIR__.'/../data/data.php';
require_once 'renderable.php';

class Product extends DBO implements Renderable {
  public $id;
  public $name;
  private $imageId;
  public $summary;
  public $description;
  public $options;
  public $selectedOption;

  public function render() {
    $l = $this->getLocale();
    ?>
<h1><?php echo $this->name[$l]?></h1>
    <?php if (isset($this->imageId)) { ?>
<img
	src="image.php?id=<?php echo $this->imageId?>" class="img-rounded"
	style="max-width: 30%; float: right" />
    <?php } ?>
<p><?php echo $this->summary[$l]?></p>
<p>BTC <?php echo $this->price?></p>
<a href="#"
	onclick="return go('product&amp;id=<?php echo $this->id?>');"><?php echo _("Details")?></a>
    <?php
  }

  public function renderDetail() {
    $l = $this->getLocale();
    ?>
<script type="text/javascript">
    //<![CDATA[
    function addToCart() {
        $.ajax({
            type: "POST",
            url: "ajax.php?site=addtocart",
            data: $("#productForm").serialize(),
            dataType: "html",
            success: function(data){
                $("#message").html(data);
            }
        });
        return false;
    }
    //]]>
</script>
<form id="productForm" action="ajax.php" method="post"
	accept-charset="UTF-8"><?php if (isset($this->imageId)) { ?><img
	src="image.php?id=<?php echo $this->imageId?>" class="img-responsive"
	alt="Product Image" /><?php } ?>
<div id="message"></div>
<h1><?php echo $this->name[$l]?></h1>
<p><?php echo $this->summary[$l]?></p>
<p><?php echo $this->description[$l]?></p>
<p>BTC <?php echo $this->price?></p>
<p>Select painter: <select name="painter" class="form-control">
	<option>Leonardo da Vinci</option>
	<option>Michelangelo Buonarroti</option>
	<option>Peter Paul Rubens</option>
	<option>Rembrandt Harmenszoon van Rijn</option>
	<option>Vincent van Gogh</option>
	<option>Claude Monet</option>
</select></p>
<input name="id" type="hidden" value="<?php echo $this->id ?>" />
<button type="button" class="btn btn-primary"
	onclick="return addToCart()"><?php echo _("Add to Cart")?></button>
<button type="button" class="btn btn-default"><?php echo _("Buy right now!")?></button>
</form>
    <?php
  }

  private function getLocale() {
    $locales = array('en', 'de');
    $accepted_languages = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach ($accepted_languages as $l) {
      if (substr($l, 0, 2) == 'de'){
        return 'de';
      }else if (substr($l, 0, 2) == 'en'){
        return 'en';
      }
    }
    return 'en';
  }

  static function find($id) {
    $p = new Product();
    $stmt = parent::getDB()->prepare("select id, price, imageId from Product where id=?");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($p->id, $p->price, $p->imageId);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    self::getTexts($p);

    return $p;
  }

  static function findAll() {
    $stmt = parent::getDB()->prepare("select id, price, imageId from Product");
    $stmt->bind_result($ids, $prices, $imageIds);
    $stmt->execute();
    while ($stmt->fetch()) {
      $p = new Product();
      $p->id = $ids;
      $p->price = $prices;
      $p->imageId = $imageIds;

      $res[] = $p;
    }
    $stmt->close();
    foreach ($res as $p) {
      self::getTexts($p);
    }
    return $res;
  }

  private static function getTexts(Product $p) {
    $stmt = parent::getDB()->prepare("select id, lang, name, summary, description from ProductTexts where id=?");
    $stmt->bind_param("i", $p->id);
    $stmt->bind_result($id, $lang, $name, $summary, $description);
    $stmt->execute();
    while ($stmt->fetch()) {
      $p->name[$lang] = $name;
      $p->summary[$lang] = $summary;
      $p->description[$lang] = $description;
    }
    $stmt->close();
  }
}

class OrderItem extends DBO {
  public $id;
  public $product;
  public $artist;

  public function __construct($product, $artist = NULL)
  {
    $this->product = $product;
    $this->artist = $artist;
  }

  public function getPrice() {
    return $this->product->price;
  }
}