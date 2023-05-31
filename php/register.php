<?php
    require '../vendor/autoload.php';
    use MongoDB\Client;
    $client = new MongoDB\Client;

    $database = $client->sinurJayaTravel;
    // $databaseList = $client->listDatabases();
    // $databaseExists = false;
    // foreach ($databaseList as $databaseInfo) {
    //     if ($databaseInfo['name'] === $databaseName) {
    //         $databaseExists = true;
    //         break;
    //     }
    // }
    // $database = null;
    // if ($databaseExists) {
    //     $database = $client->selectDatabase($databaseName);
    // } else {
    //     $database = $client->use($databaseName);
    // }

    $collectionName = "penumpang";
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

    $hash = md5($password); //anjay pakai hashing wowkwwkowkok

    $document = [
        "id" => $id,
        "name" => $name,
        "address" => $address,
        "number" => $number,
        "username" => $username,
        "password" => $hash
    ];

    $result = $collection->insertOne($document);
?>