<!-- rute.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Menu Rute</title>
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
            margin-bottom: 20px;
        }

        .brand {
            background-image: url("../image/logo\ sinurjayatravel.png");
            background-repeat: no-repeat;
            background-size: contain;
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
            justify-content: flex-start;
        }

        .rute-card {
            width: 400px;
            margin: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .rute-card h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .rute-card p {
            margin: 5px 0;
        }

        .map-container {
            width: 100%;
            height: 400px;
            margin-top: 10px;
        }

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
    <div class="headings">
        <div class="brand"></div>
    </div>

    <h1 style="text-align: center;">Daftar Rute</h1>

    <div class="container">
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
                echo "<div class='rute-card'>";
                echo "<h2>ID Bis: " . $doc->id . "</h2>";
                echo "<p><strong>Plat:</strong> " . $doc->plat . "</p>";
                echo "<p><strong>Tujuan:</strong> " . $doc->Tujuan . "</p>";
                echo "<p><strong>Berangkat:</strong> " . $doc->Berangkat . "</p>";
                echo "<p><strong>Jarak:</strong> " . $doc->Jarak . "</p>";
                echo "<p><strong>Jadwal:</strong> " . $doc->Jadwal . "</p>";
                echo "<p><strong>Waktu:</strong> " . $doc->Waktu . "</p>";
                echo "<div class='map-container'>";
                $tujuan = $doc->Tujuan;
                $mapsUrl = "https://maps.google.com/maps?q=" . urlencode($tujuan) . "&t=&z=13&ie=UTF8&iwloc=&output=embed";
                echo "<iframe src=\"" . $mapsUrl . "\" width=\"100%\" height=\"100%\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Koleksi 'bus' tidak ditemukan.";
        }
        ?>
    </div>
</body>
</html>

