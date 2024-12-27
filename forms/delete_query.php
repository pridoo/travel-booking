<?php
require_once '../db/connection.php';

class DeleteInquiry {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteRecord($inquiry_id) {
        $sql = "DELETE FROM inquiries WHERE inquiry_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $inquiry_id);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                return false;
            }
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $inquiry_id = intval($_GET['id']);
    $deleteInquiry = new DeleteInquiry($conn);

    if ($deleteInquiry->deleteRecord($inquiry_id)) {
        
        echo "<script>alert('The inquiry has been deleted successfully.');</script>";
        echo "<script>window.location.href = 'inquiries.php';</script>";
        exit();
    } else {
        header("Location: inquiries.php?error=deletion_failed");
        exit();
    }
} else {
    header("Location: inquiries.php?error=invalid_id");
    exit();
}
?>
