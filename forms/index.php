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
require '../db/connection.php';

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
                <h1 class="mt-4">Bookings</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="index.php" style="text-decoration: none;">Home</a></li>
                </ol>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-table me-1"></i>
                                        Booking/s
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-body">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Package Name</th>
                    <th>Booking Date</th>
                    <th>Departure Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
           
$sql = "SELECT b.bookingID,  c.name AS customerName, c.email AS customerEmail, b.packageID, b.bookingDate, b.departureDate, b.returnDate, b.Status, t.name AS packageName 
        FROM booking b 
        INNER JOIN customer c ON b.customerID = c.customerID
        INNER JOIN tourpackage t ON b.packageID = t.packageID";

$result = $conn->query($sql);

$count = 1; 

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $count ?></td>
            <td><?php echo $row['bookingID']; ?></td>
            <td><?php echo $row['customerName']; ?></td>
            <td><?php echo $row['customerEmail']; ?></td>
            <td><?php echo $row['packageName']; ?></td> 
            <td><?php echo date('F j, Y', strtotime($row['bookingDate'])); ?></td>
            <td><?php echo date('F j, Y', strtotime($row['departureDate'])); ?></td>
            <td><?php echo date('F j, Y', strtotime($row['returnDate'])); ?></td>
            <td><?php echo $row['Status']; ?></td>
            <td>
                <div class="btn-group" role="group" aria-label="Booking Actions">
                    <button type="button" class="btn btn-success approve-btn" data-booking-id="<?php echo $row['bookingID']; ?>">Update</button>
                    <button type="button" class="btn btn-danger reject-btn" data-booking-id="<?php echo $row['bookingID']; ?>">Reject</button>
                </div>
            </td>
        </tr>
        <?php
        $count++; 
    }
} else {
    echo "<tr><td colspan='8'>No bookings found.</td></tr>";
}
?>

            </tbody>
        </table>
    </div>
</div>


    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
                                $(document).ready(function() {
                                    
                                    $('.approve-btn, .reject-btn').click(function() {
                                       
                                        var bookingId = $(this).data('booking-id');
                                        
                                        var action = $(this).hasClass('approve-btn') ? 'approve_booking.php' : 'decline_booking.php';
                                        
                                        if (confirm("Are you sure you want to proceed?")) {
                                            
                                            $.ajax({
                                                type: 'POST',
                                                url: action,
                                                data: { bookingId: bookingId },
                                                success: function(response) {
                                                    alert(response); 
                                                    location.reload(); 
                                                },
                                                error: function(xhr, status, error) {
                                                    alert('Error: ' + error); 
                                                }
                                            });



                                            
                                        } else {
                                            return false;
                                        }
                                    });
                                });

                                $(document).ready(function() {
                                    $('#dataTable').DataTable({
                                        paging: true,
                                        searching: true,
                                    });
                                });
                            </script>
    
</body>
</html>