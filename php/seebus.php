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
    <title>BUS</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>DAFTAR BUS</h1>
    <form action="../html/bus.html">
        <button type="submit">Insert</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Plat</th>
                <th>Jenis</th>
                <th>Kursi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
                <tr>
                    <td><?php echo $document["id"]; ?></td>
                    <td><?php echo $document["plat"]; ?></td>
                    <td><?php echo $document["jenis"]; ?></td>
                    <td><?php echo $document["kursi"]; ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                            <input type="hidden" name="delete" value="<?php echo $document["id"]; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>