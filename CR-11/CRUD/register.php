<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != ""){
   header("Location: home.php"); // redirects to home.php
}
if (isset($_SESSION['adm']) != ""){
   header("Location: dashboard.php"); // redirects to home.php
}

require_once 'components/db_connect.php';
require_once 'components/file_upload.php';


$error = false;
$fname = $lname = $email = $phone_number =  $address = $pass = $picture = '';
$fnameError = $lnameError = $emailError = $phone_numberError  = $addressError = $passError = $picError = '';
if (isset($_POST['btn-signup'])) {

   // sanitize user input to prevent sql injection
   $fname = trim($_POST['fname']);
   $fname = strip_tags($fname);
   $fname = htmlspecialchars($fname);
   
   $lname = trim($_POST['lname']);
   $lname = strip_tags($lname);
   $lname = htmlspecialchars($lname);    

   $email = trim($_POST['email']);
   $email = strip_tags($email);
   $email = htmlspecialchars($email);

   $phone_number = trim($_POST['phone_number']);
   $phone_number = strip_tags($phone_number);
   $phone_number = htmlspecialchars($phone_number);

   $address = trim($_POST['address']);
   $address = strip_tags($address);
   $address = htmlspecialchars($address);

   $pass = trim($_POST['pass']);
   $pass = strip_tags($pass);
   $pass = htmlspecialchars($pass);

   $uploadError = '';
   $picture = file_upload($_FILES['picture']);

   // basic name validation
   if (empty($fname) || empty($lname)) {
       $error = true;
       $fnameError = "Please enter your full name and surname";
   } else if (strlen($fname) < 3 || strlen($lname) < 3) {
       $error = true;
       $fnameError = "Name and surname must have at least 3 characters.";
   } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
       $error = true;
       $fnameError = "Name and surname must contain only letters and no spaces.";
   }
 
   //basic email validation
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $error = true;
       $emailError = "Please enter valid email address.";
   } else {
   // checks whether the email exists or not
       $query = "SELECT email FROM users WHERE email='$email'";
       $result = mysqli_query($connect, $query);
       $count = mysqli_num_rows($result);
       if ($count != 0) {
           $error = true;
           $emailError = "Provided Email is already in use.";
       }
   }
   //checks if the phone number input was left empty
   if (empty($phone_number)) {
       $error = true;
       $phone_numberError = "Please enter your phone number.";
   }
   //checks if the address was left empty
   if (empty($address)) {
       $error = true;
       $addressError = "Please enter your address.";
   }
   // password validation
   if (empty($pass)) {
       $error = true;
       $passError = "Please enter password.";
   } else if (strlen($pass) < 6) {
       $error = true;
       $passError = "Password must have at least 6 characters.";
   } 

   // password hashing for security
   $password = hash('sha256', $pass);
   // if there's no error, continue to signup
   if (!$error) {

       $query = "INSERT INTO users(first_name, last_name, password, phone_number, address, email, picture)
                 VALUES('$fname', '$lname', '$password', '$phone_number', '$address', '$email', '$picture->fileName')";
       $res = mysqli_query($connect, $query);
       
       if ($res) {
           $errTyp = "success";
           $errMSG = "<i class='bi bi-check2-square fs-3'></i> Successfully registered, you may login now";
           $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
           header("refresh:3;url=index.php");//redirects the new user to the login page

       } else {
           $errTyp = "danger";
           $errMSG = "<i class='bi bi-exclamation-circle-fill fs-3'> Something went wrong, try again later...";
           $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
       }
   }
}
mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- BOOTSTRAP -->
   <?php require_once 'components/bootstrap.php'?>
   <!-- CSS -->
   <link rel="stylesheet" href="styles/style.css">
   <title>Login & Registration System</title>
</head>
<body>
    <!-- [MAIN] -->
    <main class="bg-dark py-5">
        <div class="container bg-light rounded-3 text-dark border border-success border-3 py-5 authentication">
            <!-- [FORM] -->
            <form class="w-auto rounded mx-auto shadow py-5 px-3 border" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
                    <div class="text-center mb-2"><i class="bi bi-person-badge text-success display-1"></i>
                    </div>
                    <h2 class="display-5 mb-2 mt-0 text-center text-success">Sign Up</h2>
                    <hr class="bg-success py-1 mb-5 mx-auto w-50">
                    <?php
                    if (isset($errMSG)) {
                    ?>
                    <div class="alert alert-<?php echo $errTyp ?> alert_notification">
                        <p><?php echo $errMSG; ?></p>
                        <p><?php echo $uploadError; ?></p>
                    </div>

                    <?php
                    }
                    ?>

                    <!-- first_name -->
                    <input class='form-control mb-1 py-1' type ="text"  name="fname" placeholder="First name" maxlength="50" value="<?php echo $fname ?>">
                        <span class="text-danger"> <?php echo $fnameError; ?> </span>
                    <!-- last name -->
                    <input class='form-control mb-1 py-1' type ="text"  name="lname" placeholder="Surname" maxlength="50" value="<?php echo $lname ?>">
                        <span class="text-danger"> <?php echo $fnameError; ?> </span>
                    <!-- email -->
                    <input class='form-control mb-1 py-1' type="email" name="email" placeholder="Enter Your Email" maxlength="40" value ="<?php echo $email ?>">
                    <span  class="text-danger"> <?php echo $emailError; ?> </span>
                    <!-- phone number -->
                    <input class='form-control mb-1 py-1' placeholder="Phone number" type="text"  name="phone_number" value ="<?php echo $phone_number ?>">
                    <span class="text-danger"> <?php echo $phone_numberError; ?> </span>
                    <!-- address -->
                    <input class='form-control mb-1 py-1' placeholder="Address" type="text"  name="address" value ="<?php echo $address ?>"/>
                    <span class="text-danger"> <?php echo $addressError; ?> </span>
                    <!-- picture -->
                    <div class="input-group py-0 mb-1">
                        <label class="input-group-text" for="picture"><i class="bi bi-camera2 text-success fw-bold"></i></label>
                        <input class='form-control' type="file" name="picture" id="picture" aria-describedby="picture">
                        <span class="text-danger"> <?php echo $picError; ?> </span>
                    </div> 
                    <!-- password -->
                    <input type="password" name="pass" class="form-control mb-1 py-1" placeholder="Enter Password" maxlength="15">
                        <span class="text-danger"> <?php echo $passError; ?> </span>
                    <hr/>
                    <!-- submit button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
                    </div>
                    <hr/>
                    <small>Already have an account? <a href="index.php">Sign in Here...</a></small>
            </form>
        </div>
    </main>
    
    <!-- [JAVASCRIPT] -->
    <script>
        // prevents submiting the data again after refreshing the page
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</body>
</html>