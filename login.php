<?php
session_start();

class Redirect {
   public static function ifLoggedIn($redirectLocation) {
       if(isset($_SESSION['userAdmin'])) {
           header("Location: $redirectLocation");
           exit();
       }
   }
}


Redirect::ifLoggedIn("forms/index.php");

class Authentication {
    private $username;
    private $password;
    private $error_message;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function validateCredentials() {
        
        if ($this->username === 'admin@admin.com' && $this->password === 'root') {
            $_SESSION['userAdmin'] = true;
            header('Location: forms/index.php');
            exit();
        } else {
         
            $this->error_message = "Incorrect username or password. Please try again.";
        }
    }

    public function getErrorMessage() {
        return $this->error_message;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $auth = new Authentication($username, $password);

    $auth->validateCredentials();
}
?>


<!DOCTYPE html>
<html lang="eng" class="no-js">

   <head>

      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="UTF-8">
      
      <title>Admin Login | TravelSphere</title>

      <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <link rel="stylesheet" href="css/style.css">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   </head>

   <body>

   <div class="row vh-100 g-0">

      <div class="col-lg-6 position-relative d-none d-lg-block">

         <div class="bg-holder" style="background-image: url(img/banaue.jpg);"></div>

      </div>


      <div class="col-lg-6">

         <div class="row align-items-center justify-content-center h-100 g-0 px-4 px-sm-0">
            <div class="col col-sm-6 col-lg-7 col-xl-6">

               <div class="text-center mb-5">
                  <h3 class="fw-bold">Admin Login</h3>
                  <p class="text-secondary">Get Access To Admin Account</p>
               </div>

               <form action="" method="POST">
                  <div class="mb-3">
                     <?php 
                     
                     if (isset($auth) && $error = $auth->getErrorMessage()) : ?>
                        <div class="text-danger">
                           <?php echo $error; ?>
                        </div>
                     <?php endif; ?>
                  </div>

                  <div class="input-group mb-3">
                     <span class="input-group-text">
                        <i class="bx bx-user"></i>
                     </span>
                     <input type="text" name="username" class="form-control form-control-lg fs-6" placeholder="Username">
                  </div>

                  <div class="input-group mb-3">
                     <span class="input-group-text">
                        <i class='bx bx-lock-alt' ></i>
                     </span>
                     <input type="password" name="password" class="form-control form-control-lg fs-6" placeholder="Password">
                  </div>

                  <div class="input-group mb-3 d-flex justify-content-between">
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck">
                        <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                     </div>

                  </div>

                  <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Login</button>
               </form>

               <div class="text-center">
                  <p>Want to visit the main website? <a href="index.php">Go to website</a></p>
               </div>
            


            </div>
         </div>
      </div>
   </div>
</body>

</html>