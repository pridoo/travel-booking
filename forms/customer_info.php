<?php
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the database connection file
include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Your SMTP username
        $mail->Password = 'your-email-password'; // Your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('your-email@gmail.com', 'Your Name'); // Sender email and name
        $mail->addAddress('admin@example.com'); // Admin's email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Customer Info Received';
        $mail->Body = "
            <h3>New Booking Details:</h3>
            <ul>
                <li>Name: $name</li>
                <li>Email: $email</li>
                <li>Address: $address</li>
                <li>Contact Number: $contact</li>
            </ul>
        ";

        // Send email
        $mail->send();

        // After sending email, insert data into the database
        $stmt = $conn->prepare("INSERT INTO customer (Name, Email, Phone, Address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $contact, $address);

        if ($stmt->execute()) {
            echo 'success'; // Return success response after successful insertion
            exit(); // Ensure script stops execution after redirection
        } else {
            echo 'Error inserting data into the database';
        }
        $stmt->close(); // Close prepared statement

    } catch (Exception $e) {
        echo 'Error sending email: ' . $mail->ErrorInfo; // Display error if email sending fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Info</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#customer').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                submitInfo(formData);
            });
        });

        function submitInfo(formData) {
            $.ajax({
                type: 'POST',
                url: '../forms/customer_info.php', // Your PHP script to handle form submission
                data: formData,
                success: function(response) {
                    // Show success message using SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Info Successful!',
                        text: 'Your information has been submitted successfully.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../forms/booking_form.php';
                            }
                        });
                    document.getElementById('customer').reset(); // Reset form fields
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.',
                    });
                }
            });
        }
    </script>
 <style>
        .hover-white:hover {
            color: white;
        }

        body {
            background-image: url('../img/banaue.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            margin-bottom: 5px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2 class="mt-3 card-header" style="text-align: center;">Customer Info</h2>
            <form id="customer" action="../forms/customer_info.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contact" class="form-label">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Proceed to Booking</button>
            </form>
        </div>
    </div>
</body>
</html>