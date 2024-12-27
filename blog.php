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
		
		<title>Blogs | TravelSphere</title>

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
		 include 'Header.php';

$header = new Header();
$header->render();
?>
		  
			
			<section class="relative about-banner">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Blogs 		
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span><a href="blog.php">Blogs </a></p>
						</div>	
					</div>
				</div>
			</section>					  
			
			
			<section class="recent-blog-area section-gap">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="menu-content pb-60 col-lg-9">
                            <div class="title text-center">
                                <h1 class="mb-10">Our Blog</h1>
                                <p>Explore the latest insights, travel tips, and captivating stories on our blog. Immerse yourself in a world of wanderlust as we share valuable information and inspiration for your next adventure.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="active-recent-blog-carusel">
                            <?php

                            $database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
                            $conn = $database->connect();

                            
                                $query = "SELECT * FROM posts WHERE status = 'Active'"; 
                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $title = $row['title'];
                                        $content = $row['content'];
                                        $date = $row['date'];
                                        $author = $row['author'];
                                        $category = $row['category'];
                                        $image = $row['image']; 

                                        $formatted_date = date('F d, Y', strtotime($date));

                                        $plain_content = strip_tags($content);

                                        
                                        $short_content = strlen($plain_content) > 200 ? substr($plain_content, 0, 200) . '...' : $plain_content;
                                        
                                        
                                        echo '<div class="single-recent-blog-post item">';
                                        echo '<div class="thumb">';
                                        echo '<img class="img-fluid" src="img/' . $image . '" alt="' . $title . '" style="width: 600px; height: 200px;">';
                                        echo '</div>';
                                        echo '<div class="details">';
                                        echo '<ul class="tags">'; 
                                        echo '<li>' . $category . '</li>'; 
                                        echo '</ul>';
                                        echo '<a href="blog2.php?post_id=' . $row['post_id'] . '"><h4 class="title">' . $title . '</h4></a>';
                                        echo '<div class="meta">';
                                        echo '<span class="author">By ' . $author . '</span>'; 
                                        echo '</div>';
                                        echo '<br>';
                                        echo '<p>' .  $short_content . '</p>';
                                        echo '</div>';
                                        echo '<span class="date">' . $formatted_date . '</span>';
                                        echo '</div>';
                                    }
                                } else {
                                    
                                }
                                ?>
                    </div>
                </div>
            </div>
        </section>
			
			<?php

                include 'Footer.php';

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