<?php

    require '../vendor/autoload.php';
    use MongoDB\Client;
    $client = new MongoDB\Client;

    $database = $client->sinurJayaTravel;

    $collection = $database->selectCollection("users");

    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $username = isset($_POST["username"]) ? $_POST["username"] : "";

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
    <form action="updateuser.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <label for="plat">Foto:</label>
        <input type="file" name="image" />
        <label for="plat">Nama:</label>
        <input type="text" name="name">
        <label for="kursi">Alamat:</label>
        <input type="text" name="address">
        <label for="kursi">Email:</label>
        <input type="text" name="email">
        <label for="kursi">Nomor Telepon:</label>
        <input type="text" name="number">
        <label for="kursi">Password Baru:</label>
        <input type="password" name="password">
        <button type="submit">Update</button>
    </form>
</body>
</html>