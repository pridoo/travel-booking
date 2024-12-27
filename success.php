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
                    <h1 class="mb-10">Thank You For Your Payment!</h1>
                    <p>Your payment has been successfully processed. Thank you for choosing TravelSphere. Please wait for the confirmation email regarding your booking details.</p>
                </div>
                <div class="text-center">
                    <a href="index.php" class="primary-btn mr-3">Home</a>
                    <a href="booking.php" class="primary-btn">Booking</a>
                </div>
            </div>
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