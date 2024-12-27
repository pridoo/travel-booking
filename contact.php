<?php

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once('db/connection.php');

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
		 
			$body = '
			<p>Thank you for subscribing to our newsletter! We are excited to have you on board. Stay tuned for our latest updates, promotions, and exclusive offers!</p>

			<p>Best regards,<br> TravelSphere</p>
			';

			$mail->Body = $body;
   
		
		 $mail->send();

		
	    } catch (Exception $e) {
		 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	    }
	} else {
	   
	}
   } else {
	
	echo 'Invalid request method';
   }
   

class FormSubmission {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertFormData($name, $email, $subject, $message) {
 
        $stmt = $this->conn->prepare("INSERT INTO inquiries (name, email, subject, message) VALUES (?, ?, ?, ?)");
      
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        if ($stmt->execute()) {
            return true; 
        } else {
        
            error_log("Error inserting form data: " . $stmt->error);
            return false; 
        }
    }
}


$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$conn = $database->connect();


$formSubmission = new FormSubmission($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    
    if ($formSubmission->insertFormData($name, $email, $subject, $message)) {
       
        echo "Form submission successful!";
        
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

            
            $mail->isHTML(false);
            $mail->Subject = 'Thank You For Contacting Us';
	     $mail->Body = "Dear $name,\n\nThank you for contacting us. We have received your inquiry and will get back to you as soon as possible.";

	     $body .= " In the meantime, feel free to explore our website for more information about our services and offerings.\n\n";
	     $body .= "Best regards,\nTravelSphere";
	     
	     $mail->Body .= $body;

            $mail->send();
            echo 'Email has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        
        echo "Form submission failed!";
    }
}

$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="eng" class="no-js">
<head>
		
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="UTF-8">
		
<title>Contact Us | TravelSphere</title>

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

			<section class="relative about-banner">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Contact Us				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="contact.php"> Contact Us</a></p>
						</div>	
					</div>
				</div>
			</section>
					  

			<section class="contact-page-area section-gap">
				<div class="container">
					<div class="row">
						<div class="map-wrap" style="width:100%; height: 445px;" id="map">
						
							<iframe
							width="100%"
							height="100%"
							frameborder="0"
							style="border:0"
							allowfullscreen
						   src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7680.791997961884!2d120.92112776977537!3d15.730176900000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3390d6542653b51b%3A0x111f20f17a610056!2sCentral%20Luzon%20State%20University%20(CLSU)!5e0!3m2!1sen!2sph!4v1702040152711!5m2!1sen!2sph"
					  ></iframe>
						
						
						</div>
						<div class="col-lg-4 d-flex flex-column address-wrap">
							<div class="single-contact-address d-flex flex-row">
								<div class="icon">
									<span class="lnr lnr-home"></span>
								</div>
								<div class="contact-details">
									<h5>Central Luzon State University</h5>
									<p>
										Science City of Muñoz, Nueva Ecija
									</p>
								</div>
							</div>
							<div class="single-contact-address d-flex flex-row">
								<div class="icon">
									<span class="lnr lnr-phone-handset"></span>
								</div>
								<div class="contact-details">
									<h5>(+63) 9123 456 7890</h5>
									<p>Mon to Fri 8am to 5pm</p>
								</div>
							</div>
							<div class="single-contact-address d-flex flex-row">
								<div class="icon">
									<span class="lnr lnr-envelope"></span>
								</div>
								<div class="contact-details">
									<h5>travel@sphere.com</h5>
									<p>Send your email anytime!</p>
								</div>
							</div>														
						</div>
						<div class="col-lg-8">
						<form class="form-area contact-form text-right" id="myForm" action="" method="POST">
								<div class="row">    
								<div class="col-lg-6 form-group">
									<input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mb-20 form-control" required="" type="text">
									
									<input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

									<input name="subject" placeholder="Enter subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter subject'" class="common-input mb-20 form-control" required="" type="text">
								</div>
								<div class="col-lg-6 form-group">
									<textarea class="common-textarea form-control" name="message" placeholder="Enter message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" required=""></textarea>                
								</div>
								<div class="col-lg-12">
									<div class="alert-msg" style="text-align: left;"></div>
									<button id="submitButton" class="genric-btn primary" style="float: right;">Send message</button>                                          
								</div>
								</div>
							</form> 
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

$(document).ready(function() {
    $('#emailForm').submit(function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize();
        $.ajax({
            type: 'GET', 
            url: '', 
            data: formData,
            success: function(response) {
                
                $('#message').html('Email submitted successfully.');
            },
            error: function(xhr, status, error) {
                
                $('#message').html('Error occurred while submitting the form.');
            }
        });
    });
});

</script>


<script>

class FormSubmitter {
    constructor(formSelector) {
        this.form = $(formSelector);
        this.alertMsg = $('.alert-msg');
        this.submitButton = $('#submitButton');
        this.bindEvents();
    }

    bindEvents() {
        const self = this;
        this.submitButton.click(function(e) {
            e.preventDefault();
            self.submitForm();
        });
    }

    submitForm() {
        const formData = this.form.serialize();
        $.ajax({
            type: 'POST',
            url: this.form.attr('action'),
            data: formData,
            success: this.handleSuccess.bind(this),
            error: this.handleError.bind(this)
        });
    }

    handleSuccess(response) {
        this.alertMsg.html('Form submitted successfully.');
        this.form[0].reset();
    }

    handleError(xhr, status, error) {
        this.alertMsg.html('Error occurred while submitting the form.');
    }
}

$(document).ready(function() {
    const formSubmitter = new FormSubmitter('#myForm');
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