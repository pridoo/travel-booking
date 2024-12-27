<?php



require '../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookingId'])) {
    $bookingId = $_POST['bookingId'];

    $sql = "UPDATE booking SET Status = 'Approved' WHERE bookingID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);

    if ($stmt->execute()) {
        echo "Booking approved successfully.";
    } else {
        echo "Error updating booking status: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
