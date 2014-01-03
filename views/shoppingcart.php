<?php
require_once __DIR__.'/../data/data.php';
require_once 'renderable.php';
require_once 'product.php';

class ShoppingCart extends DBO implements Renderable {
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
              $("#sum").text(data);
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

  public function addItem(OrderItem $p) {
    $this->items[] = $p;
    $p->id = array_search($p, $this->items);
    setcookie("cart", serialize($this));
    return '<div class="alert alert-success alert-dismissable"><strong>'._("Item added to cart.").'</strong> '.sprintf(_("Your shopping cart now contains %d items"), $this->count()).'</div>';
  }

  public function removeItem($id) {
    unset($this->items[$id]);
  }

  public static function get() {
    if (isset($_COOKIE['cart'])) {
      return unserialize($_COOKIE['cart']);
    } else {
      return new ShoppingCart();
    }
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