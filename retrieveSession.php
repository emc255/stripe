<?php

//save to database 

require "./vendor/autoload.php";
include_once './config/Database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$db = new Database();
$conn = $db->getConnection();
$dbname = "stripe";
$collection = 'invoice';

const stripeSK = 'SK_TEST_KEY';

$stripe = new \Stripe\StripeClient(stripeSK);
$sessionId = $_GET["sessionId"];
$checkoutSession = $stripe->checkout->sessions->retrieve($sessionId);
$data = [
  'name' => $checkoutSession->customer_details->name,
  'email' => $checkoutSession->customer_details->email,
  'amount_total' => $checkoutSession->amount_total
];

$insert = new MongoDB\Driver\BulkWrite();
$insert->insert($data);
$result = $conn->executeBulkWrite("$dbname.$collection", $insert);

echo json_encode($checkoutSession);
