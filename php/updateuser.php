<?php
    require '../vendor/autoload.php';
    use MongoDB\Client;

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->sinurJayaTravel;
    $collection = $database->users;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $gambar = $_FILES["image"];
        $nama = isset($_POST["name"]) ? $_POST["name"] : "";
        $alamat = isset($_POST["address"]) ? $_POST["address"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $nomor = isset($_POST["number"]) ? $_POST["number"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $hash = hash("sha256", $password);

        $filter = [ "id" => $id ];
        $update = [
            '$set' => [
                "profile" => $gambar,
                "name" => $nama,
                "address" => $alamat,
                "email" => $email,
                "number" => $nomor,
                "username" => $username,
                "password" => $hash 
            ]
        ];

        $result = $collection->updateOne($filter, $update);

        if ($result->getModifiedCount() > 0) {
            header("Location: user.php?username=$username");
            exit();
        } else {
            echo "Update Failed";
        }
    }
?>