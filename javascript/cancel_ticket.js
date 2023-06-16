function cancelTicket(ticketId) {
    if (confirm("Are you sure you want to cancel this ticket?")) {
        // Send an AJAX request to delete the ticket
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/cancel_ticket.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Ticket canceled successfully, refresh the page
                    location.reload();
                } else {
                    alert("Failed to cancel the ticket. Please try again later.");
                }
            }
        };
        xhr.send("ticketId=" + ticketId);
    }
}
