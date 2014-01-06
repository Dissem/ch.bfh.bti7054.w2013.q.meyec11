<?php
require_once 'renderable.php';

class BitCoin implements Renderable{
  private $secret = 'ZQnluBj2vdldj5Vb8dGc';
  private $address = "1EK3u1mbRs94XsXyrPgFW8FWUXEdwgB92m";
  private $callbackUrl;
  private $invoiceId;

  public function __construct($invoiceId) {
    include __DIR__.'/../config.php';

    $this->callbackUrl = $site_url."/bitcoincallback.php";
  }

  public function render() {
    $amount = 0.5; // TODO
    $receivingAdr = $this->getReceivingAddress();
    $btcuri = "bitcoin:$receivingAdr?amount=$amount";
    $btcurienc = urlencode($btcuri);
    $receivingAdrLink = "<a href=\"$btcuri\">$receivingAdr</a>";
    ?>
<h2><?php echo _("Payment")?></h2>
<div class="alert alert-warning"><?php echo _("Please note that this is just a demonstration, for the moment all payments are considered DONATIONS.")?></div>
<img
	src="https://chart.googleapis.com/chart?chs=300x300&amp;cht=qr&amp;chl=<?php echo $btcurienc?>"
	style="float: right; margin-left: 2em;" alt="QR code" />
<p><?php printf(_("Please send BTC %d to the address %s."), $amount, $receivingAdrLink)?></p>
<p><?php echo _("You can click the link if you have a wallet on this computer, or use the QR code with a mobile wallet.")?></p>
<p><?php echo _("After the payment is complete, you will be able to download the product from your personal section.")?></p>
    <?php
  }

  private function getReceivingAddress() {
    return $this->address;
    // FIXME: This is just for testing - uncomment the lines below and remove the line above for production
    //    $my_address = $this->address;
    //    $my_callback_url = $this->callbackUrl.'?invoice_id='.$this->invoiceId.'&secret='.$this->secret;
    //
    //    $root_url = 'https://blockchain.info/api/receive';
    //    $parameters = 'method=create&address='.$this->address.'&callback='.urlencode($this->callbackUrl);
    //
    //    $response = file_get_contents($root_url . '?' . $parameters);
    //
    //    $object = json_decode($response);
    //
    //    return $object->input_address;
  }

  public function receive($invoiceId, $value, $secret) {
    if ($secret != $this->secret) {
      die("Wrong secret");
    }
    // TODO
    return "*ok*";
  }
}