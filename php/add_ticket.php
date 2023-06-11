<?php
require '../vendor/autoload.php';

// Mengimport kelas ObjectId
use MongoDB\BSON\ObjectId;

// Mengatur koneksi ke MongoDB
$client = new MongoDB\Client;

// Mengakses database sinurJayaTravel
$database = $client->sinurJayaTravel;

// Mengakses collection tiket
$collectionTiket = $database->selectCollection("tiket");

// Menerima data tiket dari request POST
$tiketData = $_POST;

// Mengatur id tiket otomatis
$latestTicket = $collectionTiket->findOne([], ['sort' => ['_id' => -1]]);
$latestTicketId = $latestTicket ? $latestTicket['_id'] : 0;

// Mengubah inisialisasi ObjectId jika $latestTicketId adalah 0
$newTicketId = $latestTicketId != 0 ? new ObjectId((string) $latestTicketId) : new ObjectId();

// Menerima data tiket dari request POST
$tiketData = $_POST;

// Menghapus nilai '_id' dari data tiket
unset($tiketData['_id']);

// Mengonversi busId menjadi tipe data ObjectId
$tiketData['busId'] = new MongoDB\BSON\ObjectId($tiketData['busId']);

// Menambahkan data tiket ke koleksi tiket
$result = $collectionTiket->insertOne($tiketData);

// Mengecek data tiket yang terkirim
var_dump($tiketData);

// Mengembalikan respons
if ($result->getInsertedCount() === 1) {
    echo "Tiket berhasil ditambahkan.";
} else {
    echo "Terjadi kesalahan saat menambahkan tiket.";
}
?> 
