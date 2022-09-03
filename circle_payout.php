<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api-sandbox.circle.com/v1/businessAccount/payouts",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"source\":{\"id\":\"12345\",\"type\":\"wallet\"},\"destination\":{\"id\":\"3f3aa55a-3977-3be7-9ad5-6dc702cc82a3\",\"type\":\"wire\"},\"amount\":{\"currency\":\"USD\",\"amount\":\"3.14\"},\"metadata\":{\"beneficiaryEmail\":\"satoshi@circle.com\"},\"idempotencyKey\":\"ba943ff1-ca16-49b2-ba55-1057e70ca5c7\"}",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Authorization: Bearer QVBJX0tFWTpmZWYxOTMyMTBiMzdiZDczYzFiZTFhZDNmZjEyYTM2YTpjYmRiMzAyMTE1Njg4NDBlOWM1ZGMyMGY1ODU2MWEyNw==",
    "Content-Type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}