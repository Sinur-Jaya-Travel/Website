<?php
require '../vendor/autoload.php';

// Mengimport kelas ObjectId
use MongoDB\BSON\ObjectId;

// Mengatur koneksi ke MongoDB
$client = new MongoDB\Client;

// Mengakses database sinurJayaTravel
$database = $client->sinurJayaTravel;

// Mengakses collection tiket dan bus
$collectionTiket = $database->selectCollection("tiket");
$collectionBus = $database->selectCollection("bus");

// Mendapatkan data bus dari koleksi bus
$busList = $collectionBus->find();

// Mengatur id tiket otomatis
$latestTicket = $collectionTiket->findOne([], ['sort' => ['_id' => -1]]);
$latestTicketId = $latestTicket ? $latestTicket['_id'] : 0;

?>

<style>
    .headings {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60px;
        padding: 5px;
        background-color: #6233fc;
        text-transform: capitalize;
        font-size: 40px;
    }

    .brand {
        background-image: url("../image/logo\ sinurjayatravel.png");
        background-repeat: no-repeat;
        background-size: contain; /* atau cover, tergantung preferensi */
        /* Tambahan: atur lebar dan tinggi jika diperlukan */
        width: 165px;
        height: 65px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
        margin-left: 20px;
    }

    .brand-text {
        color: aliceblue;
        font-family: "Lobster";
    }

    .container {
        display: flex;
        flex-wrap: wrap;
    }

    .tiket {
        width: 33.33%; /* Setiap kotak akan memenuhi 33.33% lebar container */
        padding: 20px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    .tiket img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .tiket p {
        margin: 0;
    }

    .tiket button {
        margin-top: 10px;
    }

    /* Tambahkan CSS untuk keterangan tiket */
    .keterangan {
        display: none;
        padding: 10px;
        margin-top: 10px;
        background-color: #f1f1f1;
    }

    /* CSS Styles */
    .close-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #6233fc;
        color: aliceblue;
        border: none;
        padding: 5px 20px;
        border-radius: 50%;
        cursor: pointer;
        font-family: "Roboto", sans-serif;
        text-decoration: none;
    }
</style>

<a href="../html/index.html" class="close-button">&times;</a>
<div class="headings">
    <div class="brand"></div>
</div>

<div class="container">
    <?php
    // Menampilkan tiket bus
    foreach ($busList as $bus) {
        $id = $bus["_id"];
        $gambar = "../image/tiket.jpg"; // Ubah ekstensi menjadi jpg
        $tujuan = $bus["Tujuan"]; // Gunakan huruf kapital (Tujuan)
        $jadwal = $bus["Jadwal"]; // Gunakan huruf kapital (Jadwal)

        // Menampilkan gambar tiket tujuan bus
        echo "<div class='tiket'>";
        echo "<img src='$gambar' alt='Tiket'>";
        echo "<p style='text-transform: capitalize;'>Tujuan: $tujuan</p>";
        echo "<p style='text-transform: capitalize;'>Jadwal: $jadwal</p>";
        echo "<button onclick='tampilkanKeterangan(\"$id\")'>Keterangan</button>";

        // Tambahkan elemen keterangan tiket
        echo "<div id='keterangan-$id' class='keterangan'>";
        echo "<p>ID: $id</p>";
        echo "<p>Plat: " . $bus["plat"] . "</p>";
        echo "<p>Jenis: " . $bus["jenis"] . "</p>";
        echo "<p>Kursi: " . $bus["kursi"] . "</p>";
        echo "<p>Tujuan: " . $bus["Tujuan"] . "</p>";
        echo "<p>Berangkat: " . $bus["Berangkat"] . "</p>";
        echo "<p>Jadwal: " . $bus["Jadwal"] . "</p>";
        echo "<p>Jarak: " . $bus["Jarak"] . "</p>";
        echo "<p>Waktu: " . $bus["Waktu"] . "</p>";
        echo "<button onclick='pesanTiket(\"$id\")'>Pesan</button>";
        echo "</div>";

        echo "</div>";
    }
    ?>
</div>

<a href="../php/riwayat_tiket.php" style="position: fixed; bottom: 20px; right: 20px; padding: 10px; background-color: #6233fc; color: #fff; text-decoration: none;">Riwayat Pemesanan Tiket</a>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function tampilkanKeterangan(id) {
        var keterangan = document.getElementById("keterangan-" + id);
        if (keterangan.style.display === "none") {
            keterangan.style.display = "block";
        } else {
            keterangan.style.display = "none";
        }
    }

    function pesanTiket(id) {
        // Mengatur data tiket
        var tiketData = {
            busId: id // ID bus
        };

        // Menambahkan data tiket ke koleksi tiket
        $.ajax({
            type: "POST",
            url: "add_ticket.php", // File PHP untuk menambahkan tiket
            data: tiketData,
            success: function (response) {
                console.log("Tiket berhasil ditambahkan: " + response);
                tampilkanNotifikasi("Tiket berhasil dipesan");
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
        }

        function tampilkanNotifikasi(message) {
            var notifikasi = document.createElement("div");
            notifikasi.className = "notifikasi";
            notifikasi.innerHTML = message;
            document.body.appendChild(notifikasi);
            setTimeout(function () {
                notifikasi.remove();
            }, 3000);
        }
    </script>
</body>
</html>

