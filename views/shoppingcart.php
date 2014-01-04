<?php
require_once __DIR__.'/../data/data.php';
require_once 'renderable.php';
require_once 'product.php';
require_once 'navbar.php';
require_once 'login.php';

class ShoppingCart extends DBO implements Renderable {
  private static $instance;
  private $items;

  public function render() {
    $l = $this->getLocale();
    ?>
<div class="table-responsive"><script type="text/javascript">
  //<![CDATA[
  function removeItem(id) {
      $.ajax({
          type: "POST",
          url: "ajax.php?site=removecartitem&id="+id,
          data: $("#loginForm").serialize(),
          dataType: "html",
          success: function(data){
              $("#item"+id).remove();
              d = data.split(";");
              $("#sum").text(d[0]);
              $("#cartSize").text(d[1]);
          }
      });
      return false;
  }
  //]]>
</script>
<table class="table">
	<thead>
		<tr>
			<th><?php echo _("Product")?></th>
			<th><?php echo _("Artist")?></th>
			<th>&nbsp;</th>
			<th><?php echo _("Price")?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>BTC <span id="sum"><?php echo $this->total()?></span></td>
		</tr>
	</tfoot>
	<tbody>
	<?php if ($this->items) foreach ($this->items as $item) { ?>
		<tr id="item<?php echo $item->id?>">
			<td><?php echo $item->product->name[$l]?></td>
			<td><?php echo $item->artist?></td>
			<td><a href="#" onclick="return removeItem('<?php echo $item->id?>')"><span
				class="glyphicon glyphicon-trash" title="<?php echo _("Remove")?>"></span></a></td>
			<td><?php echo "BTC ".$item->getPrice()?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>
		<?php
  }

  public function total() {
    $sum = 0;
    if ($this->items) foreach ($this->items as $item) {
      $sum += $item->getPrice();
    }
    return $sum;
  }

  public function count() {
    return count($this->items);
  }

  public function addItem(Item $p) {
    $p->store();
    $this->items[$p->id] = $p;
    return $this->count();
  }

  public function removeItem($id) {
    $p = $this->items[$id];
    unset($this->items[$id]);
    $p->remove();
    return $this->count();
  }

  public static function get() {
    if (!self::$instance) {
      self::$instance = new ShoppingCart();
      $stmt = parent::getDB()->prepare("SELECT id FROM Item WHERE user=? AND paid=FALSE");
      $stmt->bind_param("s", Login::getLoggedInUser()->email);
      $stmt->bind_result($id);
      $stmt->execute();
      while ($stmt->fetch()) {
        $ids[] = $id;
      }
      $stmt->close();
      if (isset($ids)) foreach ($ids as $id) {
        self::$instance->items[$id] = Item::load($id);
      }
    }
    return self::$instance;
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
}

class CartMenuEntry extends MenuEntry {
  public function __construct() {
    $this->action = "cart";
    $count = ShoppingCart::get()->count();
    if ($count == 0) {
      $count = "";
    }
    $this->text = _("Cart")." <span id=\"cartSize\" class=\"badge\">$count</span>";
  }
}