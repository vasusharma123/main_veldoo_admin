<?php
// send email
$msg = "Results: " . print_r( $_REQUEST, true );
mail("lalitattri.orem@gmail.com","My subject",$msg);
print_r($_REQUEST); die;

$item_no            = $_REQUEST['item_number'];
$item_transaction   = $_REQUEST['tx']; // Paypal transaction ID
