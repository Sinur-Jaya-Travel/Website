<!-- rute.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Menu Rute</title>
    <style>
        /* CSS Styles */
        .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #6233fc;
        color: aliceblue;
        border: none;
        padding: 5px 10px;
        border-radius: 50%;
        cursor: pointer;
        font-family: "Roboto", sans-serif;
        text-decoration: none;
        }
    </style>
</head>
<body>
<a href="../html/index.html" class="close-button">&times;</a>
    <h1>Daftar Rute</h1>

<?php
require '../vendor/autoload.php';
use MongoDB\Client;

$client = new Client;
$database = $client->sinurJayaTravel;

$collectionName = "bus";
$collectionNames = $database->listCollectionNames();
$collectionExist = in_array($collectionName, iterator_to_array($collectionNames));
$collection = null;

if ($collectionExist) {
    $collection = $database->selectCollection($collectionName);
    $rute = $collection->find([]);

    // Menampilkan data rute
    foreach ($rute as $doc) {
        echo "<h2>ID Bis: " . $doc->id . "</h2>";
        echo "<p>Plat: " . $doc->plat . "</p>";
        echo "<p>Tujuan: " . $doc->Tujuan . "</p>";
        echo "<p>Berangkat: " . $doc->Berangkat . "</p>";
        echo "<p>Jadwal: " . $doc->Jadwal . "</p>";
        echo "<p>Jarak: " . $doc->Jarak . "</p>";
        echo "<p>Waktu: " . $doc->Waktu . "</p>";

        // Menampilkan peta statis berdasarkan lokasi tujuan
        $tujuan = $doc->Tujuan;
        $mapsUrl = "https://maps.google.com/maps?q=" . urlencode($tujuan) . "&t=&z=13&ie=UTF8&iwloc=&output=embed";
        echo "<iframe src=\"" . $mapsUrl . "\" width=\"100%\" height=\"400\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
 
        echo "<hr>";
    }
} else {
    echo "Koleksi 'bus' tidak ditemukan.";
}
?>

</body>
</html>