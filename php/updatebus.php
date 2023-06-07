<?php
    require '../vendor/autoload.php';
    use MongoDB\Client;
    $client = new MongoDB\Client;

    $database = $client->sinurJayaTravel;

    $collection = $database->selectCollection("bus");

    // $id = $_GET["id"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST["id"];
        $plat = isset($_POST["plat"]) ? $_POST["plat"] : "";
        $jenis = isset($_POST["jenis"]) ? $_POST["jenis"] : "";
        $kursi = isset($_POST["kursi"]) ? intval($_POST["kursi"]) : 0;

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
    }
?>