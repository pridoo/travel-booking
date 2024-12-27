<?php

class Header {
    public function render() {
        ?>
        <header id="header">
            <div class="container main-menu">
                <div class="row align-items-center justify-content-between d-flex">
                    <div id="logo">
                        <a href="index.php" style="text-decoration: none; color: white; font-weight:bold; font-size: 16px; ">TravelSphere</a>
                    </div>
                    <nav id="nav-menu-container">
                        <ul class="nav-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="booking.php">Booking</a></li>
                            <li><a href="blog.php">Blogs</a></li>
                            <li><a href="about.php">About Us</a></li>			          					          		          
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>
                    </nav>				      		  
                </div>
            </div>
        </header>
        <?php
    }
}