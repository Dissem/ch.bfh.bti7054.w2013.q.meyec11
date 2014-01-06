<?php
require_once 'views/bitcoin.php';

$real_secret = 'ZQnluBj2vdldj5Vb8dGc';
$invoice_id = $_GET['invoice_id']; //invoice_id is passed back to the callback URL
$transaction_hash = $_GET['transaction_hash'];
$input_transaction_hash = $_GET['input_transaction_hash'];
$input_address = $_GET['input_address'];
$value_in_satoshi = $_GET['value'];
$value_in_btc = $value_in_satoshi / 100000000;

//Commented out to test, uncomment when live
if ($_GET['test'] == true) {
  return;
}

$btc = new BitCoin();
echo $btc->receive($invoice_id, $value_in_btc, $real_secret);
//try {
//  //create or open the database
//  $database = new SQLiteDatabase('db.sqlite', 0666, $error);
//} catch(Exception $e) {
//  die($error);
//}
//
////Add the invoice to the database
//$query = "insert INTO invoice_payments (invoice_id, transaction_hash, value) values($invoice_id, '$transaction_hash', $value_in_btc)";
//
//if($database->queryExec($query, $error)) {
//  echo "*ok*";
//}
//
////Select the amount paid into an invoice with select SUM(value) as value from invoice_payments where invoice_id = $invoice_id