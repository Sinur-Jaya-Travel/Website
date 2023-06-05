<?php
require '../vendor/autoload.php';
use MongoDB\Client;

$client = new MongoDB\Client;
$database = $client->sinurJayaTravel;
$collection = $database->selectCollection("users");

$result = null;

if (isset($_GET["username"]) && isset($_GET["password"])) {
    $username = $_GET["username"];
    $password = $_GET["password"];
    $hash = hash("sha256", $password);

    $query = [
        "username" => $username,
        "password" => $hash
    ];

    $result = $collection->findOne($query);

    if ($result) {
        echo $result;
        include "../html/userindex.html"; //nanti adminnya.
    } else {
        echo "Invalid username or password.";
    }
}


// require '../vendor/autoload.php';

// use MongoDB\Client;

// // Establishing connection to the MongoDB server
// $client = new MongoDB\Client;
// $database = $client->sinurJayaTravel;
// $collection = $database->users;

// if (isset($_GET["username"]) && isset($_GET["password"])) {
//     $username = $_GET["username"];
//     $password = $_GET["password"];
//     $hashedPassword = hash("sha256", $password);

//     $query = [
//         "username" => $username,
//         "password" => $hashedPassword
//     ];

//     // Retrieving a single matching document from the "users" collection
//     $result = $collection->findOne($query);
//     var_dump($result);

//     if ($result) {
//         include "../html/userindex.html";
//         exit(); // Terminate the script execution after including the file
//     }
// }

// Display error message for invalid username or password
// echo "Invalid username or password.";


?>