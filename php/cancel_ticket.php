<?php
include "../php/connect.php";

if (isset($_POST["ticketId"])) {
    $ticketId = $_POST["ticketId"];

    $collection = $database->selectCollection("tiket");

    $query = [
        "id" => $ticketId
    ];

    $result = $collection->deleteOne($query);

    if ($result->getDeletedCount() === 1) {
        // Ticket deleted successfully
        echo "success";
    } else {
        // Failed to delete the ticket
        echo "error";
    }
}
?>
