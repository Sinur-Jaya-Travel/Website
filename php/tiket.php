<?php
include "../php/connect.php";

$userCollection = $database->selectCollection("users");

$userDocument = null;

if (isset($_GET["username"])) {
    $username = $_GET["username"];

    $query = [
        "username" => $username
    ];

    $userDocument = $userCollection->findOne($query);
}

$userid = $userDocument["id"];

$collection = $database->selectCollection("tiket");
$documents = $collection->find(["userid" => $userid]);

$busCollection = $database->selectCollection("bus");

// Function to update the departure date of a ticket
function updateTicketDate($ticketId, $newDate) {
    global $collection;

    $query = [
        "id" => $ticketId
    ];

    $updateData = [
        '$set' => [
            "date" => $newDate
        ]
    ];

    $updateResult = $collection->updateOne($query, $updateData);

    if ($updateResult->getModifiedCount() > 0) {
        echo "Ticket date updated successfully.";
    } else {
        echo "Failed to update ticket date.";
    }
}

// Handle ticket date update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["ticketId"]) && isset($_POST["newDate"])) {
        $ticketId = $_POST["ticketId"];
        $newDate = $_POST["newDate"];

        // Check if the date format is correct (YYYY-MM-DD)
        if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $newDate)) {
            updateTicketDate($ticketId, $newDate);
        } else {
            echo "Format Tanggal Keberangkatan Salah. Silahkan Masukkan Ulang.";
        }
    } else if (isset($_POST["showAll"])) {
        $documents = $collection->find(["userid" => $userid]);
    }
}

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["search"])) {
        $searchTerm = $_POST["search"];
        $documents = $collection->find([
            "userid" => $userid,
            "Tujuan" => ['$regex' => $searchTerm, '$options' => 'i']
        ]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/tiket.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Tiket User</title>
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
                    <li><a id="userMain" href="../php/userindex.php">beranda</a></li>
                    <li><a id="userLink" href="../php/user.php">akun</a></li>
                    <li><a id="userBus" href="../php/bus.php">bus</a></li>
                    <li><a id="userRute" href="../php/rute.php">rute</a></li>
                    <li><a id="userTikets" href="../php/tiket.php">tiket</a></li>
                </ul>
            </nav>
        </div>
        <div class="tiketnya">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?username=' . $username; ?>">
                <label for="search">Cari Tiket:</label>
                <input type="text" id="search" name="search">
                <button type="submit">Cari</button>
            </form>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?username=' . $username; ?>">
                <button type="submit" name="showAll">Tampilkan Semua Tiket</button>
            </form>
            <ul class="tiketlist">
                <?php foreach ($documents as $document): ?>
                    <?php
                    $busId = $document["busid"];
                    $busQuery = ["id" => $busId];
                    $busDocument = $busCollection->findOne($busQuery);
                    $Tujuan = "";
                    if ($busDocument !== null && isset($busDocument["Tujuan"])) {
                        $Tujuan = $busDocument["Tujuan"];
                    }
                    ?>
                    <li>
                        <img class="tiket-image" src="../image/tiket.png" alt="tiket bang"/>
                        <span>ID: <?php echo $document["id"]; ?></span><br>
                        <span>ID Bus: <?php echo $document["busid"]; ?></span><br>
                        <span>Tujuan: <?php echo $Tujuan; ?></span><br>
                        <span>Tanggal Keberangkatan: <?php echo $document["date"]; ?></span><br>
                        <span>Total Harga: <?php echo $document["price"]; ?></span>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?username=' . $username; ?>">
                            <input type="hidden" name="ticketId" value="<?php echo $document["id"]; ?>">
                            <label for="newDate">Update Date:</label>
                            <input type="date" id="newDate" name="newDate" required>
                            <button type="submit">Update</button>
                        </form>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?username=' . $username; ?>">
                            <input type="hidden" name="ticketId" value="<?php echo $document["id"]; ?>">
                            <button onclick="cancelTicket('<?php echo $document["id"]; ?>')">Batalkan Pesanan Tiket</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="../javascript/button.js"></script>
    <script src="../javascript/cancel_ticket.js"></script>
</body>
</html>









