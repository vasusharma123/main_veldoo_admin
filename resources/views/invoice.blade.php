<!doctype html>
<html>
	<head>
		<title>Haylup</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	</head>
	<body style="margin: 0; padding: 0; font-family: arial">
		<div style="width: 600px; margin: 0 auto;">
			<table cellpadding="0" cellspacing="0"  style="width: 600px; padding: 25px 15px 0px 15px; max-width: 100%; background: #000;" align="left" valign="middle">
				<tr>
					<td style="width: 150px;">
						<a href="#"><img src="https://dev.appmantechnologies.com/haylup/public/images/haylup_logo.png" style="width: 100px;" /></a>
					</td>
					<td style="font-size: 15px; color: #fff; text-align: right;">
						<h4 style="margin: 0 0 10px 0; font-size: 30px; text-transform: uppercase;">INVOICE</h4>
						<p style="margin: 0 0 10px 0;">Total <strong>&#36;{{$price}}</strong></p>
						<p style="margin: 0;">{{$ride_date}}</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<h1 style="color: #fff; font-size: 70px; margin: 50px 0">Thank you for riding</h1>
						<p style="margin: 0 0 50px 0; font-size: 25px; color: #fff;">Hope you enjoy the ride </p>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0"  style="width: 600px; max-width: 100%;" align="left" valign="middle">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" style="width: 100%; background: #f2f2f2; padding: 15px;">
							<tr>
								<td>
									<h2 style="font-size: 20px; color: #797575; margin: 0 0 10px 0">Your ride with {{$driver_name}}</h2>
									
								</td>
							</tr>
						</table>
						<table cellpadding="0" cellspacing="0"  style="width: 100%; padding: 15px;">
							<tr>
								<td>
									<span style=" background: #004fff; padding: 10px 16px; color: #fff; font-weight: 600; border-radius: 50px; display: inline-block; margin-right: 15px;">Haylup</span> {{$ride_date}}<span style="margin:0 10px;">
								</td>
							</tr>
							<tr>
								<td style="margin:40px 0 20px 0; display: block;">
									<p style="margin: 0; display: inline-block; vertical-align: middle;"><img src="http://dev.appmantechnologies.com/haylup/public/images/pic_location.png" style="width: 22px; display: inline-block; vertical-align: middle; float: left; margin-right: 7px;"><span style="display: table;">{{$pickup_location}}</span></p>
								</td>
							</tr>
							<tr>
								<td style="margin: 20px 0; display: block;">
									<p style="margin: 0; display: inline-block; vertical-align: middle;"><img src="http://dev.appmantechnologies.com/haylup/public/images/drop_location.png" style="width: 22px; display: inline-block; vertical-align: middle; float: left; margin-right: 7px;"><span style="display: table;">{{$dest_address}}</span></p>
								</td>
							</tr>
						</table>
						<table cellpadding="0" cellspacing="0"  style="width: 100%; padding: 15px;">
							<tr style="background: #f2f2f2">
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: center;"><strong>List</strong></td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: center;"><strong>Charges</strong></td>
							</tr>
							<tr>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: left;">Trip Fare</td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: right;">&#36;{{$price}}</td>
							</tr>
							<tr style="background: #f1f1f1">
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: left;">Sub Total</td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: right;">&#36;{{$price}}</td>
							</tr>
						<!--	<tr>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: left;">Booking Fee</td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: right;">&#8377;5.00</td>
							</tr>
							<tr style="background: #f1f1f1">
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: left;">Brfore Tax Fee</td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: right;">&#8377;98.00</td>
							</tr>
							<tr>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: left;">IGST 5%</td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: right;">&#8377;5.00</td>
							</tr>-->
							<tr style="background: #f1f1f1">
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: left;"><strong>Amount Charged</strong></td>
								<td style="border: 1px solid #ccc; padding: 10px 15px; text-align: right;"><strong>&#36;{{$price}}</strong></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>