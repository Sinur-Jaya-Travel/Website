<?php
    require '../vendor/autoload.php';
    use MongoDB\Client;

    $client = new MongoDB\Client;
    $database = $client->sinurJayaTravel;
    $collection = $database->selectCollection("users");

    $document = null;

    if (isset($_GET["username"])) {
        $username = $_GET["username"];

        $query = [
            "username" => $username
        ];

        $result = $collection->findOne($query);

        if ($result) {
            $document = $result;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFIL</title>
</head>
<body>
    <h1>Profil</h1>
    <?php if ($document): ?>
        <ul class="bus-list">
            <li>
                <span>ID: <?php echo $document["id"]; ?></span>
                <span>Nama: <?php echo $document["name"]; ?></span>
                <span>Username: <?php echo $document["username"]; ?></span>
                <span>Alamat: <?php echo $document["address"]; ?></span>
                <span>Nomor HP: <?php echo $document["number"]; ?></span>
                <span>Email: <?php echo $document["email"]; ?></span>

                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                    <input type="hidden" name="delete" value="<?php echo $document["id"]; ?>">
                    <button type="submit">Hapus Akun</button>
                </form>
                <form action="../php/getuser.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $document["id"]; ?>">
                    <button type="submit">Perbarui</button>
                </form>
            </li>
        </ul>
    <?php else: ?>
        <p>Data profil tidak ditemukan.</p>
    <?php endif; ?>
</body>
</html>