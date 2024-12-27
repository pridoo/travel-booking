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
		
<title>TravelSphere | Travel and Tour Accomodation</title>

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

	

			<section class="banner-area relative">
				<div class="overlay overlay-bg"></div>				
				<div class="container">
					<div class="row fullscreen align-items-center justify-content-center">
						<div class="col-lg-9 col-md-9 banner-left text-center">
							<h1 class="text-white">Explore Boundless Adventures with TravelSphere</h1>
							<p class="text-white">
							If you're seeking an immersive travel experience with a knowledgeable tour guide, TravelSphere serves as your comprehensive hub for all your travel needs, promising memorable journeys without breaking the bank.
							</p>
							<a href="booking.php" class="primary-btn text-uppercase mt-2">Book Now</a>
						</div>
						
						</div>
					</div>
				</div>					
			</section>


			
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
                                            <span><?php echo $row["duration"]; ?></span>
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

			
<section class="recent-blog-area">
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
						echo '<ul class="tags">'; // Moved ul tag here
						echo '<li>' . $category . '</li>'; // Displaying category
						echo '</ul>';
						echo '<a href="blog2.php?post_id=' . $row['post_id'] . '"><h4 class="title">' . $title . '</h4></a>';
						echo '<div class="meta">';
						echo '<span class="author">By ' . $author . '</span>'; // Displaying formatted date
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

		<section class="home-about-area" >
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