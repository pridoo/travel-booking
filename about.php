<?php

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('db/connection.php');

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
		
<title>About Us | TravelSphere</title>

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
								About Us				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="about.php"> About Us</a></p>
						</div>	
					</div>
				</div>
			</section>

			
			<section class="about-info-area section-gap">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-6 info-left">
							<img class="img-fluid" src="img/about.jpg" alt="">
						</div>
						<div class="col-lg-6 info-right" style="text-align: justify;">
							<h6>About Us</h6>
							<h1>Who We Are?</h1>
							<p>
								At TravelSphere, we are a team of passionate individuals driven by a shared love for exploration and adventure. With a collective commitment to providing unparalleled travel experiences, we strive to be your trusted companion on the journey of discovering the world's wonders. Join us as we weave together stories of unforgettable journeys and create memories that last a lifetime.
							</p>
						</div>
					</div>
				</div>	
			</section>

			<section class="about-info-area section-gap">
				<div class="container">
					<div class="row align-items-center">
					<div class="col-lg-6 info-left" style="text-align: justify;">
						<h6>About Us</h6>
						<h1>What We Do?</h1>
						<p>
						TravelSphere specializes in curating unforgettable travel experiences for adventurers seeking to explore the world's wonders. Whether it's embarking on a breathtaking trek through rugged mountain trails, immersing in vibrant cultural festivals, or indulging in luxurious escapes to pristine beaches, TravelSphere caters to every traveler's unique desires. Our team of passionate experts meticulously crafts personalized itineraries, ensuring each journey is filled with excitement, discovery, and lifelong memories. With TravelSphere as your trusted companion, embark on a journey of exploration and let us transform your travel dreams into reality.
						</p>
					</div>
					<div class="col-lg-6 info-right">
						<img class="img-fluid" src="img/about1.jpg" alt="">
					</div>
					</div>
				</div>
			</section>
	
			<?php

				class TourGuide {
					private $conn;

					public function __construct($database) {
						$this->conn = $database->connect();
					}

					public function getAllGuides() {
						$guides = [];
						$sql = "SELECT * FROM tourGuide";
						$result = $this->conn->query($sql);
						if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$guides[] = $row;
						}
						}
						return $guides;
					}

					public function generateHTML() {
						$guides = $this->getAllGuides();
						$html = '';
						foreach ($guides as $guide) {
							$html .= '<div class="col-lg-3 col-md-4">';
							$html .= '<div class="single-other-issue" >';
							$html .= '<div class="thumb">';
							$html .= '<img class="img-fluid" src="img/' . $guide['image'] . '" alt="">';
							$html .= '</div>';
							$html .= '<a href="#" style="pointer-events: none;">';
							$html .= '<h4>' . $guide['name'] . '</h4>';
							$html .= '</a>';
							$html .= '<div class="contact-info">';
							$html .= '<p><i class="fa fa-envelope"></i> ' . $guide['email'] . '</p>';
							$html .= '<p><i class="fa fa-phone"></i> ' . $guide['phone'] . '</p>';
							$html .= '</div>';
							$html .= '<p>' . $guide['specialization'] . '</p>';
							$html .= '</div>';
							$html .= '</div>';

						}
						
						return $html;
					}
				}

				$tourGuide = new TourGuide($database);
			?>

			<section class="other-issue-area section-gap">
			<div class="container">
				<div class="row d-flex justify-content-center">
				<div class="menu-content pb-70 col-lg-9">
					<div class="title text-center">
					<h1 class="mb-10">Our Expert Tour Guides</h1>
					<p>Embark on your travels with the guidance of our expert tour guides. Explore new destinations, uncover hidden gems, and immerse yourself in the local culture with the help of our knowledgeable and passionate guides. Whether you're seeking historical insights, culinary delights, or off-the-beaten-path adventures, our tour guides are here to enrich your journey and ensure an unforgettable experience.</p>
					</div>
				</div>
				</div>

				<div class="row justify-content-center">
				<?php echo $tourGuide->generateHTML(); ?>
				</div>
			</div>
			</section>

			<section class="testimonial-area section-gap">
		        <div class="container">
		            <div class="row d-flex justify-content-center">
		                <div class="menu-content pb-70 col-lg-8">
		                    <div class="title text-center">
		                        <h1 class="mb-10">Reviews About TravelSphere</h1>
		                        <p>Discover what our valued customers have to say about their unforgettable experiences with TravelSphere. From enchanting destinations to impeccable service, our reviews reflect the satisfaction and joy of travelers who have chosen us as their trusted companion in exploration.</p>
		                    </div>
		                </div>
		            </div>
		            <div class="row">
		                <div class="active-testimonial">
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
		                            <img class="img-fluid" src="img/person1.png" alt="">
		                        </div>
		                        <div class="desc">
					   <p>"TravelSphere's website offers a seamless and user-friendly experience. Finding the perfect destination is effortless with intuitive navigation and comprehensive search options."</p>
		                            <h4>Belay Cayling</h4>
	                            	<div class="star">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>		
						</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
						<img class="img-fluid" src="img/person2.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>"Navigating TravelSphere's website was a delight, and the detailed information helped me choose the perfect getaway."</p>
		                            <h4>Felifs Kiben</h4>
	                           		<div class="star">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>	
						</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
						<img class="img-fluid" src="img/person3.png" alt="">
		                        </div>
		                        <div class="desc">
					   <p>"I appreciate TravelSphere's website for its clarity. The detailed descriptions and images provided helped me visualize my ideal vacation."</p>
		                        <h4>Joys Perando</h4>
	                            	<div class="star">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>			
						</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
						<img class="img-fluid" src="img/person4.png" alt="">
		                        </div>
		                        <div class="desc">
					   <p>"The user-friendly interface of TravelSphere's website made booking my trip a stress-free experience. I was impressed by how quickly I could find and book exactly what I needed."</p>
					   <h4>Sean Bernard</h4>
	                           		<div class="star">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>		
						</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
						<img class="img-fluid" src="img/person5.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>"TravelSphere's website is a treasure trove of travel inspiration, and the booking process is both straightforward and secure."</p>
		                            <h4>Loren De Sarapen</h4>
	                            	<div class="star">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>		
						</div>	
		                        </div>
		                    </div>
		                    <div class="single-testimonial item d-flex flex-row">
		                        <div class="thumb">
						<img class="img-fluid" src="img/person6.png" alt="">
		                        </div>
		                        <div class="desc">
		                            <p>"The reviews section on TravelSphere's website provided valuable insights, contributing to my confident decision to book with them."</p>
		                            <h4>Mary Crizimas</h4>
	                           		<div class="star">
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>		
						</div>	
		                        </div>
		                    </div>		                    		                    
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