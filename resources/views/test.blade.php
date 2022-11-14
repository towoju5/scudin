<?php

// phpinfo();

// var_dump(twilio());

// $address = [
//   'address' => '1604 E 41ST PL',
//   'city' => 'LOS ANGELES',
//   'postal'  => 90011,
//   'state'=> 'CA',
//   'country'=> 'US'
// ];

// getShippingRateFedEx();

// $dd = (validate_address($address));

// // echo $dd->ambiguous."<hr>"; // true
// // echo $dd->candidates."<hr>";

// var_dump($dd);
// 

// echo $dd = getShippingRateUps(2);
// echo $dd;
// echo response()->json($dd);

// $date = date('Y-m-d');
// $data = [
//   'inEffectAsOfTimestamp' => "$date",
//   'validateAddressControlParameters' => [
//     'includeResolutionTokens' => true,
//   ],
//   'addressesToValidate' => [
//     0 => [
//       'address' => [
//         'streetLines' => [
//           0 => '7372 PARKRIDGE BLVD',
//           1 => 'APT 286',
//           2 => '2903 sprank',
//         ],
//         'city' => 'IRVING',
//         'stateOrProvinceCode' => 'TX',
//         'postalCode' => '75063-8659',
//         'countryCode' => 'US',
//         'urbanizationCode' => 'EXT VISTA BELLA',
//         'addressVerificationId' => 'string',
//       ],
//     ],
//   ],
// ];


// $url = "https://apis-sandbox.fedex.com/address/v1/addresses/resolve";

// $curl = curl_init($url);
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// $headers = array(
//    "Authorization: Bearer 3c0eaeafaa3c417ba5fb128b70d8af7e",
//    "Content-Type: application/json",
// );
// curl_setopt($curl, CURLOPT_ENCODING, '');
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

// //for debug only!
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// $resp = curl_exec($curl);
// curl_close($curl);
// echo ($resp);





// $request = new HttpRequest();
// $request->setUrl('https://apis-sandbox.fedex.com/address/v1/addresses/resolve');
// $request->setMethod("POST");

// $request->setHeaders(array(
//   'Authorization' => 'Bearer ',
//   'X-locale' => 'en_US',
//   'Content-Type' => 'application/json'
// ));

// $request->setBody($data); // 'input' refers to JSON Payload

// try {
//   $response = $request->send();

//   echo $response->getBody();
// } catch (\Exception $ex) {
//   echo $ex;
// }


// $url = "https://apis-sandbox.fedex.com/oauth/token";

// $curl = curl_init($url);
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// $headers = array(
//   "Content-Type: application/x-www-form-urlencoded",
// );
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// $data = [
//   "grant_type" => "client_credentials",
//   "client_id" => "17622fa7b8689e40f8a9156b6a4143b08",
//   "client_secret" => "3c0eaeafaa3c417ba5fb128b70d8a7e"
// ];
// $data = http_build_query($data);
// // echo $data;
// curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));

// //for debug only!
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// $resp = curl_exec($curl);
// curl_close($curl);
// var_dump ($resp);
