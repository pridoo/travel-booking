<?php

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ('db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	
	if (isset($_GET['email'])) {
	    $email = $_GET['email'];
   
	   
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
		 $mail->addAddress($email); 
   
		
		 $mail->isHTML(true);
		 $mail->Subject = 'Subscription Confirmation';
		 $mail->Body = 'Thank you for subscribing to our newsletter!';
   
		
		 $mail->send();

		
	    } catch (Exception $e) {
		 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	    }
	} else {
	   
	}
   } else {
	
	echo 'Invalid request method';
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



   			

			<div class="text-center">
    <section class="destinations-area section-gap">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-40 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Popular Destinations</h1>
                        <p>Uncover the charm of the World's most sought-after destinations. Immerse yourself in the beauty of iconic landmarks, hidden gems, and captivating landscapes that have made these locations favorites among travelers from around the world.</p>
                    </div>
                </div>
            </div>			

            <div class="row justify-content-center">
                <?php
                $sql = "SELECT * FROM tourpackage";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
                       
                	?>
                        <div class="col-lg-4">
                            <div class="single-destinations">
                                <div class="thumb">
				    <img src="img/<?php echo $row["image"]; ?>" alt="PackageIMG" width="100" height="200">

                                </div>
                                <div class="details">
                                    <h4><?php echo $row["name"]; ?></h4>
                                    <ul class="package-list">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Duration</span>
                                            <span><?php echo $row["duration"]; ?> Days</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Airport</span>
                                            <span><?php echo $row["airport"]; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Extras</span>
                                            <span><?php echo $row["extras"]; ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span>Price Per Person</span>
                                            <a href="booking_form.php?packageID=<?php echo $row["packageID"]; ?>" class="price-btn">₱<?php echo $row["price"]; ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
        </div>
    </section>


		</div>
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