<?php
require_once 'renderable.php';
require_once 'product.php';

class BitCoin implements Renderable{
  private $secret = 'ZQnluBj2vdldj5Vb8dGc';
  private $address;
  private $callbackUrl;
  public $invoice;

  public function __construct($invoiceId) {
    include __DIR__.'/../config.php';
    
    $this->invoice = Invoice::load($invoiceId);
    $this->address = $btcAddress;
    $this->callbackUrl = $site_url."/bitcoincallback.php";
  }

  public function render() {
    if (!isset($this->invoice->receivingBtcAddress)) {
      $this->invoice->receivingBtcAddress = $this->getReceivingAddress();
      $this->invoice->update();
    }
    $receivingAdr = $this->invoice->receivingBtcAddress;
    $amount = $this->invoice->amount;
    $btcuri = "bitcoin:$receivingAdr?amount=$amount";
    $btcurienc = urlencode($btcuri);
    $receivingAdrLink = "<a href=\"$btcuri\">$receivingAdr</a>";
    ?>
<h2><?php echo _("Payment")?></h2>
<div class="alert alert-warning"><?php echo _("Please note that this is just a demonstration, for the moment all payments are considered DONATIONS.")?></div>
<img
	src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl=<?php echo $btcurienc?>"
	style="float: right; margin-left: 2em; border: solid black 1px;" alt="QR code" />
<p><?php printf(_("Please send BTC %f to the address %s."), $amount, $receivingAdrLink)?></p>
<p><?php echo _("You can click the link if you have a wallet on this computer, or use the QR code with a mobile wallet.")?></p>
<p><?php echo _("After the payment is complete, you will be able to download the product from your personal section.")?></p>
    <?php
  }

  private function getReceivingAddress() {
    $my_address = $this->address;
    $my_callback_url = $this->callbackUrl.'?invoice_id='.$this->invoice->id.'&secret='.$this->secret;

    $root_url = 'https://blockchain.info/api/receive';
    $parameters = 'method=create&address='.$this->address.'&callback='.urlencode($this->callbackUrl);

    $response = file_get_contents($root_url . '?' . $parameters);

    $object = json_decode($response);

    return $object->input_address;
  }

  public function receive($invoiceId, $value, $secret) {
    include __DIR__.'/../config.php';

    if ($secret != $this->secret) {
      die("Wrong secret");
    }
    $invoice = Invoice::load($invoiceId);
    $invoice->confirmations++;
    if ($invoice->confirmations >= $btcConfirmations) {
      $items = Item::findByInvoice($invoice);
      foreach ($items as $item) {
        $item->paid = true;
        if (!$item->update())
          return "Error saving Item";
      }
    }
    if (!$invoice->update())
      return "Error saving Invoice";
    if ($invoice->confirmations >= $btcConfirmations) {
      return "*ok*";
    } else {
      return "needs more confirmations";
    }
  }
}