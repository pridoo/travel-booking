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
                <h1 class="mt-4">Inquiries</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="index.php" style="text-decoration: none;">Home</a> / Inquiries</li>
                </ol>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-table me-1"></i>
                                            Concern/s
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    require '../db/connection.php';

                                    class Details extends Database {
                                        public function getDetails() {
                                            $sql = "SELECT * FROM inquiries";
                                            $result = $this->connect()->query($sql); 
                                            $details = array();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $details[] = $row;
                                                }
                                            }
                                            return $details;
                                        }
                                        
                                    }

                                    $detailsObj = new Details(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
                                    $details = $detailsObj->getDetails();
                            ?>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Date & Time</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($details as $detail) {
                                                    echo "<tr>";
                                                    echo "<td>$count</td>";
                                                    echo "<td>{$detail['name']}</td>";
                                                    echo "<td>{$detail['email']}</td>";
                                                    echo "<td>" . date("F j, Y | g:i:s A", strtotime($detail['date'])) . "</td>";
                                                    echo "<td>{$detail['subject']}</td>";
                                                    echo "<td style='width: 300px;'>" . substr($detail['message'], 0, 150);
                                                    if (strlen($detail['message']) > 150) {
                                                        echo "...";
                                                    }
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<button class='btn btn-info view-btn' style='width: 80px; margin-right: 5px; color: white;' data-id='{$detail['inquiry_id']}'>View</button>";
                                                    echo "<button class='btn btn-danger delete-btn' style='width: 80px;' data-id='{$detail['inquiry_id']}'>Delete</button>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    $count++;
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
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this post?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="messageModalBody">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const messageId = this.dataset.id;
                const message = <?php echo json_encode($details); ?>.find(detail => detail.inquiry_id === messageId);
                if (message) {
                    const messageModalBody = document.getElementById('messageModalBody');
                    messageModalBody.innerHTML = `
                        <p>${message.message}</p>
                    `;
                    $('#messageModal').modal('show');
                } else {
                    alert('Message details not found.');
                }
            });
        });
    </script>

    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>


    <?php
    class DataTableManager {
        private $tableName;
        private $deleteScript;

        public function __construct($tableName, $deleteScript) {
            $this->tableName = $tableName;
            $this->deleteScript = $deleteScript;
        }

        public function initializeDataTable() {
            echo "
            <script>
                $(document).ready(function() {
                    $('#{$this->tableName}').DataTable({
                        paging: true,
                        searching: true,
                    });
                });
            </script>
            ";
        }

        public function initializeDeleteButtons() {
            echo "
            <script>
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const postId = this.dataset.id;
                        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                        confirmDeleteBtn.dataset.postId = postId;
                        $('#deleteConfirmationModal').modal('show');
                    });
                });

                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    window.location.href = '{$this->deleteScript}?id=' + postId;
                });
            </script>
            ";
        }
        
    }

    $dataTableManager = new DataTableManager('dataTable', 'delete_query.php');
    $dataTableManager->initializeDataTable();
    $dataTableManager->initializeDeleteButtons();

    ?>


</body>
</html>


