<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paypal Integration Test</title>
</head>
<body>

<?php $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
//$paypal_id='himanshukumar077@gmail.com'; // Business email ID
$paypal_id='lalitattri.orem@gmail.com'; // Business email ID
//$paypal_id='thenamzdaddy@aol.com'; // Business email ID
if(!empty($_REQUEST['amount']) && !empty($_REQUEST['currency']) && !empty($_REQUEST['ride_id']))
{
	//print_r($_REQUEST); die;
	$amount = base64_decode($_REQUEST['amount']);
	$currency = base64_decode($_REQUEST['currency']);
	$currency = strtoupper($currency);
	$currency = "USD";
	$ride_id = base64_decode($_REQUEST['ride_id']);
	
	$amount = 1;
	$currency = 'USD';
	$ride_id = 100;
}
?>
<div class="ajax_loader"><img src="ajax-loader.gif"><span>Redirecting to payment....</div>

<div class="product">
    
    <div class="btn">
    <form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1" id="payform" style="display: none;">
    <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" value="Haylup Ride">   
    <input type="hidden" name="item_number" value="<?php echo $ride_id; ?>">   
    
    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
    <input type="hidden" name="cpp_header_image" value="https://www.phpgang.com/wp-content/uploads/gang.jpg">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="currency_code" value="<?php echo $currency; ?>">
    <input type="hidden" name="handling" value="0">
    <input type="hidden" name="custom" value="1">
    <input type="hidden" name="cancel_return" value="http://dev.appmantechnologies.com/haylup/cron/cancelpayment">
    <input type="hidden" name="return" value="http://dev.appmantechnologies.com/haylup/cron/successpayment">
    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    </div>
</div>
<style>
.ajax_loader {
    display: inline-block;
    width: 100%;
    text-align: center;
}
.ajax_loader span{
    display: inline-block;
    width: 100%;
    text-align: center;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function(){
	$("#payform").submit();
})
</script>
</body>
</html>
