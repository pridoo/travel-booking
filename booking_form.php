<?php
require 'db/connection.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['packageID']) && filter_var($_POST['packageID'], FILTER_VALIDATE_INT)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $departure = $_POST['departure'];
        $tourguideID = $_POST['tourguide']; 

        $packageID = $_POST['packageID']; 
        $durationSql = "SELECT duration, name FROM tourpackage WHERE packageID = ?";
        $stmt = $conn->prepare($durationSql);
        $stmt->bind_param("i", $packageID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $duration = $row['duration']; 
            $packageName = $row['name'];

            $numberOfDays = intval($duration);

            $departureDateTime = new DateTime($departure);
            $returnDateTime = clone $departureDateTime;
            $returnDateTime->modify('+' . $numberOfDays . ' days');
            $returnDateTime->setTime(12, 0, 0);
            $returnDate = $returnDateTime->format('Y-m-d');

            $customerSql = "INSERT INTO customer (name, email, phone, address) VALUES (?, ?, ?, ?)";
            $stmtCustomer = $conn->prepare($customerSql);
            $stmtCustomer->bind_param("ssss", $name, $email, $contact, $address);

            if ($stmtCustomer->execute()) {
                $customerId = $conn->insert_id; 
           
                $bookingSql = "INSERT INTO booking (customerID, packageID, departureDate, returnDate, guideID, Status) VALUES (?, ?, ?, ?, ?, 'Pending')";
                $stmtBooking = $conn->prepare($bookingSql);
                $stmtBooking->bind_param("iissi", $customerId, $packageID, $departure, $returnDate, $tourguideID);

                if ($stmtBooking->execute()) {
                    $bookingID = $conn->insert_id; 

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; 
                        $mail->SMTPAuth = true;
                        $mail->Username = 'quiban.phillip@clsu2.edu.ph';
                        $mail->Password = 'llub jhuz cwje ppcd'; 
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('travel@sphere.com', 'TravelSphere');
                        $mail->addAddress($email, $name); 

                        $mail->isHTML(true);
                        $mail->Subject = 'Booking Details';
                        $mail->Body    = 'Dear ' . $name . ',<br><br>Your booking details:<br>Package Name: ' . $packageName . '<br>Departure Date: ' . $departure . '<br>Return Date: ' . $returnDate . '<br>Email: ' . $email . '<br>Contact: ' . $contact . '<br><br>Thank you for booking with us. Please wait for the confirmation of your booking.';

                        $mail->send();
                        echo 'Email sent successfully.';
                    } catch (Exception $e) {
                        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    
                    echo '<script>window.location.href = "transaction.php?packageID=' . $packageID . '&bookingID=' . $bookingID . '";</script>';
                    exit(); 
                } else {
                    echo 'Error inserting data into the booking table: ' . $stmtBooking->error;
                }
            } else {
                echo 'Error inserting data into the customer table: ' . $stmtCustomer->error;
            }
        } else {
            echo 'Error: Package duration not found.';
            exit(); 
        }
    } else {
        echo 'Invalid package ID provided.';
    }
}
?>








<!DOCTYPE html>
	<html lang="eng" class="no-js">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta charset="UTF-8">
		
		<title>Booking | TravelSphere</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
		<link rel="stylesheet" href="css/linearicons.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/magnific-popup.css">
		<link rel="stylesheet" href="css/jquery-ui.css">				
		<link rel="stylesheet" href="css/nice-select.css">							
		<link rel="stylesheet" href="css/animate.min.css">
		<link rel="stylesheet" href="css/owl.carousel.css">				
		<link rel="stylesheet" href="css/main.css">

		</head>

		<body>	

		<?php
		 include 'header.php';

		$header = new Header();
		$header->render();
		?>


