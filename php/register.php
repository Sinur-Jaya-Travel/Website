<?php
require '../vendor/autoload.php';
use MongoDB\Client;

$client = new MongoDB\Client;
$database = $client->sinurJayaTravel;

$collectionName = "users";
$collectionNames = $database->listCollectionNames();
$collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
$collection = null;

if ($collectionExist) {
    $collection = $database->selectCollection($collectionName);
} else {
    $collection = $database->createCollection($collectionName);
}

$randomNumber = mt_rand(1, 99999);
$paddedNumber = str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
$id = "PNP" . $paddedNumber;
$name = $_POST["name"];
$address = $_POST["address"];
$email = $_POST["email"];
$number = $_POST["number"];
$username = $_POST["username"];
$password = $_POST["password"];

$hash = hash("sha256", $password);

$document = [
    "id" => $id,
    "name" => $name,
    "address" => $address,
    "number" => $number,
    "username" => $username,
    "password" => $hash
];

$result = $collection->insertOne($document);

if ($result) {
    include "../html/success.html";
} else {
    echo "Failed.";
}
?>