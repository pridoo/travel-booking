<?php
require '../db/connection.php';

class TourGuideManager {
    private $connection;

    public function __construct($database) {
        $this->connection = $database->connect();
    }

    public function deleteTourGuide($tourguide_id) {
        $stmt = $this->connection->prepare("DELETE FROM tourguide WHERE guideID = ?");
        $stmt->bind_param("i", $tourguide_id);

        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
}

$tourGuideManager = new TourGuideManager($database);

$tourguide_id = $_GET['id'] ?? NULL;

if($tourguide_id == NULL){
    header('Location: tour_index.php');
    exit();
}

if ($tourGuideManager->deleteTourGuide($tourguide_id)) {
    echo "<script>alert('The tour guide has been successfully deleted.'); window.location.href = 'tour_index.php';</script>";
    exit();
} else {

}
?>
