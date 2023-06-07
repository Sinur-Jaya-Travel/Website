<?php
    require '../vendor/autoload.php';
    use MongoDB\Client;
    $client = new MongoDB\Client;

    $database = $client->sinurJayaTravel;

    $collection = $database->selectCollection("bus");

    $id = $_POST["id"];
    $plat = $_POST["plat"];
    $jenis = $_POST["jenis"];
    $kursi = $_POST["kursi"];

    $filter = [ "id" => $id ];
    $update = [ '$set' => [
        "plat" => $plat,
        "jenis" => $jenis,
        "kursi" => $kursi
    ]];

    $result = $collection->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        echo "Update Success";
    } else {
        echo "Update Failed";
    }
?>