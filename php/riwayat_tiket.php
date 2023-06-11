<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pemesanan Tiket</title>
</head>
<body>
    <h1>Riwayat Pemesanan Tiket</h1>

    <?php
    require '../vendor/autoload.php';

    // Mengatur koneksi ke MongoDB
    $client = new MongoDB\Client;

    // Mengakses database sinurJayaTravel
    $database = $client->sinurJayaTravel;

    // Mengakses collection tiket dan bus
    $collectionTiket = $database->selectCollection("tiket");
    $collectionBus = $database->selectCollection("bus");

    // Mendapatkan data tiket dari koleksi tiket
    $riwayatTiket = $collectionTiket->find();

    // Menampilkan riwayat pemesanan tiket
    foreach ($riwayatTiket as $tiket) {
        $idTiket = $tiket["_id"];
        $idBus = $tiket["busId"];

        // Mendapatkan data bus berdasarkan id bus
        $bus = $collectionBus->findOne(["_id" => $idBus]);

        if ($bus) {
            $plat = $bus["plat"];
            $jenis = $bus["jenis"];
            $kursi = $bus["kursi"];
            $tujuan = $bus["Tujuan"];
            $berangkat = $bus["Berangkat"];
            $jadwal = $bus["Jadwal"];
            $jarak = $bus["Jarak"];
            $waktu = $bus["Waktu"];

            echo "<h3>ID Tiket: $idTiket</h3>";
            echo "<p>Plat: $plat</p>";
            echo "<p>Jenis: $jenis</p>";
            echo "<p>Kursi: $kursi</p>";
            echo "<p>Tujuan: $tujuan</p>";
            echo "<p>Berangkat: $berangkat</p>";
            echo "<p>Jadwal: $jadwal</p>";
            echo "<p>Jarak: $jarak</p>";
            echo "<p>Waktu: $waktu</p>";
            echo "<hr>";
        }
    }
    ?>

</body>
</html>