<section class="about-banner relative">
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
									Booking			
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="booking.php">Booking</a></p>
						</div>	
					</div>
				</div>
			</section>


            <section class="other-issue-area section-gap">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-10 col-lg-9">
                <div class="title text-center">
                    <h1 class="mb-10">Input Details</h1>
                    <p>Please fill out the form below with your details. Make sure to provide accurate information to ensure a smooth booking process. Fields marked with an asterisk (*) are required.</p>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form id="bookingForm" action="" method="post">
                    <div class="form-group">
                        <label for="name">Name <span>*</span>:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address <span>*</span>:</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span>*</span>:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact Number <span>*</span>:</label>
                        <input type="tel" id="contact" name="contact" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tourguide">Tour Guide<span>*</span>:</label>
                        <select id="tourguide" name="tourguide" class="form-control" required>
                            <option value="">Select Tour Guide</option>
                            <?php
                            $sql = "SELECT guideID, name FROM tourguide";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["guideID"] . "'>" . $row["name"] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No tour guides available</option>";
                            }
                            ?>
                        </select>
                    </div>



                    <div class="form-group">
                        <label for="departure">Departure Date <span>*</span>:</label>
                        <input type="datetime-local" id="departure" name="departure" class="form-control" required>
                    </div>

                    
                    <input type="hidden" id="packageID" name="packageID" value="<?php echo $_GET['packageID']; ?>">


                    <div class="text-center">
                        <button type="submit" class="primary-btn mt-3">Submit</button>
                    </div>

                    <div class="text-center">
    <a href="booking.php" class="primary-btn mt-3">Back</a>
</div>
                </form>
            </div>
        </div>
    </div>
</section>


    <div id="message"></div>
    <script>
    function submitFormWithPackageID() {
        
        const urlParams = new URLSearchParams(window.location.search);
        const packageID = urlParams.get('packageID');

      
        document.getElementById('packageID').value = packageID;

      
        document.getElementById('bookingForm').submit();
    }
</script>


<section class="home-about-area">
				<div class="container-fluid">
					<div class="row align-items-center justify-content-end">
						<div class="col-lg-6 col-md-12 home-about-left">
							<h1>
								Did not find your package? <br>
								Don't hesitate to reach out. <br>
								We'll tailor it just for you!
							</h1>
							<p style="text-align: justify;">
								Our dedicated team is here to customize a package that aligns perfectly with your preferences and desires, ensuring a personalized and unforgettable travel experience.
							</p>
							<a href="contact.php" class="primary-btn text-uppercase">Contact Us</a>
						</div>
						<div class="col-lg-6 col-md-12 home-about-right no-padding">
							<img class="img-fluid" src="img/back.jpg" alt="">
						</div>
					</div>
				</div>	
			</section>

			<?php

include 'footer.php';

$footer = new Footer();
$footer->render();

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>

class FormSubmitter {
    constructor(formSelector, messageSelector) {
        this.form = $(formSelector);
        this.message = $(messageSelector);
        this.bindEvents();
    }

    bindEvents() {
        const self = this;
        this.form.submit(function(e) {
            e.preventDefault(); 
            const formData = $(this).serialize();
            self.submitForm(formData);
        });
    }

    submitForm(formData) {
        $.ajax({
            type: 'GET', 
            url: '', 
            data: formData,
            success: this.handleSuccess.bind(this),
            error: this.handleError.bind(this)
        });
    }

    handleSuccess(response) {
        this.message.html('Email submitted successfully.');
    }

    handleError(xhr, status, error) {
        this.message.html('Error occurred while submitting the form.');
    }
}

$(document).ready(function() {
    const formSubmitter = new FormSubmitter('#emailForm', '#message');
});

</script>

<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="js/vendor/bootstrap.min.js"></script>			
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>						
<script src="js/easing.min.js"></script>			
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.min.js"></script>	
<script src="js/jquery.magnific-popup.min.js"></script>										
<script src="js/owl.carousel.min.js"></script>							
<script src="js/main.js"></script>	

</body>
</html>

