<?php

use Stripe\Stripe;

require "./vendor/autoload.php";

header("Content-Type", "application/json");

const stripeSK = 'SK_TEST_KEY';

\Stripe\Stripe::setApiKey(stripeSK);

$name = $_GET["name"];
$desc = $_GET["desc"];
$amount = $_GET["amount"];
$qty = $_GET["qty"];

$session = \Stripe\Checkout\Session::create([
  "success_url" => "http://localhost:8080/retrieveSession.php?sessionId={CHECKOUT_SESSION_ID}",
  "cancel_url" => "http://localhost:8080/cancel.html",
  "payment_method_types" => ['card', 'alipay'],
  "mode" => 'payment',
  "line_items" => [
    [
      "price_data" => [
        "currency" => "usd",
        "product_data" => [
          "name" => $name,
          "description" => $desc
        ],
        "unit_amount" => $amount
      ],
      "quantity" => $qty
    ],
  ]
]);

echo json_encode($session);
