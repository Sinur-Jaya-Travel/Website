<?php
require '../vendor/autoload.php';
use MongoDB\Client;

$client = new MongoDB\Client;
$database = $client->sinurJayaTravel;

$collectionName = "bus";
$collection = $database->selectCollection($collectionName);

$documents = $collection->find();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idToDelete = $_POST["delete"];
    $collection->deleteOne(["id" => $idToDelete]);
    header("Location: seebus.php"); // Redirect to the same page after deletion
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/bus.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>BUS</title>
</head>
<body>
    <div class="container">
        <div class="headings">
            <div class="brand">
                <span class="brand-text">sinur jaya travel</span>
                <span class="menu" onclick="openBtn()"><i class="fas fa-bars"></i></span>
            </div>
        </div>
        <div class="rightmenu" id="rightMenu">
            <a href="#" class="button" onclick="closeBtn()">x</a>
            <nav class="navigations">
                <ul>
                    <li><a href="../html/index.html">beranda</a></li>
                    <li><a href="../html/login.html">akun</a></li>
                    <li><a href="seebus.php">bus</a></li>
                    <li><a href="../html/rute.html">rute</a></li>
                    <li><a href="#">tiket</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <script src="../javascript/button.js"></script>
    <h1>DAFTAR BUS</h1>
    <form action="../html/bus.html">
        <button type="submit">Insert</button>
    </form>
    <ul class="bus-list">
        <?php foreach ($documents as $document): ?>
            <li>
                <span>ID: <?php echo $document["id"]; ?></span>
                <span>Plat: <?php echo $document["plat"]; ?></span>
                <span>Jenis: <?php echo $document["jenis"]; ?></span>
                <span>Kursi: <?php echo $document["kursi"]; ?></span>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                    <input type="hidden" name="delete" value="<?php echo $document["id"]; ?>">
                    <button type="submit">Delete</button>
                </form>
                <form action="../html/updatebus.html" method="POST">
                    <input type="hidden" name="id" value="<?php echo $document["id"]; ?>">
                    <button type="submit">Update</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>