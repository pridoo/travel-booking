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

$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$conn = $database->connect();

$post_id = $_GET['post_id'] ?? NULL;

if ($post_id == NULL) {
    header("Location: blog.php");
    exit();
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-foobarbaz" crossorigin="anonymous" />

</head>

<body>	

	<?php
		 include 'Header.php';

		$header = new Header();
		$header->render();
	?>
		  
		<?php

			$stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = ?");
			$stmt->bind_param("i", $post_id);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$post = $result->fetch_assoc();
				$title = $post['title'];
				$content = $post['content'];
				$author = $post['author'];
				$date = $post['date'];
				$category = $post['category'];
				$image = $post['image'];
				$formatted_date = date('F d, Y', strtotime($date));
			
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
			
			
			<section class="post-content-area single-post-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 posts-list">
							<div class="single-post row">
								<div class="col-lg-12">
									<div class="feature-img">
										<img class="img-fluid" src="img/<?php echo $image; ?>" alt="<?php echo $title; ?>" alt="">
									</div>									
								</div>

								<div class="col-lg-3 col-md-4 meta-details">    
									<div class="user-details row">
										<div class="col-lg-12 col-md-12 col-6">
										<ul class="tags">
										<li><a href="" style="pointer-events: none; text-decoration: none; color: inherit;"><?php echo $category; ?></a> <span class="lnr lnr-category"></span></li>
									</ul>
										<p class="user-name"><?php echo $author; ?> <span class="lnr lnr-user"></span></p>
										<p class="date"><a href="" style="pointer-events: none; text-decoration: none; color: inherit;"><?php echo $formatted_date; ?></a> <span class="lnr lnr-calendar-full"></span></p>
										</div>
									</div>
								</div>

								<div class="col-lg-9 col-md-9">
									<h3 class="mt-20 mb-20"><?php echo $title; ?></h3>
									<p class="excert" style="text-align: justify;"><?php echo $content; ?></p>
								</div>
								
									
		<?php 
		}
		?>
					
							</div>
							
							<div class="comments-area">
							    <h4>Comment Section</h4>
							    <?php
							    
							    $sql = "SELECT * FROM comments WHERE post_id = ?";
							    $stmt = $database->connect()->prepare($sql);
							    $stmt->bind_param("i", $_GET["post_id"]); 
							    $stmt->execute();
							    $result = $stmt->get_result();
							
							    if ($result->num_rows > 0) {
								 while ($row = $result->fetch_assoc()) {
								     ?>
								     <div class="comment-list">
									  <div class="single-comment justify-content-between d-flex">
									      <div class="user justify-content-between d-flex">
										   <div class="thumb">
											
											<i class="fas fa-user-circle"></i>
										   </div>
										   <div class="desc">
											<h5><?php echo $row['name']; ?></h5>
											<p class="date" style="color: black;"><?php echo date('F j, Y | h:i A', strtotime($row['created_at'])); ?></p>
											<p class="subject" style="font-weight: bold;"><?php echo $row['subject']; ?></p>

											<p class="comment" style="text-align: justify;">
											    <?php echo $row['message']; ?>
											</p>
										   </div>
									      </div>
									  </div>
								     </div>
								     <?php
								 }
							    } else {
								 echo "No comments yet.";
							    }
							    ?>
							</div>
							

							<div class="comment-form">
								<h4>Leave a Comment</h4>
								<form action="post_comment.php" method="POST">
									<input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
										<div class="form-group form-inline">
											<div class="form-group col-lg-6 col-md-12 name">
											<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'" required>
											</div>
											<div class="form-group col-lg-6 col-md-12 email">
											<input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" required>
											</div>										
										</div>
										<div class="form-group">
											<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'" required>
										</div>
										<div class="form-group">
											<textarea class="form-control mb-10" rows="5" name="message" placeholder="Message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Message'" required></textarea>
										</div>
										<button type="submit" class="primary-btn text-uppercase">Post Comment</button>
								</form>

							</div>
						</div>
						<div class="col-lg-4 sidebar-widgets">
							<div class="widget-wrap">
								
								<div class="single-sidebar-widget user-info-widget">
									<img src="img/editor.png" alt="">
									<a href="#"><h4>Darell Supremo</h4></a>
									<p>
										Editor in Chief
									</p>
									<ul class="social-links">
										<li><a href="#"><i class="fa fa-facebook"></i></a></li>
										<li><a href="#"><i class="fa fa-twitter"></i></a></li>
										<li><a href="#"><i class="fa fa-instagram"></i></a></li>
										<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
									</ul>
									<p style="text-align: center;">
										As the Editor in Chief, Darell Supremo is dedicated to bringing you engaging and insightful content that captures the essence of travel. With a passion for exploration and storytelling, he leads our team in curating guides that inspire and inform, making your journey into the world of travel an enriching experience.
									</p>
								</div>
								
								<div class="single-sidebar-widget ads-widget">
									<a href="#"><img class="img-fluid" src="img/ads.jpg" alt=""></a>
								</div>
															
							</div>
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