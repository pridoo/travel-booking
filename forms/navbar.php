<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Welcome, Admin!</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
        
            </div>
        </form>
        
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item ">
                <a class="nav-link" href="../logout.php" onclick="return confirm('Are you sure you want to logout?');"><i class="fas fa-sign-out-alt fa-fw"></i></a>
            </li>
        </ul>
</nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main Menu</div>
                        <a class="nav-link" href="index.php" style="margin-left: 5px;">
                            <div class="sb-nav-link-icon hover-white"><i class="fas fa-calendar"></i></div>
                            <span class="icon-text">Bookings</span>   
                        </a>
                        <a class="nav-link" href="tour_index.php">
                            <div class="sb-nav-link-icon hover-white"><i class="fas fa-map-marked-alt"></i></div>
                            <span class="icon-text">Tour Guides</span>   
                        </a>
                        <a class="nav-link" href="blog_index.php">
                            <div class="sb-nav-link-icon hover-white"><i class="fas fa-newspaper"></i></div>
                            <span class="icon-text">Blogs</span>  
                        </a>
                        <a class="nav-link" href="comment_index.php">
                            <div class="sb-nav-link-icon hover-white"><i class="fas fa-newspaper"></i></div>
                            <span class="icon-text">Blog Comments</span>  
                        </a>
                        <a class="nav-link" href="inquiries.php">
                            <div class="sb-nav-link-icon hover-white"><i class="fas fa-envelope"></i></div>
                            <span class="icon-text">Inquiries</span>  
                        </a>
                        <a class="nav-link" href="../index.php">
                            <div class="sb-nav-link-icon hover-white"><i class="fas fa-eye"></i></div>
                            <span class="icon-text">View Website</span>  
                        </a>
                    </div>
                </div>
            <div class="sb-sidenav-footer bg-dark">
                <div class="small">Logged in as:</div>
                admin@admin.com
            </div>
        </nav>
    </div>


        