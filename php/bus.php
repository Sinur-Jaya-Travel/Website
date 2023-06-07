<?php
require '../vendor/autoload.php';
use MongoDB\Client;

$client = new MongoDB\Client;
$database = $client->sinurJayaTravel;

$collectionName = "bus";
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
$id = "BUS" . $paddedNumber;
$bus = $_POST["bus"];
$category = $_POST["category"];
$chair = intval($_POST["chair"]); // Convert $chair to an integer

$document = [
    "id" => $id,
    "plat" => $bus,
    "jenis" => $category,
    "kursi" => $chair
];

$result = $collection->insertOne($document);

if ($result) {
    header("Location: ../php/seebus.php");
    exit(); // It's a good practice to add an exit statement after redirecting
} else {
    echo "Failed.";
}
?>