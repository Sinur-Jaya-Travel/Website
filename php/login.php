<?php
    require '../vendor/autoload.php';
    use MongoDB\Client;

    $client = new MongoDB\Client;
    $database = $client->sinurJayaTravel;
    $collection = $database->selectCollection("users");

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
            header("Location: ../html/userindex.html?username=$username");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Username and password are required.";
    }
?>