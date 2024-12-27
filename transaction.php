<?php

require 'db/connection.php';

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$bookingID = $customerName = $packageName = $address = $paymentMethod = $departureDate = $amount = "";
$paymentMethod_err = "";
$success_message = "";

if (isset($_GET['packageID']) && filter_var($_GET['packageID'], FILTER_VALIDATE_INT)) {
    $packageID = $_GET['packageID'];

    $sql = "SELECT price FROM tourpackage WHERE packageID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $packageID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $amount = $row['price'];
            } else {
                exit('Error: Package not found.');
            }
        } else {
            exit('Error fetching data from tourpackage table.');
        }
    } else {
        exit('Error preparing SQL statement.');
    }
} else {
    exit('Invalid package ID provided.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["paymentMethod"])) {
        $paymentMethod = trim($_POST["paymentMethod"]);
    } else {
        $paymentMethod_err = "Please select the payment method.";
    }

    if (empty($paymentMethod_err)) {
        $bookingID = $_POST["bookingID"]; 

        $sqlInsertPayment = "INSERT INTO payment (bookingID, amount, paymentMethod) VALUES (?, ?, ?)";
        if ($stmtInsertPayment = $conn->prepare($sqlInsertPayment)) {
            $stmtInsertPayment->bind_param("ids", $bookingID, $amount, $paymentMethod);

            if ($stmtInsertPayment->execute()) {

                header("Location: success.php");
                exit();



            } else {
                echo "Error inserting payment data: " . $stmtInsertPayment->error;
            }
        } else {
            echo "Error preparing payment SQL statement: " . $conn->error;
        }
    }
}

$conn->close();
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
    <div class="col-lg-6 offset-lg-3 text-center"> <!-- Center the form -->
        <?php if (!empty($success_message)) : ?>
            <div><?php echo $success_message; ?></div>
        <?php else : ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?packageID=' . $packageID); ?>" method="post">
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="text" id="amount" name="amount" value="₱<?php echo $amount; ?>" readonly class="form-control">

                </div>
                <div class="form-group">
                    <label for="paymentMethod">Payment Method*:</label>
                    <select id="paymentMethod" name="paymentMethod" class="form-control">
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="Gcash">Gcash</option>
                    </select>
                    <span class="text-danger"><?php echo $paymentMethod_err; ?></span>
                </div>
                <div class="form-group" id="gcashNumberInput" style="display: none;">
                    <label for="gcashNumber">Gcash Number:</label>
                    <input type="tel" id="gcashNumber" name="gcashNumber" pattern="\d{11}" class="form-control">
                </div>
                <div class="form-group" id="cardNumberInput" style="display: none;">
                    <label for="cardNumber">Card Number:</label>
                    <input type="tel" id="cardNumber" name="cardNumber" pattern="\d{16}" class="form-control">
                </div>
                <input type="hidden" name="bookingID" value="<?php echo isset($_GET['bookingID']) ? $_GET['bookingID'] : ''; ?>">
                <div class="text-center">
                    <input type="submit" value="Submit" class="primary-btn">
                </div>
                
            </form>
        <?php endif; ?>
    </div>
</div>
</section>




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
    document.getElementById("paymentMethod").addEventListener("change", function() {
        var selectedValue = this.value;
        var gcashInput = document.getElementById("gcashNumberInput");
        var cardInput = document.getElementById("cardNumberInput");
        
        if (selectedValue === "Gcash") {
            gcashInput.style.display = "block";
            cardInput.style.display = "none";
        } else if (selectedValue === "Credit Card" || selectedValue === "Debit Card") {
            gcashInput.style.display = "none";
            cardInput.style.display = "block";
        } else {
            gcashInput.style.display = "none";
            cardInput.style.display = "none";
        }
    });
</script>


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
