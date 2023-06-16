<?php
include "../php/connect.php";

$collectionName = "tiket";
$collectionNames = $database->listCollectionNames();
$collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
$collection = null;

if ($collectionExist) {
    $collection = $database->selectCollection($collectionName);
} else {
    $collection = $database->createCollection($collectionName);
}

$busid = $_POST["busid"];
$userid = $_POST["userid"];
$date = $_POST["date"];

$sumatra = array(
    "Aceh",
    "Sumatera Utara",
    "Sumatera Barat",
    "Riau",
    "Kepulauan Riau",
    "Jambi",
    "Sumatera Selatan",
    "Bangka Belitung",
    "Bengkulu",
    "Lampung"
);
$jawa = array(
    "DKI Jakarta",
    "Jawa Barat",
    "Jawa Tengah",
    "DI Yogyakarta",
    "Jawa Timur",
    "Banten"
);
$nusaTenggara = array(
    "Nusa Tenggara Barat",
    "Nusa Tenggara Timur"
);
$kalimantan = array(
    "Kalimantan Barat",
    "Kalimantan Tengah",
    "Kalimantan Selatan",
    "Kalimantan Timur",
    "Kalimantan Utara"
);
$sulawesi = array(
    "Sulawesi Utara",
    "Gorontalo",
    "Sulawesi Tengah",
    "Sulawesi Barat",
    "Sulawesi Selatan",
    "Sulawesi Tenggara"
);
$maluku = array(
    "Maluku",
    "Maluku Utara"
);
$papua = array(
    "Papua",
    "Papua Barat"
);

$price = 0;

$busCollection = $database->selectCollection("bus");

$tempid = $busid;
$busDocument = $busCollection->findOne(["id" => $tempid]);

if (!$busDocument) {
    echo "Bus not found.";
    exit();
}

$type = $busDocument['type'];
switch ($type) {
    case 'BIG':
        $price = 200000;
        break;
    case 'MEDIUM':
        $price = 100000;
        break;
    case 'MICRO':
        $price = 50000;
        break;
    default:
        $price = 0;
        break;
}

$Tujuan = isset($busDocument["Tujuan"]) ? $busDocument["Tujuan"] : "";

if (in_array($Tujuan, $jawa) || in_array($Tujuan, $nusaTenggara)) {
    $price *= 1.5;
} else if (in_array($Tujuan, $sumatra)) {
    $price *= 2;
} else if (in_array($Tujuan, $kalimantan)) {
    $price *= 3;
} else if (in_array($Tujuan, $sulawesi)) {
    $price *= 3.5;
} else if (in_array($Tujuan, $maluku) || in_array($Tujuan, $papua)) {
    $price *= 4;
}

$id = generateTiketId();

$query = [
    "id" => $id,
    "busid" => $busid,
    "userid" => $userid,
    "Tujuan" => $Tujuan,
    "date" => $date,
    "price" => $price
];

$document = $collection->insertOne($query);

if ($document) {
    header("Location: ../php/tiketsuccess.php?id=$userid");
    exit();
} else {
    echo "Something went wrong.";
}

function generateTiketId()
{
    $randomNumber = mt_rand(1, 99999999);
    $paddedNumber = str_pad($randomNumber, 8, '0', STR_PAD_LEFT);
    return "TKT" . $paddedNumber;
}
?>