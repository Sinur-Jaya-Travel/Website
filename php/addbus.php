<?php
    include "../php/connect.php";

    $collectionName = "bus";
    $collectionNames = $database->listCollectionNames();
    $collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
    $collection = null;

    if ($collectionExist) {
        $collection = $database->selectCollection($collectionName);
    } else {
        $collection = $database->createCollection($collectionName);
    }

    $id = generateBusId();
    $image = $_FILES["image"];
    $plat = isset($_POST["plat"]) ? $_POST["plat"] : '';
    $type = isset($_POST["type"]) ? $_POST["type"] : '';
    $chair = isset($_POST["chair"]) ? intval($_POST["chair"]) : 0;
    $status = "active";
    $Tujuan = isset($_POST["Tujuan"]) ? $_POST["Tujuan"] : '';
    $Berangkat = isset($_POST["Berangkat"]) ? $_POST["Berangkat"] : '';
    $Jarak = isset($_POST["Jarak"]) ? $_POST["Jarak"] : '';
    $Jadwal = isset($_POST["Jadwal"]) ? $_POST["Jadwal"] : '';
    $Waktu = isset($_POST["Waktu"]) ? $_POST["Waktu"] : '';    

    $query = [
        "id" => $id,
        "plat" => $plat,
        "type" => $type,
        "chair" => $chair,
        "status" => $status,
        "Tujuan" => $Tujuan,
        "Berangkat" => $Berangkat,
        "Jarak" => $Jarak,
        "Jadwal" => $Jadwal,
        "Waktu" => $Waktu
    ];

    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $image = $_FILES["image"];
        $tempFilePath = $image["tmp_name"];
        $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $destinationPath = '../image/busprofile/' . $id . '.' . $extension;
        move_uploaded_file($tempFilePath, $destinationPath);
        $query['image'] = $destinationPath;
    }

    try {
        $document = $collection->insertOne($query);

        if ($document) {
            header("Location: ../php/listbus.php");
            exit();
        } else {
            echo "Something went wrong.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    function generateBusId() {
        $randomNumber = mt_rand(1, 99999999);
        $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
        return "BUS" . $paddedNumber;
    }
?>