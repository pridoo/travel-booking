<?php

class SessionManager {
    public static function checkAdminSession() {
        session_start();
        if (!isset($_SESSION['userAdmin'])) {
            header("Location: ../login.php");
            exit();
        }
    }
}

SessionManager::checkAdminSession();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Dashboard</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .hover-white:hover {
            color: white;
        }
    </style>
</head>
<body class="sb-nav-fixed">

    <?php include 'navbar.php'; ?>

    <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tour Guides</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><a href="index.php" style="text-decoration: none;">Home</a> / Tour Guides</li>
                    </ol>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-table me-1"></i>
                                            Post/s
                                        </div>
                                        <div>
                                            <a href="tour_add.php" class="btn btn-primary">Add Tour Guide</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Image</th>
                                                    <th>Specialization</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../db/connection.php';

                                                class TourGuideManager {
                                                    private $connection;
                                                
                                                    public function __construct($database) {
                                                        $this->connection = $database->connect();
                                                    }
                                                
                                                    public function getTourGuides() {
                                                        $tourGuides = array();
                                                
                                                        $query = "SELECT * FROM tourguide";
                                                        $result = $this->connection->query($query);
                                                
                                                        if ($result && $result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                $tourGuides[] = $row;
                                                            }
                                                        }
                                                
                                                        return $tourGuides;
                                                    }
                                                }
                                                
                                                $database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
                                                $tourGuideManager = new TourGuideManager($database);
                                                $tourGuides = $tourGuideManager->getTourGuides();
                                                
                                                $tourGuideCount = 0;
                                                
                                                if (count($tourGuides) > 0) {
                                                    foreach ($tourGuides as $tourGuide) {
                                                        echo "<tr>";
                                                        echo "<td>" . ++$tourGuideCount . "</td>";
                                                        echo "<td>{$tourGuide['name']}</td>";
                                                        echo "<td>{$tourGuide['email']}</td>";
                                                        echo "<td>{$tourGuide['phone']}</td>";
                                                        echo "<td><img src='../img/{$tourGuide['image']}' alt='Image' style='max-width: 100px; max-height: 100px; width: auto; height: auto;'></td>";
                                                        echo "<td>{$tourGuide['specialization']}</td>";
                                                        echo "<td>
                                                                <a href='tour_update.php?id={$tourGuide['guideID']}' class='btn btn-success' style='width: 85px;'>Update</a>
                                                                <button class='btn btn-danger delete-btn' style='width: 85px;' data-tourguide-id='{$tourGuide['guideID']}'>Delete</button>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No tour guides found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php
                include 'footer.php';
            ?>

        </div>
    </div>

        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Tour Guide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this tour guide?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
    </div>
    
<script src="js/scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>


$(document).ready(function() {
        $('#dataTable').DataTable({
            paging: true,
            searching: true,
        });
    });

    $(document).ready(function() {
        $('.update-btn').click(function() {
            var postId = $(this).data('post-id');
            window.location.href = 'post_update.php?id=' + postId;
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const tourGuideId = this.dataset.tourguideId; 
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.dataset.tourguideId = tourGuideId;
        $('#deleteConfirmationModal').modal('show');
    });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    const tourGuideId = this.dataset.tourguideId;
    window.location.href = 'tour_delete.php?id=' + tourGuideId; 
});
</script>

</body>
</html>


