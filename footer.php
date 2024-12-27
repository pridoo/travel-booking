<?php

class Footer {
    public function render() {
        ?>
        <footer class="footer-area section-gap" style="background-color: black;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5  col-md-8 col-sm-8">
                        <div class="single-footer-widget">
                            <h6>About TravelSphere</h6>
                            <p style="text-align: justify; color: white;">
                                At TravelSphere, we transcend the role of a mere travel service provider; we are your devoted companions on the voyage of exploration. Our mission is to inspire and facilitate unforgettable travel experiences, connecting you with the world's most captivating destinations and cultures. With a commitment to excellence and personalized service, we strive to turn your travel dreams into reality.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6>Navigation Links</h6>
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="booking.php">Booking</a></li>
                                        <li><a href="blog.php">Blogs</a></li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <ul>
                                        <li><a href="about.php">About Us</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>
                                    </ul>
                                </div>										
                            </div>							
                        </div>
                    </div>							
                    <div class="col-lg-4  col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6>Newsletter</h6>
                            <p style="text-align: justify; color: white;">
                                Subscribe to our newsletter and stay in the loop with the latest travel inspirations, exclusive offers, and insider tips.		
                            </p>	
                            
                            

                            <div id="mc_embed_signup">
                                <form id="emailForm" class="subscription relative white-placeholder" action="" method="get">
                                    <div class="d-flex flex-row">
                                        <input name="email" id="emailInput" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required="" type="email" class="white-placeholder">
                                        <button type="submit" id="submitButton" class="btn bb-btn"><span class="lnr lnr-location"></span></button>
                                    </div>
                                    <div class="mt-10 info"></div>
                                </form>
                            </div>

                                <div id="message" class="alert-msg1"></div>


                        </div>
                    </div>											
                </div>

                <div class="row footer-bottom d-flex justify-content-center align-items-center">
                    <p class="col-lg-8 col-sm-12 footer-text m-0 text-center">
                        TravelSphere 2024 | All Rights Reserved.
                    </p>
                </div>

            </div>
        </footer>
        <?php
    }
}
