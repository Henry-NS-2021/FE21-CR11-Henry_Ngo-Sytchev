<?php
session_start();
require_once 'components/db_connect.php';

// it will never let you open login page if session is set
if (isset($_SESSION['user']) != "") {
   header("Location: home.php");
   exit;
}
if (isset($_SESSION['adm']) != "") {
   header("Location: dashboard.php"); // redirects to home.php
}

$error = false;
$email = $password = $emailError = $passError = '';

if (isset($_POST['btn-login'])) {

   // prevent sql injections/ clear user invalid inputs
   $email = trim($_POST['email']);
   $email = strip_tags($email);
   $email = htmlspecialchars($email);

   $pass = trim($_POST['pass']);
   $pass = strip_tags($pass);
   $pass = htmlspecialchars($pass);
   // prevent sql injections / clear user invalid inputs

   if (empty($email)) {
       $error = true;
       $emailError = "Please enter your email address.";
   } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $error = true;
       $emailError = "Please enter valid email address.";
   }

   if (empty($pass)) {
       $error = true;
       $passError = "Please enter your password.";
   }

   // if there's no error, continue to login
   if (!$error) {

       $password = hash('sha256', $pass); // password hashing

       $sql = "SELECT id, first_name, password, user_status FROM users WHERE email = '$email';";
       $query = mysqli_query($connect, $sql);
       $row = mysqli_fetch_assoc($query);
       $count = mysqli_num_rows($query);
       if ($count == 1 && $row['password'] == $password) {
           if($row['user_status'] == 'adm'){
           $_SESSION['adm'] = $row['id'];          
           header( "Location: dashboard.php");}
           else{
               $_SESSION['user'] = $row['id'];
              header( "Location: home.php");
           }          
       } else {
           $errMSG = "Incorrect Credentials, Try again...";
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
<title>Login & Registration System</title>
<!-- BOOTSTRAP -->
<?php require_once 'components/bootstrap.php'?>
    <!-- [CSS] -->
    <style>
        main{
           height: 100vh;
       }
    </style>
</head>
<body>
    <!-- [MAIN] -->
    <main class="bg-dark py-5">
        <div class="container bg-light rounded-3 text-dark border border-success  border-3 w-50 py-5">
            <!-- [FORM] -->
            <form class="w-auto rounded mx-auto shadow py-5 px-3 border" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <div class="text-center  mb-2"><i class="bi bi-box-arrow-in-right display-1 text-success"></i></div>
                <h2 class="display-5 mb-2 mt-0 text-center text-success">Sign In</h2>
                <hr class="bg-success py-1 mb-5 mx-auto w-50">
                <?php
                if (isset($errMSG)) {
                    echo $errMSG;
                }
                ?>
                <input class="form-control mb-1" type="email" autocomplete="off" name="email"  placeholder="Your Email" value="<?php echo $email; ?>"  maxlength="40" />
                <span class="text-danger"><?php echo $emailError; ?></span>

                <input class="form-control" type="password" name="pass"   placeholder="Your Password" maxlength="15"  />
                <span class="text-danger"><?php echo $passError; ?></span>
                <hr class="border border-success">
                <p class="text-center mt-3 mb-5"><button class="btn btn-block btn-primary w-50" type="submit" name="btn-login">Sign In</button></p>
                <small>Not registered yet? <a href="register.php">Click here</a></small>
            </form>
        </div>
    </main>
</body>
</html>