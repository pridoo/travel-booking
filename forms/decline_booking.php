<?php
require '../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookingId'])) {
    $bookingId = $_POST['bookingId'];

    
    $deletePaymentSql = "DELETE FROM payment WHERE bookingID = ?";
    $stmtPayment = $conn->prepare($deletePaymentSql);
    $stmtPayment->bind_param("i", $bookingId);

    if ($stmtPayment->execute()) {
       
        $deleteBookingSql = "DELETE FROM booking WHERE bookingID = ?";
        $stmtBooking = $conn->prepare($deleteBookingSql);
        $stmtBooking->bind_param("i", $bookingId);

        if ($stmtBooking->execute()) {
            echo "Booking deleted successfully.";
        } else {
            echo "Error deleting booking: " . $stmtBooking->error;
        }

        $stmtBooking->close();
    } else {
        echo "Error deleting payment records: " . $stmtPayment->error;
    }

    $stmtPayment->close();
}

$conn->close();
?>