<?php
require_once __DIR__.'/../data/data.php';
require_once 'renderable.php';
require_once 'columnlayout.php';
require_once 'login.php';

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
                $("#message").html('<div class="alert alert-success alert-dismissable"><strong><?php echo _("The item was added to the shopping cart.")?></strong></div>');
                if (data == 0)
                    $("#cartSize").text("");
                else
                    $("#cartSize").text(data);
            }
        });
        return false;
    }
    //]]>
</script>
<form
	id="productForm" action="ajax.php" method="post" accept-charset="UTF-8"><?php if (isset($this->imageId)) { ?><img
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
<!-- <button type="button" class="btn btn-default"><?php echo _("Buy right now!")?></button> -->
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

class ProductOverview implements Renderable {
  public function render() {
    $layout = new ColumnLayout();
    $products = Product::findAll();
    if (isset($products)) {
      foreach ($products as $p) {
        $layout->addElement($p);
      }
    }
    $layout->render();
  }
}

class Item extends DBO {
  public $id;
  public $product;
  public $artist;
  public $invoiceId;
  public $paid = false;

  public function __construct($product = NULL, $artist = NULL)
  {
    $this->product = $product;
    $this->artist = $artist;
  }

  public function getPrice() {
    return $this->product->price;
  }

  public static function load($id) {
    $item = new Item();
    $item->id = $id;
    $stmt = parent::getDB()->prepare("SELECT productId, artist, invoiceId, paid FROM Item WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($productId, $item->artist, $item->invoiceId, $item->paid);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    $item->product = Product::find($productId);
    return $item;
  }

  public static function findByInvoice(Invoice $invoice) {
    $items = array();
    $item->id = $id;
    $stmt = parent::getDB()->prepare("SELECT id, productId, artist, paid FROM Item WHERE invoiceId=?");
    $stmt->bind_param("i", $invoice->id);
    $stmt->bind_result($id, $productId, $artist, $paid);
    $stmt->execute();
    while ($stmt->fetch()) {
      $item = new Item();
      $item->id = $id;
      $item->product = $productId;
      $item->artist = $artist;
      $item->paid = $paid;
    }
    $stmt->close();
    // Warning: this isn't necessary at the moment, but might be later...
    //    $item->product = Product::find($item->product);
    return $items;
  }

  public function store() {
    $stmt = parent::getDB()->prepare("INSERT INTO Item(user, productId, artist, paid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisb", Login::getLoggedInUser()->email, $this->product->id, $this->artist, $this->paid);
    $stmt->execute();
    $stmt->close();
    $this->id = parent::getDB()->insert_id;
  }

  public function update() {
    $stmt = parent::getDB()->prepare("UPDATE Item SET invoiceId=?,  paid=? WHERE id=? AND user=?");
    $stmt->bind_param("ibis", $this->invoiceId, $this->paid, $this->id, Login::getLoggedInUser()->email);
    $stmt->execute();
    $stmt->close();
  }

  public function remove() {
    $stmt = parent::getDB()->prepare("DELETE FROM Item WHERE id=? AND user=?");
    $stmt->bind_param("is", $this->id, Login::getLoggedInUser()->email);
    $stmt->execute();
    $stmt->close();
  }
}

class Invoice extends DBO {
  public $id;
  public $user;
  public $amount;
  public $receivingBtcAddress;
  public $confirmations = 0;

  public static function load($id) {
    $item = new Invoice();
    $item->id = $id;
    $stmt = parent::getDB()->prepare("SELECT user, amount, btcAddress, confirmations FROM Invoice WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($item->user, $item->amount, $item->receivingBtcAddress, $item->confirmations);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    return $item;
  }

  public function store() {
    $stmt = parent::getDB()->prepare("INSERT INTO Invoice(user, amount, btcAddress, confirmations) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsi", Login::getLoggedInUser()->email, $this->amount, $this->receivingBtcAddress, $this->confirmations);
    $stmt->execute();
    $stmt->close();
    $this->id = parent::getDB()->insert_id;
  }

  public function update() {
    $stmt = parent::getDB()->prepare("UPDATE Invoice SET btcAddress=?, confirmations=? WHERE id=? AND user=?");
    $stmt->bind_param("siis", $this->receivingBtcAddress, $this->confirmations, $this->id, Login::getLoggedInUser()->email);
    $stmt->execute();
    $stmt->close();
  }

  public function remove() {
    $stmt = parent::getDB()->prepare("DELETE FROM Invoice WHERE id=? AND user=?");
    $stmt->bind_param("is", $this->id, Login::getLoggedInUser()->email);
    $stmt->execute();
    $stmt->close();
  }
}