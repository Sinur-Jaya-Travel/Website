<?php

    require '../vendor/autoload.php';
    use MongoDB\Client;
    $client = new MongoDB\Client;

    $database = $client->sinurJayaTravel;

    $collection = $database->selectCollection("bus");

    $id = isset($_POST["id"]) ? $_POST["id"] : "";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bus</title>
</head>
<body>
    <h1>Update Bus</h1>
    <form action="updatebus.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="plat">Plat:</label>
        <input type="text" name="plat">
        <label for="jenis">Jenis:</label>
        <input type="text" name="jenis">
        <label for="kursi">Kursi:</label>
        <input type="number" name="kursi">
        <button type="submit">Update</button>
    </form>
</body>
</html>
