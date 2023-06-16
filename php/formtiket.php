<?php
    include "../php/connect.php";
    $collection = $database->selectCollection("bus");
    $id = isset($_GET["busid"]) ? $_GET["busid"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/formtiket.css">
    <title>BELI TIKET</title>
</head>
<body>
    <div class="ticketform">
        <h1>PEMBELIAN TIKET</h1>
        <form action="../php/buytiket.php" method="POST">
            <input type="hidden" name="busid" value="<?= htmlspecialchars($id) ?>">
            <label for="userid">Masukkan User ID:</label>
            <input type="text" name="userid"/>
            </select>
            <label for="date">Tanggal Berangkat:</label>
            <input type="date" name="date" required>
            <button type="submit">Beli Tiket</button>
        </form>
        <a href="javascript:history.back()" class="button-cancel">BATAL</a>
    </div>
</body>
</html>